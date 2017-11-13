<?php

class Test_user_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
        $this->load->model('User');
    }

    /**
     * Ejecuta todos los test y genera un reporte visible en el navegador.
     */
    public function test()
    {
        $this->db->trans_begin(); // inicio una transaccion

        $this->test_create_user();
        $this->test_get_qualification();
        $this->test_find_user_by_email();
        $this->test_update_rating();
        $this->test_update_password();
        $this->test_delete_account();

        $this->db->trans_rollback(); // rollback para no afectar los datos en la base de datos.

        echo $this->unit->report();
    }

    public function test_create_user()
    {
        $test_name = 'Test Create User - Registra un nuevo usuario en la Base de Datos';

        $user = array(
            "name" => "Emanuel", 
            "surname" => "Balcazar", 
            "mail" => "emanuelbalcazar13@gmail.com", 
            "password" => "first_password",
            "qualification" => 1,
            "accumulated" => 0,
            "active_account" => 1 
        );

        $test = $this->User->create($user);
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_get_qualification()
    {
        $test_name = 'Test Get Qualification - Obtiene la calificacion del usuario';
        $result = $this->User->get_qualification("emanuelbalcazar13@gmail.com");
        $expected_result = 1;

        $this->unit->run($result->qualification, $expected_result, $test_name);
    }

    public function test_find_user_by_email()
    {
        $test_name = 'Test Find User By Email - Busca y retorna un usuario buscado por su Email';
        $test = $this->User->find(array("mail" => "emanuelbalcazar13@gmail.com"));
        $expected_result = "emanuelbalcazar13@gmail.com";

        $this->unit->run($test[0]->mail, $expected_result, $test_name);
    }

    public function test_update_rating()
    {
        $test_name = 'Test Update Rating - Actualiza la Calificacion y los Acumulados de un Usuario';

        $user = array("mail" => "emanuelbalcazar13@gmail.com");
        $data = array("qualification" => 3, "accumulated" => 1);
        $test = $this->User->update($user, $data);

        $new = $this->User->get_qualification("emanuelbalcazar13@gmail.com");
        $expected_result = 3;

        $this->unit->run($new->qualification, $expected_result, $test_name);
    }

    public function test_update_password()
    {
        $test_name = 'Test Update Password - Actualiza la contraseña de un usuario';

        $user = array("mail" => "emanuelbalcazar13@gmail.com");
        $data = array("password" => "new_password");
        $test = $this->User->update($user, $data);

        $new = $this->User->find(array("mail" => "emanuelbalcazar13@gmail.com"));
        $expected_result = "new_password";

        $this->unit->run($new[0]->password, $expected_result, $test_name);
    }

    public function test_delete_account()
    {
        $test_name = 'Test Delete Account - Desactiva una cuenta de usuario cambiando el estado de su cuenta';
        $test = $this->User->delete_account("emanuelbalcazar13@gmail.com");
        $expected_result = TRUE;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
