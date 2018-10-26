<?php
$varMp = $varM = $pg = '';
if(isset($_GET) && count($_GET)>0){
    foreach($_GET as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . sanitize($valor) . "';";    eval($asignacion); }
} 
    if(!isset($pg) || $pg =="" || $pg =="index"){
        $pg =$varM=$varMp= "index";  }
        
   

       class sidebarMenu extends hyperClass{
		    function inicio_menu() {
				$topmenu = '  <aside class="main-sidebar">
								<section class="sidebar">
								<ul class="sidebar-menu" data-widget="tree">
								<li class="header">MAIN NAVIGATION</li>';
				return $topmenu;
			}
			
			 function fin_menu() {
					$foot = '</ul>
								</section>
							</aside>';
					return $foot;
				}
				function menu_proyecto($opcion,$proyecto){
					
					$_SESSION[NOMBRESISTEMA]['SESSION_EQUIPO_MENU'];
					$menu_proyecto  = '<ul class="sidebar-menu tree" data-widget="tree"> 
											<li class=" "> 
												<a href="proyecto.php?pg=dashboard&tokenProyecto='.$proyecto.'" class="">
													<i class="fa fa-tachometer"></i> 
													<span>Panel de Informaci&oacute;n</span>
												</a> 
											</li>
											
											<li>
												<a href="?pg=tareas_proyecto&tokenProyecto='.$proyecto.'"> 
													<i class="fa fa-list-alt"></i> 
													<span class="title">Tareas</span>
												</a>
											</li>
											
											<li>
												<a href="?pg=archivos_proyecto&tokenProyecto='.$proyecto.'"> 
													<i class="fa fa-list-alt"></i> 
													<span class="title">Archivos del proyecto</span>
												</a>
											</li>
												<li><a href="'.$_SESSION[NOMBRESISTEMA]['SESSION_EQUIPO_MENU'].'" class="">
													<i class="fa fa-arrow-left"></i> 
													<span>Regresar</span>
												</a>
											</li>
										</ul>';
					
					return $this->inicio_menu().$menu_proyecto.$this->fin_menu();
					
				}
                 function desplegarMenuV2($varM,$varMp){
                    
                      $concat1 = $concat2 = $concat3 = $concat4 =  $concat5 = $TituloMenu= $breadActivo ='';
                      $varMenu = $this->DB->query("SELECT  m.icono,m.cod_menu,m.nombre_menu,m.dir_menu, (SELECT count(mn.cod_menu) FROM menus mn  WHERE  m.cod_menu = mn.menu_padre) as padres
                                                        FROM menus m ,rol_menu mr 
                                                        WHERE m.menu_padre = '0' AND mr.cod_rol = '".$_SESSION[NOMBRESISTEMA] ['cod_rol']."' and mr.cod_menu = m.cod_menu  and m.habilitado_menu = 'Habilitado' 
                                                        ORDER BY m.cod_menu ASC,m.nombre_menu ASC");
                    
                      $breadActivoPadre   = '<a href="?pg=index" class="tip-bottom"><i class="icon-home"></i>Inicio</a> <i class="icon-double-angle-righ" aria-hidden="true"></i>';
                      $mActi    = $varMp;
					  $icon		= "fa fa-bars";
                  
         
                          while($menuAdmin = $varMenu->fetch_assoc()){
								$PermisosMenus[]  = $menuAdmin['dir_menu'];
								$activoPadre      = '';
								 $icon		= "fa fa-bars";
								if($menuAdmin['icono']!=''){
									 $icon	= "fa ".$menuAdmin['icono']; 
								}
							   
								 
								 
                          if($menuAdmin['padres']>0){
                                 if($varMp==$menuAdmin['dir_menu']){

                                        $breadActivoPadre   = '<li><a class="tip-bottom"><i class="'.$icon.'"></i>'
																	.$menuAdmin['nombre_menu'].'  
																</a> </li>';
                                        $activoPadre        = "active open"; 
                                    }
                                $concat1    = '<li class="treeview '.$activoPadre.'"> 
												<a href="#">
													<i class="'.$icon.'"></i> 
													<span>'.$menuAdmin['nombre_menu'].'</span>
														<span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
												</a>';
                                $concat2    = $concat1 . '<ul class="treeview-menu" >'; 
                                $padre      = $menuAdmin['cod_menu'];                 
                                $varSubMenu = $this->DB->query("SELECT  m.icono,m.cod_menu,m.nombre_menu,m.dir_menu
                                                                    FROM menus m ,rol_menu mr 
                                                                    WHERE m.menu_padre = '".$padre."'  AND mr.cod_rol = '".$_SESSION[NOMBRESISTEMA] ['cod_rol']."' and mr.cod_menu = m.cod_menu  and m.habilitado_menu = 'Habilitado' 
                                                                    ORDER BY m.cod_menu ASC,m.nombre_menu ASC");
  
                            while($submenu = $varSubMenu->fetch_assoc()){
                              $PermisosMenus[]  = $submenu['dir_menu'];
                              $activo           = ''; 
                                if($varM==$submenu['dir_menu']){ 
                                    $TituloMenu     = $submenu['nombre_menu'];
                                    $activo         = 'class="active"'; 
                                    $breadActivo    = '<li><a href="#" class="active">'.$TituloMenu.'</a></li> ';
                                }
								$icono_Sub = 'fa fa-dot-circle-o';
									if($submenu['icono']!=''){
									 $icono_Sub	= "fa ".$submenu['icono']; 
								}
                                    $concat3 = $concat3. ' <li '.$activo.' ><a href="?pg='.$submenu['dir_menu'].'&varM='.$submenu['dir_menu'].'&varMp='.$menuAdmin['dir_menu'].'">  
											<i class="'.$icono_Sub.'"></i> <span class="title">'.$submenu['nombre_menu'].'</span></a></li>';         
                            }
                                     $concat4 = $concat2.$concat3. ' </ul></li>'.$concat4;
                                     $concat2 = $concat3 = '';
                          }else{
                            
                                if($mActi==$menuAdmin['dir_menu'] || $varM ==$menuAdmin['dir_menu'] ){ 
                                       $TituloMenu     = $menuAdmin['nombre_menu'];
                                        $activo         ='active'; 
                                        $href           ='';
                                        $breadActivo    = '<li><a href="#" class="active">'.$menuAdmin['nombre_menu'].'</a> </li>';
                                    }else {
                                            $activo =''; 
                                            $sapan  ='';
                                            $href   ='href="?pg='.$menuAdmin['dir_menu'].'&varM='.$menuAdmin['dir_menu'].'"';
                                        }
									
                                     $concat5 = $concat5.'<li class=" '.$activo.'"> <a '.$href.' class="" ><i class="'.$icon.'"></i> <span>'.$menuAdmin['nombre_menu'].'</span></a> </li>';
                          }
                      }    
                      $_SESSION[NOMBRESISTEMA]['breadActivo'] = '  
						  
										<h1>
											'.$TituloMenu.'
										  </h1>
										  <ol class="breadcrumb">
											 '.$breadActivoPadre.$breadActivo.'
										  </ol>
                           ';
                            $menuCompleto = ''.$concat5.$concat4.'';
                    return array('menu'=> $this->inicio_menu().$menuCompleto.$this->fin_menu(),'permisos'=>$PermisosMenus);     
                 }
        }
     
     
  	$menuUsuario   = new sidebarMenu();
	if($pg!='salir' && $pg !='login'){
			$_SESSION[NOMBRESISTEMA]['url_actual'] =  ($_SERVER['QUERY_STRING']);
	}	
	define('SEARCHFORM','formulario');
     
?>