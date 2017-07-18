<?php

/**
* Clase que representa un Usuario.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class User extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->table = 'users';
    }

    /**
    * Obtiene la calificacion del usuario
    *
    * @access  public
    * @param $mail
    * @return la calificacion del usuario
    */
    public function get_qualification($mail)
    {
        $this->db->select('qualification');
        $this->db->where('mail', $mail);
        $result = $this->db->get('users');

        return $result->row();
    }

    /**
    * Desactiva una cuenta de usuario cambiando el estado de su cuenta en
    * la base de datos.
    *
    * @access  public
    * @param type $mail
    * @return boolean true si pudo actualizar el estado de la cuenta.
    */
    public function delete_account($mail)
    {
        $data = array('active_account' => FALSE);

        $this->db->where('mail', $mail);
        $result = $this->db->update('users', $data);
        return $result;
    }
}
