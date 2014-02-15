<?php

/*
 * REGROUPER EN UN SEUL FICHIER LES DIFFERENTES FEUILLES DE STYLE CSS
 *
*/

	// Dossier des feuilles de style
	$dossier="../templates/styles/";
	
	// Feuilles à incorporer
	$feuilles = glob($dossier."*.css");

	ob_start ("ob_gzhandler");
	header("Content-type: text/css; charset: UTF-8");
	header("Cache-Control: must-revalidate");
	$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + 60 * 60) . " GMT";
	header($ExpStr);
	
	//$c="";
	foreach ($feuilles as $f) {
		//$c.=file_get_contents($f);
		include_once $f;
	}
	//$c = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $c);
	//echo $c;
	
	ob_end_flush();
?>