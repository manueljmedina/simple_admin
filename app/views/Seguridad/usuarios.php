<?php
require 'models/permisos.model.php';
require 'models/usuarios.model.php';
require 'models/general_variables.php';


$roles    = new roles();
$crud     = new usuarios();

 if(!isset($padres)){$padres='';}
    $rolArray       = $roles->queryOptions('');
   

if(!isset($nombre)){$nombre='';}
if(!isset($apellido)){$apellido='';}     
if(!isset($email)){$email='';}   
if(!isset($usuario)){$usuario='';}   
if(!isset($rol)){$rol='';}  

#campos para el formulario
    $nombreProv          = $formulario ->input('Nombre',$nombre, '', 'text', '');

    $emailProv           = $formulario ->input('Email',$email, '', 'text', '');
    $usuarioProv         = $formulario ->input('Usuario',$usuario, '', 'text', '');
    $rolPro              = $formulario ->select('Rol','',$rolArray,'',$rol);
   
   
    $campos             = $nombreProv.$emailProv.$usuarioProv.$rolPro.$obliatorios;
#botones para el formulario
    $botonesForm           = $formulario ->inputButton('Consultar','submit','btn-success consulta','',4,'');
    if(in_array(9,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){
        $botonesForm .=  $formulario ->inputButton('Crear nuevo registro','button','btn-primary guardar','',4,'');
    }
    $botonesForm              .= $formulario ->inputButton('Limpiar Valores','button','btn-warning reset','',4,'');
#renderizar formulario
    $formularioGenerado = $formulario -> formularioPorlet($campos, 'Mantenimiento de usuarios', 'blue ', $botonesForm, 'GET','Formulario');

#resultados
    $campos     = array('nombre_usual'=>'%'.$nombre.'%','correo'=>'%'.$email.'%','usuario'=>'%'.$usuario.'%','cod_rol'=>'%'.$rol.'%');
    $botones    = array('Ver registro');   
        if(in_array(10,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){$botones[] = 'editarConsulta';}
        if(in_array(11,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){$botones[] = 'Eliminar'; }
    $forenkey   = array('cod_rol'=>$rolArray);
    $resultado  =  $crud-> consultar($campos,$botones,$forenkey,'');
    
    echo $formularioGenerado.$resultado;
	$js = '<script src="assets/js/modulos.min.js"></script> ';
			
			
    
    ?>
