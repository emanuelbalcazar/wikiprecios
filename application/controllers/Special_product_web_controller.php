<?php

/**
* Controlador encargado de manejar los productos especiales desde la aplicacion web.
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Special_product_web_controller extends CI_Controller {


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
        $this->load->model('Special_product_model');
        $this->load->model('Item_model');
        $this->load->model('Category_model');
    }

    public function load_special_product_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view');
        } else {
            redirect(base_url());
        }
    }

    public function load_special_product()
    {
        $data["name"] = $this->input->post('name', TRUE);
        $data["item"] = $this->input->post('item', TRUE);
        $data["unit"] = $this->input->post('unit', TRUE);
        $data["user"] = $this->session->userdata('user');

        $data = $this->utils->replace($data, "\"", "");  // Saco las comillas

        if ($data["name"] == "") {
            $data["error"] = "Ingrese un nombre para el tipo de producto especial";
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view', $data);
        }
        else if ($this->Category_model->category_exists($data["name"])) {
            $data["warning"] = "El producto especial ya existe  ";
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view', $data);
        }
        else if (!$this->Item_model->id_item_exists($data["item"])) {
            $data["error"] = "El rubro no existe";
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view', $data);
        }
        else {
            $this->_insert_category($data);
        }
    }

    /**
    * Crea y registra una nueva categoria
    *
    * @access private
    * @param $data nombre y rubro de la categoria a crear
    * @return un arreglo indicando si la categoria pudo ser insertada
    */
    private function _insert_category($data)
    {
        $product_code = $this->_get_special_product_code($data["item"]);
        $category_inserted = $this->Category_model->register_category($data["item"], $data["name"], $product_code, $data["unit"]);
        $product_inserted = $this->Special_product_model->register_special_product($product_code, $data["name"]);

        $result = $this->_check_inserts($category_inserted, $product_inserted);

        if ($result["registered"]) {
            $data["success"] = "El producto especial se registro correctamente";
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view', $data);
        } else {
            $data["error"] = "No se pudo regitrar el producto especial";
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_special_product_view', $data);
        }
    }

    /**
    * Crea un nuevo codigo de producto especial basado en el rubro
    *
    * @access private
    * @param $item rubro al que esta asociado el producto especial
    * @return $product_code el codigo del producto especial
    */
    private function _get_special_product_code($item)
    {
        $quantity = $this->Item_model->get_amount_category_by_item($item);
        $letters = $this->Item_model->get_letters_item($item);

        $quantity = $quantity->quantity + 1;
        $letter = $letters->letter;
        $product_code = (string)$letter.$quantity; // Creo el codigo del producto especial (ej CAR1)

        return $product_code;
    }

    /**
     * Checkea si la categoria pudo ser insertada correctamente
     *
     * @param type $data arreglo donde se guardara el estado de la categoria
     * @param type $category_inserted booleano indicando si la categoria fue insertada
     * @param type $product_inserted booleano indicando si el producto especial fue insertado
     * @return type $data
     * @access private
     */
    private function _check_inserts($category_inserted, $product_inserted)
    {
        $data["registered"] = false;

        if ($category_inserted) {
            $data['registered'] = TRUE;
        }
        else if ($product_inserted) {
            $data['registered'] = TRUE;
        }

        return $data;
    }

    public function load_masive_special_products_view()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_masive_special_products_view', $data);
        } else {
            redirect(base_url());
        }
    }

    public function load_masive_special_products()
    {
        if ($this->session->userdata('user')) {
            $data["user"] = $this->session->userdata('user');
            $item = $this->input->post('item');

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = "No se pudo cargar el archivo, por favor seleccione un archivo valido";
                $data["items"] = $this->Item_model->get_items();
                $this->load->view('menu_admin', $data);
                $this->load->view('load_masive_special_products_view', $data);
            } else {
                $file_data = $this->upload->data();
                $file_path =  './uploads/'.$file_data['file_name'];

                $this->_load_special_products($item, $file_path, $data);
            }
        } else {
            redirect(base_url());
        }
    }

    private function _load_special_products($item, $file, $data)
    {
        if ($this->csvimport->get_array($file)) {
            $csv_array = $this->csvimport->get_array($file);
            $count = 0;
            $exists = 0;

            foreach ($csv_array as $row) {
                if (isset($row['NOMBRE']) && isset($row['UNIDAD'])) {
                    $is_valid = TRUE;
                } else {
                    $is_valid = FALSE;
                }
            }

            if (!$is_valid) {
                $data['error'] = "El archivo esta mal formado, verifique que contenga los datos requeridos";
                $data["items"] = $this->Item_model->get_items();
                $this->load->view('menu_admin', $data);
                $this->load->view('load_masive_special_products_view', $data);
                return;
            }

            foreach ($csv_array as $row) {
                $category_exists = $this->Category_model->category_exists($row['NOMBRE']);

                if (!$category_exists) {
                    $product_code = $this->_get_special_product_code($item);
                    $category_inserted = $this->Category_model->register_category($item, $row['NOMBRE'], $product_code, $row['UNIDAD']);
                    $product_inserted = $this->Special_product_model->register_special_product($product_code, $row['NOMBRE']);
                    $count++;
                } else {
                    $exists++;
                }
            }

            if ($count > 0) {
                $data['success'] = "Se cargaron correctamente ".$count." productos especiales";
            }

            if ($exists > 0) {
                $data['warning'] = $exists." productos especiales ya habian sido cargados anteriormente";
            }

            $data["items"] = $this->Item_model->get_items();
            $this->load->view('menu_admin', $data);
            $this->load->view('load_masive_special_products_view', $data);
        }
    }

}  // Fin del controlador
