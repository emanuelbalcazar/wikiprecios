<?php

/**
* Clase que representa un Comercio Favorito.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Favorite_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Registra el comercio como favorito a un usuario recibido como parametro
    *
    * @access  public
    * @param $user
    * @param $commerce
    * @return un booleano indicando si el comercio favorito pudo ser registrado
    */
    public function register_favorite_trade($user, $commerce)
    {
        $data = array(
            'user' => $user,
            'commerce_id' => $commerce
        );

        $result = $this->db->insert('favorites', $data);
        return $result;
    }

    /**
    * Elimina todos los comercios favoritos de un usuario
    *
    * @access  public
    * @param $user
    * @return la cantidad de filas afectadas
    */
    public function delete_all_favorites($user)
    {
        $this->db->where('user', $user);
        $this->db->delete('favorites');
        return $this->db->affected_rows();
    }
}
