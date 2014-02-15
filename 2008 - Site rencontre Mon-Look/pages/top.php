<?php

head('<link rel="stylesheet" type="text/css" href="include/effet/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="include/effet/niftyPrint.css" media="print">
<script type="text/javascript" src="include/effet/nifty.js"></script>');

echo '<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck())return;
Rounded("div.round","all","#B4E4E6","#B4E4E6","smooth, border #FFFFFF");}
</script>';

switch($_GET['a']) {
case "last":
	
	$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid FROM members WHERE img_principale!='' AND img_valid=1 ORDER BY id_membre DESC LIMIT 0,10") or die('Erreur de selection '.mysql_error());
	echo '<h3>Les dernières photos de membres</h3><br>';
	mini_fiche($sql);
	
break;
case "top10":
	
	$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid FROM members WHERE img_principale!='' AND img_valid=1 AND coeff_note>=10 ORDER BY note DESC LIMIT 0,10") or die('Erreur de selection '.mysql_error());
	echo '<h3>Top 10 de Mon-Look<i>.com</i></h3><br>';
	mini_fiche($sql);
	
break;
case "topH":
	
	$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid FROM members WHERE img_principale!='' AND img_valid=1 AND coeff_note>=5 AND gender='h' ORDER BY note DESC LIMIT 0,10") or die('Erreur de selection '.mysql_error());
	echo '<h3>Les 10 plus beaux mecs !</h3><br>';
	mini_fiche($sql);
	
break;
case "topF":
	
	$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid FROM members WHERE img_principale!='' AND img_valid=1 AND coeff_note>=5 AND gender='f'  ORDER BY note DESC LIMIT 0,10") or die('Erreur de selection '.mysql_error());
	echo '<h3>Les 10 plus belles femmes !</h3><br>';
	mini_fiche($sql);
	
break;
case "enLigne":
	
	$temps=time()-1200;
	$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid FROM members WHERE online=1 AND lastdate>=$temps");
	echo '<h3>Membres actuellement en ligne !</h3><br>';
	mini_fiche($sql);
	
break;
}

foot();

?>