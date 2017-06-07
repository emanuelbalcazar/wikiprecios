<?php

class Test_user_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('User_model');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->db->trans_begin(); // Inicio una transaccion

        $this->test_create_user();
        $this->test_get_qualification();
        $this->test_find_user_by_email();
        $this->test_update_rating();
        $this->test_update_password();
        $this->test_delete_account();

        $this->db->trans_rollback(); // Rollback para no afectar los datos en la DB

        echo $this->unit->report();
    }

    public function test_create_user()
    {
        $test_name = 'Test Create User - Registra un nuevo usuario en la Base de Datos';
        $test = $this->User_model->create_user("first_password", "emanuelbalcazar@gmail.com", "emanuel", "balcazar", 1);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_qualification()
    {
        $test_name = 'Test Get Qualification - Obtiene la calificacion del usuario';
        $test = $this->User_model->get_qualification("emanuelbalcazar13@gmail.com");
        $result = $test->qualification;
        $expected_result = 1;

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_find_user_by_email()
    {
        $test_name = 'Test Find User By Email - Busca y retorna un usuario buscado por su Email';
        $test = $this->User_model->find_user_by_email("emanuelbalcazar13@gmail.com");
        $result = $test->mail;
        $expected_result = "emanuelbalcazar13@gmail.com";

        $this->unit->run($result, $expected_result, $test_name);
    }

    public function test_update_rating()
    {
        $test_name = 'Test Update Rating - Actualiza la Calificacion y los Acumulados de un Usuario';
        $test = $this->User_model->update_rating("emanuelbalcazar13@gmail.com", 1, 3);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_update_password()
    {
        $test_name = 'Test Update Password - Actualiza la clave de un usuario';
        $test = $this->User_model->update_password("emanuelbalcazar13@gmail.com", "password_updated");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_delete_account()
    {
        $test_name = 'Test Delete Account - Desactiva una cuenta de usuario cambiando el estado de su cuenta';
        $test = $this->User_model->delete_account("emanuelbalcazar13@gmail.com");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
