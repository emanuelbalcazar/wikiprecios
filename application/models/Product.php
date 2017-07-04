<?php

/**
* Clase que representa a un Producto.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Product extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'products';
    }

}
