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
class Category extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'categories';
    }

}
