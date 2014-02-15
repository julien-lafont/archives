<?php
header('Content-Type: text/html; charset=UTF-8');

// Déclaration optimisations et charset
ob_start("ob_gzhandler");

// Chargement du fichier de configuration
include_once 'include/config.php';
define('AJAX', 1);

// Inclusion de la classe principale
include_once 'classes/class_main.php';
$m = new Main();

	include_once "include/menus.php";

// On récupère l'adresse de la page du type www.monsite/?nom_page
if (@array_shift(@array_keys(@$_GET))) @$page_load = @strtolower(array_shift(array_keys($_GET)));
else $page_load = PAGE_DEFAUT;

// Vérif faille include supplémentaire ( >>>FACULTATIF<<< Mieux vaut trop que pas assez ^^  )
if (preg_match("#http|ftp|www|.php#is", $page_load) || strpos($page_load, '..')!==false || strpos($page_load, './')!==false || strpos($page_load, '__')!==false || strpos($page_load, '_/')!==false) {
	die('Hack Attempt');
}

// On redirige vers le dossier /membre si la page contient le terme '?my-xxxxx' ( idem avec admin )
if (eregi( "^my-([-_a-zA-Z0-9]*)", $page_load, $membre )) $page_load="membre/".$membre[1];
if (eregi( "^admin-([-_a-zA-Z0-9]*)", $page_load, $admin )) $page_load="admin/".$admin[1];

if (file_exists('pages/' . $page_load . '.php')) {
    include 'pages/' . $page_load . '.php';
} else die("404");

if (isset($_SESSION["sess_anglais"])) $lang="en";
else								  $lang="fr";
$m->design->assign("lang", $lang);

if ($page_load!="afficher_template" && (isset($ajax_titre) || isset($ajax_hash))) Fonctions::echoAjax($ajax_titre.'|:|'.$ajax_hash.'|:|');
$m->design->displayAjax($lang.'/'.$m->design->get_template().".tpl");

ob_end_flush();
mysql_close();
?>