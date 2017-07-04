<?php

/**
* Clase que representa un Administrator.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Administrator extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->table = 'administrators';
    }

    /**
    * Desactiva una cuenta de administrador cambiando el estado de su cuenta en
    * la base de datos.
    *
    * @access  public
    * @param type $mail
    * @return boolean true si pudo actualizar el estado de la cuenta.
    */
    public function delete_account($mail)
    {
        $data = array(
            'active_account' => FALSE
        );

        $this->db->where('mail', $mail);
        $result = $this->db->update('administrators', $data);
        return $result;
    }
}
