<?php

/**
* Controlador para el manejo de cuentas de usuario.
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
        $this->load->library('utils');
        $this->load->library('encryption');
        $this->load->model('User');
    }

    /**
    * Retorna un mensaje indicando si el usuario inicio sesion correctamente.
    * @access public
    */
    public function login()
    {
        $data["mail"] = $this->input->post('mail');
        $data["password"] = $this->input->post('password');

        $data = $this->utils->replace($data, "\"", ""); // Elimino las comillas
        
        if ($this->User->exists($data) && $this->_is_valid_password($data["mail"], $data["password"])) {
            $where = array("mail" => $data["mail"]);
            $result = $this->User->find($where)[0];
        } else {
            $result["noUser"] = 1;
        }

        echo json_encode($result);
    }

    /**
    * Cambia la contraseña de un usuario por una nueva contraseña ingresada.
    * @access public
    */
    public function change_password()
    {
        $data["mail"] = $this->input->post('mail');
        $data["password"] = $this->input->post('password');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $founded = $this->User->find(array("mail" => $data["mail"]));

        if (!$this->User->exists(array("mail" => $data["mail"]))) {
            $result["message"] = "No existe el usuario con el email: ".$data["mail"];
            $result["updated"] = FALSE;
            echo json_encode($result); 
            return;           
        }

        $data["password"] = $this->encryption->encrypt($data["password"]);  // encripto la contraseña

        $where = array("mail" => $data["mail"]);
        $fields = array("password" => $data["password"]);
        $result["updated"] = $this->User->update($where, $fields);

        $result["message"] = ($result["updated"]) ? "La clave se cambio correctamente" : "No se pudo cambiar la clave del usuario";
        echo json_encode($result);
    }

    /**
    * Desactiva la cuenta de un usuario utilizando su mail y contraseña.
    * Se realiza una baja logica, lo cual los datos del usuario nunca son eliminados.
    *
    * @access public
    */
    public function delete_account()
    {
        $data["mail"] = $this->input->post('mail');
        $data["password"] = $this->input->post('password');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->User->exists(array("mail" => $data["mail"]))) {
            $result["message"] = "No existe el usuario con el email: ".$data["mail"];
            $result["deleted"] = FALSE;
            echo json_encode($result); 
            return;           
        }

        if ($this->_is_valid_password($data["mail"], $data["password"])) {  // Si la contraseña es correcta
            $this->User->delete_account($data["mail"]);
            $result["message"] = "La cuenta se dio de baja correctamente";
            $result["deleted"] = TRUE;
        } else {
            $result["message"] = "La clave es incorrecta, la cuenta no pudo darse de baja";
            $result["deleted"] = FALSE;
        }

        echo json_encode($result);
    }

    /**
    * Valida si la contraseña recibida corresponde a la cuenta asociada al mail recibido.
    *
    * @access private
    * @param $mail correo del usuario
    * @param $password contraseña ingresada por el usuario
    * @return Boolean TRUE si la contraseña es correcta.
    */
    private function _is_valid_password($mail, $password)
    {
        $where = array("mail" => $mail);
        $user = $this->User->find($where);
        $password_decoded = $this->encryption->decrypt($user[0]->password);

        return ($password_decoded == $password || $user[0]->password == $password);
    }

}