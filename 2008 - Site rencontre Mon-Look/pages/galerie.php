<?php

if (is_log()==0) { head(); echo '<br><br><br><br><center><b>Vous devez être connecter pour visionner cette galerie</b></center><br><br><br><br><br><br>'; foot(); exit; }

$pseudo=strtolower($_GET['pseudo']);

head('<script type="text/javascript" src="include/effet/lightbox.js"></script>
		<style type="text/css" media="all">
		@import "include/effet/lightbox.css";
		</style>');
echo '<h3>Les photos de '.ucfirst($pseudo).'</h3><br><br>';
	
	$sql=mysql_query("SELECT dir_galerie FROM members WHERE username='".$pseudo."'");
	$dat=mysql_fetch_object($sql);
	
	echo "<table width=95% border=0 align=center>";
	
	$sql2 = mysql_query('SELECT * FROM photos WHERE pseudo="'.$pseudo.'" AND valid=1 ORDER BY id');	
	$i=1;
	while($data = mysql_fetch_object($sql2) ) {

		if ($i%3 == 1) { // SI $i est pair
       		 echo "<tr><td align='center' valign='center'><a href='upload/galerie/$dat->dir_galerie/$data->img' rel='lightbox' title='".nl2br($data->description)."'><img src='upload/galerie/$dat->dir_galerie/_min_$data->img' border=0 id='img3'></a></td>"; }
    	if ($i%3 == 2) { // SI $i est impair
        	echo "<td align='center' valign='center'><a href='upload/galerie/$dat->dir_galerie/$data->img' rel='lightbox' title='".nl2br($data->description)."'><img src='upload/galerie/$dat->dir_galerie/_min_$data->img' border=0 id='img3'></a></td>"; }
		if ($i%3 == 0){ // SI $i est impair
        	echo "<td align='center' valign='center'><a href='upload/galerie/$dat->dir_galerie/$data->img' rel='lightbox' title='".nl2br($data->description)."'><img src='upload/galerie/$dat->dir_galerie/_min_$data->img' border=0 id='img3'></a></td></tr>
			<tr> <td colspan=3>&nbsp;</td></tr>"; }
			$i++; 
			 
	}
	
	echo "</table><br><br><br><br><br>";
		 


foot();
?>