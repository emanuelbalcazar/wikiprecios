<?php

/**
* Clase que representa un Usuario.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    /**
    * Agrega un nuevo usuario en la Base de Datos
    *
    * @access  public
    * @param type $password
    * @param type $mail
    * @param type $name
    * @param type $surname
    * @param type $qualification
    * @return boolean true si pudo registrar el usuario
    */
    public function create_user($password, $mail, $name, $surname, $qualification, $accumulated = 0)
    {
        $user = array(
            'name' => $name,
            'surname' => $surname,
            'mail' => $mail,
            'password' => $password,
            'qualification' => $qualification,
            'accumulated' => $accumulated,
            'active_account' => TRUE
        );

        $result = $this->db->insert('users', $user);
        return $result;
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
    * Busca y retorna un usuario buscado por su Email
    *
    * @access  public
    * @param type $mail
    * @return el usuario encontrado
    */
    public function find_user_by_email($mail)
    {
        $this->db->where('mail', $mail);
        $result = $this->db->get('users');

        return $result->row();
    }

    /**
    * Actualiza la Calificacion y los Acumulados de un Usuario
    *
    * @access  public
    * @param type $mail
    * @param type $qualification
    * @param type $accumulated
    * @return boolean true si pudo actualizar la calificacion y acumulado.
    */
    public function update_rating($mail, $qualification, $accumulated)
    {
        $data = array(
            'qualification' => $qualification,
            'accumulated' => $accumulated
        );

        $this->db->where('mail', $mail);
        $result = $this->db->update('users', $data);
        return $result;
    }

    /**
    * Actualiza la contraseña del usuario ingresado.
    *
    * @access  public
    * @param type $mail
    * @param type $password nueva contraseña
    * @return boolean true si pudo actualizar la contraseña
    */
    public function update_password($mail, $password)
    {
        $data = array(
            'password' => $password
        );

        $this->db->where('mail', $mail);
        $result = $this->db->update('users', $data);
        return $result;
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
        $data = array(
            'active_account' => FALSE
        );

        $this->db->where('mail', $mail);
        $result = $this->db->update('users', $data);
        return $result;
    }
}
