<?php

/**
* Controlador de la pantalla de comercios.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Commerce_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('files');
        $this->load->model('Commerce');
    }

    /**
    * Carga en el navegador la pantalla de nuevo producto especial.
    * @access public
    */
    public function new()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        // $data["items"] = $this->Item->find();
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
        $this->load->view('commerce/commerce_view', $data);
    }



    /**
    * Carga en el navegador la pantalla de carga de comercio masivo.
    *
    * @access public
    */
    public function load()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
        $this->load->view('businesses/load_businesses_view');
    }

    /**
    * Carga el archivo seleccionado a la aplicacion para luego ser leido.
    * @access public
    */
    public function load_from_file()
    {
        $data["user"] = $this->session->userdata('user');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $result['error'] = "No se pudo cargar el archivo, por favor seleccione un archivo valido";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'comercios/cargar');
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
            $this->_load_businesses($file_path);
        }
    }

    /**
    * Inicia la carga del archivo CSV a la base de datos.
    * @access private
    */
    private function _load_businesses($file_path)
    {
        $this->files->set_file($file_path);
        $this->files->set_model(new Commerce);
        $count = $this->files->init_load();

        $result['success'] = "Se cargaron correctamente ". $count . " comercios";
        $this->session->set_flashdata('messages', $result);
        redirect(base_url().'comercios/cargar');
    }

}   // fin del controlador
