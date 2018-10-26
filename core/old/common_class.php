<?php
#INICIO DE SESSIÓN - Y VALIDACIONES
function is_session_started(){
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if (is_session_started() === TRUE &&  array_key_exists(NOMBRESISTEMA, $_SESSION) && isset($_SESSION[NOMBRESISTEMA]['cod_user'])){
    define('USUARIO', $_SESSION[NOMBRESISTEMA]['usuario']);
}

function cleanInput($input) {
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Elimina javascript
        '@<[\/\!]*?[^<>]*?>@si', // Elimina las etiquetas HTML
        '@<style[^>]*?>.*?</style>@siU', // Elimina las etiquetas de estilo
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-lï¿½nea*/
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

function sanitizaDescript($input){
        $remove = Array("'",   "[", "]",  "<?php","?>","<?");
        $input  = str_replace($remove, '', $input);
        $input  = trim((htmlspecialchars($input)));
    return $input;       
}
function sanitize($input) {
    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    } else {
        $remove = Array("'", '"', "%", "|", "[", "]",  "<?php","?>","<?");
        $input  = str_replace($remove, '', $input);
        $input  = trim(addslashes(htmlspecialchars($input)));
       # $input  = htmlentities(cleanInput($input), ENT_QUOTES, "UTF-8");     
    }
    return $input;
}
function sanitize_decode($input){  
   $cadena =  htmlspecialchars_decode(stripslashes($input));
    return $cadena;   
}
function generaPass(){
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena=strlen($cadena);
    $pass = "";
    $longitudPass=8;
    for($i=1 ; $i<=$longitudPass ; $i++){
        $pos=mt_rand(0,$longitudCadena-1);  
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}

function sanitize_output($buffer) {
    $search = array(
        '/\>[^\S ]+/s',  
        '/[^\S ]+\</s', 
        '/(\s)+/s'      
    );
    $replace = array(
        '>',
        '<',
        '\\1'
    );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
ob_start("sanitize_output"); 

function enviarCorreo($datos){
		date_default_timezone_set('America/Panama');
        require_once '../assets/plugins/PHPMailer/PHPMailerAutoload.php';
		
		$para			= $datos['para'];
        $titulo			= $datos['titulo'];
		$mensajeCuerpo	= $datos['mensajeCuerpo'];
		
        $mail = new PHPMailer;
		$mail->setFrom('noreply@lahipotecaria.com', 'Notificaciones');  
		
		if(isset($datos['attachment']) ){
			foreach ($datos['attachment'] as $atta){
				if(filesize($atta)<5000000){//5MB
					$mail->AddAttachment($atta);
				}
				
			}
					
			
		}
		 
		
        foreach ($para as $correos){
			foreach ($correos as $nombre_correo=>$correos_destinado){
				 $mail->addAddress($correos_destinado, $nombre_correo);
			}
           
        }
		
		 require("mailconten.php");
        $mail->Subject = $titulo;
        $mail->msgHTML($contenidoCorreo);
        $mail->CharSet = 'UTF-8';

        if (!$mail->send()) { return "NO ";} 
            else {return "OK";}
}


?>