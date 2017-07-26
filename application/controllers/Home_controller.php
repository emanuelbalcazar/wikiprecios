<?php

/**
* Controlador de la pantalla de home.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Home_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encryption');
        $this->load->library('session');
    }

    /**
    * Carga en el navegador la pantalla de home.
    *
    * @access public
    */
    public function index()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('home/home_view');
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
    }

}
