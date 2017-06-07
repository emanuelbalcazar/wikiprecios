<?php

/**
* Controlador encargado de manejar los rubros desde la aplicacion web.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Item_web_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('email');
        $this->load->library('encrypt');
        $this->load->library('utils');
        $this->load->library('csvimport');
        $this->load->library('pagination');
        $this->load->model('Item_model');
    }

    public function load_item_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');

            $this->load->view('menu_admin', $data);
            $this->load->view('load_item_view');
        } else {
            redirect(base_url());
        }
    }

    public function load_item()
    {
        $data["name"] = $this->input->post('name', TRUE);
        $data["user"] = $this->session->userdata('user');
        $data = $this->utils->replace($data, "\"", "");

        if ($data["name"] == "") {
            $data["error"] = "Ingrese un nombre para el rubro";
            $this->load->view('menu_admin', $data);
            $this->load->view('load_item_view', $data);
        }
        else if ($this->Item_model->item_exists($data["name"])) {
            $data["warning"] = "El rubro ya existe";
            $this->load->view('menu_admin', $data);
            $this->load->view('load_item_view', $data);
        } else {
            $registered = $this->Item_model->register_item($data["name"]);

            if ($registered) {
                $data["success"] = "Rubro agregado correctamente";
                $this->load->view('menu_admin', $data);
                $this->load->view('load_item_view', $data);
            } else {
                $data["error"] = "No se pudo registrar el rubro";
                $this->load->view('menu_admin', $data);
                $this->load->view('load_item_view', $data);
            }
        }
    }

    public function load_list_items_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('list_items_view', $data);
        } else {
            redirect(base_url());
        }
    }

    public function search_item()
    {
        $data["user"] = $this->session->userdata('user');
        $data["item"] = $this->input->get('item');

        $data["items"] = $this->Item_model->search_item($data["item"]);

        $this->load->view('menu_admin', $data);
        $this->load->view('list_items_view', $data);

    }

} // Fin controlador
