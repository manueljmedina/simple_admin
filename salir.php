<?php
require 'core/Core.php';
if(isset($_SESSION[SYSTEM])){
    $nick			= $_SESSION[SYSTEM]['username'];
	$nombre_sistema = SYSTEM;
    unset($_SESSION[SYSTEM]);
    header("location:index.php?pg=login&nick=".$nick);
    exit();
  } 

?>