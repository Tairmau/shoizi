<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
session_start();
include('vues/v_entete.php');

if(!isset($_REQUEST['uc'])){
	$uc = 'accueil';
}else{
	$uc = $_REQUEST['uc'];
}


switch($uc)
{
	case 'accueil':
		{
			include('vues/v_accueil.php');
			break;
		}
	case 'roue':
		{
			include('vues/v_roue.php');
			break;
		}
}

include('vues/v_footer.php');
?>
