<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* File
* Libreria que facilita la carga de datos desde archivos CSV.
*
* @package         CodeIgniter
* @subpackage      Libraries
* @category        Libraries
*/

class Files {

    protected $file_path;
    protected $filter;
    protected $model;

    /**
    * Constructor que se ejecuta al cargar la libreria, este llama a un get_instance()
    * que permite invocar otras librerias.
    */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('csvimport');
    }

    /**
    * Setea la ruta del archivo a cargar.
    *
    * @access  public
    * @param   $file_path ruta completa del archivo a cargar.
    * @return  TRUE si el archivo puede ser cargado, FALSE en caso contrario
    */
    public function set_file($file_path)
    {
        $this->file_path = $file_path;
        return ($this->CI->csvimport->get_array($file_path));
    }

    /**
    * Setea el modelo utilizado para realizar la creacion de nuevos registros.
    *
    * @access  public
    * @param   $model instancia de un modelo, si extiende de MY_Model puede utilizarse.
    */
    public function set_model($model)
    {
        $this->model = $model;
    }

    /**
    * @access  public
    * @param  $array retorna los datos leidos en el archivo.
    */
    public function get_data()
    {
        return $this->CI->csvimport->get_array($this->file_path);
    }

    /**
    * Inicia la carga de los datos utilizando el modelo para crear los nuevos registros.
    *
    * @access  public
    * @return $count retorna la cantidad de registros creados en la base de datos.
    */
    public function init_load()
    {
        $count = 0;
        $data = $this->CI->csvimport->get_array($this->file_path);

        foreach ($data as $row) {
            if (!$this->model->exists($row)) {
                $this->model->create($row);
                $count++;
            }
        }

        return $count;
    }
}
