<?php

/**
* Controlador de recuperacion de clave de usuario.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Forgot_password_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('utils');
        $this->load->model('Administrator');
    }

    /**
     * Genera una nueva clave de usuario y envia un email con la nueva clave.
     * @access public
     */
    public function reset()
    {
        $data["mail"] = $this->input->post('email', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $new_password = mt_rand(1000, 9999);
        $encrypted_password = $this->encryption->encrypt($new_password);

        set_error_handler(array($this, 'my_error_handler')); // Para capturar los warnings de PHP.
        $data["status"] = $this->_send_email($data["mail"], $new_password, $encrypted_password);

        echo json_encode($data);
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

        if (!$this->email->send())
            return $result["error"] = "No se pudo enviar su nueva clave al correo ingresado";
    
        $result["success"] = "Su nueva contraseña se envió al correo ingresado";
        $this->Administrator->update(array("mail" => $mail), array("password" => $encrypted_password));
        return $result;
    }

    /**
     * Funcion de utilidad para capturar los warning de PHP.
     * Por el momento, la funcion no posee un cuerpo implementado.
     */
    public function my_error_handler($errno, $errstr, $errfile, $errline)
    {
        // void
    }

}
