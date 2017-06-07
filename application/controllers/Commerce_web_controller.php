<?php

/**
* Controlador encargado de manejar los comercios desde la aplicacion web.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Commerce_web_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('email');
        $this->load->library('encrypt');
        $this->load->library('utils');
        $this->load->library('csvimport');
        $this->load->model('Commerce_model');

    }

    public function load_commerce_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');

            $this->load->view('menu_admin', $data);
            $this->load->view('load_commerce_view', $data);
        } else {
            redirect(base_url());
        }
    }

    public function load_masive_businesses_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');

            $this->load->view('menu_admin', $data);
            $this->load->view('load_masive_businesses_view');
        } else {
            redirect(base_url());
        }
    }

    public function load_masive_businesses()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = "No se pudo cargar el archivo, por favor seleccione un archivo valido";
                $this->load->view('menu_admin', $data);
                $this->load->view('load_masive_businesses_view', $data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];
                $this->_load_businesses($file_path, $data);
            }
        } else {
            redirect(base_url());
        }
    }

    private function _load_businesses($file_path, $data)
    {
        if ($this->csvimport->get_array($file_path)) {
            $csv_array = $this->csvimport->get_array($file_path);
            $count = 0;
            $exists = 0;
            $is_valid = FALSE;

            foreach ($csv_array as $row) {
                if (isset($row['NOMBRE']) && isset($row['DIRECCION']) && isset($row['LATITUD'])
                    && isset($row['LONGITUD']) && isset($row['CIUDAD']) && isset($row['PROVINCIA']) && isset($row['PAIS'])) {
                    $is_valid = TRUE;
                } else {
                    $is_valid = FALSE;
                }
            }

            if (!$is_valid) {
                $data['error'] = "El archivo esta mal formado, verifique que contenga los datos requeridos";
                $this->load->view('menu_admin', $data);
                $this->load->view('load_masive_businesses_view', $data);
                return;
            }

            foreach ($csv_array as $key => $row) {
                $commerce_exists = $this->Commerce_model->commerce_exists($row['NOMBRE'], $row['DIRECCION'], $row['CIUDAD'], $row['PROVINCIA']);

                if (!$commerce_exists) {
                    $this->Commerce_model->register_trade($row['NOMBRE'], $row['DIRECCION'], $row['LATITUD'], $row['LONGITUD'], $row['CIUDAD'], $row['PROVINCIA'], $row['PAIS']);
                    $count++;
                } else {
                    $exists++;
                }
            }

            if ($count > 0) {
                $data['success'] = "Se cargaron correctamente ".$count." comercios";
            }

            if ($exists > 0) {
                $data['warning'] = $exists." comercios ya habian sido cargados anteriormente";
            }


            $this->load->view('menu_admin', $data);
            $this->load->view('load_masive_businesses_view', $data);

        } else {
            $data['error'] = "No se pudieron cargar los comercios";
            $this->load->view('menu_admin', $data);
            $this->load->view('load_masive_businesses_view', $data);
        }
    }

}  // Fin del controlador
