<?php

	$m->mbre->deconnexion();
	
	if (defined('AJAX')) 
		header('location: ajax.php?billets_generaux');
	else
		header("location: accueil.htm");
	
 
?>