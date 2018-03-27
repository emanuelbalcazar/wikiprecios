<?php

/**
* Controlador de la pantalla de carga de precios.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Price_controller extends CI_Controller
{

    private $DIFF_SCORE = 15; // Diferencia de puntos entre dos precios    

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('files');
        $this->load->library('utils');
        $this->load->model('Commerce');
        $this->load->model('Price');
        $this->load->model('Product');        
    }

    /**
    * Carga el archivo seleccionado a la aplicacion para luego ser leido.
    * @access public
    */
    public function upload()
    {
        $data["user"] = $this->input->post('user');
        $data["commerce_id"] = $this->input->post('commerce');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $result['error'] = "No se pudo cargar el archivo, por favor seleccione un archivo valido";
            $result['upload'] = $this->upload->display_errors();
            echo json_encode($result);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
            $this->_load_prices($file_path, $data);
        }
    }

    /**
    * Inicia la carga del archivo CSV a la base de datos.
    * @access private
    */
    private function _load_prices($file_path, $data)
    {
        $this->files->set_file($file_path);
        $file_data = $this->files->get_data();
        $count = 0;

        foreach ($file_data as $row) {
            if (!isset($row["price"]) || !isset($row["product_code"])) {
               $result["error"] = "El archivo esta mal formado o no es el correcto.";
               echo json_encode($result);
               return;
            }  
            
            if (!$this->Product->exists(array("product_code" => $row["product_code"]))) {
                $this->Product->create(array("product_code" => $row["product_code"]));
                $this->Price->register_new_price_calculated($data["commerce_id"], $row["product_code"], $row["price"], 0, "$".$row["price"]);
            } else {
                //$this->Price->register_new_price_calculated($data["commerce_id"], $row["product_code"], $row["price"], 0, "$".$row["price"]);
                $this->_existing_calculate_price($data["commerce_id"], $row["product_code"], $row["price"]);
            }

            $data["price"] = $row["price"];
            $data["product_code"] = $row["product_code"];
            $data["date"] = date("Y-m-d");
            $this->Price->create($data);

            $count++;
        }

        $result['success'] = "Se cargaron correctamente ". $count . " precios";
        echo json_encode($result);
    }

    /**
    * Obtiene los ultimos precios registrados de un producto y calcula nuevamente
    * cual es el precio que posiblemente tenga el producto basandose en los precios anteriores.
    *
    * @access private
    * @param $commerce comercio en donde se encuentra el producto
    * @param $product codigo del producto
    */
    private function _existing_calculate_price($commerce, $product, $price)
    {
        $days = 5; // Como parametro inicial, tomo 5 dias previos de precios registrados.
        $all_prices = $this->Price->get_last_prices($commerce, $product, $days);

        if (count($all_prices) == 0) {
            $this->Price->register_new_price_calculated($commerce, $product, $price, 0, "$".$price);
            return;
        }

        if (count($all_prices) < 10 && count($all_prices) > 0) {  // Si tengo pocos precios, pido datos de los ultimos 10 dias.
            $days = 10;
            $all_prices = $this->Price->get_last_prices($commerce, $product, $days);
        }
        $this->_calculate_possible_prices($all_prices, $commerce, $product);
    }

    /**
    * Calcula el/los precios posibles que tendria el producto recibido como parametro.
    * Una vez calculado se envian los precios a persistir en la base de datos.
    *
    * @access private
    * @param $all_prices todos los precios obtenidos de un producto.
    * @param $commerce comercio en donde se encuentra el producto
    * @param $product codigo del producto
    */
    private function _calculate_possible_prices($all_prices, $commerce, $product)
    {
        // Calculo los puntajes para cada precio
        $possible_prices = $this->_get_possible_prices($all_prices);

        uasort($possible_prices, array($this, 'cmp')); // Ordeno los precios de mayor a menor

        $most_probable_price= current($possible_prices); // Precio mas probable por puntaje
        $price_1 = key($possible_prices);
        $less_likely_price = next($possible_prices); // Precio menos probable por puntaje

        $price_2 = key($possible_prices);

        if ($price_2 == null) {
            $price_2 = 0;
        }

        $score = $most_probable_price - $less_likely_price; // Calculo la diferencia de puntajes

        $this->_check_calculated_price($all_prices, $possible_prices, $score, $price_1, $price_2, $commerce, $product);
        reset($possible_prices);
    }

    /**
    * Calcula y da puntajes a los precios obtenidos. El calulo se realiza
    * utilizando el ranking de los precios, estos se suman a medida que se van repitiendo
    * por lo cual al finalizar los precios que mas se repiten poseen un mayor puntaje.
    *
    * @access private
    * @param $all_prices todos los precios obtenidos de un producto.
    */
    private function _get_possible_prices($all_prices)
    {
        $possible_prices = array();

        for ($index = 0; $index < count($all_prices); $index++) {
            $price = $all_prices[$index];

            if (array_key_exists($price->price, $possible_prices)) {
                $possible_prices[$price->price] = $possible_prices[$price->price] + $price->ranking;
            } else {
                $possible_prices[$price->price] = 5 + $price->ranking;
            }
        }

        return $possible_prices;
    }

    /**
    * Funcion de comparacion para el ordenamiento.
    *
    * @access private
    */
    private function cmp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    }

    /**
    * Verifica los precios calculados y los persiste segun los criterios establecidos en el codigo.
    *
    * @access private
    */
    private function _check_calculated_price($all_prices, $possible_prices, $score, $price_1, $price_2, $commerce, $product)
    {

        if (count($all_prices) == 0) {
            $price_1 = $price_1;
        }

        if ($score > $this->DIFF_SCORE) {
           $price_2 = 0;
           $this->Price->register_new_price_calculated($commerce, $product, $price_1, $price_2, "$".$price_1);
        }
        else if (count($possible_prices > 1)) {
           $this->_insert_new_calculated_price($commerce, $product, $price_1, $price_2);
       }
    }

    /**
    * Persiste en la base de datos un nuevo precio calculado.
    *
    * @access private
    * @param $commerce comercio en donde se encuentra el producto
    * @param $product codigo del producto
    * @param $price_1
    * @param $price_2
    */
    private function _insert_new_calculated_price($commerce, $product, $price_1, $price_2)
    {
        if ($price_1 > $price_2 && $price_2 != 0) {
           $ok = $this->Price->register_new_price_calculated($commerce, $product, $price_2, $price_1, "$".$price_2."- $".$price_1);
        }
        else if ($price_2 != 0) {
           $ok = $this->Price->register_new_price_calculated($commerce, $product, $price_1, $price_2, "$".$price_1."- $".$price_2);
        }
        else {
           $ok = $this->Price->register_new_price_calculated($commerce, $product, $price_1, $price_2, "$".$price_1);
       }
   }

}   // fin del controlador
