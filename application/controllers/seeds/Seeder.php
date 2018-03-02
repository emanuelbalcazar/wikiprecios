<?php

/**
 * Clase encargada de cargar la base de datos con informacion de archivos CSV.
 *
 * @package         CodeIgniter
 * @subpackage      controllers/seeds
 * @category        Seeder
 */
class Seeder extends CI_Controller
{
    protected $route = '/controllers/seeds/files/';
    protected $file_path;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->load->library('csvimport');
        $this->load->library('files');

        $this->load->model('Province');
        $this->load->model('Country');
        $this->load->model('City');
        $this->load->model('Commerce');
        $this->load->model('Item');
        $this->load->model('Category');
        $this->load->model('Administrator');
        $this->load->model('User');
        $this->load->model('Product');

        $this->file_path = APPPATH.$this->route;
    }

    /**
     * Ejecuta todos los metodos de carga de datos
     * @access  public
     */
    public function run()
    {
        $this->load_countries();
        $this->load_provinces();
        $this->load_cities();
        $this->load_businesses();
        $this->load_items();
        $this->load_categories();
        $this->load_administrators();
        $this->load_users();
        $this->load_products();
    }

    /**
     * Carga paises desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_countries()
    {
        $file = $this->file_path.'countries.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Country);
            $this->files->init_load();
            echo 'Se crearon los paises satisfactoriamente'.PHP_EOL;
            return;
        }
        echo 'No se pudieron cargar los paises correctamente'.PHP_EOL;
    }

    /**
     * Carga provincias desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_provinces()
    {
        $file = $this->file_path.'provinces.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Province);
            $this->files->init_load();
            echo 'Se crearon las provincias satisfactoriamente'.PHP_EOL;
            return;
        }
        echo 'No se pudieron cargar las provincias correctamente'.PHP_EOL;
    }

    /**
     * Carga ciudades desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_cities()
    {
        $file = $this->file_path.'cities.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new City);
            $this->files->init_load();
            echo 'Se crearon las ciudades satisfactoriamente'.PHP_EOL;
            return;
        }
        echo 'No se pudieron cargar las ciudades correctamente'.PHP_EOL;
    }

    /**
     * Carga comercios desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_businesses()
    {
        $file = $this->file_path.'businesses.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Commerce);
            $this->files->init_load();
            echo  'Se crearon los comercios satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar los comercios correctamente'.PHP_EOL;
    }

    /**
     * Carga los rubros desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_items()
    {
        $file = $this->file_path.'items.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Item);
            $this->files->init_load();
            echo  'Se crearon los rubros satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar los rubros correctamente'.PHP_EOL;
    }

    /**
     * Carga las categorias desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_categories()
    {
        $file = $this->file_path.'categories.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Category);
            $this->files->init_load();
            echo  'Se crearon las categorias satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar las categorias correctamente'.PHP_EOL;
    }

    /**
     * Carga administradores desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_administrators()
    {
        $file = $this->file_path.'administrators.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new Administrator);
            $this->files->init_load();
            echo  'Se crearon los administradores satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar los administradores correctamente'.PHP_EOL;
    }

    /**
     * Carga usuarios desde un archivo CSV a la Base de Datos.
     *
     * @access public
     */
    public function load_users()
    {
        $file = $this->file_path.'users.csv';

        if ($this->files->set_file($file)) {
            $this->files->set_model(new User);
            $this->files->init_load();
            echo  'Se crearon los usuarios satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar los usuarios correctamente'.PHP_EOL;
    }

    /**
     * Carga productos desde un archivo CSV a la Base de Datos.
     * @access public
     */
    public function load_products() {
        $file = $this->file_path.'products.csv';
        
        if ($this->files->set_file($file)) {
            $this->files->set_model(new Product);
            $this->files->init_load();
            echo  'Se crearon los productos satisfactoriamente'.PHP_EOL;
            return;
        }
        echo  'No se pudieron cargar los productos correctamente'.PHP_EOL;
    }

}
