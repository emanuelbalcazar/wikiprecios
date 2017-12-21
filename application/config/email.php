<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Configuracion del correo Wikiprecios.
 */
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'wikipreciosunpsjb@gmail.com'; // correo sin espacio
$config['smtp_pass'] = 'wikiprecios2017';
$config['smtp_timeout'] = '5';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['mailtype'] = 'text';
$config['validation'] = TRUE;