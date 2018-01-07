<?php

class Test_commerce_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Commerce');
        $this->load->model('Favorite');
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

        $commerce = array(
            "name" => "La Anonima",
            "address" => "Jujuy 1330",
            "latitude" => -42.780992,
            "longitude" => -65.037777,
            "city" => "Puerto Madryn",
            "province" => "Chubut",
            "country" => "Argentina"
        );

        $test = $this->Commerce->create($commerce);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_commerce_exists()
    {
        $test_name = 'Test Commerce Exists - Verifica si el comercio existe';

        $commerce = array(
            "name" => "La Anonima",
            "address" => "Jujuy 1330",
            "city" => "Puerto Madryn"
        );

        $test = $this->Commerce->exists($commerce);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_businesses()
    {
        $test_name = 'Test Get Businesses - Devuelve todos los comercios registrados';
        $test = $this->Commerce->find();
        $expected_result = 'is_array';

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_favorites_businesses()
    {
        $test_name = 'Test Get Favorites Businesses - Devuelve todos los comercios favoritos de un usuario';
        
        $this->Favorite->create(array("user" => "emanuelbalcazar13@gmail.com", "commerce_id" => 1));
        
        $user = "emanuelbalcazar13@gmail.com";
        $data = $this->Commerce->get_favorites($user);
        $test = $data[0]->name;
        $expected_result = "Chango Mas";

        $this->unit->run($test, $expected_result, $test_name);
    }
}
