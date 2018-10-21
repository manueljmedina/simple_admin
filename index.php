<?php

require 'core/Core.php';

if ($_SESSION && array_key_exists(SYSTEM, $_SESSION)){
	$_SESSION[SYSTEM]['menu_activo'] = $page;	
	    require 'app/header.php';
		require 'app/topbar.php';
		require 'app/sidebar.php';
		
		if(isset($sidebar_class->main_folder)){ # si existe la variable de la carpta del padre se concatena a la variable de la página
			$pagina = SYSTEMAPP.PATHVIEWS.$sidebar_class->main_folder.$page.'.php';
		}else{
			$pagina = SYSTEMAPP.PATHVIEWS.$page.'.php';
		}
		
	if(isset($page)){
		
		if (file_exists($pagina)) {
			if (in_array($page, $_SESSION[SYSTEM]['permisos'])) {
				$pagina =  $pagina;
			}else{
					$pagina =  SYSTEMAPP.PATHVIEWS."403.php";
				}
			}else{
					$pagina =  SYSTEMAPP.PATHVIEWS . "404.php";
			}
	}else{
		$pagina =  SYSTEMAPP.PATHVIEWS . "404.php";
	}

	require $pagina;
	require 'app/footer.php';
	
	
}else{
	require SYSTEMAPP.PATHVIEWS.'login.php';
}
?>