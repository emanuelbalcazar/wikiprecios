<?php

/**
* Controlador de la pantalla inicial de Login y recuperacion de clave de usuario.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Login_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->model('Administrator');
    }

    /**
    * Carga en el navegador la pantalla de login.
    *
    * @access public
    */
    public function index()
    {
        if ($this->session->userdata('user')) {
            redirect(base_url().'home');
        }

        $this->load->view('header/header');
        $this->load->view('login/login_view');
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
    }

    /**
    * Retorna un mensaje indicando si el usuario se loggeo correctamente
    *
    * @access public
    */
    public function login()
    {
        $data["mail"] = $this->input->post('mail', TRUE);
        $data["password"] = $this->input->post('password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_verify_user($data["mail"])) {
            $result["error"] = "No se encuentra registrado o su cuenta fue desactivada";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url());
        }
        else if (!$this->_is_valid_password($data["mail"], $data["password"])) {
            $result["error"] = "El email o la contraseña es incorrecta";
            $this->session->set_flashdata('messages', $result);
            redirect(base_url());
        }
        else {
            $this->session->set_userdata(array('user' => $data["mail"]));
            $this->Administrator->update(array("mail" => $data["mail"]), array("last_session" => date("y-m-d H:m:s")));
            redirect(base_url() . 'home');
        }
    }

    /**
    * Valida si existe el usuario y si su cuenta esta activa.
    *
    * @access private
    * @param email
    * @return boolean true si el email esta bien formado.
    */
    private function _verify_user($mail)
    {
        $exists = $this->_exists_email($mail);
        $active = $this->_is_active_account($mail);

        return ($exists && $active);
    }

    /**
    * Valida si existe un usuario con el email recibido como parametro
    *
    * @access private
    * @param email
    * @return boolean true si el email ya fue registrado.
    */
    private function _exists_email($mail)
    {
        $mail = $this->Administrator->find(array("mail" => $mail));
        return (isset($mail)) ? true : false;
    }

    /**
    * Valida si la cuenta asociada al mail recibido esta activa.
    *
    * @access private
    * @param email
    * @return boolean true si la cuenta esta activa.
    */
    private function _is_active_account($mail)
    {
        $user = $this->Administrator->find(array("mail" => $mail));
        if (!isset($user[0])) {
            return false;
        }

        return ($user[0]->active_account);
    }

    /**
    * Valida si la contraseña recibida corresponde a la cuenta asociada al mail recibido.
    *
    * @access private
    * @param email del usuario
    * @param $password contraseña ingresada por el usuario
    * @return boolean true si la contraseña es correcta.
    */
    private function _is_valid_password($mail, $password)
    {
        $user = $this->Administrator->find(array("mail" => $mail));
        $password_decoded = $this->encryption->decrypt($user[0]->password);

        return ($password_decoded == $password);
    }

} // Fin del controlador
