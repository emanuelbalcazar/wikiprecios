<?php

/**
* API WEB - cuentas de usuario
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
    * Cambia la contraseña del usuario.
    * @access public
    */
    public function change_password()
    {
        $data["user"] = $this->input->post('email', TRUE);
        $data["old_password"] = $this->input->post('password', TRUE);
        $data["new_password"] = $this->input->post('newPassword', TRUE);
        $data["confirm_password"] = $this->input->post('confirmNewPassword', TRUE);
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->_is_valid_password($data["user"], $data["old_password"])) {
            $result["error"] = 'La clave actual es incorrecta';
            echo json_encode($result);
            return;
        }

        if ($data["new_password"] != $data["confirm_password"]) {
            $result["error"] = 'La nueva clave no coincide con la confirmada';
            echo json_encode($result);
            return;            
        }

        $data["new_password"] = $this->encryption->encrypt($data["new_password"]);
        $this->Administrator->update(array("mail" => $data["user"]), array("password" => $data["new_password"]));
        $result["success"] = 'Su clave se actualizo correctamente';
        echo json_encode($result);
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
    * Cierra la sesion actual del usuario.
    * @access public
    */
    public function logout()
    {
        $data["user"] = $this->input->post('user', TRUE);        
        $this->session->unset_userdata(array('user' => $data["mail"]));  
        
        $data["session"] = $this->session->has_userdata('user');
        echo json_encode($data);
    }

    /**
     * Retorna la sesion actual del usuario
     */
    public function session() {
        $session = $this->session->userdata();        
        echo json_encode($session);
    }

}  // fin del controlador.
