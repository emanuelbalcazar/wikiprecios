<?php

/**
* Controlador de la clase Usuario
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class User_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('email');
        $this->load->helper('url');
        $this->load->library('encryption');
        $this->load->library('utils');
        $this->load->model('User');
    }

    /**
    * Registra un nuevo usuario
    *
    * @access public
    */
    public function create()
    {
        $data["mail"] = $this->input->post('mail');        
        $data["password"] = $this->input->post('password');
        $data["name"] = $this->input->post('name');
        $data["surname"] = $this->input->post('surname');

        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $result = $this->_validate_data($data);
        echo json_encode($result);
    }

    /**
    * Valida los datos ingresados del usuario a registrar.
    * @access private
    */
    private function _validate_data($data)
    {
        if ($this->User->exists(array("mail" => $data["mail"]))) {
            $result["mensaje"] = "El mail ingresado ya fue utilizado en otra cuenta";
            $result["registrado"] = FALSE;
        } else {
            $result = $this->_insert_user($data);
        }

        return $result;
    }

    /**
    * Registra al usuario en la base de datos.
    *
    * @access private
    * @param $data arreglo que contiene los datos del usuario.
    */
    private function _insert_user($data)
    {
        $data["qualification"] = 1;
        $data["accumulated"] = 0;
        $data["active_account"] = 1;

        $result["registrado"] = $this->User->create($data);
        $result["mensaje"] = "Registrado con exito";

        return $result;
    }

    /**
     * Busca un usuario mediante su ID.
     * @access public
     */
    public function findById($id) {
        $user = $this->User->find(array("id" => $id));
        echo json_encode($user);
    }

    /**
     * Retorna todos los usuarios registrados.
     * @access public
     */
    public function findAll() {
        $users = $this->User->find();
        echo json_encode($users);
    }

    /**
    * Login de facebook
    *
    * @access public
    */
    public function login_facebook()
    {
        $data["facebook_id"] = $this->input->get('facebook_id');
        $data["mail"] = $this->input->get('mail');
        $data["name"] = $this->input->get('name');
        $data["surname"] = $this->input->get('surname');

        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        //$result =
        $this->_validate_data_facebook($data);

        $where = array("mail" => $data["mail"]);
        $result = $this->User->find($where)[0];
        echo json_encode($result);
    }

    /**
    * Valida los datos ingresados del usuario a registrar.
    * @access private
    */
    private function _validate_data_facebook($data)
    {
        if ($this->User->exists(array("mail" => $data["mail"]))) {
          if($this->_is_valid_facebook_id($data["mail"], $data["facebook_id"])){
            $result["mensaje"] = "Logeado correctamente";
          }else {
            $result["mensaje"] = "facebook_id incorrecto";
          }
          $result["registrado"] = FALSE;
        } else {
            $result = $this->_insert_user($data);
        }

        return $result;
    }

    /**
    * Valida si el id de facebook recibido corresponde a la cuenta asociada al mail recibido.
    *
    * @access private
    * @param $mail correo del usuario
    * @param facebook_id contraseña ingresada por el usuario
    * @return Boolean TRUE si los facebook_id coinciden.
    */
    private function _is_valid_facebook_id($mail, $facebook_id)
    {
        $where = array("mail" => $mail);
        $user = $this->User->find($where);

        return $user[0]->facebook_id == $facebook_id;
    }

}
