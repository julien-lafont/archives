<?php

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	
	include_once '../../include/config.php';
	include_once '../../classes/class_main.php';
	$m = new Main('../../');

//:: Vérification existance Pseudo
if (isset($_GET['pseudo'])) {
		if ($m->mbre->verif_login($_GET['pseudo'])) echo "login_ok";
		else										echo "login_utilise";
}

//:: Vérification existance Email
if (isset($_GET['email'])) {
	if ($m->mbre->valider_email($_GET['email'])) 	echo "email_ok";
	else											echo "email_utilise";
}

//:: Vérification concordance Pseudo-Pass 
if (isset($_GET['connexion_login']) && isset($_GET['connexion_pass'])) {
	if (!preg_match('#^'.URL.'#', $_SERVER['HTTP_REFERER']))
		die('hack attempt');
	
	if($m->mbre->connexion($_GET['connexion_login'], $_GET['connexion_pass'])) {
		header('location: ../../ajax.php?afficher_template&tpl=poster_commentaire_login');
	}
	else
	{
		echo "pass_bad";
	}
}

?>