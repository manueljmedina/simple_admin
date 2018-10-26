<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require 'common_class.php';

$datos_correo['para']				= array(array('manuel'=>'mmedina@lahipotecaria.com'));

					$datos_correo['titulo']				= 'Nueva orden de compra ';
					$datos_correo['mensajeCuerpo']		= 'dfgdfgdfgdfgdfg';
					enviarCorreo($datos_correo);

?>