<?php
#controlador para el Login
require_once 'core/Core.php';
require_once 'app/models/Sidebar.model.php';
#
$sidebar_class		= new sidebar();
$sidebar_class->render_sidebar();
  
?>