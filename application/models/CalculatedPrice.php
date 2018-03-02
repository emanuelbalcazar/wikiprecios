<?php

/**
* Clase que representa un precio calculado.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class CalculatedPrice extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'pricescalculated';
    }

}