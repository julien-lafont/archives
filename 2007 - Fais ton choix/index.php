<?php
/**
 * Fun site : Faistonchoix.fr
 *
 * PHP version 4.5 - Url rewriting actif
 *
 * @descript   Concept fun de vote sur des sujets divers
 * @author     Yotsumi <yotsumi.fx@gmail.com>
 * @copyright  Studio-dev <www.studio-dev.fr>
 * @version	   1.01
 * @modified   31/03/07 17h49
 */

ob_start("ob_gzhandler");
ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src");  /* Bug ovh xhtml */
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();

	include_once("include/fonctions.php");
	
// On lance le système de template et on ajoute les menus qui seront sur toutes les pages 
$design = new Design();
	include_once('include/menus.php');
	
// Version lite ?
	if(@$_GET['nojvs']==1 || $_SESSION['no_jvs']==1) {
		$_SESSION['sess_no_jvs']=1;
		setcookie('no_jvs', 1, (time() + 604800), URL_REL); /* 7j */
	}
	if(@$_GET['activjvs']==1) {
		$_SESSION['sess_no_jvs']=0;
		setcookie('no_jvs', 0, (time() + 604800), URL_REL); /* 7j */
	}
	
// On récupère l'adresse de la page, appellé sous la forme : 'www.monsite.fr/?le_nom_de_ma_page' lié à 'page/le_nom_de_ma_page.php'
if (@array_shift(array_keys($_GET))) $page = @strtolower(array_shift(array_keys($_GET)));
else $page = PAGE_DEFAUT;

// URL rewriting en php 
if (eregi( "^admin-([-_a-zA-Z0-9]*)", $page, $admin )) $page="admin/".$admin[1];

// On regarde si la page demandé existe, si oui on l'affiche, si non message d'erreur
if (file_exists('pages/' . $page . '.php')) {
    include 'pages/' . $page . '.php';
} else {
	$design->template('simple');
	$design->zone('titre', 'Page introuvable');
	$design->zone('contenu',miseenforme('erreur','Impossible d\'afficher la page <u>'.$page.'</u>.'));
	$design->zone('titrePage', 'Erreur 404 : page introuvable');
} 

// Affiche le contenu avec le template, seulement si des zones ont été spécifiées
$design->afficher();
ob_end_flush();
?>