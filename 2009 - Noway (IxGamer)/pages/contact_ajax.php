<?php
/**
 * Appel Ajax - Page Contact
 * Nécessaire à certaines actions du module Contact
 *
 */
 
// Inclusion Ajax
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';

switch(@$_GET['act'])
{
// Envoyer un message en tant qu'utilisateur loggé
case "posterLog":

	securite_membre(true);

	$sujet=addBdd($_POST['sujet']);
	$message=addBdd($_POST['message']);
	$myId=$_SESSION['sess_id'];
	$ip=ip();
	
	$sql=mysql_query("INSERT INTO ".PREFIX."contact (`sujet`, `message`, `id_membre`, `date`, `ip`)
											VALUES	('$sujet', '$message', '$myId', NOW(), '$ip')");
	
	if ($sql) echo "ok".SEPARATOR.miseenforme('message', '<b>Votre message a été envoyé avec succés !</b><br><br>Un membre du staff vous répondra dans les plus brefs délais.');
	else	  echo "bad";
	
break;
###################################################################################################################
// Envoyer un message en tant qu'invité
case "posterNoLog":

	$sujet=addBdd($_POST['sujet']);
	$message=addBdd($_POST['message']);
	$nom=addBdd($_POST['nom']);
	$email=addBdd($_POST['email']);
	$ip=ip();
	
	$sql=mysql_query("INSERT INTO ".PREFIX."contact (`sujet`, `message`, `nom`,`email`, `date`, `ip`)
											VALUES	('$sujet', '$message', '$nom','$email', NOW(), '$ip')")
										or die (mysql_error());
	
	if ($sql) echo "ok".SEPARATOR.miseenforme('message', '<b>Votre message a été envoyé avec succés !</b><br><br>Un membre du staff vous répondra dans les plus brefs délais.');
	else	  echo "bad";
	
break;
}

ob_end_flush();
?>