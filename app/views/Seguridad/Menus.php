<?php
require 'app/models/Menus.model.php';
$menus_padres	=  $menus->menu_padre();

$inputs = array(
				['name'=>'Nombre'],
				['name'=>'Descripción'],
				['name'=>'Padre','type'=>'select','options'=>$menus_padres],
				['name'=>'Habilitado','type'=>'select','options'=>$form->habilitado]
			 );
	
$btns = array(
				['name'=>'Consultar','type'=>'submit'],
				['name'=>'Limpiar Valores','class'=>'btn-warning reset']
		    );

	$form->porlet_title		= 'Mantenimiento de menus';
	$form->porlet_body		= $form->input($inputs);
	$form->porlet_buttons	= $form->inputButton($btns);
	
	echo $form->porlet();

?>
