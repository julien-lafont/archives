<?php

include "../include/fonctions.php";

if($_GET['secure']=="iloveyou") {

	// On calcule si on doit remettre à 0 les stats des mois
	$sql3=mysql_query("SELECT last_del FROM stats");
	$d=mysql_fetch_object($sql3);
		$now=time();
		$diff=$now-$d->last_del;
		$jour=round(($diff/60/60/24));
		
	// On remet les jours à 0, et les mois si $jour>30 ( qu'on me parle pas d'années bissextiles ou jsé pas koi !!! )
	if ($jour>=30) {
		$sql4=mysql_query("UPDATE membres SET jour=0, mois=0");
		$sql5=mysql_query("UPDATE stats SET jour=0, mois=0, last_del='$now'");
		echo "Mois + Jour OK";
	} else {
		$sql1=mysql_query("UPDATE membres SET jour=0");
		$sql2=mysql_query("UPDATE stats SET jour=0");
		echo "Jour OK";
	}
	
} else { 
	echo "No auth";
}

?>