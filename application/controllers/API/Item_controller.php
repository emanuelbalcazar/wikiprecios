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
        $data["name"] = $this->input->post('name');
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Item->exists($data)) {
            $result["error"] = "El rubro \"".$data["name"]."\" ya existe";
            $result["registered"] = FALSE;
        } else {
            $data["letter"] = strtoupper(substr($data["name"], 0, 3));
            $result["registered"] = $this->Item->create($data);
            $result["success"] = "Rubro agregado correctamente";
        }

        echo json_encode($result);
    }

    public function delete($id) {
        $result["deleted"] = $this->Item->delete(array("id" => $id));

        if ($result["deleted"] > 0)
            $result["success"] = "El rubro se elimino correctamente.";
        else
            $result["error"] = "No se pudo eliminar el rubro con ID ".$id;

        echo json_encode($result);
    }

} 
