<?php
function is_session_started(){
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function loggin_session(){
	if (array_key_exists(SYSTEM, $_SESSION)){
		var_dump($_SESSION);
		define('USERNAME', $_SESSION[SYSTEM]['USERNAME']);
		return true;
	}else{
		return false;
	}
}




#transforma las peticiones en variables
if((isset($_GET) && count($_GET)>0) || (isset($_POST) && count($_POST)>0) ){
	$array = array();

	if(isset($_POST)){
		foreach($_POST as $nombre_campo => $valor){ 
		  $asignacion = "\$" . $nombre_campo . "='" . $Security->sanitize($valor) . "';";    
		 eval($asignacion);  
		}
	}

 	if(isset($_GET)){ 
		foreach($_GET as $nombre_campo => $valor){ 
		  $asignacion = "\$" . $nombre_campo . "='" . $Security->sanitize($valor) . "';";    
		 eval($asignacion);  
		}
	}

}


switch (ENVIRONMENT){
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}



$u = $_SERVER['HTTP_USER_AGENT'];

$isIE6  = (bool)preg_match('/msie 6./i', $u );
$isIE7  = (bool)preg_match('/msie 7./i', $u );
$isIE8  = (bool)preg_match('/msie 8./i', $u );
$isIE9  = (bool)preg_match('/msie 9./i', $u );
$isIE10 = (bool)preg_match('/msie 10./i', $u );

    function normaliza_campo($cadena){
         $cadena = str_replace("&aacute;","a",$cadena);
        $cadena = str_replace("&Aacute;","A",$cadena);
        $cadena = str_replace("&eacute;","e",$cadena);
        $cadena = str_replace("&Eacute;","E",$cadena);
        $cadena = str_replace("&iacute;","i",$cadena);
        $cadena = str_replace("&Iacute;","I",$cadena);
        $cadena = str_replace("&oacute;","o",$cadena);
        $cadena = str_replace("&Oacute;","O",$cadena);
        $cadena = str_replace("&uacute;","u",$cadena);
        $cadena = str_replace("&Uacute;","U",$cadena);
           return utf8_encode($cadena);
    }
    
    function normaliza($cadena){  
        $cadena = str_replace('-', '', $cadena);
        $cadena = str_replace(' ', '_', $cadena);
        $cadena = str_replace('__', '_', $cadena);
        $cadena = str_replace("&aacute;","a",$cadena);
        $cadena = str_replace("&Aacute;","A",$cadena);
        $cadena = str_replace("&eacute;","e",$cadena);
        $cadena = str_replace("&Eacute;","E",$cadena);
        $cadena = str_replace("&iacute;","i",$cadena);
        $cadena = str_replace("&Iacute;","I",$cadena);
        $cadena = str_replace("&oacute;","o",$cadena);
        $cadena = str_replace("&Oacute;","O",$cadena);
        $cadena = str_replace("&uacute;","u",$cadena);
        $cadena = str_replace("&Uacute;","U",$cadena);
		$cadena = str_replace("&ntilde;","n",$cadena);
		$cadena = str_replace("&Ntilde;","N",$cadena);
		$cadena = str_replace("Ñ;","N",$cadena);
		$cadena = str_replace("ñ","n",$cadena);
        $cadena = str_replace("á","a",$cadena);
        $cadena = str_replace("é","e",$cadena);
        $cadena = str_replace("í","i",$cadena);
        $cadena = str_replace("ó","o",$cadena);
        $cadena = str_replace("ú","u",$cadena);
   $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
                    
                
    return utf8_encode($cadena);
}

if ($isIE8 || $isIE7 || $isIE6) {
	$msgError = 'Esta versi&oacute;n explorador no es compatible con esta aplicaci&oacute;n, favor actualizalo o utiliza Google Chrome';
	
}








