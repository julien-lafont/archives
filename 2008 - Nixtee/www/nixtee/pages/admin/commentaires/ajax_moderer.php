<?php

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	
	include_once '../../../include/config.php';
	include_once '../../../classes/class_main.php';
	$m = new Main('../../../');
	
	$act=$_GET['act'];
	$id=$_GET['id'];
	
	if ($act=="accepter") {
		$sql=mysql_query("UPDATE ".PREFIX."commentaires SET statut=1 WHERE id_com=$id");
	} else {
		$sql=mysql_query("DELETE FROM ".PREFIX."commentaires WHERE id_com=$id");
	}
	
	echo $_GET['id'];

?>