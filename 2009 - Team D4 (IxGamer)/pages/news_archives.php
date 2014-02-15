<?php
setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');

	$sql=mysql_query("SELECT id, titre, date, nb_com FROM ".PREFIX."news ORDER BY date DESC");
	
	$contenu.='<center><b style="font-size:12px;">Liste des actualitées parues</b></center><br />';
	
	$last_date="";
	while ($d=mysql_fetch_object($sql))
	{
		$jour=substr($d->date, 0, 10);
		if ($jour!=$last_date) {
		
			$timestamp=strtotime($d->date);
			$dateFR=strftime("%A %d %B %Y", $timestamp );
	
			$contenu.=' <br /><b> &rsaquo; '.ucfirst($dateFR).'</b><br />
						<span style="font-size:12px; line-height:18px">
							&nbsp;&nbsp;&nbsp;&nbsp; <a href="Actualite-d4/'.$d->id.'/'.recode($d->titre).'/">'.$d->titre.'</a> <span style="font-size:10px">- '.round($d->nb_com).' coms</span>
						</span><br />';
		}
		else {
			$contenu.='<span style="font-size:12px; line-height:18px">
						&nbsp;&nbsp;&nbsp;&nbsp; <a href="Actualite-d4/'.$d->id.'/'.recode($d->titre).'/">'.$d->titre.'</a> <span style="font-size:10px">- '.round($d->nb_com).' coms</span>
					   </span><br />';
		}
		
		$last_date=$jour;
	}
		
	$design->template('simple');
	$design->zone('titre', 'Les archives des news');
	$design->zone('titrePage', 'Actualité : archives');	
	$design->zone('contenu', $contenu);
	

?>