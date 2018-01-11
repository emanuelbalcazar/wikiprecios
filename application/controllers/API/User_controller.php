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
}
