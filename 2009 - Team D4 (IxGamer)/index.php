<?php
ini_set("SESSION_USE_TRANS_SID", 0);
ob_start("ob_gzhandler");
ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src"); /* BUG OVH Xhtml */
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();

	include("include/fonctions.php");

// Gère l'activité du membre ( online ou non )
manage_activity();

// On lance le système de template //
$design = new Design($wap);
	$design->zone('menu_principal', $menu_principal);
	$design->zone('menu_map', $menu_map);
	$design->zone('news', $news);
	$design->zone('breves', $breves);
	$design->zone('team', $team);
	$design->zone('partners', $partners);
	$design->zone('head_sponsor', $head_sponsor);
	$design->zone('sponsor', $sponsor);

// On récupère l'adresse de la page
if (@array_shift(@array_keys(@$_GET))) @$page = @strtolower(array_shift(array_keys($_GET)));
else $page = PAGE_DEFAUT;

// On redirige vers le dossier /membre si la page contient le terme '?my-xxxxx' ( idem avec admin )
if (eregi( "^my-([-_a-zA-Z0-9]*)", $page, $membre )) $page="_membre/".$membre[1];
if (eregi( "^admin-([-_a-zA-Z0-9]*)", $page, $admin )) $page="_admin/".$admin[1];

if (file_exists('pages/' . $page . '.php')) {
    include 'pages/' . $page . '.php';
} else {
	$design->zone('contenu',miseenforme('erreur','Impossible d\'afficher la page <u>'.$page.'</u>.'));
	$design->zone('titrePage', 'Erreur 404 : page introuvable');
} 

// Affiche le contenu avec le template, seulement si des zones ont été spécifiées
$design->afficher();
ob_end_flush();
?>