<?php
/**
 * Module Archives des News
 * Affiche la liste des News
 *
 * Url : /news-archives/
 */

setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');

	$sql=mysql_query('( SELECT id, titre, date, nb_com , "news" as type FROM '.PREFIX.'news )
							UNION
					   ( SELECT id, titre, date, nb_com, "brev" as type FROM '.PREFIX.'breves)
						ORDER BY date DESC');
							
	$contenu.='<div class="titreMessagerie">Archive des actualités</div>
	
	<div style="margin-left:25px">';
	
		$last_date="";
		while ($d=mysql_fetch_object($sql))
		{
			
			$jour=substr($d->date, 0, 10);
			if ($jour!=$last_date) {
			
				$timestamp=strtotime($d->date);
				$dateFR=strftime("%A %d %B %Y", $timestamp );
		
				$contenu.=' <br /><b style="color:#666; line-height:20px"> &rsaquo; '.ucfirst($dateFR).'</b><br />';
			}
			
			if ($d->type=="news") {
				$dossier="Actualite-wL";
				$marque=' <span style="color:#0066FF; font-size:10px; font-variant:small-caps">[news]</span>&nbsp;&nbsp;';
			} else {
				$dossier="Breves";
				$marque='<span style="color:#FF3300; font-size:10px; font-variant:small-caps">[breve]</span> &nbsp;';
			}
			$contenu.='<span style="line-height:20px">
						  &nbsp;&nbsp;&nbsp;&nbsp; '.$marque.' <a href="'.$dossier.'/'.$d->id.'/'.recode(recupBdd($d->titre)).'.htm">'.recupBdd($d->titre).'</a> <span style="font-size:9px">- '.round($d->nb_com).' coms</span>
						</span><br />';
			
			$last_date=$jour;
		}
		
	$contenu.="</div>";
	
	$design->template('simple');
	$design->zone('titre', 'Les archives des news');
	$design->zone('titrePage', 'Actualité : archives');	
	$design->zone('contenu', $contenu);
	

?>