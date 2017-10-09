<?php

/**
* Controlador encargado de manejar los rubros desde la aplicacion web.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Item_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->library('files');        
        $this->load->model('Item');
    }

    /**
    * Carga en el navegador la pantalla de nuevo rubro.
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
        $this->load->view('item/load_item_view', $data);
    }

    public function load_item()
    {
        $data["name"] = $this->input->post('name', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if ($data["name"] == "") {
            $result['error'] = "Ingrese un nombre de rubro";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'rubros/nuevo');
        }
    }

} // Fin controlador
