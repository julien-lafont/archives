<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';

	$xml = '<?xml version="1.0" encoding="iso-8859-1"?><rss version="2.0">';
	$xml .= '<channel>'; 
	$xml .= '<title>'.NOM.' : actu de la team</title>';
	$xml .= '<link>'.URL.'</link>';
	$xml .= '<description>'.DESCRIPTION.'</description>';
	$xml .= '<copyright>© ix-gamer.net 2007</copyright>';
	$xml .= '<language>fr</language>';
	
	$res=mysql_query("SELECT * FROM ".PREFIX."news ORDER BY id DESC LIMIT 0, 10");
	while($d=mysql_fetch_object($res)){   
			$titre=recupBdd($d->titre);
			$adresse=URL.'actualite/'.$d->id.'/'.recode($d->titre).'.htm';
			$contenu=recupBdd($d->apercu);
					
				$xml .= '<item>';
				$xml .= '<title>'.$titre.'</title>';
				$xml .= '<link>'.$adresse.'</link>';
				$xml .= '<guid isPermaLink="True">'.$adresse.'</guid>';
				$xml .= '<pubDate>'.$d->date.'</pubDate>'; 
				$xml .= '<description>'.$contenu.'</description>';
				$xml .= '</item>';	
		}
	
	$xml .= '</channel>';
	$xml .= '</rss>';
		   
	echo($xml);
?>