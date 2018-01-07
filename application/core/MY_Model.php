<?php

/**
* Modelo Generico.
*
* Todos los modelos deben extender de esta clase la cual agrupa los metodos
* comunes para todos los modelos utilizados.
*
* @package         CodeIgniter
* @subpackage      Core
* @category        Models
*/
class MY_Model extends CI_Model {

    /**
     * Nombre de la tabla a la cual le corresponde el modelo, se sobreescribe
     * en cada implementacion.
     * @var String
     */
    protected $table = '';


    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
    }

    /**
    * Crea un nuevo registro en la base de datos.
    *
    * @access public
    * @param $data
    * @return Boolean TRUE en caso de la creacion exitosa, FALSE en caso contrario.
    */
    public function create($data = [])
    {
        if (isset($data['password']))
            $data['password'] = $this->encryption->encrypt($data['password']);

        $result = $this->db->insert($this->table, $data);
        return $result;
    }

    /**
    * Busca un registro filtrando por los atributos recibidos como parametro.
    * Por defecto, si no recibe ningun parametro de busqueda trae todos los registros.
    *
    * @access public
    * @param $where condiciones de busqueda en la base de datos, puede no estar.
    * @return Array el registro encontrado, o arreglo vacio en otro caso.
    */
    public function find($where = [])
    {
        $this->db->where($where);
        $result = $this->db->get($this->table);

        return $result->result();
    }

    /**
    * Actualiza un registro con los datos indicados como parametros.
    *
    * @access public
    * @param $where condiciones de busqueda para el registro a actualizar.
    * @param $data informacion a actualizar.
    * @return Boolean TRUE si el registro pudo ser actualizado.
    */
    public function update($where = [], $data = [])
    {
        $this->db->where($where);
        $result = $this->db->update($this->table, $data);

        return $result;
    }

    /**
    * Actualiza un registro con los datos indicados como parametros.
    *
    * @access public
    * @param $where condiciones de busqueda para el registro a borrar.
    * @return Number cantidad de columnas afectadas.
    */
    public function delete($where = [])
    {
        $this->db->where($where);
        $this->db->delete($this->table);

        return $this->db->affected_rows();
    }

    /**
    * @access public
    * @return Schema retorna los campos de la tabla en la base de datos.
    */
    public function get_schema()
    {
        $fields = $this->db->list_fields($this->table);
        return $fields;
    }

    /**
    * Verifica si un registro existe.
    *
    * @access public
    * @return TRUE si existe, FALSE en caso contrario.
    */
    public function exists($where = [])
    {
        if (isset($where['password']))
            unset($where['password']);

        $this->db->select('count(*) as count');
        $this->db->from($this->table);
        $this->db->where($where);
        $result = $this->db->get();

        return ($result->row()->count > 0);
    }

}
