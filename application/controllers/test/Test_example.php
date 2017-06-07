<?php

/**
 * Ejemplo de Test en Codeigniter
 *
 */
class Test_example extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        $this->load->library('unit_test');
    }

    // Ejecuto todos los test y genero un reporte visible en el navegador
    public function test()
    {
        $this->test_1();
        $this->test_2();
        echo $this->unit->report();
    }

    public function test_1()
    {
        $test_name = 'Test Example: Adds one plus one';
        $test = 1 + 1;
        $expected_result = 2;

        $this->unit->run($test, $expected_result, $test_name);
    }

    public function test_2()
    {
        $test_name = 'Test Example: Adds two plus two';
        $test = 2 + 2;
        $expected_result = 4;

        $this->unit->run($test, $expected_result, $test_name);
    }
}
