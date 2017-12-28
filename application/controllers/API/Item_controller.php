<?php

/**
* Controlador de la clase Rubro.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Item_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Item');
        $this->load->library('utils');
    }

    /**
    * Registra un nuevo rubro
    *
    * @access public
    */
    public function register()
    {
        $data["name"] = $this->input->get('name');
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Item->exists($data)) {
            $result["message"] = "El rubro ya existe";
            $result["registered"] = FALSE;
        } else {
            $data["letter"] = strtoupper(substr($data["name"], 0, 3));
            $result["registered"] = $this->Item->create($data);
            $result["message"] = "Rubro agregado correctamente";
        }
        echo json_encode($result);
    }

} 
