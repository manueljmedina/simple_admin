<?php
#controlador para el Login
require_once '../../core/Core.php';
require_once '../../app/models/Login.model.php';
#
$login_class		= new login();

if($variable){
	
	if($variable=='Login'){
		$data				= array();
		$data['username']	= $username;
		$data['password']	= md5($password);

		$respuesta = $login_class->login_user($data);
		
		echo json_encode($respuesta);
	}
}
  
?>