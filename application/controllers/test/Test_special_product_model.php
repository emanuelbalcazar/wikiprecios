<?php

class Test_special_product_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Special_product');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion
        $this->test_register_special_product();
        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_register_special_product()
    {
        $test_name = 'Test Register Special Product - Registra un nuevo producto especial';
        $test = $this->Special_product->create(array("product_code" => "0123456789012", "name" => "CAR5"));
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
