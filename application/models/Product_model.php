<?php

/**
* Clase que representa a un Producto.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra un nuevo producto mediante su codigo de barra
    *
    * @access  public
    * @param $product_code
    * @return un booleano indicando si el producto pudo ser registrado
    */
    public function register_product($product_code, $name = '')
    {
        $data = array(
            'product_code' => $product_code,
            'name' => $name
        );

        $result = $this->db->insert('products', $data);
        return $result;
    }

    /**
    * Verifica si un producto ya existe en la Base de datos mediante su codigo
    *
    * @access  public
    * @param $product_code
    * @return un booleano indicando si el producto existe
    */
    public function product_exists($product_code)
    {
        $this->db->select('count(*) as count');
        $this->db->from('products');
        $this->db->where('product_code', $product_code);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

}
