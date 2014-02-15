<?php

$url=$_GET['url'];

$sql=mysql_query("UPDATE ".PREFIX."medias SET nb_dl=nb_dl+1 WHERE id=7");
header('location: '.$url);

?>