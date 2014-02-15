<?php

/*  ---------------------------------------------------------------------------------------------------------------
	  Version Accés direct ( no ajax ) des actions sur les thèmes :
	    -> Afficher une nouvelle catégorie de thème avec le premier duel choisi au hasard
		-> Voter pr un duel 'type thème'
    --------------------------------------------------------------------------------------------------------------- */

switch(@$_GET['act']) {

case "afficher":

	$idTheme=(int)$_GET['id'];
	
	// On récupère toutes les photos de la catégorie
	$sqlListe=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id_theme=$idTheme ORDER BY nb_votes DESC");
	
		$i=1;
		// On prépare la liste
		while ($l=mysql_fetch_object($sqlListe)) {
			if ($l->nb_votes<2)  $vote=$l->nb_votes.' vote';
			else				 $vote=$l->nb_votes.' votes';
			
			if ($i==1)  $refresh="<a href='".$_SERVER['REQUEST_URI']."' onclick='maj_liste_theme(); return false' title='Mettre à jour le classement des thèmes'><img src='images/recur.png' style='float:right; margin-top:-15px'/></a>";
			else 		$refresh='';
			$liste.='<li style="color:#666"><span style="font-weight:bold">'.$i.'</span><a href="?theme_photo&id='.$l->id.'" onclick="Modalbox.show(this.title, this.href, {height:350 }); return false" title="Afficher la photo : '.recupBdd($l->nom).'">'.recupBdd($l->nom).'</a></div> &nbsp;&nbsp;<span>'.$vote.'</span>'.$refresh.'</li>';
			$i++;
		}
		
	// On récupère vite fait le nom du thème :
		$sqlTh=mysql_query("SELECT nom FROM ".PREFIX."themes WHERE id=$idTheme");
		$th=mysql_fetch_object($sqlTh);
		$nomTheme=recupBdd($th->nom);
		
		
		
	// On sélectionne deux images au hasard dans la catégorie
	$i=0;
	do { // On répète si l'utilisateur a déjà voté pr les deux images
		if ($i==50) exit('Erreur détectée ! Merci de revenir sur la page principale du site !');
		
		$sql=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id_theme=$idTheme ORDER BY rand() LIMIT 0,2") or die(mysql_error());
			
			//-- On s'occupe de la première image	
			$d=mysql_fetch_object($sql);
				$id1=$d->id;	
				$nom1=recupBdd($d->nom);
				$img1=recupBdd($d->img);
				$vote1=$d->nb_votes;
	
			//-- On s'occupe de la première image	
			$d=mysql_fetch_object($sql);
				$id2=$d->id;
				$nom2=recupBdd($d->nom);
				$img2=recupBdd($d->img);
				$vote2=$d->nb_votes;
	
			//-- Calcul des pourcentages
			$note1=round((100*$vote1)/($vote1+$vote2),1);
			$note2=round((100*$vote2)/($vote1+$vote2),1);
			
			//-- Vérification déjà voté
			$sqlVerif=mysql_query("SELECT id FROM ".PREFIX."themes_verif WHERE (idphoto=$id1 || idphoto=$id2) AND ip='".ip()."'");
			$nb=mysql_num_rows($sqlVerif);
	
		$i++;		
	} while ($nb==2);

			
			$image1 = '<div id="image1"><a id="lien1" href="theme-'.recode(recupBdd($th->nom)).'-voter_pour_'.recode(recupBdd($nom1)).'-'.$id1.'-'.$idTheme.'.htm" title="Voter pour '.recupBdd($nom1).' dans le thème '.recupBdd($th->nom).' sur Faistonchoix.fr" onclick="voterDuelTheme('.$idTheme.','.$id1.','.$id2.',1); return false">
						<img id="img1" src="'.PHOTO.$img1.'" style="z-index:10" />
						<div id="etoile1" style="display:none"><img src="images/star.png" alt="star" /></div>
						</a></div>
						<img id="waitImg1" src="images/loader_blue.gif" class="waitImg" style="display:none" alt="load"/>
				
						<br /><b id="nom1">'.recupBdd($nom1).'</b><br />
						
						<div class="barre_pourcentage" id="fond-barre1">
							<div id="barre1" style="width:'.$note1.'%" class="barre_couleur">
								<span class="nombre_pourcentage" id="pourcentage1">'.$note1.' %</span>
							</div>
						</div>';

	
			$image2 = '<div id="image2"><a id="lien2" href="voter_pour_'.recode(recupBdd($nom2)).'-'.$id2.'-'.$idTheme.'.htm" title="Voter pour '.recupBdd($nom2).' dans le thème '.recupBdd($th->nom).' sur Faistonchoix.fr" onclick="voterDuelTheme('.$idTheme.', '.$id2.','.$id1.',2); return false">
						<img id="img2" src="'.PHOTO.$img2.'" style="z-index:10" />
						<div id="etoile2" style="display:none"><img src="images/star.png" alt="star" /></div>
						</a></div>
					
						<img id="waitImg2" src="images/loader_blue.gif" class="waitImg" style="display:none" alt="load"/>
				
						<br /><b id="nom2">'.recupBdd($nom2).'</b><br />
						
						<div class="barre_pourcentage" id="fond-barre2">
							<div id="barre2" style="width:'.$note2.'%" class="barre_couleur">
								<span class="nombre_pourcentage" id="pourcentage2">'.$note2.' %</span>
						</div>
						</div>';

		$design->zone('interImage1', $image1);
		$design->zone('interImage2', $image2 );
		
		// no-jvs users : Duel précédent :
		$design->zone('fleche_gauche', '<div id="fleche_gauche"><a id="lienFlG" href=""><img id="imgFlG" name="flG" src="theme/images/gauche.png" /></a></div>');
		$design->zone('fleche_droite', '<div id="fleche_droite"><a id="lienFlD" href=""><img id="imgFlD" name="flD" src="theme/images/droite.png" /></a></div>');
		
		$design->zone('derniers_duels','<h3 id="nom_cat2">Theme : '.recupBdd($th->nom).'</h3>	
						<ul id="liste_duels" style="height:228px; overflow:auto">'.$liste.'</ul>');


break;
###########################################################################################################################
###########################################################################################################################
case "voter":

	$idGagnant=(int)$_GET['idPhoto']; 
	$idTheme=(int)$_GET['idTheme']; 
	
	$ip=ip();
	
	// On ajouter le vote
	$sqlMaj=mysql_query("UPDATE ".PREFIX."themes_photos SET nb_votes=nb_votes+1 WHERE id=$idGagnant");
	
	// On ajoute dans la table de vérification
	$sqlAddVerif=mysql_query("INSERT INTO ".PREFIX."themes_verif (`idphoto`,`ip`, `date`) VALUES ('$idGagnant','$ip', NOW() )");
	
	// Si il est loggé on ajoute les points
	if ($_SESSION['log_id'])
		$sqlUpdPoints=mysql_query("UPDATE ".PREFIX."membres SET nb_votes=nb_votes+1, points=points+".PT_VOTE." WHERE email='".$_SESSION['log_email']."'");

	// On récupère vite fait le nom du thème :
		$sqlTh=mysql_query("SELECT nom FROM ".PREFIX."themes WHERE id=$idTheme");
		$th=mysql_fetch_object($sqlTh);
		$nomTheme=recupBdd($th->nom);

	header('location: theme-'.recode($nomTheme).'-'.$idTheme.'.htm');
	
break;
default:
	exit("Accés interdit");
break;
}

?>