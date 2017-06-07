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
    private $route = '/controllers/seeds/files/';
    private $file_path;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->load->library('csvimport');
        $this->load->model('Province_model');
        $this->load->model('Country_model');
        $this->load->model('City_model');
        $this->load->model('Commerce_model');
        $this->load->model('Item_model');
        $this->load->model('Category_model');
        $this->load->model('Administrator_model');
        $this->load->model('User_model');

        $this->file_path = APPPATH.$this->route;
    }

    /**
     * Ejecuta todos los metodos de carga de datos
     * @access  public
     */
    public function run()
    {
        $this->_load_countries();
        $this->_load_provinces();
        $this->_load_cities();
        $this->_load_businesses();
        $this->_load_items();
        $this->_load_categories();
        $this->_load_administrators();
        $this->_load_users();
    }

    /**
     * Carga paises desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_countries()
    {
        $file = $this->file_path.'countries.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Country_model->country_exists($row['NAME'])) {
                    $this->Country_model->register_country($row['NAME']);
                }
            }
            echo '<p>'.'Se cargaron los paises satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar los paises'.'</p>';
        }
    }

    /**
     * Carga provincias desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_provinces()
    {
        $file = $this->file_path.'provinces.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Province_model->province_exists($row['NAME'])) {
                    $this->Province_model->register_province($row['NAME']);
                }
            }
            echo '<p>'.'Se cargaron las provincias satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar las provincias'.'</p>';
        }
    }

    /**
     * Carga ciudades desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_cities()
    {
        $file = $this->file_path.'cities.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->City_model->city_exists($row['CITY'])) {
                    $this->City_model->register_city($row['CODE'], $row['CITY']);
                }
            }
            echo '<p>'.'Se cargaron las ciudades satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar las ciudades'.'</p>';
        }
    }

    /**
     * Carga comercios desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_businesses()
    {
        $file = $this->file_path.'businesses.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Commerce_model->commerce_exists($row['NAME'], $row['ADDRESS'], $row['CITY'], $row['PROVINCE'])) {
                    $this->Commerce_model->register_trade($row['NAME'], $row['ADDRESS'], $row['LATITUDE'], $row['LONGITUDE'],
                                                            $row['CITY'], $row['PROVINCE'], $row['COUNTRY']);
                }
            }
            echo '<p>'.'Se cargaron los comercios satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar los comercios'.'</p>';
        }
    }

    /**
     * Carga los rubros desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_items()
    {
        $file = $this->file_path.'items.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Item_model->item_exists($row['NAME'])) {
                    $this->Item_model->register_item($row['NAME']);
                }
            }
            echo '<p>'.'Se cargaron los rubros satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar los rubros'.'</p>';
        }
    }

    /**
     * Carga las categorias desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_categories()
    {
        $file = $this->file_path.'categories.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Category_model->category_exists($row['CATEGORY'])) {
                    $this->Category_model->register_category($row['ITEM'], $row['CATEGORY'], $row['CODE'], $row['UNIT']);
                }
            }
            echo '<p>'.'Se cargaron las categorias satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar las categorias'.'</p>';
        }
    }

    /**
     * Carga administradores desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_administrators()
    {
        $file = $this->file_path.'administrators.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->Administrator_model->find_admin_by_email($row['MAIL'])) {
                    $row['PASSWORD'] = $this->encrypt->encode($row['PASSWORD']);
                    $this->Administrator_model->register_administrator($row['NAME'], $row['SURNAME'], $row['MAIL'], $row['PASSWORD'], $row['CITY'],
                                                                        $row['PROVINCE'], $row['COUNTRY']);
                }
            }
            echo '<p>'.'Se cargaron los administradores satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar los administradores'.'</p>';
        }
    }

    /**
     * Carga usuarios desde un archivo CSV a la Base de Datos.
     *
     * @access private
     */
    private function _load_users()
    {
        $file = $this->file_path.'users.csv';

        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);

            foreach ($csv_array as $row) {
                if (!$this->User_model->find_user_by_email($row['MAIL'])) {
                    $row['PASSWORD'] = $this->encrypt->encode($row['PASSWORD']);
                    $this->User_model->create_user( $row['PASSWORD'], $row['MAIL'], $row['NAME'], $row['SURNAME'],  $row['QUALIFICATION']);
                }
            }
            echo '<p>'.'Se cargaron los usuarios satisfactoriamente'.'</p>';
        } else {
            echo '<p>'.'No se pudieron cargar los usuarios'.'</p>';
        }
    }

}  // Fin controlador
