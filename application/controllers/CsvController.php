<?php
/**
 * Created by PhpStorm.
 * User: kuyfi
 * Date: 17/11/2015
 * Time: 05:57 PM
 */class CsvController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Precio_Model');
        $this->load->model('Producto_Model');
        $this->load->model('Usuario_Model');
        $this->load->model('Users_Model');
        $this->load->library('csvimport');
    }



    function importcsv() {
        $this->verify_session();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $comercio=$this->input->post('comercio');
        $this->load->library('upload', $config);
        $usuario="comercio@comercio";

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['alertWarning'] = "No se pudo cargar el archivo";
            $this->load->view('csv_view',$data);


        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
            $count=0;
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'codigo'=>$row['codigo'],
                        'precio'=>$row['precio'],

                    );

                    $exist=$this->Producto_Model->existeProducto($row['codigo']);
                    if(!$exist){
                        $this->Producto_Model->InsertarProducto($row['codigo']);

                    }
                        $ok=$this->Precio_Model->insertarPrecioMasivo($comercio,$usuario,$row['precio'],$row['codigo']);

                            $count++;


                    //$this->csv_model->insert_csv($insert_data);
                    $this->calcularPrecio($comercio,$row['codigo'],$row['precio'],!$exist);
                }
                //$this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                $data["alertOk"]="Se cargaron correctamente ".$count." precios correctamente";
                $this->load->view('csv_view',$data);
                //redirect(base_url().'ImportarCsv');
                //echo "<pre>"; print_r($insert_data);
            } else {
                // $data['error'] = "Error occured";
                $data['alertWarning'] = "Error occured";
                $this->load->view('csv_view', $data);
            }
        }

    }

    function calcularPrecio( $comercio , $idProducto,$precio, $nuevo){

        if(!$nuevo) {
            $dias = 5;
            $precios = $this->Precio_Model->getUltimosPrecios($comercio, $idProducto, $dias);


            if (count($precios) < 10) {// si tengo pocos datos pido los ultimos 10 dias
                $dias = 10;
                $precios = $this->Precio_Model->getUltimosPrecios($comercio, $idProducto, $dias);
            }


            // calculo los puntajes para cada precio
            $preciosPosibles = array();
            for ($index = 0; $index < count($precios); $index++) {
                $precio = $precios[$index];

                if (array_key_exists($precio->precio, $preciosPosibles)) {
                    $preciosPosibles[$precio->precio] = $preciosPosibles[$precio->precio] + $precio->ranking;
                } else {
                    $preciosPosibles[$precio->precio] = 0 + $precio->ranking;
                }
            }

            /// ordeno los precios de mayor a menor
            uasort($preciosPosibles, array($this, 'cmp'));

            $precioMasProbable= current($preciosPosibles);
            $precio1= key($preciosPosibles);
            //next($preciosPosibles);
            $precioMenosProbable = next($preciosPosibles);
            $precio2= key($preciosPosibles);
            reset($preciosPosibles);
            if(count($precios)==0){
                $precio1=$precio;
            }

            if($precioMasProbable-$precioMenosProbable>15){
                $precio2=0;
                $this->Precio_Model->insertNuevoPrecioCalculado($comercio, $idProducto, $precio1,$precio2,"$".$precio1);

            }else if(count($preciosPosibles>1)){
                if($precio1>$precio2 && $precio2!=0){
                    $ok= $this->Precio_Model->insertNuevoPrecioCalculado($comercio, $idProducto, $precio2,$precio1,"$".$precio2."- $".$precio1);
                }else if($precio2!=0){
                    $ok= $this->Precio_Model->insertNuevoPrecioCalculado($comercio, $idProducto, $precio1,$precio2,"$".$precio1."- $".$precio2);
                }else{
                    $ok= $this->Precio_Model->insertNuevoPrecioCalculado($comercio, $idProducto, $precio1,$precio2,"$".$precio1);
                }
                //echo("el Precio es: $".$precioMasProbable."- $".$precioMenosProbable);
            }
        }else{
            $precio2=0;
            $precio1=$precio;
            $ok=$this->Precio_Model->insertNuevoPrecioCalculado($comercio, $idProducto,$precio1,$precio2, "$".$precio);

        }

    }

    // funcion de comparacion para ordenamiento
    function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    }
    function verify_session()
    {
        if(!$this->Users_Model->isLogged())
        {
            redirect(redirect(base_url()."loguear"));
            exit();
        }
    }


}