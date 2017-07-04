<?php

/**
* Clase que representa un Pais.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Country extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'countries';
    }

}
