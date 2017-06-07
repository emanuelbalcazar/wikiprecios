<?php

/**
* Controlador encargado de manejar las operaciones del Administrador
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Login_web_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('email');
        $this->load->library('utils');
        $this->load->model('Administrator_model');
    }

    /**
    * Carga en el navegador la pantalla de login.
    *
    * @access public
    */
    public function load_login_view()
    {
        if ($this->session->userdata('user')) {
            redirect(base_url().'menu_administrador');
        } else {
            $this->load->view('login_view');
        }
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

        if (!$this->_is_valid_email($data["mail"])) {
            $result["error"] = "El email ingresado es invalido";
            $this->load->view('login_view', $result);
        }
        else if (!$this->_exists_email($data["mail"])) {
            $result["error"] = "No se encuentra registrado";
            $this->load->view('login_view', $result);
        }
        else if (!$this->_is_active_account($data["mail"])) {
            $result["warning"] = "Su cuenta esta desactivada";
            $this->load->view('login_view', $result);
        }
        else if (!$this->_is_valid_password($data["mail"], $data["password"])) {
            $result["error"] = "La contraseña es incorrecta";
            $this->load->view('login_view', $result, 'refresh');
        }
        else {
            $this->session->set_userdata(array('user' => $data["mail"]));
            $this->Administrator_model->update_last_session($data["mail"]);
            redirect(base_url() . 'menu_administrador');
        }
    }


    /**
    * Valida si el email esta bien formado
    *
    * @access private
    * @param email
    * @return boolean true si el email esta bien formado.
    */
    private function _is_valid_email($mail)
    {
        return valid_email($mail);
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
        $mail = $this->Administrator_model->find_admin_by_email($mail);
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
        $user = $this->Administrator_model->find_admin_by_email($mail);
        return ($user->active_account);
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

    /**
    * Si el usuario inicio sesion, lo redirecciona a la pagina principal.
    *
    * @access public
    */
    public function menu()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $this->load->view('menu_admin', $data);
            $this->load->view('main_view');
        } else {
            redirect(base_url());
        }
    }

    /**
    * Cierra la sesion actual del usuario.
    *
    * @access public
    */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    /**
    * Carga la vista que permite recuperar la clave olvidada.
    *
    * @access public
    */
    public function load_reset_password_view()
    {
        $this->load->view('reset_password_view');
    }

    /**
    * Realiza la logica para recuperar la clave olvidada.
    * Se genera una clave aleatoria de 4 digitos.
    *
    * @access public
    */
    public function reset_password()
    {
        $data["mail"] = $this->input->post('mail', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $new_password = mt_rand(1000, 9999);
        $encrypted_password = $this->encrypt->encode($new_password);

        set_error_handler(array($this, 'my_error_handler')); // Para capturar los warnings de PHP.
        $this->_send_email($data["mail"], $new_password, $encrypted_password);
    }

    /**
    * Envia un correo con la nueva clave restablecida al destinatario obtenido.
    *
    * @access private
    */
    private function _send_email($mail, $password, $encrypted_password)
    {
        $this->email->from('wikipreciosunpsjb@gmail.com', 'Wikiprecios UNPSJB');
        $this->email->to($mail);
        $this->email->subject('Restablecimiento de Contraseña');
        $this->email->message('Su nueva contraseña es: '. $password . ', úsela para iniciar sesión y puede cambiarla en en el menú de la pantalla principal.');

        if (!$this->email->send()) {
            $result["error"] = "No se pudo enviar la nueva contraseña al correo ingresado";
            $this->load->view('reset_password_view', $result);
        } else {
            $result["success"] = "Su nueva contraseña se envió al correo ingresado";
            $this->Administrator_model->update_password($mail, $encrypted_password);
            $this->load->view('login_view', $result);
        }
    }

    public function my_error_handler($errno, $errstr, $errfile, $errline)
    {
        // Void
    }

} // Fin del controlador
