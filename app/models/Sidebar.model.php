<?php
#controlador para el Login
class sidebar extends database{
	
	function render_sidebar(){
		$this->role			= $_SESSION[SYSTEM]['role'];
		$this->menu_activo  = $_SESSION[SYSTEM]['menu_activo'];
		$permisos			= array();
		
		#array para la consulta de los menus
		$array_select_menu['table']		= 'menu_rol mr ,menus m';
		$array_select_menu['where']		= array('mr.cod_menu'=>'m.cod_menu','mr.cod_rol'=>$this->role,'m.tipo'=>'1','m.menu_padre'=>'0');#obtener menus
		$array_select_menu['select']	= array('m.cod_menu','m.nombre','m.icono','m.descripcion');
		#fin del arreglo
		
		$query_rol		= $this->get_where($array_select_menu); 
		
			if(count($query_rol)>0){
			$menu = '';
				foreach($query_rol as $row_roles_menu){
					
					$nombre_menu	= $row_roles_menu['nombre'];
					$cod_menu		= $row_roles_menu['cod_menu'];
					$icono_menu		= $row_roles_menu['icono'];
					$permisos[]			= $nombre_menu;
					$descripcion_menu	= $row_roles_menu['descripcion'];
						#array para la consulta de los menus
						$array_select_submenu['table']		= 'menu_rol mr ,menus m';
						$array_select_submenu['where']		= array('mr.cod_menu'=>'m.cod_menu','mr.cod_rol'=>$this->role,'m.menu_padre'=>$cod_menu);#obtener submenus
						$array_select_submenu['select']		= $array_select_menu['select'];
						#fin del arreglo
					
					$query_sub_menu		= $this->get_where($array_select_submenu); 
					
					if(count($query_sub_menu)>0){
						$sub_menu = '';
						$active_menu = '';
							foreach($query_sub_menu as $row_roles_sub_menu){
								$activo_sub = '';
								$nombre_sub_menu			= $row_roles_sub_menu['nombre'];
								$icono_sub_menu				= $row_roles_sub_menu['icono'];
								$descripcion_sub_menu		= $row_roles_sub_menu['descripcion'];
								$permisos[]					= $nombre_sub_menu;
								if(isset($this->menu_activo) && $this->menu_activo == $nombre_sub_menu){
									$activo_sub					= 'class="active"';
									$active_menu				= 'active';
									$this->descripcion_activa	= $descripcion_sub_menu;
									$this->main_folder	        = $nombre_menu.'/';
								}
								$sub_menu		   .= '<li '.$activo_sub.' ><a href="?page='.$nombre_sub_menu.'"><i class="fa '.$icono_sub_menu.'"></i> '.$nombre_sub_menu.' </a></li>';
							}
							$menu .= '<li class="treeview '.$active_menu.'">
									<a href="#">
									  <i class="fa '.$icono_menu.'"></i> 
									  <span>'.$nombre_menu.'</span>
									  <span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									  </span>
									</a>
									<ul class="treeview-menu">
										'.$sub_menu.'
									</ul>
								  </li>';
							$sub_menu = '';
						
					}else{
						if(isset($this->menu_activo) && $this->menu_activo ==$nombre_menu){
									$active_menu = 'class="active"';
									 $this->descripcion_activa = $descripcion_menu;
								
						}else{$active_menu= '';}
							
						$menu .='<li '.$active_menu.'><a href="?page='.$nombre_menu.'"><i class="fa '.$icono_menu.'"></i> <span>'.$nombre_menu.'</span></a></li>';
					}

					# 
				}
				
				$this->render_menu = $menu;
				$_SESSION[SYSTEM]['permisos'] = $permisos;
			}
	}
}

		$sidebar_class = new sidebar();
$sidebar_class->render_sidebar();

	?>