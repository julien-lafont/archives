<?php

//:: Vérification concordance Pseudo-Pass 
if (isset($_GET['pseudo']) && isset($_GET['pass'])) {
	if (!preg_match('#^'.URL.'#', $_SERVER['HTTP_REFERER']))  die('hack attempt  -- '.URL.' -- '.$_SERVER['HTTP_REFERER']);
	
	if($m->mbre->connexion($_GET['pseudo'], $_GET['pass'])) {
		header('location: ajax.php?afficher_template&tpl=_blocs/login');
	}
	else
	{
		die("bad");
	}
}

?>