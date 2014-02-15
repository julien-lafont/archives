<?php 
is_admin();

$select = 'SELECT id FROM ix_stats';
$result = mysql_query($select) or die ('Erreur : '.mysql_error() );
$nb_pagesvues = mysql_num_rows($result);

$sql = 'SELECT DISTINCT(ip) FROM ix_stats';
$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
$nb_visiteurs = mysql_num_rows ($result);

// Stats Globales
$texte="<div class=\"titreBS\">Statistiques :</div>

	<span class='txt2'>Visiteurs Totals : </span><b>$nb_pagesvues</b><br />
	<span class='txt2'>  Visiteurs Uniques : </span><b>$nb_visiteurs</b><br />";
			
// Stats Mois / Mois	
			$visite_par_mois = array();
			
			$sql = 'SELECT date FROM ix_stats ORDER BY date ASC';
			$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				$date=$data['date'];
			
				sscanf($date, "%4s-%2s-%2s %2s:%2s:%2s", $date_Y, $date_m, $date_d, $date_H, $date_i, $date_s);
			
				if ($date_m < "10"){
					$date_m = substr($date_m, -1);
				}
				$visite_par_mois[$date_m]=$visite_par_mois[$date_m]+1;
			}
			$total_pages_vu = mysql_num_rows($result);

	$texte.='<br /><span class="txt2">Les statistiques de l\'année '.$date_Y.' : </span><blockquote class="stats"><table>';
	
			for($i = 1; $i <= 12; $i++) {
			
				if ($i=="1") $mois="Janvier";
				if ($i=="2") $mois="Février";
				if ($i=="3") $mois="Mars";
				if ($i=="4") $mois="Avril";
				if ($i=="5") $mois="Mai";
				if ($i=="6") $mois="Juin";
				if ($i=="7") $mois="Juillet";
				if ($i=="8") $mois="Aout";
				if ($i=="9") $mois="Septembre";
				if ($i=="10") $mois="Octobre";
				if ($i=="11") $mois="Novembre";
				if ($i=="12") $mois="Décembre";
				
				if (!isset($visite_par_mois[$i])) {
					$texte.='<tr><td width="80">'.$mois.'</td><td class="txt2">-> 0 page vue</tr>';
				}
				else {
					$texte.='<tr><td width="80">'.$mois.'</td><td  class="txt2">-> '.$visite_par_mois[$i].' pages vues</tr>';
				}
			}

	$texte.='</table></blockquote>';
	
// on recherche les pages qui ont été les plus vues sur le mois (on calcule au passage le nombre de fois qu'elles ont été vu)
$texte.= '<br /><span class="txt2">Les pages les plus vues :</span><br /><blockquote class="stats"><table>';

		echo $ixteam['url2'];
		$sql = 'SELECT distinct(page), count(page) as nb_page FROM ix_stats WHERE page!="" GROUP BY page ORDER BY nb_page DESC LIMIT 0,15';
		$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		while ($data = mysql_fetch_array($result)) {
			$nb_page = $data['nb_page'];
			$page = $data['page'];
			$page = ereg_replace("page=","",$page);
			$texte.='<tr><td width="120">'.ucfirst($page).'</td><td> -> '.$nb_page.' visites </tr>';
		}
		


// on recherche les visiteurs qui ont été les plus connectes au site sur le mois (on calcule au passage le nombre de page qu'ils ont chargé)
$texte.= '</table></blockquote><br /><span class="txt2">Les membres qui surf le plus :</span><br /><blockquote class="stats"><table>';

$sql = 'SELECT distinct(id_mbre), count(id_mbre) as nb_host FROM ix_stats WHERE id_mbre!=0 GROUP BY id_mbre ORDER BY nb_host DESC LIMIT 0,15';
$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
while ($data = mysql_fetch_array($result)) {
    $nb_ps = $data['nb_host'];
    $host = $data['id_mbre'];
		$sql2 = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$host");
		$pseud = mysql_fetch_object($sql2);
		$pseudo = $pseud->pseudo;
		
    $texte.= '<tr><td width="80">'.ucfirst($pseudo).'</td><td>-> '. $nb_ps.'</tr>';
}



// on recherche les meilleurs Referer
$texte.= '</table></blockquote><br /><span class="txt2">Les meilleurs Référers :</span><br /><blockquote class="stats"><table>';

$sql = 'SELECT distinct(referer),  count(referer) as nb_referer FROM ix_stats WHERE referer!="" GROUP BY referer ORDER BY nb_referer DESC LIMIT 0,15';
$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
$nb_referer = mysql_num_rows ($result);
while ($data = mysql_fetch_array($result)) {
    $nb_referer = $data['nb_referer'];
    $referer = $data['referer'];
    $texte.= '<tr><td width="200"><a href="'.$referer.'" target="_blank">'.$referer.'</a></td><td>-> '.$nb_referer.'</td></tr>';
}
if ($nb_referer==0 ) $texte.= '<tr><td width="200">Aucun référer enregistré</td><td></td></tr>';



// on recherche les navigateurs et les OS utilisés par les visiteurs (on calcule au passage le nombre de page qui ont été chargés avec ces systèmes)
$texte.= '</table></blockquote><br /><span class="txt2">Les navigateurs et OS :</span><br /><blockquote class="stats"><table>';

$sql = 'SELECT distinct(nav), count(nav) as nb_navigateur FROM ix_stats  GROUP BY nav ORDER BY nb_navigateur DESC LIMIT 0,15';
$result = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
while ($data = mysql_fetch_array($result)) {
    $nb_navigateur = $data['nb_navigateur'];
    $navigateur = $data['nav'];
    $texte.= '<tr><td width="300">'.$navigateur.'</td><td>-> '.$nb_navigateur.'</td></tr>'; 
}
$texte.= '</table></blockquote><br><br>
<center><a href="?page=admin/accueil">- Retour à l\'aministration -</a><br><br></center>';


	$afficher->AddSession($handle, "contenu");
	$afficher->setVar($handle, "contenu.module_titre", "Statistique du site");
	$afficher->setVar($handle, "contenu.module_texte", $texte );
	$afficher->CloseSession($handle, "contenu"); 
	    
?>