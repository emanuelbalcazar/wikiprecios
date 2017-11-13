<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Utils
* Libreria para funciones de utilidad necesarias en esta aplicacion
*
* @package         CodeIgniter
* @subpackage      Libraries
* @category        Libraries
*/

class Utils {

    /**
    * Busca y reemplaza caracteres en un arreglo
    *
    * @access  public
    * @param   $data arreglo a evaluar
    * @param   $search caracter a reemplazar
    * @param   $replace caracter por el cual se desea reemplazar
    * @return  $data el arreglo con los caracteres reemplazados
    */
    public function replace($data, $search, $replace)
    {
        foreach ($data as $key => $value) {
            $data[$key] = str_replace($search, $replace, $data[$key]);
        }

        return $data;
    }

    /**
    * Calcula la distancia entre dos coordenadas.
    *
    * @access  public
    * @param   $latitude1
    * @param   $longitude1
    * @param   $latitude2
    * @param   $longitude2
    * @return  distance distancia calculada en kilometros con 2 decimales de precision.
    */
    public function calculate_distance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;

        return round($kilometers, 2);
    }

    /**
     * Envia una peticion post a la ruta indicada como parametro.
     * @param  [type] $url  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function send_post($url, $data)
    {
        $data_string = json_encode($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                    'Content-Length: '.strlen($data_string)));
                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * Envia una peticion GET a la ruta solicitada.
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function send_get($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

}
