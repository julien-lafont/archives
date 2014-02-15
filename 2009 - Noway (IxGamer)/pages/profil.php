<?php
/**
 * Module Profil
 * Affiche le profil complet d'un membre
 *
 * Url : /profil/Nom_Du_Membre/
 */

$design->template('profil');
$header='<script type="text/javascript" src="javascript/-profil.js" ></script>';

// Affiche une page avec toutes les membres
if (empty($_GET['pseudo']))
{
	
	$contenu="<div class='titreMessagerie'>Liste de nos membres</div>
				<ul id='liste_perso' style='margin:15px 0 0 50px;'>";
				
	$sql=mysql_query("	SELECT m.pseudo, m.last_activity, md.gen_pays, md.gen_sexe 
						FROM ".PREFIX."membres m
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id");
	while ($d=mysql_fetch_object($sql))
	{
		$img=imgOnline($d->gen_sexe, $d->last_activity);
		$contenu.='<li><img src="'.CHEMIN_PAYS.$d->gen_pays.'.gif" alt="'.$d->gen_pays.'" /> <a href="profil/'.$d->pseudo.'/">'.ucfirst(recupBdd($d->pseudo)).'</a> <img src="images/'.$img.'" /> </li>';

	}
	
	$contenu.="</ul>";
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Liste des membres');
	$design->template('simple');
	$design->afficher();
	die();
}

//:: Sélections des données :://
$sqlMembre = mysql_query("SELECT id, last_activity FROM ".PREFIX."membres WHERE pseudo='".addBdd(strtolower($_GET['pseudo']))."'");
	$membre=mysql_fetch_object($sqlMembre);	
	$id = $membre->id;
	
	// Le membre existe ?
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
						'gen_date_naiss' => 'Age', 
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
				if ($value=='Age') { $details[$key]=age(inverser_date($details[$key], 2), '-').' ans'; }
			$general.='<li class="'.$class.'"><strong>'.$value.'</strong> <span class="rightNormal">'.ucfirst(recupBdd($details[$key])).'</span></li>';
			$i++;
		}
	}
		($i%2==0) ? $class="a" : $class="b";
		// Online ou non ? + Dernière connexion
		if (time()>=$d->last_activity && time()<=($membre->last_activity+5*60) ) {
			$general.='<li class="'.$class.'" style="text-align:center"><strong style="font-variant:small-caps; color:#00A8FF; font-size:11px">ONLINE</strong></li>';
		} else {
			$general.='<li class="'.$class.'"><strong>Dernière connexion</strong> <span class="rightNormal">'.difference_date($membre->last_activity).'</span></li>';
		}
	$design->zone('li_general', $general);

	//-- Software --//
	$software=""; $i=0;
	foreach($labelS as $key=>$value)
	{
		if (!empty($details[$key])) {
			($i%2==0) ? $class="a" : $class="b";
			$software.='<li class="'.$class.'"><strong>'.$value.'</strong> <span class="rightNormal">'.recupBdd($details[$key]).'</span></li>';
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
			$hardware.='<li class="'.$class.'"><strong>'.$value.'</strong> <span class="rightNormal">'.recupBdd($details[$key]).'</span></li>';
			$i++;
		}
	}
	if (empty($hardware)) $hardware="<br /><center>Description hardware vide</center><br />";
	$design->zone('li_hardware', $hardware);

	//-- Contact --//
	$contact=''; $nbContact=0;
	foreach($labelC as  $key=>$value)
	{
		if (!empty($details[$key])) {
			switch ($key)
			{
				case "c_msn":
				 $contact.='<img src="'.URL.'images/profil/msn.png" id="msn" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Adresse MSN '.recupBdd($details[$key]).' (<b>click</b>)\')" onmouseout="tooltip.hide(this)" onclick="$(\'#temp_contact\').css(\'display\',\'inline\'); $(\'#temp_contact\').val(\''.recupBdd($details[$key]).'\')" /> Msn &nbsp; &nbsp; &nbsp; ';				
				break;
				case "c_irc":
				 $contact.='<img src="'.URL.'images/profil/mirc.png" id="irc" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Channel irc : '.recupBdd($details[$key]).' (<b>click</b>)\')" onmouseout="tooltip.hide(this)" onclick="$(\'#temp_contact\').css(\'display\',\'inline\'); $(\'#temp_contact\').val(\''.recupBdd($details[$key]).'\')"/> Irc &nbsp; &nbsp; &nbsp; ';
				break;
				case "c_site":
				 $contact.='<a href="'.recupBdd($details[$key]).'" target="_blank"><img src="'.URL.'images/profil/site.png" id="site" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Site internet : '.recupBdd($details[$key]).'\');" onmouseout="tooltip.hide(this)" /></a> Site &nbsp; &nbsp; &nbsp; ';
				break;
				case "c_blog":
				 $contact.='<a href="'.recupBdd($details[$key]).'" target="_blank"><img src="'.URL.'images/profil/blog.png" id="blog" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Mon blog : '.recupBdd($details[$key]).'\');" onmouseout="tooltip.hide(this)" /></a> Blog &nbsp; &nbsp; &nbsp; ';
				break;
			}
			$nbContact++;
		}
		if ($nbContact==2) $contact.="<br /><br />";
	}
	$contact.='<br /><input type="text" id="temp_contact" style="margin-top:15px"/><br />';
	$design->zone('contact', $contact);
	
	
	//----- Actions -----//
	$nbActions=0;	
		//-> Si l'utilisateur est connecté
	if (is_log())
	{
		//.... Envoyer un message ....//
		if ($id!=$_SESSION['sess_id']) {
			$envoyerMessage='<a href="#" onclick="afficherFormMessage(); return false;"><img src="'.URL.'images/profil/message2.png" id="imgMessage" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Envoyer un message à '.ucfirst($_GET['pseudo']).'\');" onmouseout="tooltip.hide(this)" /></a>';
			$envoyerMessageTxt='Envoyer message';
			
		}
		
		//.... Ajouter à mes amis ....//
		$sqlA=mysql_query("SELECT amis FROM ".PREFIX."membres_detail WHERE id_membre=".$_SESSION['sess_id']);
		$tempA=mysql_fetch_object($sqlA);
		$amis=explode('-', $tempA->amis);
		if (!in_array($_SESSION['sess_id'], $amis) && $id!=$_SESSION['sess_id']) { 
			$ajouterAmi='<a href="#" onclick="ajouterAmi('.$id.'); return false;"><img src="'.URL.'images/profil/ami2.png" id="imgAmi" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Ajouter '.ucfirst($_GET['pseudo']).' à ma liste d\\\'amis\');" onmouseout="tooltip.hide(this)" /></a>';
			$ajouterAmiTxt='Ajouter à mes amis';
		}
		
		//.... Voir galerie ....//
		$sqlPhoto=mysql_query("SELECT count(id) as nbPhoto FROM ".PREFIX."galerie WHERE id_membre=$id");
		$photo=mysql_fetch_object($sqlPhoto);
		if ($photo->nbPhoto>0)
		{
			 $voirGalerie='<a href="Galerie-photo/'.$_GET['pseudo'].'/"><img src="'.URL.'images/profil/galerie.png" id="imgGalerie" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Voir la galerie de '.ucfirst($_GET['pseudo']).'\');" onmouseout="tooltip.hide(this)" /></a>';
			 $voirGalerieTxt='Galerie';
		}
		
		//.... Voir Guestbook ....//
		$voirGuestBook='<a href="Guestbook/'.$_GET['pseudo'].'/"><img src="'.URL.'images/profil/livre_or.png" id="imgLivreOr" onmouseover="tooltip.show(this, \'<u>Profil '.$_GET['pseudo'].'</u><br /><br />Voir le livre d\\\'or de '.ucfirst($_GET['pseudo']).'\');" onmouseout="tooltip.hide(this)" /></a>';
		$voirGuestBookTxt='Guestbook';
	
	$actions='<table style="width:100%; border:0">
				<tr>
					<td style="vertical-align:middle;text-align:left">'.$voirGuestBook.'</td>
						<td style="vertical-align:middle; text-align:left">'.$voirGuestBookTxt.'</td>
					<td style="vertical-align:middle;text-align:left; height:60px">'.$voirGalerie.'</td>
						<td style="vertical-align:middle; text-align:left">'.$voirGalerieTxt.'</td>
				</tr>
				<tr>
					<td style="width:70px; text-align:left"><br />'.$envoyerMessage.'</td>
						<td style="width:106px; vertical-align:middle; text-align:left"><br />'.$envoyerMessageTxt.'</td>
					<td style="width:70px; text-align:left"><br />'.$ajouterAmi.'</td>
						<td style="width:101px; vertical-align:middle; text-align:left"><br />'.$ajouterAmiTxt.'</td>
				</tr>
			 </table>
			 
			 <div id="details"></div>';
	}
	//--> Si l'utilisateur n'est pas connecté
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
		$li_amis='<br />';
		foreach($amis as $idAmi)
		{
			$sql=mysql_query("	SELECT m.pseudo, m.last_activity, md.gen_sexe, md.gen_pays
								FROM ".PREFIX."membres m 
								LEFT JOIN ".PREFIX."membres_detail md
								ON m.id=md.id_membre
								WHERE m.id=$idAmi");
			$d=mysql_fetch_object($sql);
			
			$img=imgOnline($d->gen_sexe, $d->last_activity);
			$li_amis.='<li class="'.$class.'"><img src="'.CHEMIN_PAYS.$d->gen_pays.'.gif" alt="'.$d->gen_pays.'" /> <a href="profil/'.$d->pseudo.'/">'.tronquerChaine(ucfirst($d->pseudo),15, "dot").'</a> <img src="images/'.$img.'" /> </li>';
			$i++;
		}
	}
	if (empty($li_amis)) $li_amis="<br /><center style='color:#aaa'>Aucun amis</center><br />";
	$design->zone('li_amis', $li_amis );
	
	
	//-- Visiteurs --//
	$visiteurs=explode('-', $details['visiteurs']);
	$li_visiteurs=""; $i=0;
	if (count($visiteurs)>0 && $visiteurs[0]!="")
	{
		$li_visiteurs='<br />';
		foreach($visiteurs as $idVisiteur)
		{
			if (!empty($idVisiteur))
			{
				$sql=mysql_query("	SELECT m.pseudo, m.last_activity, md.gen_sexe , md.gen_pays
									FROM ".PREFIX."membres m 
									LEFT JOIN ".PREFIX."membres_detail md
									ON m.id=md.id_membre
									WHERE m.id=$idVisiteur") or die(mysql_error());
				$d=mysql_fetch_object($sql);
				
				if (mysql_affected_rows()==1)
				{	
					$img=imgOnline($d->gen_sexe, $d->last_activity);
					$li_visiteurs.='<li class="'.$class.'"><img src="'.CHEMIN_PAYS.$d->gen_pays.'.gif" alt="'.$d->gen_pays.'" /> <a href="profil/'.$d->pseudo.'/">'.tronquerChaine(ucfirst($d->pseudo),15, "dot").'</a> <img src="images/'.$img.'" /> </li>';
					$i++;
				}
			}
		}
	}
	if (empty($li_visiteurs)) $li_visiteurs="<br /><center style='color:#aaa'>Aucun visiteurs</center><br />";
	$li_visiteurs.='<input type="hidden" name="dest_id" id="dest_id" value="'.$id.'" />';
	$design->zone('li_visiteurs', $li_visiteurs ) ;


	//-- Avatar -- //
	if (empty($details['avatar']))	$avatar="no_avatar.gif";
	else							$avatar=$details['avatar'];

	//:: ----- Mini Gallery ----- :://
	$sqlGalerieP=mysql_query("SELECT * FROM ".PREFIX."galerie WHERE id_membre=".$id." ORDER BY id DESC LIMIT 0,6");
	$nbG=mysql_num_rows($sqlGalerieP);
	if ($nbG==0) {
		$design->zone('galerieP', '<span style="color:#666666">Aucune photo</span>');
	} else {
	
		while($gP=mysql_fetch_object($sqlGalerieP)) {
			@$galerieP.='<li style="height:105px"><a href="images/upload/galerie/'.$id.'/'.$gP->img.'" class="thickbox"><img src="pages/fonctions/redim.php?imgfile='.URL.'images/upload/galerie/'.$id.'/min_'.$gP->img.'&max_width=80&max_height=95" class="effect"/></a></li>';
		}
	
		$design->zone('galerieP', $galerieP);
		
		$header.='	
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#mycarousel").jcarousel({ 
					 itemVisible:2,
					 itemScroll: 1,
					 buttonNextHTML:\'<a href="#" id="mini_galerie_droite" onclick="return false"><img src="images/mid_fleche_droite.png" class="jcarousel-next"/></a>\',
					 buttonPrevHTML:\'<a href="#" id="mini_galerie_gauche" onclick="return false"><img src="images/mid_fleche_gauche.png" class="jcarousel-prev"/></a>\'	 
					});
				});
			</script>';
		

	}
	
	//:: ----- Description ----- :://
	if (empty($details['description'])) 
		$description="Le silence est roi";
	else
		$description=$details['description'];
		
	//:: ----- Général avec infos ----- :://
	$gen='<table class="profil_top">
			<tr>
				<td class="aa">
					<img src="images/upload/avatar/'.$avatar.'" alt="avatar" class="imgAvatar" title="Membre ID ['.$id.']"/>
				</td>
				<td style="width:55px; vertical-align:top"><br /><img src="images/guillemet2.jpg" /></td>
				<td style="vertical-align:middle; text-align:center">'.$description.'</td>
				<td style="width:50px; vertical-align:bottom"><img src="images/guillemet1.jpg" /><br />&nbsp;</td>
			</tr>
		  </table>';
		$design->zone('profil_top', $gen );
		
		
		
	//:: ----- Team Perso ----- :://
		// Est leader ?
		$sqlV1=mysql_query("SELECT id FROM ".PREFIX."team_perso WHERE id_leader=".$id);
		$v1=mysql_fetch_object($sqlV1); 
			if (mysql_affected_rows()>0) $idTeam=$v1->id;
		
		// Est membre ?
		$sqlV2=mysql_query("SELECT id_team FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$id);
		$v2=mysql_fetch_object($sqlV2); 
			if (mysql_affected_rows()>0) $idTeam=$v2->id_team;
		
		// Si le membre fait parti d'une team
		if ($idTeam) {
		
				// Infos sur la team
				$sqlInfosTeam=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id=$idTeam");
				$iT=mysql_fetch_object($sqlInfosTeam);
					
					// Link vers le site de la team ? ----//
					$nom='&nbsp;<br /><img src="'.CHEMIN_PAYS.recupBdd($iT->pays).'.gif" alt="'.recupBdd($iT->pays).'" style="vertical-align:middle" /> ';
					$nom.='<a href="'.recupBdd($iT->site).'" target="_blank" style="border-bottom:1px dotted #00A8FF;">'.recupBdd($iT->nom).'</a>';

					
					
				$lineup=$nom.'<br /><br />';


				// Infos sur le leader :
				$sqlL=mysql_query("SELECT m.pseudo, m.last_activity, md.gen_pays, md.gen_sexe, md.avatar
									  FROM ".PREFIX."membres m 
									  LEFT JOIN ".PREFIX."membres_detail md
									  ON md.id_membre=m.id
									  WHERE m.id=".$iT->id_leader);
					$l=mysql_fetch_object($sqlL);
						
						$sexe=' <img src="images/'.imgOnline($l->gen_sexe, $l->last_activity).'" />';
						if (file_exists(CHEMIN_PAYS.$l->gen_pays.".gif")) $pays='<img src="'.CHEMIN_PAYS.$l->gen_pays.'.gif" /> ';
					
					$lineup.='<br /><span style="color:#FF9900; font-size:13px">Leader</span><br />';
					$lineup.='<a href="profil/'.recode(recupBdd($l->pseudo)).'" style="font-size:13px">'.@$pays.ucfirst(recupBdd($l->pseudo)).$sexe.'</a><br /><br />';

			
				// LineUp
				$sqlN=mysql_query("SELECT * FROM ".PREFIX."team_perso_lineup WHERE id_team=$idTeam AND etat=1");
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
								<i style="color:#aaa">'.$m->statut.'</i><br /><br />';
			
				}
		}
		else
		{
			$lineup='&nbsp;<br />
						<span style="color:#ccc">Aucune team</span>';
		}
		$design->zone('team-perso', $lineup);


// Zones en + 
$design->zone('pseudo', ucfirst(recupBdd($_GET['pseudo'])) ) ;
	
$design->zone('titrePage', 'Profil '.NOM.' de '.ucfirst(recupBdd($_GET['pseudo'])) );
$design->zone('titre', 'Infos sur le membre '.ucfirst(recupBdd($_GET['pseudo'])) );
$design->zone('header', $header);

?>