<?php

/**
* Controlador de la pantalla de home.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Account_controller extends CI_Controller
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
    * Carga en el navegador la pantalla de eliminar cuenta de administrador.
    * @access public
    */
    public function delete()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('account/delete_account_view');
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
    }

    /**
    * Elimina logicamente una cuenta de Administrator.
    * @access public
    */
    public function delete_account()
    {
        $data["user"] = $this->session->userdata('user');
        $data["password"] = $this->input->post('password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_is_valid_password($data["user"], $data["password"])) {
           $result["error"] = 'La contraseña es incorrecta';
           $this->session->set_flashdata('messages', $result);
           redirect(base_url().'desactivar_cuenta');
        } else {
           $this->Administrator->delete_account($data["user"]);
           $result["success"] = 'La cuenta ha sido desactivada correctamente';
           $this->session->set_flashdata('messages', $result);
           redirect(base_url());
        }
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

    /**
    * Carga en el navegador la pantalla de cambiar contraseña.
    * @access public
    */
    public function change()
    {
        if (!$this->session->userdata('user')) {
            redirect(base_url());
        }

        $data["user"] = $this->session->userdata('user');
        $this->load->view('header/header');
        $this->load->view('navigation/menu_admin', $data);
        $this->load->view('account/change_password_view');
        $this->load->view('footer/toast', $this->session->flashdata('messages'));
    }

    /**
    * Cambia la contraseña del usuario.
    * @access public
    */
    public function change_password()
    {
        $data["user"] = $this->session->userdata('user');
        $data["old_password"] = $this->input->post('old_password', TRUE);
        $data["new_password"] = $this->input->post('new_password', TRUE);
        $data["confirm_password"] = $this->input->post('confirm_password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_is_valid_password($data["user"], $data["old_password"])) {
            $result["error"] = 'La contraseña actual es incorrecta';
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'cambiar_clave');
        }

        if ($data["new_password"] != $data["confirm_password"]) {
            $result["error"] = 'La nueva contraseña no coincide con la confirmada';
            $this->session->set_flashdata('messages', $result);
            redirect(base_url().'cambiar_clave');
        }

        $data["new_password"] = $this->encryption->encrypt($data["new_password"]);
        $this->Administrator->update(array("mail" => $data["user"]), array("password" => $data["new_password"]));
        $result["success"] = 'Su contraseña se cambió correctamente';
        $this->session->set_flashdata('messages', $result);
        redirect(base_url().'home');
    }

    /**
    * Cierra la sesion actual del usuario.
    * @access public
    */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}  // fin del controlador.
