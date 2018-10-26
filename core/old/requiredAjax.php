<?php
foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . sanitize($valor) . "';";    eval($asignacion); }
if (is_session_started() === FALSE || !array_key_exists(NOMBRESISTEMA, $_SESSION) && ($token!=md5(date('Y-m-d').'Login') && $token!=md5(date('Y-m-d').'recoverform') && $token!=md5(date('Y-m-d').'cambiarLogin') )){
    $respuesta = array("mensaje" => 'La sesion no ha sido iniciada', "respuesta" => 'reload');
    echo json_encode($respuesta);
    exit();
}
?>