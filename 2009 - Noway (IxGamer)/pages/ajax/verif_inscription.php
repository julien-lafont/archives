<?php

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	

//:: Vérification existance Pseudo
if (isset($_GET['pseudo'])) {
	$pseudo=strtolower(addBdd($_GET['pseudo']));
	$sql=mysql_query("SELECT count(id) as nb FROM ".PREFIX."membres WHERE `pseudo`='$pseudo'");
	$nb=mysql_fetch_object($sql);
		if ($nb->nb==0) echo "login_ok";
		else			echo "login_utilise";
}

//:: Vérification existance Email
if (isset($_GET['email'])) {
	$email=strtolower(addBdd($_GET['email']));
	$sql=mysql_query("SELECT count(id) as nb FROM ".PREFIX."membres WHERE `email`='$email'");
	$nb=mysql_fetch_object($sql);
		if ($nb->nb==0) echo "email_ok";
		else			echo "email_utilise";
}

?>