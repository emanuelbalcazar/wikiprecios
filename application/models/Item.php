<?php

/**
* Clase que representa un Rubro.
* por ej: carnes, verduras, frutas, etc.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Item extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'items';
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

    /**
    * Busca un rubro por su nombre incluyendo ocurrencias en substrings.
    *
    * @access  public
    * @param $name nombre del rubro
    * @return el rubro encontrado
    */
    public function search_item($name)
    {
        $this->db->like('name', $name, 'both');
        $result = $this->db->get('items');
        return $result->result();
    }
}
