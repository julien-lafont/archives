<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_admin(true);

switch(@$_GET['action'])
{
case "changerEtat":

	$id=$_GET['id'];
	$newEtat=strtolower($_GET['value']);

	if ($newEtat=="supprimer")
	{
		$sql=mysql_query("DELETE FROM ".PREFIX."contact WHERE id=$id");
	}
	else
	{
		switch($newEtat) {
			case "nouveau":		$etat="a-nouveau"; break;
			case "lu":			$etat="b-lu"; 	   break;
			case "repondu": 	$etat="c-repondu"; break;
			case "archiver"; 	$etat="d-archive"; break;
		}
		$sql=mysql_query("UPDATE ".PREFIX."contact SET etat='$etat' WHERE id=$id");
	}
	if ($sql) echo "ok".SEPARATOR.$id.SEPARATOR.$_GET['value'];
	else 	  echo "bad";

break;
}
?>