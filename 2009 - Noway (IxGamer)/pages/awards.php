<?php
$locale = setlocale(LC_ALL, 'fr_FR@euro', 'fr_FR', 'fra');

//::::: Page principale ::::://
if (empty($_GET['id']))
{

	
	$c='<div class="titreMessagerie">Palmarès de la team '.NOM.'</div>';
	
	$anneeOld=0;
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."awards ORDER BY annee DESC, mois DESC, jour DESC");
	$nb=mysql_affected_rows();
	
	if ($nb==0) $c.='<br \><center>Aucun palmarès disponible</center><br /><br />';
	else
	{
		// Nouvelle année ?
		$c.='<table id="listeMedias" cellspacing="0" cellpadding="0" style="width:550px; margin:0 auto">'; $meta_nom="";
		while ($d=mysql_fetch_object($sql)) 
		{
			
			if ($anneeOld!=$d->annee) {
				$c.='<tr>
						<td colspan="4" class="top" style="font-size:15px; padding-top:13px">
						    '.$d->annee.'
						</td>
					  </tr>';
				$anneeOld=$d->annee;
			}	
			
			// 1er/2eme ou 3eme : résultat en gras
			if ($d->place=="1er") 		$place='<img src="images/gold.gif" style="vertical-align:middle">';
			elseif  ($d->place=="2nd") 	$place='<img src="images/silver.gif" style="vertical-align:middle">';
			elseif (recode($d->place)=="3-egrave-me") 	$place='<img src="images/bronze.gif" style="vertical-align:middle">';
			else						$place=$d->place;

			$c.='<tr class="in">
					<td style="width:70px; font-size:9px"></td>
					<td><img src="'.CHEMIN_PAYS.$d->pays.'.gif" style="vertical-align:middle"/> <a href="awards/palmares-'.$d->id.'-'.recode(recupBdd($d->nom)).'.htm">'.recupBdd($d->nom).'</a></td>
					<td style="width:25px"><img src="'.CHEMIN_JEU.$d->jeu.'.png" style="vertical-align:middle" /></td>
					<td style="width:150px;">'.$place.'</td>
				 </tr>';
			$meta_nom.=recupBdd($d->nom);
		}
		$c.='</table><br /><br />';
	}
				
	
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Palmarès');
	$design->zone('titre', 'Palmarès de la team '.NOM.' : Classement et résultats détaillés');
	metatag('Liste des différentes récompenses attribuées à la team '.NOM.' lors des différents championnats : '.$meta_nom, 
			'awards, récompenses, résultats, '.$meta_nom);

}
else //::::: Fiche détaillée ::::://
{

	   $id=(int)$_GET['id'];
	   
	   $sql=mysql_query("SELECT * FROM ".PREFIX."awards WHERE id='$id'");
	   $d=mysql_fetch_object($sql);
	  	 $num=mysql_num_rows($sql);
		 
		if ($num==0) bloquerAcces('Aucun palmarès ne correspond à cet identifiant');
	   
		//---- On cré la Line-Up ----//
		$meta_lineup="";
		for ($i=1; $i<=6; $i++) {
		
			// Si le membre est relié au site :
			if (is_numeric($d->{j.$i})) {
				$sqlD=mysql_query("SELECT m.pseudo, m.last_activity, md.gen_pays, md.gen_sexe, md.avatar
								  FROM ".PREFIX."membres m 
								  LEFT JOIN ".PREFIX."membres_detail md
								  ON md.id_membre=".$d->{j.$i}."
								  WHERE m.id=".$d->{j.$i});
				$m=mysql_fetch_object($sqlD);
				
				$sexe=' <img src="images/'.imgOnline($m->gen_sexe, $m->last_activity).'" />';
				if (file_exists(CHEMIN_PAYS.$m->gen_pays.".gif")) $pays='<img src="'.CHEMIN_PAYS.$m->gen_pays.'.gif" /> ';
				
				@$lineup.='<a href="profil/'.recode(recupBdd($m->pseudo)).'/" style="font-size:13px">'.@$pays.ucfirst(recupBdd($m->pseudo)).$sexe.'</a><br />';
				$meta_lineup.=ucfirst(recupBdd($m->pseudo)).', ';
			}
			else
			{
				@$lineup.='<span style="font-size:13px">'.ucfirst(recupBdd($d->{j.$i})).'</span><br />';
				$meta_lineup.=ucfirst(recupBdd($d->{j.$i})).', ';
			}
		}

		//---- 1er/2eme ou 3eme : résultat en gras ----//
			if ($d->place=="1er" || $d->place=="2nd" || $d->place=="3eme") $place="<strong>".$d->place."</strong> ";
			else	$place=$d->place;

			if ($d->place=="1er") 		$place.='<img src="images/gold.gif" style="vertical-align:middle">';
			elseif  ($d->place=="2nd") 	$place.='<img src="images/silver.gif" style="vertical-align:middle">';
			elseif ($d->place=="3eme") 	$place.='<img src="images/bronze.gif" style="vertical-align:middle">';


		
		//---- Link vers le site adverse ? ----//
		if (!empty($d->site)) $nom='<a href="'.recupBdd($d->site).'" target="_blank" class="award_col_nom">'.recupBdd($d->nom).'</a>';
								else	 $nom=recupBdd($d->nom);


	   $c='<div id="retour"><a href="awards/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>

	  
			<br /><div class="titreMessagerie">
					Palmarès '.NOM.' '.$d->date.'
				</div><br /><br /><br />

		   
		   <div class="award_col1">
		   	<b>Informations sur le palmarès</b>
			
				<ul id="liste_perso" >
					<li><em>Classement</em> <dfn><strong>'.$place.'</strong></dfn></li>
					<li><em>Nom</em> <dfn>'.$nom.'</dfn></li>
					<li><em>Date</em> <dfn>'.@strftime("%A %d %B %Y", @mktime(0, 0, 0, $d->mois , $d->jour, $d->annee)).'</dfn></li>
					<li><em>Pays</em> <dfn><img src="'.CHEMIN_PAYS.recupBdd($d->pays).'.gif" alt="'.recupBdd($d->pays).'" style="vertical-align:middle" /> '.recupBdd($d->pays).'</dfn></li>
				</ul>
		   </div>
		   
		   <div class="award_col2">
				<strong>Line-Up</strong><br /><br />
		   		'.$lineup.'
		   </div>
		   
		   <div class="clear"></div>
		   
		   <div class="award_col3">
		   	<b>Détails sur le palmarès</b><br /><br />
				<p style="margin-left:10px; width:500px">'.nl2br(recupBdd($d->detail)).'</p>
		   </div>
		   
		   <br /><br />';	
		   	   
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Palmarès : '.recupBdd($d->nom));
	$design->zone('titre', 'Palmarès de la team '.NOM);
	metatag('Palmarès '.recupBdd($d->nom).', '.$d->place.' le '.@strftime("%A %d %B %Y", @mktime(0, 0, 0, $d->mois , $d->jour, $d->annee)).' de la team '.NOM.'. Lineup : '.$meta_lineup, 
			$meta_lineup.' awards, récompenses, résultats, '.recupBdd($d->nom));

}


?>
