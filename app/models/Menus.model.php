<?php
#Modelo del módulo Menus
$menus	= new Menus();
class Menus extends database{
	protected $table			= 'menus';
	protected $id				= 'cod_menu';
    protected $name				= 'nombre';
    protected $table_singular   = 'menu';
	
	function menu_padre(){
		$select_campos	= array('cod_menu','nombre');
		$arreglo		= array();
		$menu_padre		= array();
		$arreglo['table']	= $this->table;
		$arreglo['where']	= array('activo'=>1,'tipo'=>1);
		$arreglo['select']	= $select_campos;
		$where				= $this->get_where($arreglo);  
		
		foreach($where as $menus){
			$id				 = $menus[$select_campos[0]];
			$value			 = $menus[$select_campos[1]];
			$menu_padre[$id] = $value;
		}
		
		return $menu_padre;
	}
	


	

	
}


?>