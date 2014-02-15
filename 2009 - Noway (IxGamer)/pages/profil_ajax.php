<?php
/**
 * Appel Ajax - Page Profil
 * Nécessaire à certaines actions du module Profil
 *
 */

// Inclusions ajax
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
// Ajoute un ami depuis la page profil
case "ajouterAmi":

	$id=(int)$_GET['id'];
	$from=$_SESSION['sess_id'];
	$cle=genKey(15);
	
	// Insertion de la demande ds mysql
	$sql=mysql_query("INSERT INTO ".PREFIX."amis_temp (demandeur, futur_ami, cle) VALUES ('$from', '$id', '$cle')");
	$newId=mysql_insert_id();
	
	// Envoie d'un MP
	$dest=$id;
	$sujet=ucfirst($_SESSION['sess_pseudo'])." désire vous ajouté à sa liste d'ami";
	$message='Le membre <a href="profil/'.recode($_SESSION['sess_pseudo']).'/">'.ucfirst($_SESSION['sess_pseudo']).'</a> désire vous ajouter à sa liste d\'amis.<br /><br />
				<img src="images/puce1.gif" /> <a href="membre/mes-amis/accepterAll/'.$newId.'-'.$cle.'/">Accepter et ajouter ce membre à mes amis</a><br />
				<img src="images/puce1.gif" /> <a href="membre/mes-amis/accepter/'.$newId.'-'.$cle.'/">Accepter l\'invitation seulement</a><br />
				<img src="images/puce1.gif" /> <a href="membre/mes-amis/refuser/'.$newId.'-'.$cle.'/">Refuser l\'invitation</a><br />';
	$etat="auto";
	envoyerMp($dest, addslashes($sujet), addslashes($message), $etat);
	
	echo "<div style='margin-top:15px; text-align:center;'>Une invitation vient d'être envoyée à ce membre.</div>";


break;
#############################################################################################################################
// Affiche le formulaire pour envoyer un message sur le guestbook
case "writeMess":

	echo '
	<center style="color:#00A8FF; font-weight:bold; margin-top:8px; margin-bottom:10px">Envoyer un message :</center>
	<form id="form" method="post" action="?" onsubmit="sendMsg(); return false; ">
		<fieldset>
			Sujet<br />
			<input type="text" name="sujet" id="sujet" maxlength="250" /><br /><br />
			Message<br />
			<textarea name="message" id="message"></textarea><br /><br />
			<input type="submit" class="submit" value="envoyer" />	
		</fieldset>
	</form>';

break;
#############################################################################################################################
// Valide ou non le message envoyé
case "guestbook_send":

	$message=addbdd($_POST['message']);
	$id_membre=(int)$_POST['id'];
	$id_auteur=$_SESSION['sess_id'];
	$ip=ip();
	
	$sql=mysql_query("	INSERT INTO ".PREFIX."guestbook
						(`id_membre`, `id_auteur`, `message`, `date`, `ip`)
						VALUES
						('$id_membre', '$id_auteur', '$message', NOW(), '$ip')
					");
					
	if ($sql) echo "ok";
	else	  echo "bad";

break;
}
?>