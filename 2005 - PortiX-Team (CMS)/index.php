<?php
session_start();
	include("ixteam.php");
	global $afficher;

if (isset($_GET['page'])) $page = $_GET['page'];
else $page = "developpement";

$afficher = new VTemplate;
$handle = $afficher->Open("theme/" . $ixteam['theme'] . "/theme.htm");
include("include/theme_include.php");
	
if (file_exists("pages/" . $page . ".php")) {
    include 'pages/' . $page . '.php';
} else {
    $afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Erreur 404");
    $afficher->setVar($handle, "contenu.module_texte", "<center><br><br>Impossible d'afficher la page <u>$page</u>.<br><br><br><br><a href=\"" . $ixteam['url'] . "\">Retourner à l'accueil</a></center>");
    $afficher->CloseSession($handle, "contenu");
} 

$afficher->Display($handle);
?>
