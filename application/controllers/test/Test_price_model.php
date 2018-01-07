<?php

class Test_price_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Price');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_register_price();
        $this->test_get_possible_prices();
        $this->test_register_new_price_calculated();
        $this->test_get_product_prices();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB
        echo $this->unit->report();
    }

    public function test_register_price()
    {
        $test_name = 'Test Register Price - Registra Registra un nuevo precio de un producto';

        $price = array(
            "user" => "emanuelbalcazar13@gmail.com",
            "commerce_id" => 1,
            "price" => 20,
            "product_code" => "9091615000490"
        );

        $test = $this->Price->create($price);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_possible_prices()
    {
        $test_name = 'Test Get Possible Prices - Retorna los posibles precios de un producto';
        $prices = $this->Price->get_possible_prices(1, "9091615000490");
        $test = $prices[0]->price;
        $expected_result = "20";

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_register_new_price_calculated()
    {
        $test_name = 'Test Register New Price Calculated - Registra o actualiza un nuevo precio calculado';
        $test = $this->Price->register_new_price_calculated(1, "9091615000490", 9, 10, "$9 - $10");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_product_prices()
    {
        $test_name = 'Test Get Product Prices - Retorna los precios calculados de un producto';
        $test = $this->Price->get_product_prices("9091615000490", 1);
        $expected_result = 'is_object';

        $this->unit->run($test, $expected_result, $test_name);
    }
}
