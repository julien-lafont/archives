<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
case "noter_photo":

	$idPhoto=(int)$_POST['idPhoto'];
	$note=(int)$_POST['note'];
	$myId=$_SESSION['sess_id'];
	
	// Vérifications nécessaires
	if ($note>5) die("ERROR : On ne triche pas !");

	$sqlVerif=mysql_query("	SELECT count(id_membre) as nbVote FROM ".PREFIX."galerie_verif_vote WHERE id_membre='".$myId."' AND id_photo='".$idPhoto."'");
	$verif=mysql_fetch_object($sqlVerif);
	if ($verif->nbVote!=0) die("ERROR : Déjà voté !");
	
	$sqlVerif2=mysql_query("SELECT * FROM ".PREFIX."galerie WHERE id=$idPhoto");
	$d=mysql_fetch_object($sqlVerif2);
	if ($d->id_membre==$myId) die("ERROR : On ne vote pas pr ses photos");
	
	// Insertion dans Mysql
	$newcoeff=$d->note_coeff+1;
	$newnote=(($d->note*$d->note_coeff)+$note)/($newcoeff);
	
	$sql=mysql_query("UPDATE ".PREFIX."galerie SET note='$newnote', note_coeff='$newcoeff' WHERE id='$idPhoto'");
	$sql2=mysql_query("INSERT INTO ".PREFIX."galerie_verif_vote VALUES ('$idPhoto', '$myId')");
	
	echo "+".SEPARATOR.$idPhoto.SEPARATOR.round($newnote,1).SEPARATOR.$newcoeff; 

break;
}
?>