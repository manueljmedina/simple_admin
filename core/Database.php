<?php
class database{
	
	protected function conexion(){  
        $conexion = new mysqli(SERVER, USER, PASS, DATEBASE);
        $conexion->query("SET NAMES '".CODING."'");
            if ($conexion->connect_errno) {
                $mensaje=  "Falló la conexión a MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error;
                exit($mensaje);
            }
        return $conexion;
    }

    function __construct(){	
       $this->db=$this->conexion();
    }
	
    function __destruct() {
		$this->db->close();   
    }
	
	#get_where
	public function get_where($array){
		if (is_array($array) && isset($array['table'])){#si no se introduce la tabla a consultar la funcion no hace nada
			$operator = 'AND';
			
			if (isset($array['select']) && is_array($array['select'])){#valida si se espeficicaron los valores que se desean obtener
					$select_fields = implode(',', $array['select']);
				}else{
					$select_fields = '*';
				}

				$this->query_build = "SELECT ".$select_fields." FROM ".$array['table'];

				if (isset($array['where'])){#valida si existe condiciones en la consulta
					$where		= $array['where'];
					$fieldsvals = array();
					foreach($where as $value=>$fields){
						$where_fields	= $where[$value];
						$find			= strpos($where_fields, '.');#validar si tiene un punto el campo para identificar otra base de datos
						$find_like		= strpos($where_fields, 'like:');
						$find_like_a	= strpos($where_fields, 'like%');
						
						if ($find === false) {
							$where_fields = "'". $where[$value]."'";
						}

						$fieldsvals[]  = ' '.$value . " = ". $where_fields;
					}
					if (isset($array['operator'])){
						$operator = $array['operator'];
					}
					$this->query_build .= ' WHERE '.implode(' '.$operator.' ', $fieldsvals);
				}

				if (isset($array['limit'])){
					$this->query_build .= ' LIMIT '.$array['limit'];
				}

				#echo $this->query_build;
				$execute_query	= $this->db->query($this->query_build);
				$fetch_array	= $execute_query->fetch_all(MYSQLI_ASSOC); //se almacena el resultado de la consulta en una variable con el fetch_all
			return $fetch_array;
		}
	}
	
	
	
	public function insert($array){
		if(is_array($array) && isset($array['table']) && isset($array['values'])){
			$table				= $array['table'];
			$values				= $array['values'];
			
				foreach($values as $field_key=>$field_value){
					$field_query[]  = $field_key;                                    
                    $values_Query[] = "'".$field_value."'";
				}
			
			$this->query_insert = "INTERT INTO ".$table ."(".join(',', $field_query).") VALUES (".join(',', $values_Query).")";
			$this->db->query($this->query_insert);
			
			if($this->db->affected_rows > 0){
				$this->insert_id    = $this->db->insert_id;
				
			} 
           

		}
	}
	
	
	
}

#$database = new database();

?>