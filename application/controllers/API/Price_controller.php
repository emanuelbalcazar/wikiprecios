<?php

/**
* Controlador de la clase Precio.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Price_controller extends CI_Controller
{
    private $IS_NEW_PRODUCT = FALSE;
    private $DIFF_SCORE = 15; // Diferencia de puntos entre dos precios

    private $MAX_QUALIFICATION = 5;
    private $MIN_QUALIFICATION = 0;

    private $MAX_ACCUMULATED = 5;
    private $MIN_ACCUMULATED = 0;


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('utils');
        $this->load->model('Price');
        $this->load->model('Product');
        $this->load->model('User');
        $this->load->model('Commerce');
        $this->load->model('CalculatedPrice');
    }

    /**
    * Registra un nuevo precio, ademas realiza las siguientes operaciones:
    * - Registra el producto en caso de que no exista.
    * - Calcula el precio basado en los precios anteriores y lo persiste.
    * - Califica al usuario teniendo en cuenta si los datos fueron correctos.
    * - Busca los precios del producto ingresado  ylo devuelve como JSON.
    *
    * @access public
    */
    public function register()
    {
        $data["user"] = $this->input->post('user');
        $data["commerce_id"] = $this->input->post('commerce');
        $data["price"] = $this->input->post('price');
        $data["product_code"]= $this->input->post('product');
        $data2["latitud"]= $this->input->post('latitud');
        $data2["longitud"]= $this->input->post('longitud');

        $data = $this->utils->replace($data, "\"", ""); // Elimino las comillas

        $where = array("product_code" => $data["product_code"]);
        $product_exists = $this->Product->exists($where);

        if (!$product_exists) {
            $this->_insert_product($data["product_code"]);
        }

        $this->_register_price($data);
        $this->_calculate_price($data["commerce_id"], $data["price"], $data["product_code"]);
        $this->_user_qualify($data["commerce_id"], $data["user"], $data["price"], $data["product_code"]);
        $result["result"] = $this->_get_favorites_prices($data["commerce_id"], $data["user"], $data["product_code"], $data2["latitud"], $data2["longitud"]);

        $where = array("mail" => $data["user"]);
        $result["user"] = $this->User->find($where)[0];

        echo json_encode($result);
    }

    // -------------------------------------------------------------------------

    /**
    * Registra un nuevo producto en la Base de datos.
    *
    * @access private
    * @param $product codigo del producto a registrar
    */
    private function _insert_product($product)
    {
        $insert_product = $this->Product->create(array("product_code" => $product));
        $this->IS_NEW_PRODUCT = TRUE;
    }

    // -------------------------------------------------------------------------

    /**
    * Registra un nuevo precio en la Base de datos.
    *
    * @access private
    * @param $commerce comercio en donde se encuentra el producto
    * @param $user usuario que registra el precio
    * @param $price precio del producto
    * @param $product codigo del producto a registrar
    */
    private function _register_price($data)
    {
        $data["date"] = date("Y-m-d");
        $insert = $this->Price->create($data);
    }

    // -------------------------------------------------------------------------

    /**
    * Registra o actualiza un nuevo precio calculado que se utiliza para mostrar al usuario.
    *
    * @access private
    * @param $commerce comercio en donde se encuentra el producto
    * @param $price precio del producto
    * @param $product codigo del producto
    */
    private function _calculate_price($commerce, $price, $product)
    {
        if ($this->IS_NEW_PRODUCT) {
            $price_2 = 0;
            $price_1 = $price;
            $ok = $this->Price->register_new_price_calculated($commerce, $product, $price_1, $price_2, "$".$price);
        } else {
            $this->_existing_calculate_price($commerce, $product, $price);
        }
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
                $possible_prices[$price->price] = 0 + $price->ranking;
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

   // -------------------------------------------------------------------------

   /**
   * Califica al usuario segun el precio ingresado por el mismo.
   *
   * @access private
   * @param $commerce comercio en donde se encuentra el producto
   * @param $product codigo del producto
   * @param $price
   * @param $user
   */
   private function _user_qualify($commerce, $user, $price, $product)
   {
       $prices = $this->Price->get_product_prices($product, $commerce);
       $user = $this->User->find(array("mail" => $user));

        if (!isset($user[0]->qualification) || !isset($user[0]->accumulated))
            return;

       $qualification = $user[0]->qualification;
       $accumulated = $user[0]->accumulated;

       $diff_1 = abs($prices->price_1 - $price);
       $diff_2 = abs($prices->price_2 - $price);

       $accepted = $this->_price_accepted($diff_1, $diff_2, $price);
       $this->_update_qualify($accepted, $user[0]->mail, $qualification, $accumulated);
   }

   /**
   * Verifica la diferencia entre los precios registrados y el precio ingresado
   * por el usuario y retorna un booleano indicado si el precio es aceptado.
   *
   * @access private
   * @param $diff_1 la diferencia entre el precio calculado 1 y el precio ingresado por el usuario
   * @param $diff_2 la diferencia entre el precio calculado 2 y el precio ingresado por el usuario
   * @param $price precio ingresado por el usuario
   */
   private function _price_accepted($diff_1, $diff_2, $price)
   {
        $price_accepted = FALSE;

        if ($diff_2 == $price && $diff_1 < 5) { // El precio 2 resulto ser 0
            $price_accepted = TRUE;
        }
        else if ($diff_1 < 5 || $diff_2 < 5) {
            $price_accepted = TRUE;
        }
       return $price_accepted;
   }

   /**
   * Califica al usuario si el precio ingresado fue aceptado
   *
   * @access private
   * @param $accepted booleano indicando si el precio fue aceptado.
   * @param $user
   * @param $qualification calificacion del usuario
   * @param $accumulated acumulados del usuario
   */
   private function _update_qualify($accepted, $user, $qualification, $accumulated)
   {
       if ($accepted) {
           $this->_up_qualify($user, $qualification, $accumulated);
       } else {
           $this->_down_qualify($user, $qualification, $accumulated);
       }
   }

   /**
   * Incrementa la calificacion del usuario
   *
   * @access private
   * @param $user
   * @param $qualification calificacion del usuario
   * @param $accumulated acumulados del usuario
   */
   private function _up_qualify($user, $qualification, $accumulated)
   {
        if ($accumulated < $this->MAX_ACCUMULATED) {
           $accumulated++;
       } else if ($accumulated == $this->MAX_ACCUMULATED && $qualification == $this->MAX_QUALIFICATION) {
           // no se incrementa nada, dejarlo con el acumulado maximo
       } else {
            $accumulated = 0;
            if ($qualification < $this->MAX_QUALIFICATION) {
               $qualification++;
           }
       }
       $where = array("mail" => $user);
       $data = array("qualification" => $qualification, "accumulated" => $accumulated);
       $this->User->update($where, $data);
   }

   /**
   * Decrementa la calificacion del usuario
   *
   * @access private
   * @param $user
   * @param $qualification calificacion del usuario
   * @param $accumulated acumulados del usuario
   */
   private function _down_qualify($user, $qualification, $accumulated)
   {
        if ($accumulated > $this->MIN_ACCUMULATED) {
           $accumulated--;
       } else if ($accumulated == $this->MIN_ACCUMULATED && $qualification == $this->MIN_QUALIFICATION) {
            // no se decrementa nada, dejarlo con el acumulado minimo
       } else {
            $accumulated = 0;
            if ($qualification > $this->MIN_QUALIFICATION) {
               $qualification--;
           }
        }
        $where = array("mail" => $user);
        $data = array("qualification" => $qualification, "accumulated" => $accumulated);
        $this->User->update($where, $data);
    }

    // -------------------------------------------------------------------------

    /**
    * Retorna un arreglo con los precios de un producto en los comercios favoritos y no favoritos
    * del usuario.
    *
    * @access private
    * @param $commerce
    * @param $user usuario
    * @param $product
    * @return $array
    */
    private function _get_favorites_prices($commerce, $user, $product, $latitud , $longitud)
    {
        $current_commerce = $this->Commerce->find(array("id" => $commerce));
        // Obtengo los precios en los comercios favoritos.
        $favorites_prices = $this->Price->get_favorites_prices($product, $user, $commerce);
        $favorites_prices = $this->order_by_distance($favorites_prices, $latitud , $longitud);

        // Agrego una bandera indicando que los comercios SI son favoritos.
        for ($i = 0; $i < count($favorites_prices); $i++) {
            $favorites_prices[$i]->favorite = TRUE;
         }

        // Obtengo los precios de los comercios NO favoritos.
        $not_favorites_prices = $this->Price->get_prices_that_are_not_favorites($product, $user, $commerce);
        $not_favorites_prices = $this->order_by_distance($not_favorites_prices, $latitud , $longitud);

        // Agrego una bandera indicando que los comercios NO son favoritos.
        for ($i = 0; $i < count($not_favorites_prices); $i++) {
            $not_favorites_prices[$i]->favorite = FALSE;
         }

        for ($i = 0; $i < count($not_favorites_prices); $i++) {
           array_push($favorites_prices, $not_favorites_prices[$i]);
        }
        return $favorites_prices;
    }

    /**
    * Retorna un arreglo ordenado por distancia respecto a la ubicacion del usuario.
    *
    * @access private
    * @param $array
    * @param $latitude
    * @param $longitude
    * @return $array
    */
    private function order_by_distance($array, $latitude , $longitude)
    {
       for ($i = 0; $i < count($array); $i++) {
           $commerce_data = $this->Commerce->find(array("id" => $array[$i]->id));
           //$distance = $this->utils->calculate_distance($current_commerce[0]->latitude, $current_commerce[0]->longitude, $commerce_data[0]->latitude, $commerce_data[0]->longitude);
           $distance = $this->utils->calculate_distance($latitude, $longitude, $commerce_data[0]->latitude, $commerce_data[0]->longitude);
           $array[$i]->distance = $distance;
           $array[$i]->address = $commerce_data[0]->address;
           $array[$i]->city = $commerce_data[0]->city;
       }

       uasort($array, array($this, 'cmp_inverse')); // Ordeno los comercios de menor a mayor

       $order_array = [];

       for ($i = 0; $i < count($array); $i++) {
          array_push($order_array, $array[$i]);
       }

       return $order_array;
    }

    /**
    * Funcion de comparacion para el ordenamiento.
    *
    * @access private
    */
    private function cmp_inverse($a, $b)
    {
       if ($a->distance == $b->distance) {
           return 0;
       }
       return ($a->distance < $b->distance) ? -1 : 1;
    }

   // -------------------------------------------------------------------------

   /**
   * Devuelve los precios posibles de un producto en un determinado comercio.
   * @access public
   */
   public function get_possible_prices()
   {
       $data["commerce"] = $this->input->get('commerce');
       $data["product"]= $this->input->get('product');
       $data = $this->utils->replace($data, "\"", "");

       $posibles = $this->Price->get_possible_prices($data["commerce"] , $data["product"]);
        $result = [];

        $product_calculated = $this->CalculatedPrice->find(array('product_code' => $data["product"]));
        //var_dump($product_calculated[0]);

        if($product_calculated != null){
          $price_calculated = floatval($product_calculated[0]->price_1);
          $limit = $price_calculated * 3;
          $min = $price_calculated / 3;

          for ($i = 0; $i < count($posibles); $i++) {
              if (floatval($posibles[$i]->price) <= $limit && floatval($posibles[$i]->price) >= $min) {
                  array_push($result, $posibles[$i]);
              }
          }
        }

        echo json_encode($result);
   }

    /**
    * Devuelve los precios registrados.
    * @access public
    */
    public function findAll()
    {
        $all = $this->Price->find();
        echo json_encode($all);
    }

    /**
    * Devuelve todos los precios calculados con su respectivo comercio.
    * @access public
    */
    public function calculated_prices()
    {
        $all = $this->CalculatedPrice->find();

        for ($i = 0; $i < count($all); $i++) {
            $commerce_data = $this->Commerce->find(array("id" => $all[$i]->commerce_id));

            if (isset($commerce_data[0])) {
                $all[$i]->commerce_name = $commerce_data[0]->name;
                $all[$i]->commerce_address = $commerce_data[0]->address;
            } else {
                $all[$i]->commerce_name = "Nombre de comercio no encontrado";
                $all[$i]->commerce_address = "Direccion de comercio no encontrado";
            }
        }

        echo json_encode($all);
    }
}
