<?php
header('Content-Type: application/rss+xml; charset=UTF-8');

// Déclaration optimisations et charset
ob_start("ob_gzhandler");

// Chargement du fichier de configuration
include_once 'include/config.php';

// Inclusion de la classe principale
include_once 'classes/class_main.php';
$m = new Main();

// On récupère l'adresse de la page du type www.monsite/?nom_page
if (@array_shift(@array_keys(@$_GET))) @$page_load = @strtolower(array_shift(array_keys($_GET)));
else $page_load= PAGE_DEFAUT;

// Vérif faille include supplémentaire ( >>>FACULTATIF<<< Mieux vaut trop que pas assez ^^  )
if (preg_match("#http|ftp|www|.php#is", $page_load) || strpos($page_load, '..')!==false || strpos($page_load, './')!==false || strpos($page_load, '__')!==false || strpos($page_load, '_/')!==false) {
	Fonctions::bloquer_acces('Hack Attempt');
}

if (file_exists('rss/' . $page_load . '.php')) {
    include 'rss/' . $page_load . '.php';
} else die("404");

$m->design->display($m->design->get_template().".tpl");

ob_end_flush();
mysql_close();
?>