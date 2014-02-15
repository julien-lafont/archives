<?php
/**
 *
 */
 
// inclusions Ajax
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';
	
	$mois=(int)$_GET['mois'];
	$annee=(int)$_GET['annee'];
	$sens=$_GET['sens']{0};
	
	
	  // Gestion mois suivant/ mois précédent
	  $nextM=$mois+1; $prevM=$mois-1;
	  $nextY=$prevY=date('Y'); 
	  
	 if ($mois==1) { $prevY=$annee-1; $prevM=12; }
	if ($mois==12) { $nextY=$annee+1; $nextM=1; }
		 
	 // On génère un calendrier
	 echo2($sens.'|:|'.
	 		calendrier(
		  		$annee.'-'.$mois, 
		  		monthNumToName($mois).' '.$annee.'<span>&laquo; 
					<a href="#Mois_Precedant" onclick="calendrier('.$prevM.', '.$prevY.', \'g\'); return false">'.monthNumToName($prevM).' </a> - 
					<a href="#Mois_suivant" onclick="calendrier('.$nextM.', '.$nextY.', \'d\'); return false">'.monthNumToName($nextM).'</a> &raquo;</span>',
					true
		  ));

	
	

?>