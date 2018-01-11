<?php

/**
* Controlador de la clase Producto Especial
*
* @package         CodeIgniter
* @subpackage      Controllers
* @category        Controller
*/
class Special_product_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('Utils');
        $this->load->model('Special_product');
        $this->load->model('Item');
        $this->load->model('Category');
    }

    /**
    * Registra una nueva categoria
    * Por ej: Rubro Carnes -> peceto CAR1
    *
    * @access public
    */
    public function register()
    {
        $data["item_id"] = $this->input->post('item'); // rubro
        $data["category"] = $this->input->post('name'); // nombre ej: peceto
        $data["unit"] = $this->input->post('unit');
        $data = $this->utils->replace($data, "\"", "");

        if ($this->Category->exists($data)) {
            $result["message"] = "La categoria ya existe";
            $result["registered"] = FALSE;
        }
        else if (!$this->Item->exists(array("id" => $data["item_id"]))) {
            $result["message"] = "El rubro no existe";
            $result["registered"] = FALSE;
        }
        else {
            $result = $this->_insert_category($data);
        }

        echo json_encode($result);
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
        $product_code = $this->_get_special_product_code($data["item_id"]);
        $data["special_product_code"] = $product_code;

        $category_inserted = $this->Category->create($data);
        $product_inserted = $this->Special_product->create(array("product_code" => $product_code, "name" => $data["category"]));
        $result = $this->_check_inserts($category_inserted, $product_inserted);

        return $result;
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
        $quantity = $this->Item->get_amount_category_by_item($item);
        $letters = $this->Item->get_letters_item($item);

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
        if ($category_inserted) {
            $data['message'] = "Categoria agregada correctamente";
            $data['registered'] = TRUE;
        }
        else if ($product_inserted) {
            $data['message'] = "Producto Especial agregado correctamente";
            $data['registered'] = TRUE;
        }

        $data["rubros"] = $this->Item->find();
        return $data;
    }

    /**
    * Obtiene todas las categorias de un determinado rubro
    *
    * @access public
    */
    public function get_categories_of_items()
    {
        $data["item_id"] = $this->input->get('item');
        $data = $this->utils->replace($data, "\"", "");
        $categories = $this->Category->find($data);

        echo json_encode($categories);
    }

    /**
    * Obtiene todos los rubros registrados
    *
    * @access public
    */
    public function get_items()
    {
        $items = $this->Item->find();
        echo json_encode($items);
    }

}
