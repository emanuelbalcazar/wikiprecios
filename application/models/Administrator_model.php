<?php

/**
* Clase que representa un Administrator.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Administrator_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('date');
    }

    /**
    * Agrega un nuevo administrador en la Base de Datos
    *
    * @access  public
    * @param type $name
    * @param type $surname
    * @param type $mail
    * @param type $password
    * @param type $city
    * @param type $province
    * @param type $country
    * @return boolean true si pudo registrar al administrador
    */
    public function register_administrator($name, $surname,  $mail, $password, $city, $province, $country)
    {
        $city = strtoupper($city);
        $province = strtoupper($province);
        $country = strtoupper($country);

        $admin = array(
            'name' => $name,
            'surname' => $surname,
            'mail' => $mail,
            'password' => $password,
            'city' => $city,
            'province' => $province,
            'country' => $country,
            'active_account' => TRUE,
            'last_session' => date("Y-m-d H:i")
        );

        $result = $this->db->insert('administrators', $admin);
        return $result;
    }

    /**
    * Busca y retorna un administrador buscado por su Email
    *
    * @access  public
    * @param type $mail
    * @return el usuario encontrado
    */
    public function find_admin_by_email($mail)
    {
        $this->db->where('mail', $mail);
        $result = $this->db->get('administrators');

        return $result->row();
    }

    /**
    * Actualiza la contraseña del administrador ingresado.
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
        $result = $this->db->update('administrators', $data);
        return $result;
    }

    /**
    * Actualiza la fecha/hora de la ultima sesion iniciada por un administrador.
    *
    * @access  public
    * @param type $mail
    * @return boolean true si pudo actualizar la ultima sesion.
    */
    public function update_last_session($mail)
    {
        $data = array(
            'last_session' => date("Y-m-d H:i")
        );

        $this->db->where('mail', $mail);
        $result = $this->db->update('administrators', $data);
        return $result;
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
