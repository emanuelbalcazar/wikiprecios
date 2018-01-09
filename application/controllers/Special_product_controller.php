<?php

/**
* Controlador de la pantalla de productos especiales.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Special_product_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->library('files');        
        $this->load->model('Item');
        $this->load->model('Category');
        $this->load->model('Product');        
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
        $data["items"] = $this->Item->find();
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
        $this->load->view('product/new_special_product_view', $data);
    }

    /**
    * Registra un nuevo producto especial (categoria).
    * @access public
    */
    public function load_product()
    {
        $data["category"] = $this->input->post('name', TRUE);
        $data["item_id"] = $this->input->post('item', TRUE);
        $data["unit"] = $this->input->post('unit', TRUE);

        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if ($data["category"] == "") {
            $result['error'] = "Ingrese un nombre de producto";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'productos/nuevo');
        }

        if ($this->Category->exists($data)) {
            $result['error'] = "El producto especial ya estaba registrado";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'productos/nuevo');
        } else {
            $url = base_url().'api/categoria/registrar/?item='.$data["item_id"].'&name='.$data["category"].'&unit='.$data["unit"];
            $response = $this->utils->send_get($url);

            $result['success'] = "El producto especial se registro correctamente";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'productos/nuevo');
        }
    }

    /**
    * Carga en el navegador la pantalla de carga de productos masivo.
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
        $this->load->view('product/load_products_view');
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
            redirect(base_url().'productos/cargar');
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
            $this->_load_products($file_path);
        }
    }

    /**
    * Inicia la carga del archivo CSV a la base de datos.
    * @access private
    */
    private function _load_products($file_path)
    {
        $this->files->set_file($file_path);
        $this->files->set_model(new Product);
        $count = $this->files->init_load();

        $result['success'] = "Se cargaron correctamente ". $count . " productos";
        $this->session->set_flashdata('messages', $result);
        redirect(base_url().'productos/cargar');
    }

}
