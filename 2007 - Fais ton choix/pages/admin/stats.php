<?php
securite('4+');

	// Nombres de votes TOTAL :
	$sql1=mysql_query("SELECT SUM(votestotal) as nb1 FROM ".PREFIX."duels");
	$d1=mysql_fetch_object($sql1);

	$sql2=mysql_query("SELECT SUM(nb_votes) as nb2 FROM ".PREFIX."themes_photos");
	$d2=mysql_fetch_object($sql2);
	
		$total=$d1->nb1+$d2->nb2;
	
	// Nombre de duel / de photos :
	$sql4=mysql_query("SELECT id FROM ".PREFIX."duels");
	$nbD=mysql_num_rows($sql4);
	$sql5=mysql_query("SELECT id FROM ".PREFIX."themes_photos");
	$nbP=mysql_num_rows($sql5);
	
	// Top 10 des photos :
	$sql3=mysql_query("SELECT img, nom, nb_votes FROM ".PREFIX."themes_photos ORDER BY nb_votes DESC LIMIT 0,10");
	
	// ADMINS + infos
	$sql4=mysql_query("SELECT * FROM ".PREFIX."admin ORDER BY nb_actions DESC ");
	
	$c='<h2>Statistiques rapides </h2><br />
	
		<b>Statistiques Duels/Photos</b>
		<ul>
			<li>Nombre de votes duels : '.$d1->nb1.'</li>
			<li>Nombre de votes photos : '.$d2->nb2.'</li>
			<li>Total votes : '.$total.'<br /><br /></li>
			
			<li>Nombre duels : '.$nbD.'</li>
			<li>Nombre photos : '.$nbP.'</li>
			<li>Total d\'images : '.(($nbD*2)+$nbP).'</li></ul>
			
			<b>Top des photos : </b><ul>';
	
				$i=1;
				while ($d=mysql_fetch_object($sql3)) {
					$c.='<li>Photo <b>'.$i.'</b> : <a href="'.PHOTO.$d->img.'">'.$d->nom.'</a> ('.$d->nb_votes.')</li>';
					$i++;
				}
	$c.='</ul>';
	
	if ($_SESSION['sess_level']>4) {
	
		$c.='<b>Top des admins : </b><ul>';

				$j=1;
				while ($e=mysql_fetch_object($sql4)) {
					$c.='<li><b>'.ucfirst($e->pseudo).'</b> - Actions: '.$e->nb_actions.' - Duels: '.$e->nb_duels.' - Photos: '.$e->nb_photos.' - Connexion: '.$e->nb_connexion.'</li>';
					$j++;
				}
		$c.='</ul>';
	}
	


$design->template('admin');
$design->zone('contenu', $c);
$design->zone('categorie', 'GESTION DES DUELS');

?>