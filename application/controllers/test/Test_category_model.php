<?php

class Test_category_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Category_model');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_register_category();
        $this->test_get_categories_of_items();
        $this->test_category_exists();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB
        echo $this->unit->report();
    }

    public function test_register_category()
    {
        $test_name = 'Test Register Category - Registra una nueva categoria';
        $test = $this->Category_model->register_category(1, "carne picada", "CAR6", "kg");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_categories_of_items()
    {
        $test_name = 'Test Get Categories Of Items - Retorna las categorias de un rubro determinado';
        $test = $this->Category_model->get_categories_of_items(1);
        $expected_result = 'is_array';

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_category_exists()
    {
        $test_name = 'Test Category Exists - Verifica si la categoria ya existe';
        $test = $this->Category_model->category_exists("peceto");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
