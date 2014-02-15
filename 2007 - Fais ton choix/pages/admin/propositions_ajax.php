<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
securite_admin(true);

	$id=$_GET['id'];
	
if ($_GET['action']=="garder") {
	// Par un membre ?
	$sql1=mysql_query("SELECT id_membre FROM ".PREFIX."propositions WHERE id=$id");
	$d=mysql_fetch_object($sql1);
	if ($d->id_membre!=0) {
		$sql2=mysql_query("UPDATE ".PREFIX."membres SET nb_soumissions=nb_soumissions+1, points=points+".PT_SOUMISSION." WHERE id=".$d->id_membre);
	}
	
	$sql=mysql_query("UPDATE ".PREFIX."propositions SET etat=5 WHERE id=$id");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
} else {
	$sql=mysql_query("DELETE FROM ".PREFIX."propositions WHERE id=$id");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

}
	if ($sql) echo $id;
	else echo "bad";

?>