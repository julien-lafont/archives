<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_admin(true);

switch(@$_GET['act'])
{
case "crypter":

	$pass=$_POST['pass'];
	$newPass=crypt(md5($pass), CLE);
	
	echo $newPass;
	
break;
}

?>
