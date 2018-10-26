<?php

class Security{
	public  $remove_character = Array("'", '"',  "|", "[", "]",  "<?php","?>","<?");
	
	
function cleanInput($input) {
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Elimina javascript
        '@<[\/\!]*?[^<>]*?>@si', // Elimina las etiquetas HTML
        '@<style[^>]*?>.*?</style>@siU', // Elimina las etiquetas de estilo
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-l�nea*/
    );
    $output = preg_replace($search, '', $input);
    return $output;
}


function sanitize($input) {
    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $this->sanitize($val);
        }
    } else {
      
        $input  = str_replace($this->remove_character, '', $input);
        $input  = trim(addslashes(htmlspecialchars($input)));   
    }
    return $input;
}


}

$Security = new Security();

?>