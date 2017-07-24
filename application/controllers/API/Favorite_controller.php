<?php

/**
* Controlador de los Comercios Favoritos.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Favorite_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Favorite');
        $this->load->library('utils');
    }

    /**
    * Registra uno o mas comercios como favorito a un determinado usuario
    * Si el comercio es menor a 0, se eliminan todos los favoritos del usuario
    *
    * @access public
    */
    public function register()
    {
        $data["user"] = $this->input->get('user');
        $data["commerce"] = $this->input->get('commerce');
        $data = $this->utils->replace($data, "\"", "");

        if ($data["commerce"] < 0) {
            $result["deleted"] = $this->Favorite->delete(array("user" => $data["user"]));
            $result["message"] = "Se eliminaron los comercios favoritos satisfactoriamente";
        } else {
            $result = $this->_insert_favorite_trade($data["commerce"], $data["user"]);
        }

        echo json_encode($result);
    }

    /**
     * Inserta uno o mas comercios favoritos en la base de datos
     *
     * @access private
     * @param type $businesses comercios favoritos a insertar
     * @param type $user identificador del usuario
     */
    private function _insert_favorite_trade($businesses, $user)
    {
        // retorna un arreglo con cada elemento separado por el delimitador
        $favorites_businesses = explode(",", $businesses);
        $this->Favorite->delete(array("user" => $user));

        foreach ($favorites_businesses as $commerce) {
            $params = array("user" => $user, "commerce_id" => $commerce);
            $result["registered"] = $this->Favorite->create($params);
            array_push($result, $commerce);
        }
        return $result;
    }

} // Fin del controlador
