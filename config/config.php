<?php
session_start();	
#HEADERS GENERALES DEL SISTEMA
header('Expires: Sat, 10 Mar 1990 06:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');
#VARIABLES GLOBALES DE CONFIGURACI�N
define('SYSTEM',__FILE__);
define('DATETIME', date('Y-m-d H:i:s'));
define('DATE', date('Y-m-d'));
define('SYSTEMAPP', 'app/');
define('PATHVIEWS', 'views/');
define('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']);
define('USERAGENT',   $_SERVER['HTTP_USER_AGENT']);
define('HTTPONLY', true);
define('SECURE',   false);
#mostrar o no los errores
define('ENVIRONMENT','development');



?>

