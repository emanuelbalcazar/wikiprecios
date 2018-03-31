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
        $data["letter"] = $this->input->post('letter');
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Item->find(array('name' => $data["name"]))) {
            $result["error"] = "El rubro \"".$data["name"]."\" ya existe";
            $result["registered"] = FALSE;
        } else {

            if ($this->Item->find(array('letter' => $data['letter'])))
                $result["error"] = "El codigo de rubro \"" . $data["letter"] . "\" ya fue utilizado.";
            else {
                $status = $this->Item->create($data);
                $result["success"] = $status;
            }
        }

        echo json_encode($result);
    }

    public function update($id)
    {
        $status = $this->input->post('active');
        $where = array('id' => $id);
        $data = array('active' => $status);

        $updated = $this->Item->update($where, $data);

        if ($updated)
            $result["success"] = "Rubro actualizado";
        else
            $result["error"] = "Ocurrio un error al actualizar el rubro";

        echo json_encode($result);
    }

    public function delete($id) 
    {
        $result["deleted"] = $this->Item->delete(array("id" => $id));

        if ($result["deleted"] > 0)
            $result["success"] = "El rubro se elimino correctamente.";
        else
            $result["error"] = "No se pudo eliminar el rubro con ID ".$id;

        echo json_encode($result);
    }

} 
