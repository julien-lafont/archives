<?php
$locale = setlocale(LC_ALL, 'fr_FR@euro', 'fr_FR', 'fra');



//::::: Page principale ::::://
if (empty($_GET['id']))
{

	
	$c='<div class="titreMessagerie">Evènements de la team '.NOM.'</div>';
	
	$sql1=mysql_query("SELECT * FROM ".PREFIX."coverage ORDER BY date DESC");
	$nb=mysql_affected_rows();
	
	if ($nb==0) $c.='<br \><center>Aucun évènement disponible</center><br /><br />';
	else
	{
		  // Gestion mois suivant/ mois précédent
		  $nextM=date('m')+1; $prevM=date('m')-1;
		  $nextY=$prevY=date('Y'); 
		  
		  //if (date('m')==1) { $prevY=$date('Y')-1; $prevM=12; }
		  //if (date('m')==12) { $nextY=$date('Y')+1; $nextM=1; }

		  // On génère un calendrier
		  $periode=date("Y-m");
		  
		  $c.=calendrier(
		  		$periode, 
		  		monthNumToName(date('m')).' '.date('Y').'<span>&laquo; 
					<a href="#Mois_Precedant" onclick="calendrier('.$prevM.', '.$prevY.', \'g\'); return false">'.monthNumToName($prevM).'</a> - 
					<a href="#Mois_Suivant" onclick="calendrier('.$nextM.', '.$nextY.', \'d\'); return false">'.monthNumToName($nextM).'</a> &raquo;</span>'
		  );
		  
		  $meta="";
		  $c.='<div style="margin-top:30px; margin-left:30px">
		  	     <img src="images/mini_fleche_droite.png" style="vertical-align:middle"> <a href="#" onclick="toggle_futur(); return false"><strong>Afficher les évènements futurs</strong></a>
				 	<div id="coverage_futur">';
		 
				$sql_futur=mysql_query("SELECT * FROM ".PREFIX."coverage WHERE date>=NOW()");
				while ($f=mysql_fetch_object($sql_futur)) {
					$c.='<img src="'.CHEMIN_PAYS.$f->pays.'.gif" /> <span style="color:#666">'.inverser_date($f->date,6).'</span> &nbsp;&nbsp; <img src="'.CHEMIN_JEU.$f->jeu.'.png" /> <a href="coverage/evenement-'.$f->id.'-'.recode(recupBdd($f->nom)).'-le-'.inverser_date($f->date, 4).'.htm">'.recupBdd($f->nom).'</a><br />';
					$meta.=recupBdd($f->nom).', ';
				}

		  	$c.='  </div><br /><br />
				<img src="images/mini_fleche_droite.png" style="vertical-align:middle"> <a href="#" onclick="toggle_passe(); return false"><strong>Afficher les évènements antérieurs</strong></a>
				 	<div id="coverage_ante">';
				
				$sql_passe=mysql_query("SELECT * FROM ".PREFIX."coverage WHERE date<NOW()");
				while ($p=mysql_fetch_object($sql_passe)) {
					$c.='<img src="'.CHEMIN_PAYS.$p->pays.'.gif" /> <span style="color:#666">'.inverser_date($p->date,6).'</span> &nbsp;&nbsp; <img src="'.CHEMIN_JEU.$p->jeu.'.png" /> <a href="coverage/evenement-'.$p->id.'-'.recode(recupBdd($p->nom)).'-le-'.inverser_date($p->date, 4).'.htm">'.recupBdd($p->nom).'</a><br />';
					$meta.=recupBdd($p->nom).', ';
				}
					
			$c.=' </div>
				</div><br /><br />';
		  		
	}
				
	
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Evènements auxquels notre team à participé');
	$design->zone('titre', 'Evènements de la team '.NOM);
	$design->zone('header', '<script language="javascript" src="javascript/-coverage.js"></script>');
	metatag('Liste des évènements : '.$meta, 'coverage, evènement, evenement, calendrier, '.$meta);

}
else //::::: Fiche détaillée ::::://
{

	   $id=(int)$_GET['id'];
	   
	   $sql=mysql_query("SELECT * FROM ".PREFIX."coverage WHERE id='$id'");
	   $d=mysql_fetch_object($sql);
	  	 $num=mysql_num_rows($sql);
		 
		if ($num==0) bloquerAcces('Aucun évènement ne correspond à cet identifiant');
	   
		//---- Link vers le site adverse ? ----//
		if (!empty($d->site)) $nom='<a href="'.recupBdd($d->site).'" target="_blank" style="border-bottom:1px dotted #00A8FF;">'.recupBdd($d->nom).'</a>';
								else	 $nom=recupBdd($d->nom);

		//---- Gestion de la date ----//
		list($date, $heure) = explode(" ", $d->date);
		list($annee, $mois, $jour) = explode("-", $date);

		if (empty($d->detail)) $detail="<i>Aucun détail sur cet évènement</i>";
		else				   $detail=nl2br(recupBdd($d->detail));
		
	   $c='<div id="retour"><a href="coverage/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>

			<br /><div class="titreMessagerie">
					Evènement -wL- <img src="'.CHEMIN_JEU.$d->jeu.'.png"  /> '.recupBdd($d->nom).'
				</div><br /><br />

		   
		   <div class="cov_col1" >
		   	<img src="images/mini_fleche_droite.png" style="vertical-align:middle"> <b>Plus d\'infos sur l\'évènement</b><br /><br />
				<p class="cov_col1_in">'.nl2br(recupBdd($d->infos)).'</p>
		   </div>
		   
		   <div class="cov_col2">
		   	<img src="images/mini_fleche_droite.png" style="vertical-align:middle"> <b>Informations sur le évènement</b>
			
				<ul id="liste_perso" >
					<li><em>Nom</em> <dfn><strong>'.$nom.'</strong></dfn></li>
					<li><em>Date</em> <dfn>'.ucfirst(@strftime("%d %B %Y", @mktime(0, 0, 0, $mois , $jour, $annee))).'</dfn></li>
					<li><em>Pays</em> <dfn><img src="'.CHEMIN_PAYS.recupBdd($d->pays).'.gif" alt="'.recupBdd($d->pays).'" style="vertical-align:middle" /> '.recupBdd($d->pays).'</dfn></li>
					<li><em>Lieu</em> <dfn>'.ucfirst(recupBdd($d->lieu)).'</dfn></li>
				</ul>
		   </div>
		   
		   <br /><br />';	
		   	   
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Evènement : '.recupBdd($d->nom));
	$design->zone('titre', 'Evènements de la team '.NOM);
	metatag(recupBdd($d->pays).' : '.recupBdd($d->nom).' - '.recupBdd($d->detail));
}


?>