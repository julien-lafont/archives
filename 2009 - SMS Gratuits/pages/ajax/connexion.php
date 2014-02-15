<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';

$pseudo=strtolower(htmlspecialchars($_GET['login']));
$pass=strtolower(htmlspecialchars($_GET['pass']));


// Fonction de connexion -> return 1=OK ou 0=Erreur
$log=connexion($pseudo,$pass);

echo $log;

?>