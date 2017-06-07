<?php

/**
* Controlador de la clase Usuario
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class User_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('email');
        $this->load->library('encrypt');
        $this->load->library('utils');
        $this->load->model('User_model');
    }

    /**
    * Registra un nuevo usuario
    *
    * @access public
    */
    public function register_user()
    {
        $data["password"] = $this->input->get('password');
        $data["mail"] = $this->input->get('mail');
        $data["name"] = $this->input->get('name');
        $data["surname"] = $this->input->get('surname');

        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $result = $this->_validate_data($data);
        echo json_encode($result);
    }

    /**
    * Valida los datos ingresados del usuario a registrar.
    *
    * @access private
    */
    private function _validate_data($data)
    {
        if (!$this->_is_valid_email($data["mail"])) {
            $result["mensaje"] = "El mail ingresado esta mal escrito";
            $result["registrado"] = FALSE;

        } else if ($this->_exists_email($data["mail"])) {
            $result["mensaje"] = "El mail ingresado ya fue utilizado en otra cuenta";
            $result["registrado"] = FALSE;

        } else {
            $result = $this->_insert_user($data);
        }
        return $result;
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
        $mail = $this->User_model->find_user_by_email($mail);
        return (isset($mail)) ? true : false;
    }

    /**
    * Registra al usuario en la base de datos.
    *
    * @access private
    * @param $data arreglo que contiene los datos del usuario.
    */
    private function _insert_user($data)
    {
        $qualification = 1; // calificacion inicial
        $data["password"] = $this->encrypt->encode($data["password"]);
        $this->User_model->create_user($data["password"], $data["mail"], $data["name"], $data["surname"], $qualification);
        $result["mensaje"] = "Registrado con  exito";
        $result["registrado"] = TRUE;

        return $result;
    }

    /**
    * Retorna un mensaje indicando si el usuario se loggeo correctamente
    * TODO - Cambiar el GET por el POST
    *
    * @access public
    */
    public function login()
    {
        $data["mail"] = $this->input->get('mail');
        $data["password"] = $this->input->get('password');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if (!$this->User_model->find_user_by_email($data["mail"])) {
             $result["noUser"] = 1;

        } else if (!$this->_is_valid_password($data["mail"], $data["password"])) {
             $result["noUser"] = 1;

        } else {
             $result = $this->User_model->find_user_by_email($data["mail"]);
        }
        echo json_encode($result);
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
        $user = $this->User_model->find_user_by_email($mail);
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
        $user = $this->User_model->find_user_by_email($mail);
        $password_decoded = $this->encrypt->decode($user->password);

        return ($password_decoded == $password || $user->password == $password);
    }

    /**
    * Cambia la contraseña de un usuario por una nueva contraseña ingresada.
    *
    * @access public
    */
    public function change_password()
    {
        $data["mail"] = $this->input->get('mail');
        $data["password"] = $this->input->get('password');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $data["password"] = $this->encrypt->encode($data["password"]);
        $update = $this->User_model->update_password($data["mail"], $data["password"]);

        if ($update) {
            $result["message"] = "La clave se cambio correctamente";
            $result["updated"] = TRUE;
        } else {
            $result["message"] = "No se pudo cambiar la clave del usuario";
            $result["updated"] = FALSE;
        }
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
        $data["mail"] = $this->input->get('mail');
        $data["password"] = $this->input->get('password');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if ($this->_is_valid_password($data["mail"], $data["password"])) {  // Si la contraseña es correcta
            $this->User_model->delete_account($data["mail"]);
            $result["message"] = "La cuenta se dio de baja correctamente";
            $result["deleted"] = TRUE;
        } else {
            $result["message"] = "La clave es incorrecta, la cuenta no pudo darse de baja";
            $result["deleted"] = FALSE;
        }
        echo json_encode($result);
    }

} // Fin del controlador
