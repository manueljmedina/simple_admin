<?php
#controlador para el Login
class login extends database{
	protected $table    = 'users';
	protected $id       = 'id';
    protected $name     = 'username';
    protected $table_singular   = 'usuarios';
	
	
	public function login_user($data){
		$arreglo_login  = array();
		#Valores para la consulta
			$select_campos	= array('username','name','email','role');
			$arreglo_login['table']		= 'users';
			$arreglo_login['where']		= $data;
			$arreglo_login['limit']		= 1;
			$arreglo_login['select']	= $select_campos;
		#Fin de arreglo con los valores de la consulta
		
		$query			= $this->get_where($arreglo_login);  

		if(count($query) >0){
			$username	= $query[0]['username'];
			$name		= $query[0]['name'];
			$email		= $query[0]['email'];
			$roles		= $query[0]['role'];
			
			$_SESSION[SYSTEM]['username']	= $username;
			$_SESSION[SYSTEM]['name']		= $name;
			$_SESSION[SYSTEM]['role']		= $roles;
			$_SESSION[SYSTEM]['email']		= $email;
			$_SESSION[SYSTEM]['ip']         = REMOTE_ADDR;

			$mensaje	= '<center>Hola <b>'.$name.'</b> has iniciado correctamente.</center>';
			$respuesta  = 'reload';
		}else{
			$mensaje	= 'Credenciales incorrectas';
			$respuesta	= 'false';
		}
		$respuesta = array("mensaje"=>$mensaje,'respuesta'=>$respuesta);
		return $respuesta;
		
	} 
	
}


?>