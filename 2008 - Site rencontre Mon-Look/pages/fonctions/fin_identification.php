<?php
session_start();
include '../../include/config.inc.php';

// Fonction 1 : Ajouter un click au compte si protection OK
if (!empty($_POST['sess'])) {

	$time90s=time()-90;
	$decode=base64_decode($_POST['sess']);
	$valeurs=explode("-",$decode);
	$time=$valeurs[1];
	
	if($time90s<$time) { 
		$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
		mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");
		mysql_query("UPDATE members SET clics=clics+1 WHERE id_membre=".$_SESSION['sess_id']);
	}
}

// Fonction 2 : Protection grâce à l'ID et au time()
if (!empty($_GET['verif'])) {
	$verif=addslashes(htmlspecialchars(base64_decode($_GET['verif'])));
	$time90s=time()-90;

	$db = mysql_connect(HOST, LOGIN, PASS) or die (ERROR1); mysql_select_db(BASE, $db) or die (ERROR_2);
	$sql=mysql_query("SELECT count(id) as nb FROM photos WHERE id=$verif AND lastdate<=$time");
	$d=mysql_fetch_object($sql);
	
	// Envoie la réponse Ajax
	if ($d->nb==1) echo "ok";
	else echo "bug";
}

?>
	