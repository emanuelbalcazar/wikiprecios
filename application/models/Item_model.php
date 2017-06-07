<?php

/**
* Clase que representa un Rubro.
* por ej: carnes, verduras, frutas, etc.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Item_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra un nuevo rubro
    *
    * @access  public
    * @param $name nombre del rubro
    * @return un booleano indicando si el rubro fue registrado
    */
    public function register_item($name)
    {
        $letter = strtoupper(substr($name, 0, 3)); // Obtengo las 3 primeras letras
        $data = array(
            'letter' => $letter,
            'name' => $name
        );

        $result = $this->db->insert('items', $data);
        return $result;
    }

    /**
    * @access  public
    * @return todos los rubros registrados
    */
    public function get_items()
    {
        $result = $this->db->get('items');
        return $result->result();
    }

    /**
    * Verifica si el rubro ya existe en la Base de Datos
    *
    * @access  public
    * @param $name nombre del rubro
    * @return un booleano indicando si el rubro existe
    */
    public function item_exists($name)
    {
        $this->db->select('count(*) as count');
        $this->db->from('items');
        $this->db->where('name', $name);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    /**
    * Verifica si el rubro ya existe buscandolo por iD
    *
    * @access  public
    * @param $id ID del rubro
    * @return un booleano indicando si el rubro existe
    */
    public function id_item_exists($id)
    {
        $this->db->select('count(*) as count');
        $this->db->from('items');
        $this->db->where('id', $id);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

    /**
    * Retorna la cantidad de categorias de un rubro
    *
    * @access  public
    * @param $item rubro
    * @return cantidad de categorias
    */
    public function get_amount_category_by_item($item)
    {
        $this->db->select('count(*) quantity');
        $this->db->where('item_id', $item);
        $result = $this->db->get('categories')->row();

        return $result;
    }

    /**
    * Retorna las letras asociadas a un rubro
    *
    * @access  public
    * @param $name nombre del rubro
    * @return las letras del rubro
    */
    public function get_letters_item($id)
    {
        $this->db->select('letter');
        $this->db->where('id', $id);
        $result = $this->db->get('items');
        return $result->row();
    }

    public function search_item($name)
    {
        $this->db->like('name', $name, 'both');
        $result = $this->db->get('items');
        return $result->result();
    }
}
