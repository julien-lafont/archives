<?php
securite_admin();

$c='<center>Bienvenue <b>'.ucfirst($_SESSION['sess_pseudo']).'</b>, bienvenu sur ton espace d\'administration</center>';


			
$design->template('admin');
$design->zone('contenu', $c);

?>
