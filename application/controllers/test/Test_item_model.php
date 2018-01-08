<?php

class Test_item_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Item');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion
        $this->test_register_item();
        $this->test_get_items();
        $this->test_item_exists();
        $this->test_get_amount_category_by_item();
        $this->test_get_letters_item();
        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_register_item()
    {
        $test_name = 'Test Register Item - Registra un nuevo rubro';
        $test = $this->Item->create(array("name" => "legumbres", "letter" => "LEG"));
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_items()
    {
        $test_name = 'Test Get Items - Retorna todas los rubros registrados';
        $test = $this->Item->find();
        $expected_result = 'is_array';

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_item_exists()
    {
        $test_name = 'Test Item Exists - Verifica si el rubro fue registrado';
        $test = $this->Item->exists(array("name" => "carnes"));
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_amount_category_by_item()
    {
        $test_name = 'Test Get Amount Category By Item - Retorna la cantidad de categorias de un rubro';
        $test = $this->Item->get_amount_category_by_item(1);
        $result = $test->quantity;
        $expected_result = 5;

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_get_letters_item()
    {
        $test_name = 'Test Get Letters Item - Retorna las letras asociadas a un rubro';
        $test = $this->Item->get_letters_item(1);
        $result = $test->letter;
        $expected_result = "CAR";

        $this->unit->run($result, $expected_result, $test_name);
    }
}
