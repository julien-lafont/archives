<?php
	
	// Infos principales sur la team
	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id=$id");
		$d=mysql_fetch_object($sql);
		
	// Infos sur le leader :
	$sqlL=mysql_query("SELECT m.pseudo, m.last_activity, md.gen_pays, md.gen_sexe, md.avatar
						  FROM ".PREFIX."membres m 
						  LEFT JOIN ".PREFIX."membres_detail md
						  ON md.id_membre=m.id
						  WHERE m.id=".$d->id_leader);
		$l=mysql_fetch_object($sqlL);
			
			$sexe=' <img src="images/'.imgOnline($l->gen_sexe, $l->last_activity).'" />';
			if (file_exists(CHEMIN_PAYS.$l->gen_pays.".gif")) $pays='<img src="'.CHEMIN_PAYS.$l->gen_pays.'.gif" /> ';
		$leader='<a href="profil/'.recode(recupBdd($l->pseudo)).'" style="font-size:13px">'.@$pays.ucfirst(recupBdd($l->pseudo)).$sexe.'</a><br />';

	
	// LineUp : nombres de membres :
	$sqlN=mysql_query("SELECT * FROM ".PREFIX."team_perso_lineup WHERE id_team=$id AND etat=1");
		$nb=round(mysql_num_rows($sql));
	
	while($m=mysql_fetch_object($sqlN)) {
		
		$sqlD=mysql_query("SELECT m.pseudo, m.last_activity, md.gen_pays, md.gen_sexe, md.avatar
						  FROM ".PREFIX."membres m 
						  LEFT JOIN ".PREFIX."membres_detail md
						  ON md.id_membre=m.id
						  WHERE m.id=".$m->id_membre);
		$n=mysql_fetch_object($sqlD);
		
		$sexe=' <img src="images/'.imgOnline($n->gen_sexe, $n->last_activity).'" />';
		if (file_exists(CHEMIN_PAYS.$n->gen_pays.".gif")) $pays='<img src="'.CHEMIN_PAYS.$n->gen_pays.'.gif" /> ';
		
		@$lineup.='<a href="profil/'.recode(recupBdd($n->pseudo)).'/" style="font-size:13px">'.@$pays.ucfirst(recupBdd($n->pseudo)).$sexe.'</a><br />
					<i>'.$m->statut.'</i><br /><br />';

	}
	
	//---- Link vers le site de la team ? ----//
	if (!empty($d->site)) $nom='<a href="'.recupBdd($d->site).'" target="_blank">'.recupBdd($d->nom).'</a>';
								else	 $nom=recupBdd($d->nom);

	//---- Mise en forme générale
	$c='<div class="titreMessagerie">
					Infos sur la team '.recupBdd($d->nom).' <img src="'.CHEMIN_PAYS.recupBdd($d->pays).'.gif" style="vertical-align:middle" />
		</div><br /><br /><br />

		   <div style="float:right;  margin:0 25px 25px 25px; width:150px;">
		   		
				<div style="background-color:#F9F9F9; border:1px solid #ddd; padding:5px 5px 5px 5px; line-height:20px;">
					<center><strong>Infos</strong></center>
					<span style="color:#000">Nom  :&nbsp;</span> '.$nom.'<br />
					<span style="color:#000">Pays :&nbsp;</span> <img src="'.CHEMIN_PAYS.recupBdd($d->pays).'.gif" alt="'.recupBdd($d->pays).'" style="vertical-align:middle" /> '.recupBdd($d->pays).'
					<span style="color:#000">Leader :&nbsp;</span> '.ucfirst($l->pseudo).'</span>
				</div>

				<div style="background-color:#F4F4F4; border:1px solid #ccc; padding:5px 5px 0 5px; text-align:center; line-height:14px;  margin:20px 0 0 0 ">
					<strong>Line-Up</strong><br /><br />
					<span style="color:#0099FF; font-size:13px">Leader</span><br />
					'.$leader.'<br /><br />
					
					'.$lineup.'
				</div>
	
		   </div>
		   
		   <div style="margin:0 0 0 25px">'.bbcode(nl2br(stripslashes($d->description))).'</div>';

	
	
	
		
	$design->zone('titrePage', 'Team '.recupBdd($d->nom).' - Leader : '.$l->pseudo.' - '.$nb.' membres');
	$design->zone('contenu', $c);


?>