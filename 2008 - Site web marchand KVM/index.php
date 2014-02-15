<?php

/**
 * Portail E-Commerce KVM
 *
 * PHP version 4.5 - Url rewriting actif
 *
 * @descript   Site d'e-commerce de produits électroniques
 * @author     Yotsumi <freelance@studio-dev.fr>
 * @copyright  Studio-dev <www.studio-dev.fr> & Web-Expect <>
 * @version	   1.01
 * @modified   26/07/07
 */

// Déclaration optimisations et charset
ob_start("ob_gzhandler");
	ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src"); /* BUG OVH Xhtml */
	ini_set("SESSION_USE_TRANS_SID", 0);	/* Cacher le phpsessid sur ovh */
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();

// Inclusion des fonctions générales du site + configuration et connexion SQL
include_once "include/fonctions.php";



// On récupère l'adresse de la page du type www.monsite/?nom_page
if (@array_shift(@array_keys(@$_GET))=="page")  $page=$_GET['page'];
elseif (@array_shift(@array_keys(@$_GET)))	$page = @strtolower(array_shift(array_keys($_GET)));
else $page = PAGE_DEFAUT;


// On lance le système de template et on assigne les blocs principaux//
$design = new Design();
	include_once "include/menus.php"; // On inclus les menus communs


// On redirige vers le dossier /_membre si la page contient le terme '?my-xxxxx' ( idem avec admin )
// Si on répère une page admin, on change le template par défaut par le template administration
if (eregi( "^my-([-_a-zA-Z0-9]*)", $page, $membre )) 					{ $page="_membre/".$membre[1]; }
if (eregi( "^admin-([-_a-zA-Z0-9]*)-([-_a-zA-Z0-9]*)", $page, $admin )) { $page="_admin/".$admin[1]."/".$admin[2]; $design->template('admin/admin');}
if (eregi( "^admin-([-_a-zA-Z0-9]*)", $page, $admin )) 					{ $page="_admin/".$admin[1]; $design->template('admin/admin');}

// On inclus la page récupérée en $_GET
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