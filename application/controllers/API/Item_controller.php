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
        $this->load->helper(array('url', 'form'));
        $this->load->model('Item_model');
        $this->load->library('utils');
    }

    /**
    * Registra un nuevo rubro
    *
    * @access public
    */
    public function register_item()
    {
        $data["name"] = $this->input->get('name');
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Item_model->item_exists($data["name"])) {
            $result["message"] = "El rubro ya existe";
            $result["registered"] = FALSE;
        } else {
            $result = $this->_insert_item($data["name"]);
        }
        echo json_encode($result);
    }

    /**
     * Inserta un nuevo rubro en la base de datos
     *
     * @access private
     * @param $item rubro a insertar
     * @return $data indicando si el rubro pudo ser insertado
     */
    private function _insert_item($name)
    {
        $registered = $this->Item_model->register_item($name);

        if ($registered) {
            $data["message"] = "Rubro agregado correctamente";
            $data["registered"] = TRUE;
        } else {
            $data["message"] = "No se pudo registrar el rubro";
            $data["registered"] = FALSE;
        }

        return $data;
    }

}  // Fin del controlador
