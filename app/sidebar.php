<?php

require 'app/models/Sidebar.model.php';
?>  
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
 
     
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		
		<?php
		echo $sidebar_class->render_menu;
		?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php 
	   echo  $_SESSION[SYSTEM]['menu_activo'];?>
        <small>
		<?php 
		  if(isset($sidebar_class->descripcion_activa)){ 
			  echo $sidebar_class->descripcion_activa;
		  }
		?>
		</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">