<?php

/**
* Clase que representa un Comercio.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Commerce_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra un comercio en la Base de Datos
    *
    * @access  public
    * @param $name
    * @param $address
    * @param $latitude
    * @param $longitude
    * @return un booleano indicando si el comercio pudo ser registrado
    */
    public function register_trade($name, $address, $latitude, $longitude, $city, $province, $country)
    {
        $city = strtoupper($city);
        $province = strtoupper($province);
        $country = strtoupper($country);

        $data = array(
            'name' => $name,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'city' => $city,
            'province' => $province,
            'country' => $country
        );

        $result = $this->db->insert('businesses', $data);
        return $result;
    }

    /**
    * Verifica si el comercio ya existe en la Base de Datos
    *
    * @access  public
    * @param $name nombre del comercio
    * @param $address direccion del comercio
    * @param $city ciudad donde se ubica el comercio
    * @param $province provincia donde se ubica el comercio
    * @return un booleano indicando si el comercio existe
    */
    public function commerce_exists($name, $address, $city, $province)
    {
        $city = strtoupper($city);
        $province = strtoupper($province);

        $this->db->select('count(*) as count');
        $this->db->from('businesses');
        $this->db->where('name', $name);
        $this->db->where('address', $address);
        $this->db->where('city', $city);
        $this->db->where('province', $province);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    /**
    *
    * @access  public
    * @return todos los comercios registrados
    */
    public function get_businesses()
    {
        $result = $this->db->get('businesses');
        return $result->result();
    }

    /**
    *
    * @access  public
    * @param $user
    * @return todos los comercios favoritos del usuario pasado como parametro
    */
    public function get_favorites_businesses($user)
    {
        $this->db->select('*');
        $this->db->from('businesses b');
        $this->db->join('favorites as f', 'f.commerce_id = b.id');
        $this->db->where('f.user', $user);
        $result = $this->db->get();

        return $result->result();
    }

    public function find_commerce_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('businesses');

        return $result->row();
    }
}
