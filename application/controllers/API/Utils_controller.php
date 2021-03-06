<?php

/**
* Controlador con funciones de utileria para la API Rest.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Utils_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Retorna la version actual de la aplicacion.
     * @access public
     */
    public function version()
    {
        $version["name"] = "wikiprecios";
        $versiom["version"] = "3.0";
        $version["date"] = "diciembre 2017";
        $version["php"] = phpversion();

        echo json_encode($version);
    }

     /**
     * Retorna el mensaje recibido como dato en el POST.
     * @access public
     */
    public function echo() {
        $data["message"] = $this->input->post('message', TRUE);
        $data["status"] = "ok";
 
        echo json_encode($data);
    }
}
