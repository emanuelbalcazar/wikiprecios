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
class Special_product extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'products';
    }

}
