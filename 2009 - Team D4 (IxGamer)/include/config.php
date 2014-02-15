<?php

//:: Variables Mysql :://
define('HOTE', "mysql4");
define('LOGIN', "yotsumi");
define('PASS', "xxxxxxx");
define('BASE', "yotsumi");
define('PREFIX', "d4_");

//:: Connexion Mysql :://
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");

//:: Variables de Configuration
define('PAGE_DEFAUT', "news");
define('CLE',"jj");
define('URL', "http://www.yotsumi.info/d4/");
define('URL_REL', "/d4/");
define('PATH', path() );
define('SEPARATOR','|:|'); /* jvs */
define('TEMPLATE_DEFAULT','simple'); // Thème par défaut
define('NB_VISITEURS', 20);


/* ---- ---- LES GROUPES ---- ---- 
 * 0 : Membre inactif
 * 1 : Membre activé
 * 2 : Membres +
 * 3 : Rédacteurs
 * 4 : 
 * 5 : Admin normal
 * 6 : Admin supérieur
 * 7 : //
 * 8 : //
 * 9 : Banni
* -------------------------------- */
define('GROUPE_BAN','9');
define('GROUPE_ADMIN','5');


?>