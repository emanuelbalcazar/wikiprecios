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

            $data["price"] = $row["price"];
            $data["product_code"] = $row["product_code"];
            $data["date"] = date("Y-m-d");
            $this->Price->create($data);
            $count++;
        }

        $result['success'] = "Se cargaron correctamente ". $count . " precios";
        echo json_encode($result);
    }

}   // fin del controlador
