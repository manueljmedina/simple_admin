<?php

class subir_archivos{
	#******************************************** Funciones necesarias para subir archivos ************************************* #

private function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
	$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
	$NewWidth  			= ceil($ImageScale*$CurWidth);
	$NewHeight 			= ceil($ImageScale*$CurHeight);
	
	if($CurWidth < $NewWidth || $CurHeight < $NewHeight)
	{
		$NewWidth  = $CurWidth;
		$NewHeight = $CurHeight;
	}
	$NewCanves 	= imagecreatetruecolor($NewWidth, $NewHeight);

	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagealphablending($NewCanves, false);
				imagesavealpha($NewCanves, true);
				imagecopy($NewCanves, $SrcImage, 0, 0, 0, 0, $CurWidth, $CurHeight);
				imagepng($NewCanves,$DestFolder);
				imagedestroy($SrcImage);
				imagedestroy($NewCanves);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	if(is_resource($NewCanves)) { 
      imagedestroy($NewCanves); 
    } 
	return true;
	}

}

//esta funcion es la que se utiliza para cortar las imÃ¡genes
private function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{	 
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	if($CurWidth>$CurHeight)
	{
		$y_offset = 0;
		$x_offset = ($CurWidth - $CurHeight) / 2;
		$square_size 	= $CurWidth - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($CurHeight - $CurWidth) / 2;
		$square_size = $CurHeight - ($y_offset * 2);
	}
	
	$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	if(is_resource($NewCanves)) { 
      imagedestroy($NewCanves); 
    } 
	return true;

	}
	  
}
function uploadFile($FILES,$array){
	$mensaje			= '';
	$id_archivo			= $array['id_archivo'];
	$ruta				= $array['ruta'];
	$archivo_anterior	= $array['archivo_anterior'];
	
	if(isset($FILES['tmp_name']) && $FILES['tmp_name'] !=''){
		#datos del archivo
		$size	    = $FILES['size']; 
		$tmp_name	= $FILES['tmp_name'];
		$ImageType  = $FILES['type'];
		$size		= number_format($size/1048576,4);#obtener megabytes
		$array_resize_perimitidos = array('png','jpeg','jpg','gif');
		#fin de datos del archivo

		#pathinfo
		$pathinfo		= pathinfo($FILES['name']); 
		$name			= $pathinfo['filename']; 
		#$full_name = 
		$extension		= strtolower($pathinfo['extension']); 
		  list($Width, $Height) = getimagesize($tmp_name);
		#fin pathinfo

		if(isset($array['rename']) && $array['rename']===true){#fin de renombrar
			$name = $id_archivo.date('Ymdhis').'.'.$extension;
		}else{
			if(isset($array['normaliza']) && $array['normaliza']===true){#fin de normaliza
				$formulario = new formularios();
				$name		= $formulario->normaliza($name).$id_archivo.'.'.$extension;
			}else{
				$name = $name.'.'.$extension;
			}
			
		}#renombrar
		
		
		if(isset($array['formatos_permiti']) && count($array['formatos_permiti'])>0){#validar extensión
					if (!in_array($extension, $array['formatos_permiti'])) {
						$mensaje .= 'El archivo <b>'.$FILES['name'].'</b> no ser&aacute; publicado ya que no cumple con el formato requerido.<br>';
					}
		}

		if(isset($array['max_size']) && $array['max_size'] !=''){#validar tamaño maximo
					if ($size>$array['max_size']) {
						$mensaje .= 'El tama&ntilde;o del archivo <b>'.$FILES['name'].'</b> ('.$size.'MB) no ser&aacute; publicado ya que no cumple con lo requerido ('.$array['max_size'].' MB)<br>';
					}
		}#fin amaño maximo
		
		if($mensaje ==''){
				$ruta_anterior_completa = $ruta.$archivo_anterior;#ruta y nombre del archivo anterior

		if(isset($array['max_width']) && $array['max_width']>=32 && in_array($extension, $array_resize_perimitidos) && $array['resize']===true){#redimencionar   
				$BigImageMaxSize        = $array['max_width'];
				$Quality				= 50;
				if(isset($array['Quality']) && $array['Quality']>50){
					$Quality                = $array['Quality'];
				}
		            switch (strtolower($ImageType)) {
                        case 'image/png':
                            $CreatedImage = imagecreatefrompng($tmp_name);
                            break;
                        case 'image/gif':
                            $CreatedImage = imagecreatefromgif($tmp_name);
                            break;
                        case 'image/jpeg':
                        case 'image/pjpeg':
                            $CreatedImage = imagecreatefromjpeg($tmp_name);
                            break;
                    }
				list($CurWidth, $CurHeight) = getimagesize($tmp_name);	
				$this->resizeImage($CurWidth, $CurHeight, $BigImageMaxSize, $ruta.$name, $CreatedImage, $Quality, $ImageType);
				#Generar thum $ThumbSquareSize        = 500;
				#$this->cropImage($CurWidth, $CurHeight, $ThumbSquareSize, $ruta.$name, $CreatedImage, $Quality, $ImageType);
				# list($ResizedWidth, $ResizedHeight)     = getimagesize($ruta.$name);
				if(file_exists($ruta_anterior_completa) && $archivo_anterior !='') {
					unlink($ruta_anterior_completa);
				}
			}else{
				if(move_uploaded_file ( $tmp_name, $ruta.$name)){

					if(file_exists($ruta_anterior_completa) && $archivo_anterior !='') {
							unlink($ruta_anterior_completa);
					}
				}else{
					$mensaje .= 'No se ha podido copiar el archivo, favor intentar nuevamente<br>';
					return array(false,$mensaje);
				}
			}


		
			return array(true,$name);
		}else{
			return array(false,$mensaje);
		}
	}
}
	
}

 ?>