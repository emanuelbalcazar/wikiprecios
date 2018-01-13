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
        $this->load->model('Commerce');
        $this->load->library('utils');
    }

    /**
    * Registra un nuevo comercio en caso de que no exista.
    * @access public
    */
    public function register()
    {
        $data["name"] = $this->input->post('name');
        $data["address"] = $this->input->post('address');
        $data["latitude"] = $this->input->post('latitude');
        $data["longitude"] = $this->input->post('longitude');
        $data["city"] = $this->input->post('city');
        $data["province"] = $this->input->post('province');
        $data["country"] = $this->input->post('country');

        $data = $this->utils->replace($data, "\"", "");     // elimino las comillas.

        // Armo la consulta de busqueda en el arreglo.
        $where = $data;

        if ($this->Commerce->exists($where)) {
            $result["registered"] = FALSE;
            $result["message"] = "El comercio ya existe";
        } else {
            $result = $this->insert_commerce($data);
        }

        echo json_encode($result);
    }

    /**
    * Inserta un nuevo comercio en la Base de Datos.
    * @access private
    */
    private function insert_commerce($data)
    {
        $result["registered"] = $this->Commerce->create($data);
        $result["message"] = ($result["registered"]) ? "Comercio registrado con exito" : "Hubo un error al insertar el comercio";
        $result["commerce"] = $this->Commerce->find_by_name($data["name"]);
        return $result;
    }

    /**
     * Devuelve todos los comercios registrados
     * @access public
     */
    public function businesses()
    {
        $result = $this->Commerce->find();
        echo json_encode($result);
    }

    /**
    * Devuelve todos los comercios favoritos de un determinado usuario.
    * @access public
    */
    public function favorites()
    {
        $data["user"] = $this->input->get('user');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $commerces = $this->Commerce->find();
        $favorites_businesses = $this->Commerce->get_favorites($data["user"]);

        for ($i = 0; $i < count($commerces); $i++) {
            $commerce = $commerces[$i];
            $commerce->id = intval($commerce->id);
            $commerce->favorite = ($this->_is_favorite($commerce->id, $favorites_businesses)) ? 1 : 0;
        }

        echo json_encode($commerces);
    }

    /**
    * Devuelve los comercios favoritos ordenados por cercania (comercios cercanos)
    * @access public
    */
    public function nearby_businesses()
    {
        $data["latitude"] = $this->input->get('latitud');
        $data["longitude"] = $this->input->get('longitud');
        $data["user"] = $this->input->get('usuario');
        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        $commerces = $this->Commerce->find();
        $favorites_businesses = $this->Commerce->get_favorites($data["user"]);  // obtengo los comercios favoritos.

        $commerces = $this->_get_favorites_by_distance($commerces, $favorites_businesses, $data);
        $nearby_businesses = [];    // almaceno los comercios cercanos para posteriormente devolverlos.

        for ($i = 0; $i < count($commerces) - 1; $i++) {
            array_push($nearby_businesses, next($commerces));
        }

        echo json_encode($nearby_businesses);
    }

    /**
     * Retorna todos los comercios ordenados por distancia e indicando si es favorito o no
     * @param  [Array] $commerces todos los comercios registrados.
     * @param  [Array] $favorites_businesses comercios favoritos del usuario.
     * @param  [Array] $data  datos recibidos en el request.
     * @return [Array] todos los comercios ordenados por distancia, mas una bandera
     * indicando si el comercio es favorito del usuario o no.
     */
    private function _get_favorites_by_distance($commerces, $favorites_businesses, $data)
    {
        for ($i = 0; $i < count($commerces); $i++) {
            $distance = $this->utils->calculate_distance($data["latitude"], $data["longitude"], $commerces[$i]->latitude, $commerces[$i]->longitude);
            $commerce = $commerces[$i];
            $commerce->distance = $distance;    // seteo la distancia calculada desde la coordenada del usuario.
            $commerce->favorite = ($this->_is_favorite($commerce->id, $favorites_businesses)) ? 1 : 0;
        }

        uasort($commerces, array($this, 'sort_by_distance')); // Ordeno los comercios de menor a mayor
        return $commerces;
    }

    /**
    * Busca un comercio favorito en un arreglo de comercios favoritos existentes.
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
    * Funcion de comparacion para el ordenamiento usando la distancia del comercio.
    * @access private
    */
    private function sort_by_distance($a, $b)
    {
        if ($a->distance == $b->distance) {
            return 0;
        }
        return ($a->distance < $b->distance) ? -1 : 1;
    }

    /**
    * Elimina un comercio mediante su ID.
    * @access public
    */
    public function delete($id) {
        $result["deleted"] = $this->Commerce->delete(array("id" => $id));

        if ($result["deleted"] > 0)
            $result["success"] = "El comercio se elimino correctamente.";
        else
            $result["error"] = "No se pudo eliminar el comercio con ID ".$id;

        echo json_encode($result);
    }

}
