<?php
class formularios{
    const DIVROW = '<div class="row">';
    const FINDIV = '</div>';
		function slider(){#includes requeridos para iniciar un summernote
	$js = '<link rel="stylesheet" href="assets/plugins/bootstrap-slider/slider.css">
			<script src="assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>		
			';
		return $js;
	}
	function summernote(){#includes requeridos para iniciar un summernote
		$summernoteIncludes = '
			<link rel="stylesheet" href="assets/plugins/summernote/summernote.css" />
			<script src="assets/plugins/summernote/summernote.min.js"></script> ';
		return $summernoteIncludes;
	}
	
	function dateTimepicker(){#includes requeridos para iniciar un dateTimepicker
$datePickerIncludes = ' 
			<link   href="assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
			<script src="assets/plugins/moment-with-locales.min.js"></script> 
			<script src="assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script> 
';
			return $datePickerIncludes;
	}
		function select2(){#includes requeridos para iniciar un select2
		$select2Includes = ' 
			<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
			<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
				<script>
				$(document).ready(function() {
					$(".select2").select2();
				});
				</script>
			';
			return $select2Includes;
	}
	   function formulario($contenido,$titulo,$color,$botones,$method,$clase){
        $id		   = $this->normaliza($titulo);
        if($method =='confirm'){$id='accionRegistroForm';}
        
        $formularioPorlet   = '
			 <div class="col-md-12">
				<form class="form-horizontal '.$clase.' " method="'.$method.'" id="'.$id.'" name="'.$id.'"  >
                                                    <div class="form-body">
                                                    <div class="alertMensaje"></div>
                                                     <div class="respuestaReload"></div>
                                                            <div class="row">
                                                            '.$contenido.'
                                                            </div>
                                                    </div>
                                             <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           '.$botones.'
                                                               <span class="load"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>            
                                                </form>
												</div> 
                              ';
           return ($formularioPorlet);
    }
   function formularioPorlet($contenido,$titulo,$color,$botones,$method,$clase){
        $id		   = $this->normaliza($titulo);
        if($method =='confirm'){$id='accionRegistroForm';}
        
        $formularioPorlet   = self::DIVROW.'
                                <div class="col-md-12">
                                            <div class="portlet box '.$color.' consulta visible">
                                              <div class="portlet-title">
                                                <div class="caption ">
                                                    '.$titulo.'
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <form class="form-horizontal '.$clase.' " method="'.$method.'" id="'.$id.'" name="'.$id.'"  >
                                                    <div class="form-body">
                                                    <div class="alertMensaje"></div>
                                                     <div class="respuestaReload"></div>
                                                            <div class="row">
                                                            '.$contenido.'
                                                            </div>
                                                    </div>
                                             <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           '.$botones.'
                                                               <span class="load"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>            
                                                </form>
                                            </div>
                                      </div>
                                </div>
                              '.self::FINDIV;
           return ($formularioPorlet);
    }   
       function porlet($contenido,$titulo,$color,$botones,$method,$clase){
        $id = $this->normaliza($titulo);
        $formularioPorlet   = self::DIVROW.'
                                <div class="col-md-12">
                                            <div class="portlet box '.$color.' consulta visible">
                                              <div class="portlet-title">
                                                <div class="caption ">
                                                    '.$titulo.'
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                              
                                                    <div class="form-body">
                                                    <div class="alertMensaje"></div>
                                                     <div class="respuestaReload"></div>
                                                            <div class="row">
                                                            '.$contenido.'
                                                            </div>
                                                    </div>
                                             <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           '.$botones.'
                                                               <span class="load"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>            
                                               
                                            </div>
                                      </div>
                                </div>
                              '.self::FINDIV;
           return $formularioPorlet;
    }  
	function input_datalist($titulo,$valor,$clases,$tipo,$habilitado){
		$nombre     = $this->normaliza($titulo);
        $titulo     = $this->normaliza_campo($titulo);
		$num  = 6;
		$num3 = 3;
		$num2 = 9;
		$spanRequerido  = $key = $values='' ;
        $reg			= strpos($clases, 'reg'); 
			if($reg !==false){
                $spanRequerido = '<span class="campoRequerido">*</span>';
            }
			if(is_array($valor)){
				list($key, $values) = each($valor); 
			}
					
			$input = '
					<input type="hidden" id="idPrueba"   unique="'.$nombre.'"  name="'.$nombre.'" value="'.$key.'">
					<input '.$habilitado.' unique="'.$nombre.'" list="datalist_fk_'.$nombre.'" type="'.$tipo.'" class="form-control '.$clases.' datalist" id="fk_'.$nombre.'"   name="fk_'.$nombre.'" value="'.$values.'">';		 
						$input .= '<datalist id="datalist_fk_'.$nombre.'">

								  </datalist>';
			if (!defined('SEARCHFORM')) {
				$inputText   = '<div class="col-md-12">
							<div class="form-group">
                                <label class="control-label label_for_'.$nombre.'">'.$spanRequerido.$titulo.'</label>
                                  '.$input.'
                            </div>
                       </div>';
			}else{
				  $inputText   = '<div class="col-md-'.$num.'">
                            <div class="form-group">
                                <label class="control-label col-md-'.$num3.'">'.$spanRequerido.$titulo.':</label>
                                    <div class="col-md-'.$num2.'">
                                        '.$input.'
                                    </div>
                            </div>
                       </div>';
			}
		
		   return $inputText;
	}
   function input($titulo,$valor,$clases,$tipo,$habilitado){
      $num  = 6;
      $num3 = 3;
      $num2 = 9;
      $summer = $spanRequerido = $dateTimePicker = $valorSlider='';
     
        if($tipo!='hidden'){
              $nombre     = $this->normaliza($titulo);
              $titulo     = $this->normaliza_campo($titulo);
              $reg        = strpos($clases, 'reg');
                    if($reg !==false){
                        $spanRequerido = '<span class="campoRequerido">*</span>';
                     }
				   $dateTimepickerC        = strpos($clases, 'dateTimepicker');	 
				   if($dateTimepickerC !==false){
					$dateTimePicker			= '<script>
												   $(function () {
														$("#'.$nombre.'").datetimepicker({
															 format:"YYYY-MM-DD HH:mm:ss"
														 });
													});
											   </script>';
				   }
				   $dateTimeC        = strpos($clases, 'TdateTime');	 
				   if($dateTimeC !==false){
					$dateTimePicker			= '<script>
												   $(function () {
														$("#'.$nombre.'").datetimepicker({
															 format:"YYYY-MM-DD"
														 });
													});
											   </script>';

				   }

            if($tipo=='textarea'){
                  $pos  = strpos($clases, 'summernote');
                  $doce = strpos($clases, 'doce');

                     if($pos !==false){
                        $num3   = 1;
                        $num2   = $num = 12;
                        $summer = '<script>summernote();</script>';
                        if($habilitado=='disabled'){
                            $summer .= "<script>$('.summernote').summernote('disable');</script>";
                            
                        }
                     }
                     
                     if($doce !==false){
                        $num3 = 1;
                        $num2 = $num= 12;  
                     }
                     
                
                $input='<textarea titulo_input="'.$titulo.'"  rows="8" '.$habilitado.' class="form-control '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'">'.$valor.'</textarea>';
			}elseif($tipo=='file'){
				  $input = '<span class="btn '.$clases.' fileinput-button">
								<i class="glyphicon glyphicon-plus"></i> 
									<span>Seleccionar '.$titulo.'</span>
									<input titulo_input="'.$titulo.'" type="file" name="'.$nombre.'" id="'.$nombre.'" class="'.$clases.' btn radius"  >
							</span>';
			}elseif($tipo=='slider'){
				$input	= '<input  id="'.$nombre.'"  name="'.$nombre.'"  class=" '.$clases.' form-control slider" data-slider-id="blue" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="'.$valor.'"/>';
				
				$input .= '<script>$(function () { $(".slider").slider();$("#'.$nombre.'").change(function(){var input  = $(this); var valor  = $.trim(input.val());$(".textAyuda'.$nombre.'").html(valor+"%");});})</script>';
				$valorSlider = $valor.'%';
			}else{
                $input = '<input titulo_input="'.$titulo.'" '.$habilitado.' type="'.$tipo.'" class="form-control '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'" value="'.$valor.'">';
            }
			
			if (!defined('SEARCHFORM')) {
				$inputText   = '<div class="col-md-12">
							<div class="form-group">
                                <label class="control-label label_for_'.$nombre.'">'.$spanRequerido.$titulo.': <span class="textAyuda'.$nombre.'">'.$valorSlider.'</span></label>
                                  '.$input.'
                           
                            </div>
                         
                       </div>';
			}else{
				  $inputText   = '<div class="col-md-'.$num.'">
                            <div class="form-group">
                                <label class="control-label col-md-'.$num3.'">'.$spanRequerido.$titulo.':</label>
                                    <div class="col-md-'.$num2.'">
                                        '.$input.'
                                    </div>
                            </div>
                       </div>';
			}
  

        }else{
            $nombre = (str_replace(' ', '_', $titulo));
            $inputText = '<input titulo_input="'.$titulo.'" type="'.$tipo.'" class="form-control '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'" value="'.$valor.'">';
        }
        
        return $inputText.$summer.$dateTimePicker;
    }
   function inputButton($titulo,$tipo,$clases,$enlace,$columna,$atr){
         $nombre = $this->normaliza($titulo);
            if($enlace!=''){
                 $boton = '<a href="'.$enlace.'">'.'<span variable ="'.$atr.'"  class="form-control btn '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'" >'.$titulo.'</span></a>';
            }else{
                $boton = '<input titulo_input="'.$titulo.'" type="'.$tipo.'" variable ="'.$atr.'"  class="form-control btn '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'" value="'.$titulo.'">';
            }
        $inputButton = '<div class="col-md-'.$columna.'">
                            '.$boton.'
                       </div>';
        return $inputButton;
    }
	function isAssoc($arr){#Validar si un array es asociativo.. devuelve true .. si lo es..
		return is_array(array_keys($arr) !== range(0, count($arr) - 1));
	}
   function select($titulo,$habilitado,$valores,$clases,$seleccionado){
       if($seleccionado==''){$seleccionado='';}
		$spanRequerido	= '';
        $reg			= strpos($clases, 'reg');
            if($reg !==false){
                $spanRequerido = '<span class="campoRequerido">*</span>';
            }
        
		$nombre     = $this->normaliza($titulo);
        $titulo     = $this->normaliza_campo($titulo);
        $acumulador     = '<option value=""> - Selecciona - </option>';
        $arraySelected  = explode(',',$seleccionado);
        $columns        = array_keys($valores);
		$isAssoc		= $this->isAssoc($valores);
            foreach($columns as $column){
                $selected           = ''; 
				$valor_colum		= $column;
				if($column == $seleccionado && !in_array('', $arraySelected)){$selected = 'selected';}
				
				/*if($isAssoc!==true){
					$valor_colum = $valores[$column];
					if($valor_colum == $seleccionado && !in_array('', $arraySelected)){$selected = 'selected';}
				}*/

                $acumulador .='<option '.$selected.' value="'.$valor_colum.'">'.$valores[$column].'</option>';
            }

   
		 	if (!defined('SEARCHFORM')) {
				$inputText = '<div class="col-md-12">
								  <div class="form-group">
									  <label class="control-label  label_for_'.$nombre.'">'.$spanRequerido.$titulo.':</label>
										<select titulo_input="'.$titulo.'" '.$habilitado.'  class="form-control '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'">
												  '.$acumulador.'
										</select>
								  </div>
							 </div>';
			}else{
	         $inputText = '<div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">'.$spanRequerido.$titulo.':</label>
                                    <div class="col-md-9">
                                        <select titulo_input="'.$titulo.'" '.$habilitado.'  class="form-control '.$clases.'" id="'.$nombre.'"   name="'.$nombre.'">
                                            '.$acumulador.'
                                        </select>
                                    </div>
                            </div>
                       </div>';
			}
         
         return $inputText;  
    }
   function image($titulo,$url,$alt,$class){
        $nombre = $this->normaliza($titulo);
        
        $inputText = '<div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">'.$titulo.':</label>
                                    <div class="col-md-9">
                                        <img class="'.$class.'" src="'.$url.'" alt="'.$alt.'" title="'.$alt.'">
                                    </div>
                            </div>
                       </div>';
      
        
        return $inputText;
    }
   function span($titulo,$val,$class){
        $nombre = $this->normaliza($titulo);
        
        $inputText = '<div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">'.$titulo.':</label>
                                    <div class="col-md-9 '.$class.'">
                                        <span class="">'.$val.'</span>
                                    </div>
                            </div>
                       </div>';
      
        
        return $inputText;
    }
    
    function form($title,$content,$class){
         $nombre = $this->normaliza($title);
        
         $form = '<form name="'.$nombre.'" id="'.$nombre.'" class="'.$class.'">'.$content.'</form>';
         
         return $form;
    }
    function normaliza_campo($cadena){
         $cadena = str_replace("&aacute;","a",$cadena);
        $cadena = str_replace("&Aacute;","A",$cadena);
        $cadena = str_replace("&eacute;","e",$cadena);
        $cadena = str_replace("&Eacute;","E",$cadena);
        $cadena = str_replace("&iacute;","i",$cadena);
        $cadena = str_replace("&Iacute;","I",$cadena);
        $cadena = str_replace("&oacute;","o",$cadena);
        $cadena = str_replace("&Oacute;","O",$cadena);
        $cadena = str_replace("&uacute;","u",$cadena);
        $cadena = str_replace("&Uacute;","U",$cadena);
           return utf8_encode($cadena);
    }
    
    function normaliza($cadena){
        $cadena = strtolower($cadena);
        $cadena = str_replace('-', '', $cadena);
        $cadena = str_replace(' ', '_', $cadena);
        $cadena = str_replace('__', '_', $cadena);
        $cadena = str_replace("&aacute;","a",$cadena);
        $cadena = str_replace("&Aacute;","A",$cadena);
        $cadena = str_replace("&eacute;","e",$cadena);
        $cadena = str_replace("&Eacute;","E",$cadena);
        $cadena = str_replace("&iacute;","i",$cadena);
        $cadena = str_replace("&Iacute;","I",$cadena);
        $cadena = str_replace("&oacute;","o",$cadena);
        $cadena = str_replace("&Oacute;","O",$cadena);
        $cadena = str_replace("&uacute;","u",$cadena);
        $cadena = str_replace("&Uacute;","U",$cadena);
        $cadena = str_replace("�","a",$cadena);
        $cadena = str_replace("�","e",$cadena);
        $cadena = str_replace("�","i",$cadena);
        $cadena = str_replace("�","o",$cadena);
        $cadena = str_replace("�","u",$cadena);
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
                ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
         $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
                bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
     
         
                    $cadena = utf8_decode($cadena);
                     $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
                    
                
    return utf8_encode($cadena);
}
  
    
    
    
}


?>