<?php

high_security_admin($_GET['secure']);

head();

	// Nombre de photo principales en attente :
	$sql1=mysql_query("SELECT count(id_membre) as nbval FROM members WHERE img_principale!='' AND img_valid='0'");
	$d1=mysql_fetch_object($sql1);

	$sql2=mysql_query("SELECT count(id) as nbtof FROM photos WHERE valid='0'");
	$d2=mysql_fetch_object($sql2);

echo '<h3>Administration</h3><br><br>
<span style="font-size:14px; color:#FF0000">»</span> <a href="?p=admin/val_prin">Valider les photos principales ('.$d1->nbval.')</a><br><br>
<span style="font-size:14px; color:#FF0000">»</span> <a href="?p=admin/val_gal">Valider les photos des galeries ('.$d2->nbtof.')</a>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';


foot();

?>

