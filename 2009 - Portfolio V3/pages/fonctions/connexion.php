<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	
if ($_POST['login']==NULL || $_POST['pass']==NULL) {
	die('-');
}

$login = addBdd(strtolower(trim($_POST['login'])));
$pass = addBdd(trim(strtolower($_POST['pass'])));
$passcrypt = crypt( md5($pass) , CLE );

if ( connexion($login, $passcrypt) )
{
	// Affiche + -> OK, le séparateur |:| puis le bloc Membre à afficher
	echo '+';
}
else
{
	// Affiche - -> ERREUR
	echo '-';
}
?>