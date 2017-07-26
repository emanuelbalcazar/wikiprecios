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
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->model('Item');
        $this->load->model('Category');
    }

    /**
    * Carga en el navegador la pantalla de home.
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
        $this->load->view('product/load_special_product_view', $data);
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

        if ($this->Category->exists($data)) {
            $result['error'] = "El producto especial ya estaba registrado";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'producto/nuevo');
        } else {
            $url = base_url().'api/categoria/registrar/?item='.$data["item_id"].'&name='.$data["category"].'&unit='.$data["unit"];
            $response = $this->utils->send_get($url);

            $result['success'] = "El producto especial se registro correctamente";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'producto/nuevo');
        }
    }

}
