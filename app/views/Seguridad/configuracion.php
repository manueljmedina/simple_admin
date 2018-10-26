<?php

require 'models/general_variables.php';

$valores        = array('red','blue');
       
    $nombreSistema  = $formulario ->input('Nombre',$confSistema['nombre_app'], 'reg', 'text', '');
    $expira         = $formulario ->input('Expira',$confSistema['expira_sesion'], 'reg', 'text', '');
    $colores        = $formulario ->select('Colores','',$valores,'reg',$confSistema['color']);
    $empresa        = $formulario ->input('Empresa',$confSistema['empresa'],'reg','text','');
    $version        = $formulario ->input('Versión',$confSistema['version'],'reg','text','');
    $favico         = $formulario ->image('Favicon',$confSistema['favicon'],'Favicon del sistema','imgClic');
	$favico_input   = $formulario ->input('Favicon','','btn-danger','file','');
    $logo           = $formulario ->image('Logo','assets/img/'.$confSistema['logo_login'],'Logo del sistema','imgClic');
	$logo_login     = $formulario ->input('Logo login','','reg btn-primary','file','');
    $logoWid        = $formulario ->input('Logo Width login',$confSistema['width_logo_login'],'reg','text','');
	
	$tipo           = $formulario ->input('tipo','Guardado', '', 'hidden', '');

	
	
    $guardar        = $formulario ->inputButton('Actualizar configuraci&oacute;n','button','btn-success guardarConfi','',6,'');
    $campos         = $nombreSistema.$expira.$empresa.$version.$colores.$logo.$logo_login.$logoWid.$favico.$favico_input.$tipo.$obliatorios;

echo $formulario -> formularioPorlet($campos, 'Configuraciones del sistema', 'blue ', $guardar, 'POST','FormularioSub');

?>
