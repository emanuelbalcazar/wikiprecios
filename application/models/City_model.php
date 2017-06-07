<?php

/**
* Clase que representa una Ciudad.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class City_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra una ciudad en la Base de Datos
    *
    * @access  public
    * @param $postal_code codigo postal de la ciudad
    * @param $city nombre de la ciudad
    * @return un booleano indicando si la ciudad pudo ser registrada
    */
    public function register_city($postal_code, $city)
    {
        $city = strtoupper($city);
        $data = array(
            'postal_code' => $postal_code,
            'name' => $city
        );

        $result = $this->db->insert('cities', $data);
        return $result;
    }

    /**
    * Verifica si la ciudad ya existe en la Base de Datos
    *
    * @access  public
    * @param $city nombre de la ciudad
    * @return un booleano indicando si la ciudad existe
    */
    public function city_exists($city)
    {
        $city = strtoupper($city);
        $this->db->select('count(*) as count');
        $this->db->from('cities');
        $this->db->where('name', $city);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    public function get_cities()
    {
        $result = $this->db->get('cities');
        return $result->result();
    }
}
