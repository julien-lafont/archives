<?php
/*  ---------------------------------------------------------------------------------------------------------------
	   Accés ajax : permet de voter pour un duel ( avec toutes les vérifications ) 
	     + Gestion de l'affichage de la pub 'popup'
    --------------------------------------------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


switch(@$_GET['act'])
{
case "voterDuel": 

	$idDuel=(int)$_GET['idDuel'];
	$gagnant=(int)$_GET['gagnant'];
	$ip=ip();
	
	// On vérifie que le gars n'a pas déjà voté
	$sqlVerif=mysql_query("SELECT id FROM ".PREFIX."verifduel WHERE id_duel=$idDuel AND ip='".$ip."'");
	$nbVote=mysql_num_rows($sqlVerif);
		if ($nbVote!=0) exit("error_ip|:|$gagnant");
	
	// On ajouter le vote
	if($gagnant==1) $update="note1=note1+1";
	elseif ($gagnant==2) $update="note2=note2+1";
	else exit('error_note');
		$sqlMaj=mysql_query("UPDATE ".PREFIX."duels SET ".$update.", votestotal=votestotal+1 WHERE id=$idDuel");
	
	// On ajoute dans la table de vérification
		$sqlAddVerif=mysql_query("INSERT INTO ".PREFIX."verifduel (`id_duel`,`ip`, `email`, `vote`) VALUES ('$idDuel','$ip', '".$_SESSION['log_email']."','$gagnant')");
	
	// On calcule les nouvelles notes
	$sqlRecup=mysql_query("SELECT note1, note2, votestotal FROM ".PREFIX."duels WHERE id=$idDuel");
	$d=mysql_fetch_object($sqlRecup);
		$note1=round(($d->note1*100)/$d->votestotal,1);
		$note2=round(($d->note2*100)/$d->votestotal,1);
		
	// Si il est loggé on ajoute les points
	if ($_SESSION['log_id'])
		$sqlUpdPoints=mysql_query("UPDATE ".PREFIX."membres SET nb_votes=nb_votes+1, points=points+".PT_VOTE." WHERE email='".$_SESSION['log_email']."'");
	
	// On ajoute l'indicateur vote effectué
	$_SESSION['log_vote'][$idDuel]=true;
	
	// On gère l'affichage de la pub : -> On affiche la pub au bout du 3° et 12° vote
	$nbvoteForPub=count($_SESSION['log_vote']);
	if ($nbvoteForPub==3 || $nbvoteForPub==12) $pub='1';
	else $pub='0';
	
	// On envoie le résultat jvs
	echo "ok|:|$note1|:|$note2|:|$gagnant|:|$idDuel|:|$pub";

break;
default:
	exit("Accés interdit");
break;
}

?>
