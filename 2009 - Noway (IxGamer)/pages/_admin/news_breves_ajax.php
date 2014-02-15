<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_admin(true);

switch(@$_GET['action'])
{
case "supprNews":
	$id=(int)$_GET['id'];
	
	$sql=mysql_query("DELETE FROM ".PREFIX."news WHERE id='$id'");
	$sql2=mysql_query("DELETE FROM ".PREFIX."breves_com WHERE id_news='$id'");
	
	if ($sql) echo $id;
	
break;
case "supprBreve":
	$id=(int)$_GET['id'];
	
	//$sql=mysql_query("DELETE FROM ".PREFIX."breves WHERE id='$id'");
	//$sql2=mysql_query("DELETE FROM ".PREFIX."breves_com WHERE id_breve='$id'");
	
break;
}

?>