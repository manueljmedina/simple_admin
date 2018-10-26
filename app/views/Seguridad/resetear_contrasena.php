<?php
require 'models/general_variables.php';

if(!isset($username)){$username='';}
if(!isset($password)){$password='';}     


#campos para el formulario
    $usernamePost     = $formulario ->input('Username',$username, 'reg', 'text', '');
    $passwordPost     = $formulario ->input('Password',$password, 'reg', 'text', '');

    $campos             = $usernamePost.$passwordPost.$obliatorios;
#botones para el formulario

    $guardar            = $formulario ->inputButton('Limpiar Valores contrase&ntilde;a','button','btn-primary restPass','',6,'');
    $reset              = $formulario ->inputButton('Limpiar Valores','button','btn-warning reset','',6,'');
#renderizar formulario
    $formularioGenerado = $formulario -> formularioPorlet($campos, 'Restauraci&oacute;n de contrase&ntilde;a de los usuarios', 'blue ', $guardar.$reset, 'GET','Formulario');

    echo $formularioGenerado;

?>
