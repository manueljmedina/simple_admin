<?php
define('BASEPATH', 'simple_admin');
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('FOLDEAPP',DOCUMENT_ROOT.'/'.BASEPATH);

    require_once(FOLDEAPP.'/config/config.php');
	require_once(FOLDEAPP.'/config/db.php');
	require_once(FOLDEAPP.'/core/Security.php');
	require_once(FOLDEAPP.'/core/Common.php');
	require_once(FOLDEAPP.'/core/Database.php');
	require_once(FOLDEAPP.'/core/Forms.php');

?>