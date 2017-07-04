<?php

/**
* Controlador de la clase Comercio.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Commerce_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Commerce_model');
        $this->load->library('utils');
        $this->table = 'cities';
    }

    /**
    *  Registra un nuevo comercio en caso de que no exista
    *
    * @access public
    */
    public function register_trade()
    {
        $data["name"] = $this->input->get('name');
        $data["address"] = $this->input->get('address');
        $data["latitude"] = $this->input->get('latitude');
        $data["longitude"] = $this->input->get('longitude');
        $data["city"] = $this->input->get('city');
        $data["province"] = $this->input->get('province');
        $data["country"] = $this->input->get('country');

        // En caso de recibir multiples comercios, los separo en campos independientes
        $data = $this->utils->replace($data, "+", " ");
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Commerce_model->commerce_exists($data["name"], $data["address"], $data["city"], $data["province"])) {
            $result["registered"] = FALSE;
            $result["message"] = "El comercio ya existe";
        } else {
            $result = $this->insert_commerce($data);
        }
        echo json_encode($result);
    }

    /**
    * Inserta un nuevo comercio en la Base de Datos
    *
    * @access private
    */
    private function insert_commerce($data)
    {
        $insert = $this->Commerce_model->register_trade($data["name"], $data["address"], $data["latitude"], $data["longitude"],
                                                        $data["city"], $data["province"], $data["country"]);

        if ($insert) {
            $result["registered"] = TRUE;
            $result["message"] = "Comercio registrado con exito";
        } else {
            $result["registered"] = FALSE;
            $data["message"] = "Hubo un error al insertar el comercio, intentelo de nuevo";
        }
        return $result;
    }

    /**
     * Devuelve todos los comercios registrados
     *
     * @access public
     */
    public function businesses()
    {
        //$result = $this->Commerce_model->get_businesses();
        $result = $this->Commerce_model->findAll();
        echo json_encode($result);
    }

    /**
    *  Devuelve todos los comercios favoritos de un determinado usuario
    *
    * @access public
    */
    public function favorites_businesses()
    {
        $data["user"] = $this->input->get('user');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $commerces = $this->Commerce_model->get_businesses();
        $favorites_businesses = $this->Commerce_model->get_favorites_businesses($data["user"]);

        for ($i = 0; $i < count($commerces); $i++) {
            $commerce = $commerces[$i];
            $commerce->id = intval($commerce->id);
            $commerce->favorite = ($this->_is_favorite($commerce->id, $favorites_businesses)) ? TRUE : FALSE;
        }


        echo json_encode($commerces);
    }

    /**
    * Devuelve los comercios favoritos ordenados por cercania (comercios cercanos)
    * TODO - Indicar si el comercio es favorito o no.
    *
    * @access public
    */
    public function nearby_businesses()
    {
        $data["latitude"] = $this->input->get('latitud');
        $data["longitude"] = $this->input->get('longitud');
        $data["user"] = $this->input->get('usuario');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $commerces = $this->Commerce_model->get_businesses();
        $favorites_businesses = $this->Commerce_model->get_favorites_businesses($data["user"]);

        for ($i = 0; $i < count($commerces); $i++) {
            $distance = $this->utils->calculate_distance($data["latitude"], $data["longitude"], $commerces[$i]->latitude, $commerces[$i]->longitude);
            $commerce = $commerces[$i];
            $commerce->distance = $distance;

            $commerce->favorite = ($this->_is_favorite($commerce->id, $favorites_businesses)) ? 1 : 0;
        }

        uasort($commerces, array($this, 'cmp')); // Ordeno los comercios de menor a mayor

        $nearby_businesses = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($nearby_businesses, next($commerces));
        }

        echo json_encode($nearby_businesses);
    }

    /**
    * Busca un comercio favorito en un arreglo de comercios favoritos existentes.
    *
    * @access private
    */
    private function _is_favorite($id, $favorites)
    {
        for ($i = 0; $i < count($favorites); $i++) {
            if ($id == $favorites[$i]->commerce_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
    * Funcion de comparacion para el ordenamiento.
    *
    * @access private
    */
    private function cmp($a, $b)
    {
        if ($a->distance == $b->distance) {
            return 0;
        }
        return ($a->distance < $b->distance) ? -1 : 1;
    }

} // Fin del controlador
