<?php
#clase para la conección
#28-04-2017
#Manuel medina

class hyperClass{
    public    $habilitado			= array('Habilitado'=>'Habilitado','Inactivo'=>'Inactivo'); 
	public    $total_registros      = array('300'=>'300','500'=>'500','1000'=>'1000'); 
 
	protected function conexion(){  
        $conexion = new mysqli(SERVER, USER, PASS, DATEBASE);
        $conexion->query("SET NAMES '".CODING."'");
            if ($conexion->connect_errno) {
                $mensaje=  "Falló la conexión a MySQL: (" . $this->DB->connect_errno . ") " . $this->DB->connect_error;
                exit($mensaje);
            }
        return $conexion;
    }
	protected function buffer_off(){
		ob_end_flush(); 
		ob_flush(); 
		flush(); 
	}

    function __construct(){	
       $this->DB=$this->conexion();
    }
	
    function __destruct() {
		#$this->buffer_off();	
		$this->DB->close();   
    }
    
    function row($sql){#devuelve una fila de  la consulta realizada
            $execute    = $this->DB->query($sql);
            $fetch      = $execute->fetch_array(MYSQLI_ASSOC);
        return $fetch;      
    }
    
   function row_where($where_sent){#devuelve una fila de  la consulta realizada
            $sql        = "SELECT * FROM ".$this->table ." WHERE ".$where_sent." ORDER BY ".$this->id." DESC LIMIT 1";
            $execute    = $this->DB->query($sql);
            $fetch      = $execute->fetch_array(MYSQLI_ASSOC);
            if($fetch[$this->id]!=NULL){
                $token      = md5(DATE.$fetch[$this->id]);
            }else{
                $token = '';
            }  
        return array('fetch'=>$fetch,'token'=>$token);      
    }
    
    function insertLog($tipo,$descripcion,$id_relacion){#Funcion general para insertar los logs del sistema
        if(isset($_SESSION[NOMBRESISTEMA]['cod_user'])){
            $cod_user = $_SESSION[NOMBRESISTEMA]['cod_user'];
        }else{
            $cod_user = $id_relacion;
        }
       $selectDelete    = "INSERT INTO log_accion (tabla,tipo_log,cod_user,descripcion_log,ip_log,fecha_log,id_relacion) 
                                  VALUES('".$this->table."','".$tipo."','".$cod_user ."','".$descripcion."','".REMOTE_ADDR."','".DATETIME."','".$id_relacion."')";
       $this->DB->query($selectDelete); 
    }
    
    #Funcion para generar los options de un select dependiendo del array enviado
    function queryOptions($array){
            $where = $fieldsvals = $valName='';
              if(is_array($array)){
				 $num_array = count($array);
				
                $columns          =  array_keys($array);
				
						foreach($columns as $column){
							if($column!='NoId'){
								$fieldsvals  .= ' '.$column . " = '". $array[$column] . "' AND";
							}else{
								$valName='NoId';
							}
							
						} 
					if($valName!='NoId' || $num_array>1){
						    $fieldsvals  = substr_replace($fieldsvals , '', -4);
							$where = ' WHERE ';
							$and   = ' AND ';
					}
           
			}else{
				$valName = $array;
			}  
               $option  = array();
			  # echo "SELECT * FROM ".$this->table .$where. $fieldsvals;
               $query   = $this->DB->query("SELECT * FROM ".$this->table .$where. $fieldsvals);
                while ($row = $query->fetch_array()){
					if($valName!='NoId'){
						$option[$row[$this->id]] = $row[$this->name];
					}else{
							$option[$row[$this->name]] = $row[$this->name];
					}
                 }
            return  $option;
        }
		
    function queryOptions_noid_where($array){
            $where = $fieldsvals = $valName='';
              if(is_array($array)){
                $columns          =  array_keys($array);
                    foreach($columns as $column){
                        $fieldsvals  .= ' '.$column . " = '". $array[$column] . "' AND";
                    }    
                $fieldsvals  = substr_replace($fieldsvals , '', -4);
                $where = ' WHERE ';
                $and   = ' AND ';
			}else{
				$valName = $array;
			}  
               $option  = array();
               $query   = $this->DB->query("SELECT * FROM ".$this->table .$where. $fieldsvals);
                while ($row = $query->fetch_array()){
					if($valName!='NoId'){
						$option[$row[$this->id]] = $row[$this->name];
					}else{
							$option[$row[$this->name]] = $row[$this->name];
					}
                 }
            return  $option;
        }
		
		
		function get_datalist($array,$tipoComparacion,$arrayOptions){
			$where	= $acu =' ';
			$value1 = $arrayOptions[0];
			$value2 = $arrayOptions[1];
				
			foreach($array as $key=>$value){
				$where .= $key ." like '%".$value."%' ";
				if(end($array) !== $value){
					$where .= ' '.$tipoComparacion.' ';
				}
			}
			    $sql     = "SELECT ".$value1.",".$value2." FROM " . $this->table . " WHERE  ".$where." ORDER BY ".$value2." LIMIT 5";
				$query   = $this->DB->query($sql);
                while ($row = $query->fetch_assoc()){
                   $acu .= '<option class="datalist_option"  id="'.$row[$value1].'" value="'.$row[$value2].'">';
                 }
				 return $acu;
		}
        
    #************************************************************************ INICIO DE FUNCIONES PARA EL CRUD ******************************#
		function tableTitle($rowKey){
			$tableS = $this->table_singular;
                $rowKey =   str_replace('es_', '', $rowKey);
                $rowKey =   str_replace('cod_', '', $rowKey);
                $rowKey =   str_replace('id_', '', $rowKey);
                $rowKey =   str_replace('_', ' ', $rowKey);
                $rowKey =   str_replace($tableS, '', $rowKey);
		return ucwords($rowKey);
		}
     #Funcion para devolver el resultado de la consulta realizada
    function consultar($arreglo,$buttons,$fk,$chekRow){
            include "includeDataTable.php";
            if(!empty($arreglo)) {
                if(is_array($fk)){ $foren =  array_keys($fk);}
                $hasta            = 500;
                $columns          = array_keys($arreglo);
                $fieldsvals       = $title = $seach = $seachRow = $selectFilds = $edit = $delete='';
                
                    foreach($columns as $column){
                        $betw = strpos($column, 'between#');
                        
                            if($betw===false){
                                $fieldsvals  .= ' '.$column . " LIKE '". $arreglo[$column] . "' AND";
                                $selectFilds .= $column . ","; 
                            }else{
                                $date1 = $arreglo[$column][0];
                                $date2 = $arreglo[$column][1];
								if($date1==''){$date1 = '2015-01-01';}
								if($date2==''){$date2 = date('Y-m-d');}
                                
                                $date1_srt = strtotime($date1);
                                $date2_srt = strtotime($date2);
                                
                                if($date1_srt>$date2_srt){
                                    $date2 = $date1 = date('Y-m-d');
                                }
                               
                                $porciones = explode("between#", $column);
                                $fieldsvals  .= ' date('.$porciones[1] . ") between '". $date1 . "' AND '". $date2 . "' AND";
                                $selectFilds .= $column . ","; 
                            } 
                    }
                      
                $fieldsvals  = substr_replace($fieldsvals , '', -4);
                $selectFilds = substr_replace($selectFilds , '', -1);
                $selectFilds =  str_replace("between#","",$selectFilds);
				
                    $sql            = "SELECT ".$this->id.",".$selectFilds." FROM ".$this->table ." WHERE " . $fieldsvals. " ".$_SESSION[NOMBRESISTEMA]['CONSULTANIDADA']." ORDER BY ".$this->id." DESC LIMIT 0,".$hasta;
                    $query          = $this->DB->query($sql);
                    $number         = $query->num_rows;
                    $_SESSION[NOMBRESISTEMA]['CONSULTANIDADA'] = '';#siempre se debe limpiar el valor de la consulta anidada.
                     if($number>0 && $query != false){
                         $arrayP = array();
                         while($b = $query->fetch_assoc()){
                                  array_push($arrayP, $b);
                               }
                          $columnsQuery   = $this->getL2Keys($arrayP);
                          $i              = 1;
                    foreach($arrayP as $rows){
                        
                           $token   = md5(DATE.$rows[$this->id]);
                         
                           foreach($columnsQuery as $rowKey){
                               $campo = $rows[$rowKey];
                              if(is_array($fk)){
                                  if(in_array($rowKey, $foren)){
                                      if(isset($fk[$rowKey][$rows[$rowKey]])){
                                         $campo    =  $fk[$rowKey][$rows[$rowKey]];
                                      }else{
                                          $campo = '--';
                                      }
                                  } 
                              } 
                              if($rowKey<>$this->id && $rowKey !='habilitado'){
								 $rowKey = $this->tableTitle($rowKey);
                                    $seach       .= '<td class="td" data-th="'.$rowKey.'">'.($campo).'</td>';
                                    if($i==1){
                                       
                                        $title .= '<th class="th">'.($rowKey).'</th>';
                                    } 
                               }
                           }
                           ++$i;
                        if(is_array($buttons)){
                            $buton         = '';
                            if(in_array('editarConsulta', $buttons)){   $buton  .=  $this->buttons('editar','editarConsulta',$token);}
                            if(in_array('Eliminar', $buttons)){         $buton  .=  $this->buttons('delete','Eliminar',$token);}
                            if(in_array('Ver registro', $buttons)){     $buton  .=  $this->buttons('views','Ver registro',$token);}
                            if(in_array('listas', $buttons)){           $buton  .=  $this->buttons('menuico','listas',$token);}
                            if(in_array('lista_atributo', $buttons)){   $buton  .=  $this->buttons('menuico','lista_atributo',$token);}
                            if(in_array('opciones_menu', $buttons)){    $buton  .=  $this->buttons('menuico','opciones_menu',$token);}
                            if(in_array('editarConsulta2', $buttons)){  $buton  .=  $this->buttons('editar','editarConsulta2',$token);}
                            if(in_array('Eliminar2', $buttons)){        $buton  .=  $this->buttons('delete','Eliminar2',$token);}
							if(in_array('Equipo', $buttons)){           $buton  .=  $this->buttons('group','Equipo',$token);}
							if(in_array('detalle', $buttons)){          $buton  .=  $this->buttons('detalle','detalle',$token);}
							
                            
                            if(isset($chekRow) && $chekRow!=''){
                                $SelectInput  =''; 
                            }else{
                             $SelectInput   = '<td  class="td" data-th="Seleccionar"><label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox"value="'.$token.'"  class="rowSelect" name="select[]" ><span></span></label></td>';
                            }
                             $seachRow     .= '<tr id="'.$token.'">'.$SelectInput.''.$seach.'<td class="td" data-th="Acci&oacute;n">'.$buton.'</td></tr>';
                        }else{
                             $seachRow    .= '<tr>'.$seach.'</tr>';
                        }
                        $seach           = '';
                       }
                         if(is_array($buttons)){
                            $SelectInputTitle   = '<th width="60" class="ckTitle no-sort"><label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" value="'.$token.'"  class="tituloSelect" > <span></span></label></th>';
                               if(isset($chekRow) && $chekRow!=''){
								   $SelectInputTitle = '';
							   }
                            $titleComp          = '<tr>'.$SelectInputTitle.''.$title.'<th width="115" class="no-sort td">Acci&oacute;n</th></tr>';
                            $daleteAllSeleted   = '<input type="button" id="deleteAll" value="Eliminar registros seleccionados" class="btn btn-danger" style="display:none;">';
                            
                         }else{
                             $daleteAllSeleted      = '';
                             $titleComp             = '<tr>'.$title.'</tr>';
                         }
                         return ($datatable.$daleteAllSeleted.$this->tablaPaginacion($titleComp,$seachRow));

                     }else{
                         return 'No se encontraron registros';
                     }
            }
        }

        #Funcion general para la creación de registros
        function crear($arreglo,$arregloNoIqual,$tipoComparacion){
            $last_id	 = '';
			$camposQuery = $valoresQuery  = array();
            if(!empty($arreglo)) {
				$fields         =  array_keys($arreglo);
				$numero         = '';
                            if($arregloNoIqual!=''){
                                    $QueryIgual = $this->selectQueryWhere($arregloNoIqual,'',$tipoComparacion);
                                    $numero     = $QueryIgual['number'];
                            }
				
                            if($numero=='' || $numero==0){
								
                                foreach ($arreglo as $llave=>$campos){
									$camposQuery[]  = $llave;                                    
                                    $valoresQuery[] = "'".$campos."'";
                                }
												
                                    $sql            = "INSERT INTO ".$this->table." (".join(',', $camposQuery).") VALUES (".join(',', $valoresQuery).")";
                                    $query          = $this->DB->query($sql);
                                    $filasAfectadas = $this->DB->affected_rows; 
                                    $last_id        = $this->DB->insert_id;
                                            if(isset($_SESSION[NOMBRESISTEMA]['id'])){ 
                                                $logDescripcion = "Se inserto el registro ".$last_id.", ".$this->name."= <b>".$arreglo[$this->name]."</b>, en la tabla <b>".$this->table.'</b>';
                                                $this->insertLog('CREAR',$logDescripcion,$last_id);
                                            }
                                 if($filasAfectadas>0){
                                    $mensaje    = '<b>Se ha creado correctamente este registro.</b>';
									$resultado  = 'reload'; 
								return array('mensaje'=>$mensaje,'resultado'=>$resultado,'respuesta'=>$resultado,'last_insert'=>$last_id);
                                    
                                }else{

									return array('mensaje'=>'Este registro no se ha podido crear','resultado'=>'NO');
                                } 
                            }elseif($numero>0){
                                $mensaje    = 'No se ha podido crear este registro ya que existe uno parecido. <b>('.$this->name.': '.$QueryIgual['name'].')</b>';
                                $resultado  = 'NO';
                              return array('mensaje'=>$mensaje,'resultado'=>$resultado);
                            }
		}   
        }
        #Funcion general para la edición
        function editar($arreglo,$where,$token,$arregloNoIqual,$tipoComparacion){
			
            if(!empty($arreglo)) {
			
			$columns         =  array_keys($arreglo);
                        $fieldsvals      = $numero = $modificadas ='';
                        $numeroIgual     = 0;
                            if(is_array($arregloNoIqual)){
                               $QueryIgual  = $this->selectQueryWhere($arregloNoIqual,$token,$tipoComparacion);
                               $numeroIgual = $QueryIgual['number'];
                             }
                                 $selectName  = $this->DB->query("SELECT * FROM " . $this->table . "  WHERE  MD5(CONCAT(CURDATE(),".$this->id."))='".$token."'");
                                 $selectName  = $selectName->fetch_array(MYSQLI_ASSOC);
                             if($numeroIgual ==0){
                                foreach($columns as $column){
                                    $fieldsvals .= $column . " = '". $arreglo[$column] . "',";
                                       if( ($selectName[$column]==0 && $arreglo[$column]=='')){$arreglo[$column]=0;}
                                        if($selectName[$column]!=$arreglo[$column]){
                                            $modificadas .= $column."=>[".$selectName[$column].",".$arreglo[$column]."], ";
                                        }
                                }
                                    if($modificadas!=''){
                                            $modificadas = " Datos modificados: ".$modificadas;
                                    }
                                $fieldsvals = substr_replace($fieldsvals , '', -1);
                                if($where!='' && $token ==''){
                                    $sql        = "UPDATE " . $this->table  .  " SET " . $fieldsvals . " WHERE " . $where;
                                }elseif($where=='' && $token==''){
                                    $sql        = "UPDATE " . $this->table  .  " SET " . $fieldsvals;
                                }elseif($token!=''){
                                     $sql        = "UPDATE " . $this->table  .  " SET " . $fieldsvals . " WHERE MD5(CONCAT(CURDATE(),".$this->id."))='".$token."'";
                                }
          
                                $query          = $this->DB->query($sql);
                                $filasAfectadas = $this->DB->affected_rows;
                               
                                 if(is_bool($query) === true && $filasAfectadas>0){
                                    $logDescripcion = "Se edita el registro: ".$selectName[$this->id].", ".$this->name."= ".$selectName[$this->name].", en la tabla ".$this->table.$modificadas;
                                    $this->insertLog('EDITAR',$logDescripcion,$selectName[$this->id]);
										$mensaje    = '<b>Se ha actualizado correctamente este registro.</b>';
									    $resultado  = 'reload'; 
								return array('mensaje'=>$mensaje,'resultado'=>$resultado);
                                    
                                }else{
									$mensaje    = '<b>Nose ha actualizado este registro,</b>  <br><br>
														    Si sigue apareciendo este mensaje, puede que no estes modificando nada o haya ocurrido un error 
															durante la actualizaci&oacute;n.';
									$resultado  = 'NO'; 
								return array('mensaje'=>$mensaje,'resultado'=>$resultado);
                                } 
                            }else{
                                $mensaje    = 'No se ha actualizado este registro ya que existe uno o m&aacute;s registros iguales. '.'<br><b>('.$this->name.': '.$QueryIgual['name'].')</b>';
                                $resultado  = 'NO';
                              return array('mensaje'=>$mensaje,'resultado'=>$resultado);
                            }
		}   
        }
		#funciones para eliminar
		
		function delete_dependency($id,$array){
			$this->DB->query("ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1");
			 $tokenArray = explode(",",trim($id, ','));
			 $i = 0;
			 foreach ($tokenArray as $tokenID) { 
				$select_id		= "SELECT ".$this->id.", ".$this->name." FROM " . $this->table . "  WHERE  MD5(CONCAT(CURDATE(),".$this->id."))='".$tokenID."'";
				$query_id		= $this->DB->query($select_id);
				$selectName		= $query_id->fetch_array(MYSQLI_ASSOC);
				$table_acu		= '';
				$e = 0;
					foreach($array as $tabla=>$value){#Borrar dependencias
						$delete			= "DELETE FROM ".$tabla." WHERE ".$value." = '".$selectName[$this->id]."' " ;
						$delete_query	=  $this->DB->query($delete);
							if($e==0){
								$table_acu = $tabla;
							}else{
								$table_acu = $table_acu.','.$tabla;
							}
						++$e;
					}
				#borrar el registro solicitado
				$delete			= "DELETE FROM ".$this->table ." WHERE ".$this->id." = '".$selectName[$this->id]."' " ;
				$delete_query	=  $this->DB->query($delete);
				++$i;
				  $thisName = $selectName[$this->name];
				  $logDescripcion = "Se elimina el registro: <b>".$thisName."</b> de la tabla: ". $this->table." con el id: ".$selectName[$this->id].' y sus dependencias en: ('.$table_acu.')';
				  $this->insertLog('CASCADE_DELETE',$logDescripcion,$selectName[$this->id]);
			 }	
		
					if($delete_query===true){
						if($i>1){$s='s';}else{
							$s='';
						}
						$mensaje	= "Se ha eliminado correctamente ".$i." registro".$s." y todas las dependencias listadas.";
						$resultado	= 'reload';
					}else{
						$mensaje	= "Ooops ocurri&oacute; un error durante la eliminaci&oacute;, Intenta nuevamente...";
						$resultado	= 'reload';
					}
					 return array('mensaje'=>$mensaje,'resultado'=>$resultado);
			 
		}
		function delete_where($array,$tipoComparacion){#Esta funcion elimina con  el where que venga en el array
			$where = '';
		    $this->DB->query("ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1");
					
			foreach($array as $key=>$value){
				$where .= $key ." ='".$value."' ";
				if(end($array) !== $value){
					$where .= ' '.$tipoComparacion.' ';
				}
			}
			    $sql        = "DELETE FROM " . $this->table . " WHERE  ".$where;
                $this->DB->query($sql);
		}
           function delete($token,$used) {
            $cat        = $e = 0;
            $tokenArray = explode(",",trim($token['token'], ','));
            $mensaje    = $campo = '';
           
           foreach ($tokenArray as $tokenID) { 
               $num =0;
             
               $selectName  = $this->DB->query("SELECT * FROM " . $this->table . "  WHERE  MD5(CONCAT(CURDATE(),".$this->id."))='".$tokenID."'");
               $selectName  = $selectName->fetch_array(MYSQLI_ASSOC);
               $idDelete = $selectName[$this->id];
               $thisName = $selectName[$this->name];
               $logDescripcion = "Se elimina el registro: <b>".$thisName."</b> de la tabla: ". $this->table." con el id: ".$idDelete;
               if(is_array($used)){
                     
                      $tablas = array_keys($used);
                     
                        foreach($used as $arregloCompuesto){
                            foreach($arregloCompuesto as $llave => $valor){
                                $tabla = $tablas[$num];
                                $valor = $selectName[$valor];
                                $campo =  $llave ."= '".$valor."'";
                            }
                                $select = "SELECT count(1) AS number FROM ".$tabla." WHERE ".$campo;
                                $search = $this->DB->query($select);
                                $search = $search->fetch_array(MYSQLI_ASSOC);
                                $campo  = $select =''; 
								$number = $search['number'];
                                $cat    = $cat+$number;
								
								if($number>1){$s='s';}else{$s = '';}
								if($number!=0){
									 $mensaje    .= 'El registro <b>'.$selectName[$this->name].'</b> tiene <b>'.$number.'</b> dependencia'.$s.', en la tabla <b>'.$tabla.'</b>, por lo que <b style="color:red;">NO</b> podr&aacute; ser eliminado.<br>';
									 $resultado = 'NO';
									
								}
                            ++$num;
                        }
                       
                }
                if($cat==0){
                        if(!empty($token)) {
                                $sql        = "DELETE FROM " . $this->table . " WHERE  MD5(CONCAT(CURDATE(),".$this->id."))='".$tokenID."'";
                                $query      = $this->DB->query($sql);
                                $this->insertLog('ELIMINAR',$logDescripcion,$idDelete);
                                ++$e;
                        }
                }
           } 
           if($e>0){
			   if($e>1){$sr = 's';}else{$sr = '';}
               $mensaje .= 'Se ha eliminado correctamente '.$e.' registro'.$sr;
               $resultado = 'reload';
           }
           
            return array('mensaje'=>$mensaje,'resultado'=>$resultado);
	}
        
        #FUNCIONES ALIMENTADORAS PARA EL FUNCIONAMIENDO DE LAS FUNCIONES DEL CRUD
        
        function get($cod){
             $sql            = "SELECT * FROM ".$this->table ." WHERE MD5(CONCAT(CURDATE(),".$this->id."))='".$cod."'";
             $query          = $this->DB->query($sql);
             $query          = $query->fetch_array(MYSQLI_ASSOC);
             return $query;
        }
        
                
        function selectUsed($used){
            $campo = '';
            $num = 0;
            
             if(is_array($used)){
                   $fields         =  array_keys($used);
                   $columnsQuery   = $this->getL2Keys($used);
                 foreach($fields as $tableA){
                      foreach($columnsQuery as $filas){
                           $campo .=  ' '.$filas."='".$used[$tableA][$filas]."' AND";
                      }
                      $campo    = substr_replace($campo , '', -4);
                      $sql      = "SELECT COUNT(1) AS num FROM ".$tableA." WHERE ".$campo;
                      $search   = $this->DB->query($sql);
					  
						$search      = $search->fetch_array(MYSQLI_ASSOC);
                      $num      = $num+$search['num'];
                 }
                 
             }
             return $num;
        }
        function selectQueryWhere($arreglo,$cod,$tipoComparacion){
            if($tipoComparacion==''){
                $tipoComparacion = ' AND';
            }
            $columns          =  array_keys($arreglo);
            $fieldsvals       = $thisID ='';
                foreach($columns as $column){
                    if($tipoComparacion=='OR' && $cod!=''){
                        $fieldsvals  .= " MD5(CONCAT(CURDATE(),".$this->id."))<>'".$cod."' AND ".$column." = '". $arreglo[$column]."'  OR ";
                    }else{
                         $fieldsvals  .= ' '.$column . " = '". $arreglo[$column] . "' ".$tipoComparacion;
                    }
                 }    
                if($cod!='' && $tipoComparacion!='OR'){
                    $thisID                 = " AND MD5(CONCAT(CURDATE(),".$this->id."))<>'".$cod."'";
                    $arreglo['concatID']    = $cod;
                }
            if( $tipoComparacion!='OR'){
                 $fieldsvals  = substr_replace($fieldsvals , '', -4);
            }else{
                $fieldsvals  = substr_replace($fieldsvals , '', -3);
            }
           
                $sql            = "SELECT count(".$this->id.")AS number,".$this->name." AS name FROM ".$this->table ." WHERE " . $fieldsvals.$thisID;
               $query           = $this->DB->query($sql);
               $query          = $query->fetch_array(MYSQLI_ASSOC);
                  
                   // 


             return $query;
        }
        
        #Funcion para devolver el segundo index
       function getL2Keys($array){
            $result = array();
            $sub    = array();
            foreach($array as $sub) {
                #var_dump($sub);
                $result = array_merge($result, $sub);
            }        
            return array_keys($result);
        }
        
        function buttons($type,$class,$token){
            $class2 = '';
            if($class=='lista_atributo'){
                $boton   = '<a href="'.$_SESSION[NOMBRESISTEMA]['SESSIONMENUATRIBUTO'].'&tokenID='.$token.'&opt='.$class.'"><img src="assets/img/'.$type.'.png"  title="'.$class.'" HSPACE="5"  class="pointer '.$class.'"  width="24"></a> ';
            }elseif($class=='opciones_menu'){
                 $boton   = '<a href="'.$_SESSION[NOMBRESISTEMA]['SESSIONMENUOPCIONESMENU'].'&tokenID='.$token.'&opt='.$class.'"><img src="assets/img/'.$type.'.png"  title="'.$class.'" HSPACE="5"  class="pointer '.$class.'"  width="24"></a> ';
            }elseif($class=='detalle'){
                 $boton   = '<a href="proyecto.php?pg=dashboard&tokenProyecto='.$token.'"><img src="assets/img/'.$type.'.png"  title="'.$class.'" HSPACE="5"  class="pointer '.$class.'"  width="24"></a> ';
            }
			else{
                if($class=='Eliminar' || $class=='Eliminar2'){$class2 = ' DELETEBUTTON';}
                $boton   = '<img src="assets/img/'.$type.'.png"  title="'.$class.'" HSPACE="5"  class="pointer accionButtons '.$class.$class2.'" token="'.$token.'" width="24"> ';
            } 
           return $boton;
        }
        
        function tablaPaginacion($encabezado,$tablas){
             $tablaFinal = '    <div class="table-responsive box container e">
                                  <div class="box-header">
                                   </div>
                                    <table cellspacing="1" width="100%" class="table table-striped table-bordered table-hover dataTable rwd-table" id="tableResultado">
                                        <thead id="encabezado">'.$encabezado.'
                                        </thead>
                                        <tbody  id="tablaresultado">'.sanitize_decode($tablas).'
                                        </tbody>
                                    </table>

                                </div>';
             return $tablaFinal;
        }
        
        function box($titulo,$contenido,$tools){     
            $boxTools = $boxContenido ='';
            $boxTitulo = '      
                <div class="row" style="margin-right: 0px;  margin-left: 0px;">
                <div class="col-md-6" style="margin-top:10px;">
                    <div class="portlet box box-success collapsed-box" style="margin-bottom: 0px;">
                        <div class="box-header with-border accesos">
                          <h4 class="box-title" style="width:100%;">'.$titulo.$boxTools.'</h4>';

            if($contenido !=''){
                 $boxContenido=' <div class="box-body no-padding '.$tools.'" style="display: none;>
                                <div class="row">
                                    <div class="col-md-12">
                                        '.$contenido.'
                                    </div>
                                </div>
                            </div>';
            }        
            $boxFinal = ' 
                    </div>
                </div></div>';
            return $boxTitulo.$boxContenido.$boxFinal;
        }

}

?>