<?php

/**
* Clase que representa un Producto Especial.
* por ej: carnes, verduras, frutas, etc. no poseen un codigo de
* barra unico ya que es asignado por cada comercio en particular.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Special_product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
    * Registra un nuevo producto especial
    *
    * @access  public
    * @param $special_product_code codigo del nuevo producto
    * @param $name nombre del producto especial
    * @return un booleano indicando si el producto fue registrado
    */
    public function register_special_product($special_product_code, $name)
    {
        $data = array(
            'product_code' => $special_product_code,
            'name' => $name
        );

        $result = $this->db->insert('products', $data);
        return $result;
    }
}
