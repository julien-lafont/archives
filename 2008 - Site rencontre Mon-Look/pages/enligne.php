<?php

$temps=time()-3600; // 1h
$sql=mysql_query("SELECT * FROM members WHERE online=1 AND lastdate>=$temps");

head();
echo "Voici la liste des membres en ligne ( à étoffer ) :<br><br>";

while($data=mysql_fetch_object($sql)){
	echo " - <a href='?=info&id=$data->id_membre'>$data->username</a><br>";
}

foot();

?>
	






