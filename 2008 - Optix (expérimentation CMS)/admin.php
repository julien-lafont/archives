<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * Portail IxBlog
 *
 * PHP version 5 - Url rewriting actif
 *
 * @descript   Système de gestion de blog 2.0
 * @author     Yotsumi <freelance@studio-dev.fr>
 * @copyright  Studio-dev <www.studio-dev.fr>
 * @version	   0.23
 * @modified   12/11/07 19:15:00
 */

// Déclaration optimisations et charset
ob_start("ob_gzhandler");

// Chargement du fichier de configuration
include_once 'include/config.php';


include_once 'classes/class_main.php';
$m = new Main();

	include_once "include/menus_admin.php";

	
// On récupère l'adresse de la page du type www.monsite/?nom_page
if (@array_shift(@array_keys(@$_GET))) @$page = @strtolower(array_shift(array_keys($_GET)));
else $page = "accueil";

// Vérif faille include supplémentaire ( >>>FACULTATIF<<< Mieux vaut trop que pas assez ^^  )
if (preg_match("#http|ftp|www|.php#is", $page) || strpos($page, '..')!==false || strpos($page, './')!==false || strpos($page, '__')!==false || strpos($page, '_/')!==false) {
	die("Erreur - Acces page interdit !");
}


// On redirige vers le dossier /membre si la page contient le terme '?my-xxxxx' ( idem avec admin )
if (eregi( "^([-_a-zA-Z0-9]*)-([-_a-zA-Z0-9]*)", $page, $admin ))   $page=$admin[1]."/".$admin[2]; 
elseif (eregi( "^([-_a-zA-Z0-9]*)", $page, $admin )) 				$page=$admin[1]; 


if (file_exists('pages/admin/' . $page . '.php')) {
    include 'pages/admin/' . $page . '.php';
} else {
	$m->design->template("erreur");
	$m->design->assign('nomErreur', 'Erreur 404 : page introuvable');
	$m->design->assign('descErreur', 'Impossible d\'afficher la page <u>'.$page.'</u>.');
} 

// Affiche le contenu avec le template, seulement si des zones ont été spécifiées
$m->design->display('_admin/admin.tpl');
ob_end_flush();
mysql_close();
?>