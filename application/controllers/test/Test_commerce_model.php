<?php

class Test_commerce_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Commerce_model');
        $this->load->model('Favorite_model');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_register_trade();
        $this->test_commerce_exists();
        $this->test_get_businesses();
        $this->test_get_favorites_businesses();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_register_trade()
    {
        $test_name = 'Test Register Trade - Registra un nuevo comercio';
        $test = $this->Commerce_model->register_trade("La Anonima", "Jujuy 1330",
                                        -42.7805146, -65.0447228, "Puerto Madryn", "Chubut", "Argentina");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_commerce_exists()
    {
        $test_name = 'Test Commerce Exists - Verifica si el comercio existe';
        $test = $this->Commerce_model->commerce_exists("La Anonima", "Jujuy 1330", "Puerto Madryn", "Chubut");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_businesses()
    {
        $test_name = 'Test Get Businesses - Devuelve todos los comercios registrados';
        $test = $this->Commerce_model->get_businesses();
        $expected_result = 'is_array';

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_favorites_businesses()
    {
        $this->Favorite_model->register_favorite_trade("emanuelbalcazar13@gmail.com", 1);

        $test_name = 'Test Get Favorites Businesses - Devuelve todos los comercios favoritos de un usuario';
        $user = "emanuelbalcazar13@gmail.com";
        $data = $this->Commerce_model->get_favorites_businesses($user);
        $test = $data[0]->name;
        $expected_result = "La Anonima";

        $this->unit->run($test, $expected_result, $test_name);
    }
}
