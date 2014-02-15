<?php

$nom=$_GET['nom'];
if (file_exists('theme/'.$nom.'/accueil.tpl.php')) $_SESSION['theme']=$nom;

header('location: '.URL.'actualite/');

?>