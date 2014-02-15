<?php

//:: Variables Mysql :://
define('HOTE', "localhost");
define('LOGIN', "root");
define('PASS', "");
define('BASE', "sms");

//:: Connexion Mysql :://
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");


?>