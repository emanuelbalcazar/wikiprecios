<?php

class Test_favorite_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('Favorite');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_register_favorite_trade();
        $this->test_delete_all_favorites();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_register_favorite_trade()
    {
        $test_name = 'Test Register Favorite Trade - Registra el comercio como favorito a un usuario';
        $test = $this->Favorite->create(array("user" => "emanuelbalcazar13@gmail.com", "commerce_id" => 1));        
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_delete_all_favorites()
    {
        $test_name = 'Test Delete All Favorites - Elimina todos los comercios favoritos de un usuario';
        $test = $this->Favorite->delete(array("user" => "emanuelbalcazar13@gmail.com"));
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
