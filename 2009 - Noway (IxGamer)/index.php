<?php

/**
 * Portail Ix-Gamer
 *
 * PHP version 4.5 - Url rewriting actif
 *
 * @descript   Portail Web 2.0 pour la gestion de team E-sport
 * @author     Yotsumi <freelance@studio-dev.fr>
 * @copyright  Studio-dev <www.studio-dev.fr>
 * @version	   3.05
 * @modified   28/01/07 19:15:00
 */

// Déclaration optimisations et charset
ob_start("ob_gzhandler");
ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src"); /* BUG OVH Xhtml */
ini_set("SESSION_USE_TRANS_SID", 0);											/* Cacher le phpsessid sur ovh */
header('Content-Type: text/html; charset=ISO-8859-1');
session_start();

	include_once "include/fonctions.php";

// Gère l'activité du membre ( online ou non )
manage_activity();

// Sélection du design à utilisé
(defined('STYLE')) ? $style=STYLE : $style="futura_bleu";
if (isset($_SESSION['theme']) && $_SESSION['theme']!="" && is_dir('theme/'.$_SESSION['theme'])) $style=$_SESSION['theme'];

// On lance le système de template et on assigne les blocs principaux//
$design = new Design($style);
	include_once "include/menus.php";

// On récupère l'adresse de la page du type www.monsite/?nom_page
if (@array_shift(@array_keys(@$_GET))) @$page = @strtolower(array_shift(array_keys($_GET)));
else $page = PAGE_DEFAUT;

// Vérif faille include supplémentaire ( >>>FACULTATIF<<< Mieux vaut trop que pas assez ^^  )
if (preg_match("#http|ftp|www|.php#is", $page) || strpos($page, '..')!==false || strpos($page, './')!==false || strpos($page, '__')!==false || strpos($page, '_/')!==false) {
	bloquer_acces('Hack Attempt');
}


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