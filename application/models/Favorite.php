<?php

/**
* Clase que representa un Comercio Favorito.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Favorite extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'favorites';
    }

}
