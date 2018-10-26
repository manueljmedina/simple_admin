<?php

require 'models/general_variables.php';
require 'models/logs.model.php';
require 'models/usuarios.model.php';

$crud         = new logs();
$personal     = new usuarios();
$id_personal  = $personal->queryOptions('');

if(!isset($fecha_inicial) || $fecha_inicial==''){$fecha_inicial=date('Y-m-d');}
if(!isset($fecha_final) || $fecha_final==''){$fecha_final =date('Y-m-d');}

#campos para el formulario
    $fecha_inicialProv        = $formulario ->input('Fecha inicial',$fecha_inicial, '', 'date', '');
    $fecha_finalProv          = $formulario ->input('Fecha final',$fecha_final, '', 'date', '');
    
    $campos              = $fecha_inicialProv.$fecha_finalProv.$obliatorios;
#botones para el formulario
    $consulta           = $formulario ->inputButton('Consultar','submit','btn-success consulta','',4,'');

    $reset              = $formulario ->inputButton('Limpiar Valores','button','btn-warning reset','',4,'');
#renderizar formulario
    $formularioGenerado = $formulario -> formularioPorlet($campos, 'Consulta de logs', 'blue ', $consulta.$reset, 'GET','Formulario');

#resultados
  $campos     = array('between#fecha_log'=>array($fecha_inicial,$fecha_final),'tipo_log'=>'%%','descripcion_log'=>'%%','cod_user'=>'%%' );
    $botones    = array('editarConsulta');    
    $forenkey   = array('cod_user'=>$id_personal);
    $resultado  =  $crud-> consultar($campos,'',$forenkey,'');
    
    echo $formularioGenerado.$resultado;
?>

