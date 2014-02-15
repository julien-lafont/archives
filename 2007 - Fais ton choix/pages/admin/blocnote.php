<?php
securite('4+');


	$sql=mysql_query("UPDATE ".PREFIX."blocnote SET blocnote='".addBdd($_POST['blocnote'])."'");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	
	header('location: ?admin-accueil');


?>