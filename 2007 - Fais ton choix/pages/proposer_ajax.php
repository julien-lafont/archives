<?php
/*  ---------------------------------------------------------------------------------------------------------------
	   Proposer un site ( dispo uniquement en ajax )
    --------------------------------------------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


$idee1 =	addBdd($_GET['idee1']);
$idee2 =	addBdd($_GET['idee2']);
$pseudo =	addBdd($_GET['pseudo']);
$site =		addBdd($_GET['site']);

$sql=mysql_query("INSERT INTO ".PREFIX."propositions 
				( `id_membre` , `nom1` , `nom2` , `pseudo` , `site` )
					VALUES   
				( '".$_SESSION['log_id']."', '".$idee1."', '".$idee2."', '".$pseudo."', '".$site."')");
											
if ($sql) echo "ok";
else      echo "bad";

?>