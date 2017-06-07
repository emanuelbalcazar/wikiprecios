<?php

/**
* Clase que representa un Pais.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Country_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra un pais en la Base de Datos
    *
    * @access  public
    * @param $country pais
    * @return un booleano indicando si el pais pudo ser registrada
    */
    public function register_country($country)
    {
        $country = strtoupper($country);
        $data = array(
            'name' => $country
        );

        $result = $this->db->insert('countries', $data);

        return $result;
    }

    /**
    * Verifica si el pais existe en la Base de Datos
    *
    * @access  public
    * @param $country pais
    * @return un booleano indicando si el pais pudo ser registrada
    */
    public function country_exists($country)
    {
        $country = strtoupper($country);
        $this->db->select('count(*) as count');
        $this->db->from('countries');
        $this->db->where('name', $country);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    public function get_countries()
    {
        $result = $this->db->get('countries');
        return $result->result();
    }
}
