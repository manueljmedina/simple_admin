<?php
require 'models/general_variables.php';
require 'models/permisos.model.php';

$crud     = new roles();

if(!isset($nombre)){$nombre='';}
if(!isset($descripcion)){$descripcion='';}     
if(!isset($habilitado)){$habilitado='';}   


#campos para el formulario
    $nombreProv          = $formulario ->input('Nombre',$nombre, '', 'text', '');
    $descripcionProv     = $formulario ->input('Descripción',$descripcion, '', 'text', '');
    $habilitadoPro       = $formulario ->select('Habilitado','',$crud->habilitado,'',$habilitado); 
   
  
    $campos             = $nombreProv.$descripcionProv.$habilitadoPro.$obliatorios;
#botones para el formulario
    $botonesForm        = $formulario ->inputButton('Consultar','submit','btn-success consulta','',4,'');
   if(in_array(6,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){
        $botonesForm .=  $formulario ->inputButton('Crear nuevo registro','button','btn-primary guardar','',4,'');
    }
     $botonesForm      .= $formulario ->inputButton('Limpiar Valores','button','btn-warning reset','',4,'');
#renderizar formulario
    $formularioGenerado = $formulario -> formularioPorlet($campos, 'Mantenimiento de permisos del sistema', 'blue ', $botonesForm, 'GET','Formulario');

#resultados
    $campos     = array('nombre_rol'=>'%'.$nombre.'%','descripcion_rol'=>'%'.$descripcion.'%','habilitado_rol'=>'%'.$habilitado.'%');

    $botones    = array('Ver registro');   
        if(in_array(5,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){$botones[] = 'listas';}
        if(in_array(7,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){$botones[] = 'editarConsulta';}
        if(in_array(8,$_SESSION[NOMBRESISTEMA]['OPCIONESROL'])){$botones[] = 'Eliminar'; }
    //$forenkey   = array('cod_rol'=>$rolArray);
    $resultado  =  $crud-> consultar($campos,$botones,'','');
    
    echo $formularioGenerado.$resultado;

?>

