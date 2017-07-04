<?php

/**
* Clase que representa un Comercio.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/

class Commerce extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'businesses';
    }


    /**
    * @access  public
    * @param $user
    * @return todos los comercios favoritos del usuario pasado como parametro
    */
    public function get_favorites_businesses($user)
    {
        $this->db->select('*');
        $this->db->from('businesses b');
        $this->db->join('favorites as f', 'f.commerce_id = b.id');
        $this->db->where('f.user', $user);
        $result = $this->db->get();

        return $result->result();
    }

}
