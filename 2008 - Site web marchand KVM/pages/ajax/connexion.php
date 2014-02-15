<?php

/* 
 * KVM E-commerce : Connexion - Appel AJAX
 *
 * Gère les retours ajax de la connexion ( via la fonction connexion() )
 */
 
header('Content-Type: text/html; charset=ISO-8859-15'); 
session_start();
	include '../../include/fonctions.php';
	
if ($_POST['login']==NULL || $_POST['pass']==NULL) {
	die('var retourConnexion = { 
		  "statut": \'-\',
		  "erreur": \'Merci de remplir le formulaire\'
		} ');
}

$login = addBdd(strtolower(trim($_POST['login'])));
$pass = addBdd(trim(strtolower($_POST['pass'])));
$passcrypt = crypt( md5($pass) , CLE );


if ( connexion($login, $passcrypt) )
{
	
	
	// Affiche + -> OK, le séparateur |:| puis le bloc Membre à afficher
	echo2 ('var retourConnexion = { 
		  "statut": \'+\',
		  "newMenu": \''.json(menu("membre")).'\',
		  "newPanier": \''.json(lister_panier(gestion_panier())).'\'
		} ');
}
else
{
	// Affiche - -> ERREUR
	die('var retourConnexion = { 
		  "statut": \'-\',
		  "erreur": \'Identifiants incorrects\'
		} ');
}
?>