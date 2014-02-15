<?php

//:: Variables Mysql :://
define("HOTE", ".1and1.fr");
define("LOGIN", "");
define("PASS", ".");
define("BASE", "");
define("PREFIX", "yot_");


//:: Connexion Mysql :://
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");

//:: Variables de Configuration
define('PAGE_DEFAUT', "news");
define('CLE',"yot");
define('URL_REL', "/");
define('PATH', path() );
define('SEPARATOR','|:|'); /* jvs */
define('TEMPLATE_DEFAULT','accueil'); // Thème par défaut
define('URL', "http://www.studio-dev.fr/");


define('GROUPE_BAN','9');
define('GROUPE_ADMIN','5');


define('SIRET', '498 --- --- 00015');


?>