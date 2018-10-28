<?php
#archivo contenedor de las funciones plantillas de formulario, porlets e inputs
$form				= new form();
$form->GET			= $_GET; #se crea la variable GET dentro de la clase del formulario
$form->POST			= $_POST; #se crea la variable POST dentro de la clase del formulario

class form{
	
	public    $input_rows			= 'col-md-6';
	public    $button_rows			= 'col-md-4';
	
        public    $habilitado			= array('Habilitado'=>'Habilitado','Inactivo'=>'Inactivo'); 
	public    $total_registros              = array('300'=>'300','500'=>'500','1000'=>'1000'); 
	
	public    $porlet_color			= 'blue';
	public    $porlet_body			= '';
	public	  $porlet_title			= '';
	public    $porlet_buttons		= '';
			
    function input($array){
		
		if(isset($array[0]) && is_array($array[0])){
			$result = '';
			foreach($array as $multiple_array){
			   $result .=   $this-> input($multiple_array);
			}
			return $result;
		}else{
			if(isset($array['name'])){
				$name	= normaliza($array['name']);
				$type	= 'text';
				$clases	= $value = $spanRequerido = '';

				 if(isset($array['type'])){   $type		= $array['type']; }
				 if(isset($array['clases'])){ $clases	= $array['clases']; }
				 
				 #Validar si se le ha asigando un valor al campo o si el mismo campo se encuentra en el GET o el POST
					if(isset($array['value'])  ){  
						$value	= $array['value']; 
					}elseif(isset($this->GET[$name])){
						 $value	= $this->GET[$name]; 
					}elseif(isset($this->POST[$name])){
						 $value	= $this->POST[$name]; 
					}
				 #Fin de validación
	
				 if(isset($array['reg']) && $array['reg']=='true'){ $spanRequerido = '<span class="campoRequerido">*</span>'; }

			 $title_input	= '<label class="control-label">'.$spanRequerido.$array['name'].':</label>';
			 
				if($type=='textarea'){
					$rows=$cols='';
					if(isset($array['rows'])){   $rows		= ' rows="'.$array['rows'].'" '; }
					if(isset($array['cols'])){   $cols		= ' cols="'.$array['cols'].'" '; }
					$input	= '<textarea '.$rows.$cols.' name="'.$name.'" id="'.$name.'" class="form-control '.$clases.'">'.$value.'</textarea>';			
				}elseif($type=='select'){
					$options_b			= '<option value="">- Seleccione -</option>';
					
					if(isset($array['options'])){   
						foreach ($array['options'] as $key=>$options){
							$option_selected	= '';
							if($key==$value){
								$option_selected = 'selected';
							}
							$options_b .='<option '.$option_selected.' value="'.$key.'">'.$options.'</option>';
						}	
					}
					$input = ' <select  class="form-control '.$clases.'" id="'.$name.'"   name="'.$name.'">
                                            '.$options_b.'
                                </select>';
				}else{
				   $input	= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" class="form-control '.$clases.'" value="'.$value.'"  >'; 
				}
				
				if($type!='hidden'){
					$input_return = '<div class="form-group '.$this->input_rows.'">'.$title_input.$input.'</div>';
				}else{
					return $input;
				}
				
				return $input_return;
			 
			}

		}
   }
   
    function porlet(){	#generacion de porlet
		$name				= normaliza($this->porlet_title);
		if(isset($this->GET['page'])){
			$page = ($this->GET['page']);
		}elseif(isset($this->POST['page'])){
			$page = ($this->POST['page']);
		}
		$this_page_input	= $this->input(['name'=>'page','value'=>$page,'type'=>'hidden']);
        $formularioPorlet   = '
						<form id="'.$name.'">
							<div class="row">
                                <div class="col-md-12">
                                            <div class="portlet box '.$this->porlet_color.' consulta visible">
                                              <div class="portlet-title">
                                                <div class="caption ">
                                                    '.$this->porlet_title.'
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                    <div class="form-body">
                                                    <div class="alertMensaje"></div>
                                                     <div class="respuestaReload"></div>
                                                            <div class="row">
                                                            '.$this_page_input.$this->porlet_body.'
                                                            </div>
                                                    </div>
                                             <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           '.$this->porlet_buttons.'
                                                               <span class="load"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>            
                                               
                                            </div>
                                      </div>
                                </div>
                              </div>
						</form>';
           return $formularioPorlet;
    } 
	
	function inputButton($array){
		if(isset($array[0]) && is_array($array[0])){
			$result = '';
			foreach($array as $multiple_array){
			   $result .=   $this-> inputButton($multiple_array);
			}
			return $result;
		}else{
					if(isset($array['name'])){
			$name		= $array['name'];
			$name_norm	= normaliza($name);
			$attr		= $href = '';
			$type		= 'button';
			$class		= ' btn-success ';
				if(isset($array['attr'])){		$attr		= $array['attr']; }
				if(isset($array['type'])){		$type		= $array['type']; }
				if(isset($array['class'])){		$class		= $array['class']; }
				if(isset($array['href'])){		$href		= $array['href']; }

			if($href !=''){
					 $boton = '<a href="'.$href.'">'.'<span variable ="'.$attr.'"  class="form-control btn '.$class.'" id="'.$name_norm.'"   name="'.$name_norm.'" >'.$name.'</span></a>';
			}else{
					$boton = '<input titulo_input="'.$name.'" type="'.$type.'" variable ="'.$attr.'"  class="form-control btn '.$class.'" id="'.$name_norm.'"   name="'.$name_norm.'" value="'.$name.'">';
			}
			$inputButton = '<div class="'.$this->button_rows.' ">
								'.$boton.'
						   </div>';
			return $inputButton;
		}
		}

    }
    
    
    
}


?>