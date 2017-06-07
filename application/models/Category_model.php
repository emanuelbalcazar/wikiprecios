<?php

/**
* Clase que representa una Categoria dentro de un rubro.
* Por ej: carnes: peceto, lomo, nalga.
*         verduras: manzanas, naranjas, mandarinas, etc.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra una nueva categoria
    *
    * @access  public
    * @param $item rubro
    * @param $category_name nombre de la categoria
    * @param $special_product_code codigo del producto especial
    * @return un booleano indicando si la categoria fue registrada
    */
    public function register_category($item, $category_name, $special_product_code, $unit)
    {
        $data = array(
            'item_id' => $item,
            'category' => $category_name,
            'special_product_code' => $special_product_code,
            'unit' => $unit
        );

        $result = $this->db->insert('categories', $data);
        return $result;
    }

    /**
    * Retorna las categorias de un rubro determinado
    *
    * @access  public
    * @param $item rubro
    * @return todas las categorias del rubro
    */
    public function get_categories_of_items($item)
    {
        $this->db->where('item_id', $item);
        $result = $this->db->get('categories');
        return $result->result();
    }

    /**
    * Verifica si la categoria ya existe en la Base de Datos
    *
    * @access  public
    * @param $name nombre de la categoria
    * @return un booleano indicando si la categoria existe
    */
    public function category_exists($name)
    {
        $this->db->select('count(*) as count');
        $this->db->from('categories');
        $this->db->where('category', $name);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }
}
