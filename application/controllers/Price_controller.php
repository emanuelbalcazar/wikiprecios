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
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('files');
        $this->load->library('utils');
        $this->load->model('Commerce');
        $this->load->model('Price');
    }

    /**
    * Carga en el navegador la pantalla de carga de precios.
    *
    * @access public
    */
    public function load()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        $data["businesses"] = $this->Commerce->find();
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
        $this->load->view('prices/load_price_view', $data);
    }

    /**
    * Carga el archivo seleccionado a la aplicacion para luego ser leido.
    * @access public
    */
    public function load_from_file()
    {
        $data["user"] = $this->session->userdata('user');
        $data["commerce_id"] = $this->input->post('commerce');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $result['error'] = "No se pudo cargar el archivo, por favor seleccione un archivo valido";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'precios/cargar');
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

        foreach ($file_data as $row) {
            $url = base_url().'api/precio/registrar/?user='.$data["user"].'&commerce='.$data["commerce_id"].'&price='.$row["price"].'&product='.$row["product_code"];
            $this->utils->send_get($url);
        }

        $result['success'] = "Se cargaron correctamente los precios";
        $this->session->set_flashdata('messages', $result);
        redirect(base_url().'precios/cargar');
    }

}   // fin del controlador
