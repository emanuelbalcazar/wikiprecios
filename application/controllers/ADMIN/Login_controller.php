<?php

/**
* API WEB - inicio de sesion.
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
    * Inicia una sesion de administrador en el sistema.
    * @access public
    */
    public function login()
    {
        $data["mail"] = $this->input->post('email', TRUE);
        $data["password"] = $this->input->post('password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_verify_user($data["mail"])) {
            $result["error"] = "No se encuentra registrado o su cuenta fue desactivada";
            echo json_encode($result); 
            return;           
        }

        if (!$this->_is_valid_password($data["mail"], $data["password"])) {
            $result["error"] = "El email o la contraseña es incorrecta";
            echo json_encode($result); 
            return;
        }

        $this->Administrator->update(array("mail" => $data["mail"]), array("last_session" => date("y-m-d H:m:s")));
        $user = $this->Administrator->find(array("mail" => $data["mail"]))[0];
        $this->session->set_userdata(array('user' => $data["mail"]));
        
        echo json_encode($user);
    }

    /**
    * Valida si existe el usuario y si su cuenta esta activa.
    *
    * @access private
    * @param email
    * @return Boolean true si el email esta bien formado.
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
    * @return Boolean true si el email ya fue registrado.
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
    * @return Boolan true si la cuenta esta activa.
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
    * @param $mail email del usuario
    * @param $password contraseña ingresada por el usuario
    * @return Boolean true si la contraseña es correcta.
    */
    private function _is_valid_password($mail, $password)
    {
        $user = $this->Administrator->find(array("mail" => $mail));
        $password_decoded = $this->encryption->decrypt($user[0]->password);

        return ($password_decoded == $password);
    }

} // Fin del controlador
