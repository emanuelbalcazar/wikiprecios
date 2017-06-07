<?php

class Test_price_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Price_model');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_register_price();
        $this->test_get_favorites_prices();
        $this->test_get_prices_that_are_not_favorites();
        $this->test_get_possible_prices();
        $this->test_get_last_prices();
        $this->test_register_new_price_calculated();
        $this->test_get_product_prices();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB
        echo $this->unit->report();
    }

    public function test_register_price()
    {
        $test_name = 'Test Register Price - Registra Registra un nuevo precio de un producto';
        $test = $this->Price_model->register_price(1, "emanuelbalcazar13@gmail.com", 22.0, "9091615000490");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_favorites_prices()
    {
        $test_name = 'Test Get Favorites Prices - Retorna los precios de un producto que esten en los comercios favoritos';
        $test = $this->Price_model->get_favorites_prices("7791615000426", "emanuelbalcazar13@gmail.com", 1);
        $result = $test[0]->name;
        $expected_result = "Frutillita";

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_get_prices_that_are_not_favorites()
    {
        $test_name = 'Test Get Prices That Are Not Favorites - Retorna los precios de un producto que NO esten en los comercios favoritos';
        $test = $this->Price_model->get_prices_that_are_not_favorites("7791615000426", "emanuelbalcazar13@gmail.com", 1);
        $result = $test[0]->name;
        $expected_result = "Pirulin";

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_get_possible_prices()
    {
        $test_name = 'Test Get Possible Prices - Retorna los posibles precios de un producto';
        $test = $this->Price_model->get_possible_prices(1, "7791615000426");
        $expected_result = 'is_array';

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_last_prices()
    {
        $test_name = 'Test Get Last Prices - Retorna los ultimos precios de un producto en el lapso de 5 dias';
        $test = $this->Price_model->get_last_prices(1, "7791615000426", 5);
        $result = $test[0]->price;
        $expected_result = "9.3";

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_register_new_price_calculated()
    {
        $test_name = 'Test Register New Price Calculated - Registra o actualiza un nuevo precio calculado';
        $test = $this->Price_model->register_new_price_calculated(1, "7791615000426", "9", 9.0, 9.2);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_product_prices()
    {
        $test_name = 'Test Get Product Prices - Retorna los precios calculados de un producto';
        $test = $this->Price_model->get_product_prices("7791615000426", 1);
        $expected_result = 'is_object';

        $this->unit->run($test, $expected_result, $test_name);
    }
}
