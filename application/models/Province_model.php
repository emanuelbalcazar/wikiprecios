<?php

/**
* Clase que representa a una Provincia.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Province_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra una provincia en la Base de Datos
    *
    * @access  public
    * @param $province
    * @return un booleano indicando si la provincia pudo ser registrada
    */
    public function register_province($province)
    {
        $province = strtoupper($province);
        $data = array(
            'name' => $province
        );

        $result = $this->db->insert('provinces', $data);

        return $result;
    }

    /**
    * Verifica si la provincia ya existe en la Base de Datos
    *
    * @access  public
    * @param $province nombre de la provincia
    * @return un booleano indicando si la provincia existe
    */
    public function province_exists($province)
    {
        $province = strtoupper($province);
        $this->db->select('count(*) as count');
        $this->db->from('provinces');
        $this->db->where('name', $province);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    public function get_provinces()
    {
        $result = $this->db->get('provinces');
        return $result->result();
    }
}
