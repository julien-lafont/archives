<?php
$design->template('profil');
$design->zone('header', '<script type="text/javascript" src="include/js/-profil.js" ></script>
						 <script type="text/javascript" src="include/js/-bulle_infos.js" ></script>');

if (empty($_GET['pseudo']))
{
	
	$contenu="<h5 style='font-size:16px; font-weight:bold; color:#00A8FF; text-align:center'>Page de debuggage<br />Affiche tous les membres</h5>
				<ul style='margin:15px 0 0 50px;'>";
				
	$sql=mysql_query("SELECT pseudo FROM ".PREFIX."membres");
	while ($d=mysql_fetch_object($sql))
	{
		$contenu.='<li><a href="profil/'.strtolower($d->pseudo).'/ " >'.ucfirst($d->pseudo).'</a></li>';
	}
	
	$contenu.="</ul>";
	
	$design->zone('contenu', $contenu);
	$design->template('simple');
	$design->afficher();
	die();
}

//:: Sélections des données :://
$sqlMembre = mysql_query("SELECT id, last_activity FROM ".PREFIX."membres WHERE pseudo='".addBdd(strtolower($_GET['pseudo']))."'");
	$membre=mysql_fetch_object($sqlMembre);	
	$id = $membre->id;
	
	$nbPseudo=mysql_affected_rows();
	if ($nbPseudo==0) {	
		bloquerAcces("Le membre que vous avez indiqué n'est pas présent dans notre base de donnée !");
	}

	$sql = mysql_query("SELECT *
						FROM ".PREFIX."membres_detail
						WHERE id_membre=$id");
	$details=mysql_fetch_array($sql, MYSQL_ASSOC) or die(mysql_error());


//:: Nouveau visiteur :://
	if (is_log() && $id!=$_SESSION['sess_id'])
	{
		$listV=explode("-", $details['visiteurs']);
		if (!in_array($_SESSION['sess_id'], $listV))
		{
			// On génère la nouvelle chaine
			$tempTab=array_reverse($listV);
			if (count($listV)>NB_VISITEURS) unset($tempTab[0]); // Pas plus de 20 visiteurs ( voir config )
			array_push($tempTab, $_SESSION['sess_id']);
			$newTab=array_reverse($tempTab);
			$newListV=implode("-", $newTab);
			$newListV=preg_replace('#-$#', '', $newListV);
			$sql=mysql_query("UPDATE ".PREFIX."membres_detail SET visiteurs='$newListV' WHERE id_membre=$id");
		}
	}
	
//:: Définition des champs :://	

	//-- Général --//
	$labelGen = array (	'gen_nom' => 'Nom', 
						'gen_prenom' => 'Prénom', 
						'gen_pays' => 'Pays', 
						'gen_ville' => 'Ville', 
						'gen_date_naiss' => 'Date de naissance', 
						'gen_sexe' => 'Sexe');
	//-- Contact --//
	$labelC = array (	'c_site' => 'Site', 
						'c_blog' => 'Blog', 
						'c_msn' => 'Msn', 
						'c_irc' => 'Irc' );
	//-- Hardware --//
	$labelH = array (	'h_cpu' => 'CPU', 
						'h_ram' => 'Ram', 
						'h_stockage' => 'Stockage', 
						'h_carte_graph' => 'Carte graphique',
						'h_carte_son' => 'Carte son',
						'h_clavier' => 'Clavier', 
						'h_souris' => 'Souris', 
						'h_moniteur' => 'Moniteur', 
						'h_ecouteur' => 'Ecouteur/HP');
	//-- Software --//	
	$labelS = array (	's_connexion' => 'Connexion', 
						's_fai' => 'FAI',
						's_resolution' => 'Résolution', 
						's_os' => 'OS',
						'g_jeux' => 'Jeux préféré',
						'g_map' => 'Map préférée', 
						'g_arme' => 'Arme préférée',
						'g_sens' => 'Sensibilité', 
						'g_clan' => 'Clan');
						
//:: Mise en place des éléments

	//-- Général --//
	$general=""; $i=0;
	foreach($labelGen as $key=>$value)
	{
		if (!empty($details[$key])) {
			($i%2==0) ? $class="a" : $class="b";
				// Cas du champs sexe :
				if ($value=='Sexe') { ($details[$key]=='f') ? $details[$key]='<img src="'.URL.'images/ico_femme.gif" />' : $details[$key]='<img src="'.URL.'images/ico_homme.gif" />'; }
				// Cas du champs date :
				if ($value=='Date de naissance') { $details[$key]=inverser_date($details[$key]); }
			$general.='<li class="'.$class.'"><strong>'.$value.'</strong> : '.ucfirst(recupBdd($details[$key])).'</li>';
			$i++;
		}
	}
		($i%2==0) ? $class="a" : $class="b";
		// Online ou non ? + Dernière connexion
		if (time()>=$d->last_activity && time()<=($membre->last_activity+5*60) ) {
			$general.='<li class="'.$class.'" style="text-align:center"><strong style="font-variant:small-caps; color:#00A8FF; font-size:11px">ONLINE</strong></li>';
		} else {
			$general.='<li class="'.$class.'"><strong>Dernière connexion</strong> : '.difference_date($membre->last_activity).'</strong></li>';
		}
	$design->zone('li_general', $general);

	//-- Software --//
	$software=""; $i=0;
	foreach($labelS as $key=>$value)
	{
		if (!empty($details[$key])) {
			($i%2==0) ? $class="a" : $class="b";
			$software.='<li class="'.$class.'"><strong>'.$value.'</strong> : '.recupBdd($details[$key]).'</li>';
			$i++;
		}
	}
	if (empty($software)) $software="<br /><center>Description software vide</center>";
	$design->zone('li_software', $software);

	//-- Hardware --//
	$hardware=""; $i=0;
	foreach($labelH as $key=>$value)
	{
		if (!empty($details[$key])) {
			($i%2==0) ? $class="a" : $class="b";
			$hardware.='<li class="'.$class.'"><strong>'.$value.'</strong> : '.recupBdd($details[$key]).'</li>';
			$i++;
		}
	}
	if (empty($hardware)) $hardware="<br /><center>Description hardware vide</center>";
	$design->zone('li_hardware', $hardware);

	//-- Contact --//
	$contact='<div id="curseur" class="infobulle"></div>';
	foreach($labelC as  $key=>$value)
	{
		if (!empty($details[$key])) {
			switch ($key)
			{
				case "c_msn":
				 $contact.='<img src="'.URL.'images/profil/msn.png" alt="Adresse MSN '.recupBdd($details[$key]).' (click)" id="msn" onmouseover="montre(this.id)" onmouseout="cache();" onclick="$(\'temp_contact\').style.display=\'inline\'; $(\'temp_contact\').value=\''.recupBdd($details[$key]).'\'" /> Msn &nbsp;&nbsp;';				
				break;
				case "c_irc":
				 $contact.='<img src="'.URL.'images/profil/mirc.png" alt="Channel irc : '.recupBdd($details[$key]).' (click)" id="irc" onmouseover="montre(this.id)" onmouseout="cache();" onclick="$(\'temp_contact\').style.display=\'inline\'; $(\'temp_contact\').value=\''.recupBdd($details[$key]).'\'"/> Irc &nbsp;&nbsp;';
				break;
				case "c_site":
				 $contact.='<a href="'.recupBdd($details[$key]).'" target="_blank"><img src="'.URL.'images/profil/site.png" alt="Site internet : '.recupBdd($details[$key]).'" id="site" onmouseover="montre(this.id)" onmouseout="cache();" /></a> Site &nbsp;&nbsp;';
				break;
				case "c_blog":
				 $contact.='<a href="'.recupBdd($details[$key]).'" target="_blank"><img src="'.URL.'images/profil/blog.png" alt="Mon blog : '.recupBdd($details[$key]).'" id="blog" onmouseover="montre(this.id)" onmouseout="cache();" /></a> Blog &nbsp;&nbsp;';
				break;
			}
		}
	}
	$contact.='<br /><input type="text" id="temp_contact" /><br />';
	$design->zone('contact', $contact);
	
	
	//-- Actions --//
	if (is_log())
	{
		//.... Envoyer un message ....//
		if ($id!=$_SESSION['sess_id']) 
			$envoyerMessage='<a href="#" onclick="afficherFormMessage(); return false;"><img src="'.URL.'images/profil/message2.png" alt="Envoyer un message à '.ucfirst($_GET['pseudo']).'" id="imgMessage" onmouseover="montre(this.id)" onmouseout="cache()" /></a> &nbsp;&nbsp;&nbsp; ';
		
		//.... Ajouter à mes amis ....//
		$sqlA=mysql_query("SELECT amis FROM ".PREFIX."membres_detail WHERE id_membre=".$_SESSION['sess_id']);
		$tempA=mysql_fetch_object($sqlA);
		$amis=explode('-', $tempA->amis);
		if (!in_array($_SESSION['sess_id'], $amis) && $id!=$_SESSION['sess_id']) { 
			$ajouterAmi='<a href="#" onclick="ajouterAmi('.$id.'); return false;"><img src="'.URL.'images/profil/ami2.png" alt="Ajouter '.ucfirst($_GET['pseudo']).' à ma liste d\'amis" id="imgAmi" onmouseover="montre(this.id)" onmouseout="cache()" /></a> &nbsp;&nbsp;&nbsp; ';
		}
		
		//.... Voir galerie ....//
		$sqlPhoto=mysql_query("SELECT count(id) as nbPhoto FROM ".PREFIX."galerie WHERE id_membre=$id");
		$photo=mysql_fetch_object($sqlPhoto);
		if ($photo->nbPhoto>0)
		{
			 $voirGalerie='<a href="Galerie-photo/'.$_GET['pseudo'].'/"><img src="'.URL.'images/profil/galerie.png" alt="Voir la galerie de '.ucfirst($_GET['pseudo']).'" id="imgGalerie" onmouseover="montre(this.id)" onmouseout="cache()" /></a> &nbsp;&nbsp;&nbsp; ';
		}
		
		//.... Voir Guestbook ....//
		$voirGuestBook='<a href="Guestbook/'.$_GET['pseudo'].'/"><img src="'.URL.'images/profil/livre_or.png" alt="Voir le livre d\'or de '.ucfirst($_GET['pseudo']).'" id="imgLivreOr" onmouseover="montre(this.id)" onmouseout="cache()" /></a>';
	
	$actions='	<div id="actions"><h5>Actions disponibles :</h5>
					<div>
						'.$envoyerMessage.'
						'.$ajouterAmi.'
						'.$voirGalerie.'
						'.$voirGuestBook.'
					</div>
					<div id="details"></div>
				</div>';
	}
	else
	{
		$actions='	<div id="actions"><h5>Actions disponibles :</h5>
					<div style="text-align:center">Vous devez être connecté pour accéder à ces actions.<br /><br />
					<span style="font-size:10px">Vous pourrez ensuite envoyer un message à '.ucfirst($_GET['pseudo']).', voir sa galerie photo, son guestbook, et bien d\'autres choses !</span>
					</div>
				</div>';
	}
	$design->zone('actions', $actions);
	
	//-- Amis --//
	$amis=explode('-', $details['amis']);
	$li_amis=""; $i=0;
	if (count($amis)>0 && $amis[0]!="")
	{
		foreach($amis as $idAmi)
		{
			$sql=mysql_query("	SELECT m.pseudo, m.last_activity, md.gen_sexe 
								FROM ".PREFIX."membres m 
								LEFT JOIN ".PREFIX."membres_detail md
								ON m.id=md.id_membre
								WHERE m.id=$idAmi");
			$d=mysql_fetch_object($sql);
			
			$img=imgOnline($d->gen_sexe, $d->last_activity);
				($i%2==0) ? $class="a" : $class="b";
			$li_amis.='<li class="'.$class.'"><img src="images/'.$img.'" /> <a href="profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a></li>';
			$i++;
		}
	}
	if (empty($li_amis)) $li_amis="<br /><center>Aucun amis</center>";
	$design->zone('li_amis', $li_amis );
	
	
	//-- Visiteurs --//
	$visiteurs=explode('-', $details['visiteurs']);
	$li_visiteurs=""; $i=0;
	if (count($visiteurs)>0 && $visiteurs[0]!="")
	{
		foreach($visiteurs as $idVisiteur)
		{
			if (!empty($idVisiteur))
			{
				$sql=mysql_query("	SELECT m.pseudo, m.last_activity, md.gen_sexe 
									FROM ".PREFIX."membres m 
									LEFT JOIN ".PREFIX."membres_detail md
									ON m.id=md.id_membre
									WHERE m.id=$idVisiteur") or die(mysql_error());
				$d=mysql_fetch_object($sql);
				
				if (mysql_affected_rows()==1)
				{	
					$img=imgOnline($d->gen_sexe, $d->last_activity);
						($i%2==0) ? $class="a" : $class="b";
					$li_visiteurs.='<li class="'.$class.'"><img src="images/'.$img.'" /> <a href="profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a></li>';
					$i++;
				}
			}
		}
	}
	if (empty($li_visiteurs)) $li_visiteurs="<br /><center>Aucun visiteurs</center>";
	$li_visiteurs.='<input type="hidden" name="dest_id" id="dest_id" value="'.$id.'" />';
	$design->zone('li_visiteurs', $li_visiteurs ) ;


	//-- Avatar -- //
	if (empty($details['avatar']))	$avatar="no_avatar.gif";
	else					$avatar=$details['avatar'];
	$design->zone('avatar', "images/avatar/".$avatar );
	

// Zones en + 
$design->zone('pseudo', ucfirst(recupBdd($_GET['pseudo'])) ) ;
	
$design->zone('titrePage', 'Profil D4team.com de '.ucfirst(recupBdd($_GET['pseudo'])) );
$design->zone('titre', 'Infos sur le membre '.ucfirst(recupBdd($_GET['pseudo'])) );


?>