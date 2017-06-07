<?php

/**
* Controlador encargado de manejar las cuentas de administradores.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Administrator_account_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('email');
        $this->load->library('encrypt');
        $this->load->library('utils');
        $this->load->model('Administrator_model');
    }

    public function load_delete_account_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $this->load->view('menu_admin', $data);
            $this->load->view('delete_account_view');
        } else {
            redirect(base_url());
        }
    }

    public function delete_account()
    {
        $data["user"] = $this->session->userdata('user');
        $data["password"] = $this->input->post('password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_is_valid_password($data["user"], $data["password"])) {
            $data["error"] = 'La contraseña es incorrecta';
            $this->load->view('menu_admin', $data);
            $this->load->view('delete_account_view', $data);
        } else {
            $this->Administrator_model->delete_account($data["user"]);
            $data["success"] = 'La cuenta ha sido desactivada correctamente';
            $this->load->view('login_view', $data);
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
        $user = $this->Administrator_model->find_admin_by_email($mail);
        $password_decoded = $this->encrypt->decode($user->password);

        return ($password_decoded == $password);
    }

    public function load_change_password_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $this->load->view('menu_admin', $data);
            $this->load->view('change_password_view');
        } else {
            redirect(base_url());
        }
    }

    public function change_password()
    {
        $data["user"] = $this->session->userdata('user');
        $data["old_password"] = $this->input->post('old_password', TRUE);
        $data["new_password"] = $this->input->post('new_password', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_is_valid_password($data["user"], $data["old_password"])) {
            $data["error"] = 'La contraseña actual es incorrecta';
            $this->load->view('menu_admin', $data);
            $this->load->view('change_password_view', $data);
        } else {
            $data["new_password"] = $this->encrypt->encode($data["new_password"]);
            $this->Administrator_model->update_password($data["user"], $data["new_password"]);
            $data["success"] = 'Su contraseña se cambió correctamente';
            $this->load->view('menu_admin', $data);
            $this->load->view('change_password_view', $data);
        }
    }

}  // Fin del controlador
