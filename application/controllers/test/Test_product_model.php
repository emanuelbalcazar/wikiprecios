<?php

class Test_product_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Product_model');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion
        $this->test_register_product();
        $this->test_product_exists();
        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_register_product()
    {
        $test_name = 'Test Register Product - Registra un nuevo producto';
        $test = $this->Product_model->register_product("7791615000426");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_product_exists()
    {
        $test_name = 'Test Product Exists - Indica si un producto exista registrado';
        $test = $this->Product_model->product_exists("7791615000426");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

}
