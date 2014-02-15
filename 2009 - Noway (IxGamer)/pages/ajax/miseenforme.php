<?php

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';


/* Transmet une fonction PHP à un script Javascript */

echo miseEnForme($_POST['type'], $_POST['txt']);

?>