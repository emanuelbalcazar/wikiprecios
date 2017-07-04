<?php

/**
* Clase que representa a una Provincia.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Province extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'provinces';
    }

}
