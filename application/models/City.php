<?php

/**
* Clase que representa una Ciudad.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class City extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'cities';
    }

    // methods in superclass
}
