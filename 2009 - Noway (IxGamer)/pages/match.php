<?php

//::::: Page principale ::::://
if (empty($_GET['id']))
{

	
	$c='<div class="titreMessagerie">Résultats de la team '.NOM.'</div>';
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."war ORDER BY date DESC");
	$nb=mysql_affected_rows();
	if ($nb==0) $c.='<br \><center>Aucun match disponible</center><br /><br />';
	
	else
	{
		$c.='<table id="listeMedias" cellspacing="0" cellpadding="0" style="width:550px; margin:0 auto">
				<tr>
					<td class="top" style="width:100px">Date</td>
					<td class="top" style="width:250px" colspan="3">Infos sur le match</td>
					<td class="top" style="width:150px; text-align:center">Score</td>
					<td class="top" style="width:50px; text-align:center">Fiche</td>
				</tr>';
		while ($d=mysql_fetch_object($sql)) 
		{
		
	    	if ($d->scoret<$d->scoreadv)  { $class="lose"; @$perdu++; $terme="perdant"; }
			if ($d->scoret>$d->scoreadv)  { $class="win"; @$gagne++; $terme="vainqueur"; }
			if ($d->scoret==$d->scoreadv) { $class="egal"; @$egalite++; $terme="ex-aequo"; }
			
			if (!empty($d->adversaire_site)) $site='<a href="'.recupBdd($d->adversaire_site).'" target="_blank"><img src="images/boutons/url2.png" /></a>';
			else							 $site='';
			
			$c.='<tr class="in">
					<td style="font-size:9px">'.inverser_date($d->date).'</td>
					<td style="width:70px"><img src="'.CHEMIN_JEU.recupBdd($d->jeu).'.png" alt="'.recupBdd($d->jeu).'" style="vertical-align:middle"/> '.NOM.'</td>
					<td style="width:32px"><span class="match_vs">vs</span></td>
					<td style="width:148px"><img src="'.CHEMIN_PAYS.recupBdd($d->nata).'.gif" alt="'.recupBdd($d->nata).'" style="vertical-align:middle" /> '.recupBdd($d->adversaire).'</td>
					<td style="text-align:center"><strong class="'.$class.'" style="font-size:12px">'.recupBdd($d->scoret).' - '.recupBdd($d->scoreadv).'</strong><br />
						<span style="color:#999; font-size:10px">'.recupBdd($d->style).'</span></td>
					<td style="padding-left:3px; text-align:center"><a href="results/match-'.$d->id.'-'.recode(NOM).'-'.$terme.'-contre-'.recode(recupBdd($d->adversaire)).'.htm" title="Match contre : '.recupBdd($d->adversaire).'"><center><img src="images/boutons/folder_blue.png" /></a></td>
				 </tr>';
		}
		$c.='</table><br /><br /><center><b><font color="#52C174">'.round($gagne).'</font> matchs gagnés, <font color="#3A37CE">'.round($egalite).'</font> matchs ex-aequo et <font color="#E71B1B">'.round($perdu).'</font> matchs perdus.</b></center>';
	}
				
	
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Matchs');
	$design->zone('titre', 'Matchs de la team '.NOM);

}
else //::::: Fiche détaillée ::::://
{

	   $id=(int)$_GET['id'];
	   
	   $sql=mysql_query("SELECT * FROM ".PREFIX."war WHERE id='$id'");
	   $d=mysql_fetch_object($sql);
	  	 $num=mysql_num_rows($sql);
		 
		if ($num==0) bloquerAcces('Aucun match ne correspond à cet identifiant');
	   
		//---- On cré la Line-Up ----//
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
			}
			else
			{
				@$lineup.='<span style="font-size:13px">'.ucfirst(recupBdd($d->{j.$i})).'</span><br />';
			}
		}

		//---- Gestion du score ----//
	    	if ($d->scoret<$d->scoreadv)  { $class="lose"; @$perdu++; $terme="perdant"; }
			if ($d->scoret>$d->scoreadv)  { $class="win"; @$gagne++; $terme="vainqueur"; }
			if ($d->scoret==$d->scoreadv) { $class="egal"; @$egalite++; $terme="ex-aequo"; }

		
	   	//---- Gestion des maps ----//
		
		// ::  Deux maps :: //
		if (!empty($d->map) && !empty($d->map2)) { 
			
			if (is_file(CHEMIN_MAPS.strtolower(recupBdd($d->map)).".jpg")) $imgMap1='<img src="'.CHEMIN_MAPS.strtolower(recupBdd($d->map)).'.jpg" alt="'.recupBdd($d->map).'" class="effect" />';
																	else   $imgMap1='<img src="'.CHEMIN_MAPS.'inconnu_cs.jpg" alt="'.recupBdd($d->map).'" class="effect" />';
			if (is_file(CHEMIN_MAPS.strtolower(recupBdd($d->map2)).".jpg")) $imgMap2='<img src="'.CHEMIN_MAPS.strtolower(recupBdd($d->map2)).'.jpg" alt="'.recupBdd($d->map2).'" class="effect" />';
																	else   $imgMap2='<img src="'.CHEMIN_MAPS.'inconnu_cs.jpg" alt="'.recupBdd($d->map2).'" class="effect" />';

			$maps='<table style="width:90%; margin:0 auto" align="center">
					<tr>
						<td style="width:33%; text-align:center; height:25px;"><strong style="font-size:13px">'.recupBdd($d->map).'</strong></td>
						<td style="width:33%" rowspan="2">
						<div style="width:70%;height:135px; margin:10px auto; background-color:#F4F4F4; border:1px solid #ccc; padding:5px 5px 0 5px; text-align:center; line-height:18px">
								<strong>Line-Up</strong><br /><br />'.$lineup.'
							</div>
						</td>
						<td style="width:33%; text-align:center"><strong style="font-size:13px">'.recupBdd($d->map2).'</strong></td>
					</tr>
					<tr>
						<td style="text-align:center; vertical-align:top">'.$imgMap1.'</td>
						<td style="text-align:center; vertical-align:top">'.$imgMap2.'</td>
					</tr>
				  </table>';
		}
		// :: Une seule map :: //
		elseif(!empty($d->map) || !empty($d->map2)) {
		
			(empty($d->map)) ? $map=$d->map2 : $map=$d->map;
			
			if (is_file(CHEMIN_MAPS.strtolower(recupBdd($map)).".jpg")) $imgMap1='<img src="'.CHEMIN_MAPS.strtolower(recupBdd($map)).'.jpg" alt="'.recupBdd($d->map).'" class="effect" />';
																	else   $imgMap1='<img src="'.CHEMIN_MAPS.'inconnu_cs.jpg" alt="'.recupBdd($map).'" class="effect" />';
																	
			$maps='<table style="width:90%; margin:0 auto" align="center">
					<tr>
						<td style="width:50%; text-align:center; height:25px;"><strong style="font-size:13px">'.recupBdd($map).'</strong></td>
						<td style="width:50%" rowspan="2">
						<div style="width:50%;height:135px; margin:10px auto; background-color:#F4F4F4; border:1px solid #ccc; padding:5px 5px 0 5px; text-align:center; line-height:18px">
								<strong>Line-Up</strong><br /><br />'.$lineup.'
							</div>
						</td>
					</tr>
					<tr>
						<td style="text-align:center; vertical-align:top">'.$imgMap1.'</td>
					</tr>
				  </table>';

		}
		// :: Aucune map configurée :: //
		else if (empty($d->map)  && empty($d->map2)) {
			
			$maps='<table style="width:90%; margin:0 auto" align="center">
					<tr>
						<div style="width:20%;height:135px; margin:10px auto; background-color:#F4F4F4; border:1px solid #ccc; padding:5px 5px 0 5px; text-align:center; line-height:18px">
								<strong>Line-Up</strong><br /><br />'.$lineup.'
							</div>
						</td>
					</tr>
					<tr>
					</tr>
				  </table>';
		
		
		}
		
		// Link vers le site adverse ?
		if (!empty($d->adversaire_site)) $adversaire='<a href="'.recupBdd($d->adversaire_site).'" target="_blank" style="border-bottom:1px dotted #00A8FF;">'.recupBdd($d->adversaire).'</a>';
								else	 $adversaire=recupBdd($d->adversaire);

		// Fichié attaché au match ?
		if (!empty($d->url)) $fichier='<a href="'.recupBdd($d->url).'" target="_blank"><img src="images/boutons/attach.png" alt="Fichier" /></a>';
					else	 $fichier='<span style="color:#999">Aucun</span>';
		
		if (empty($d->resume)) $resume="Aucun résumé";
		else				   $resume=nl2br(recupBdd($d->resume));
	   $c='<div id="retour"><a href="results/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>

	  
			<br /><div class="titreMessagerie">
				Fiche : '.NOM.' <img src="'.CHEMIN_JEU.recupBdd($d->jeu).'.png" alt="'.recupBdd($d->jeu).'" style="vertical-align:middle"/> 
				<span class="match_vs">vs</span>
				<img src="'.CHEMIN_PAYS.recupBdd($d->nata).'.gif" alt="'.recupBdd($d->nata).'" style="vertical-align:middle" /> '.recupBdd($d->adversaire).'
				</div><br />
				
		   '.$maps.'
		   
		   <div class="war_col1">
		   	<b>Informations sur le match</b>
			
				<ul id="liste_perso" >
					<li><em>Score</em> <dfn class="'.$class.'" style="font-size:14px"><b class="'.$class.'">'.$d->scoret.'</b> : '.$d->scoreadv.'</dfn></li>
					<li><em>Adversaire</em> <dfn>'.$adversaire.'</dfn></li>
					<li><em>Pays</em> <dfn><img src="'.CHEMIN_PAYS.recupBdd($d->nata).'.gif" alt="'.recupBdd($d->nata).'" style="vertical-align:middle" /> '.recupBdd($d->nata).'</dfn></li>
					<li><em>Style</em> <dfn>'.recupBdd($d->style).' en '.recupBdd($d->type).'</dfn></li>
					<li><em>Fichier attaché</em> <dfn>'.$fichier.'</dfn></li> 
				</ul>
		   </div>
		   
		   <div class="war_col2">
		   	<b>Résumé du match</b><br /><br />
				<p style="margin-left:10px; width:330px">'.$resume.'</p>
		   </div>
		   
		   <div class="clear"></div>
		   <br /><br />
		   
		   ';	
		   	   
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Matchs');
	$design->zone('titre', 'Matchs de la team '.NOM);

}






?>