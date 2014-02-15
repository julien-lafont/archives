<?php

/*  ---------------------------------------------------------------------------------------------------------------
	  Version Accés direct ( no ajax ) des actions sur les duels :
	    -> Changer le duel via l'id
		-> Voter pour un duel particulier
    --------------------------------------------------------------------------------------------------------------- */

switch(@$_GET['act']) {

case "afficher":

	$id=(int)$_GET['id'];

	// Sélection du duel défini
	$sqlChoixDuel=mysql_query("SELECT * FROM ".PREFIX."duels WHERE id='$id'");
	$d=mysql_fetch_object($sqlChoixDuel);
	$nb=mysql_num_rows($sqlChoixDuel);
		
		if ($nb==0) { 
			$design->template('simple'); 
			$design->zone('contenu', miseEnForme('message', "Le duel que vous essayer d'atteindre ne semble plus exister.")); 
			$design->zone('titre', 'Duel introuvable');
			$design->afficher();
			exit();
		}
	
		// Calcul des pourcentages
		$note1P=round((($d->note1*100)/$d->votestotal),1);
		$note2P=round((($d->note2*100)/$d->votestotal),1);				
		
		// Par défaut les deux images 'étoile' ne sont pas affichées.
		$etoile2="style='display:none'";
		$etoile1="style='display:none'";
		
		// A-t-il déjà voté pour ce duel ?
		if ($_SESSION['log_email']) $where="AND ( ip='".ip()."' OR email='".$_SESSION['log_email']."')";
		else						$where="AND ip='".ip()."'";
		$sqlVerif=mysql_query("SELECT id, vote FROM ".PREFIX."verifduel WHERE id_duel=".$d->id." ".$where);
		$v=mysql_fetch_object($sqlVerif);
		if ($v->id) { 
			$design->zone("statut_vote", "<span style='font-size:10px'>Vous avez déjà voté !</span>"); 
			if ($v->vote==1) $etoile1="";
			if ($v->vote==2) $etoile2="";
		}
		
		// Erreur ?
		if (@$_SESSION['sess_error']=="deja_vote") {
			$design->zone("statut_vote", "<span style='font-size:10px'>Vous ne pouvez pa voter deux fois pour le même duel !</span>"); 
			$d->img2="../../images/doublevote.png";
			$d->img1="../../images/doublevote.png";
			unset($_SESSION['sess_error']);
		}
		
	// Mise en forme du duel	 
	$cadreImg1='<div id="image1" >
					<a id="lien1" href="voter_pour_'.recode(recupBdd($d->nom1)).'-'.$d->id.'-1.htm" title="Vote pour '.recupBdd($d->nom1).' sur Faistonchoix.fr" onclick="voterDuel('.$d->id.',1); return false">
						<img id="img1" src="'.DUEL.recupBdd($d->img1).'" style="z-index:10" />
						<div id="etoile1" '.$etoile1.'><img src="images/star.png" alt="star" /></div>
					</a>
				</div>
				<img id="waitImg1" src="images/loader_blue.gif" class="waitImg" style="display:none" alt="load"/>
				
				<br /><b id="nom1">'.recupBdd($d->nom1).'</b><br />
				
				<div class="barre_pourcentage" id="fond-barre1">
					<div id="barre1" style="width:'.$note1P.'%" class="barre_couleur">
						<span class="nombre_pourcentage" id="pourcentage1">'.$note1P.' %</span>
					</div>
				</div>';
	
	
	$cadreImg2='<div id="image2">
					<a id="lien2" href="voter_pour_'.recode(recupBdd($d->nom2)).'-'.$d->id.'-2.htm" title="Vote pour '.recupBdd($d->nom2).' sur Faistonchoix.fr" onclick="voterDuel('.$d->id.',2); return false">
						<img id="img2" src="'.DUEL.recupBdd($d->img2).'" />
						<div id="etoile2" '.$etoile2.'><img src="images/star.png" alt="star" /></div>
					</a>
				</div>
				<img id="waitImg2" src="images/loader_blue.gif" class="waitImg" style="display:none" alt="load"/>
				
				<br /><b id="nom2">'.recupBdd($d->nom2).'</b><br />
				
				<div class="barre_pourcentage" id="fond-barre2">
					<div id="barre2" style="width:'.$note2P.'%" class="barre_couleur">
						<span class="nombre_pourcentage" id="pourcentage2">'.$note2P.' %</span>
				</div>
				</div>';

	$design->zone('interImage1', $cadreImg1);
	$design->zone('interImage2', $cadreImg2);
	$design->zone('numDuel', $d->id);
	
	// Duel avant ?
	$sqlPrec=mysql_query("SELECT id, nom1, nom2 FROM ".PREFIX."duels WHERE id<".$d->id." ORDER BY id DESC LIMIT 0,1");
	$prec=mysql_fetch_object($sqlPrec);
		if ($prec) $design->zone('fleche_gauche', '<div id="fleche_gauche"><a id="lienFlG" href="duel-'.recode(recupBdd($prec->nom1)).'_ou_'.recode(recupBdd($prec->nom2)).'-'.$prec->id.'.htm" title="Afficher le duel '.recupBdd($prec->nom1).' contre '.recupBdd($prec->nom2).'" onclick="afficher_duel(\'precedent\'); return false"><img src="theme/images/gauche.png" id="imgFlG" name="flG" onMouseOver= "if (document.images) document.flG.src=\'theme/images/gauche_hover.png\';" onMouseOut= "if (document.images) document.flG.src=\'theme/images/gauche.png\';"/></a></div>');
		else $design->zone('fleche_gauche', '<div id="fleche_gauche"><a id="lienFlG" href=""><img id="imgFlG" name="flG" src="theme/images/gauche.png" /></a></div>');

	// Duel aprés ?
	$sqlSuiv=mysql_query("SELECT id, nom1, nom2 FROM ".PREFIX."duels WHERE id>".$d->id." ORDER BY id ASC LIMIT 0,1");
	$suiv=mysql_fetch_object($sqlSuiv);
		if ($suiv) $design->zone('fleche_droite', '<div id="fleche_droite"><a id="lienFlD" href="duel-'.recode(recupBdd($suiv->nom1)).'_ou_'.recode(recupBdd($suiv->nom2)).'-'.$suiv->id.'.htm" title="Afficher le duel '.recupBdd($suiv->nom1).' contre '.recupBdd($suiv->nom2).'"onclick="afficher_duel(\'suivant\'); return false"><img src="theme/images/droite.png"  id="imgFlD" name="flD" onMouseOver= "if (document.images) document.flD.src=\'theme/images/droite_hover.png\';" onMouseOut= "if (document.images) document.flD.src=\'theme/images/droite.png\';"/></a></div>');
		else $design->zone('fleche_droite', '<div id="fleche_droite"><a id="lienFlD" href=""><img id="imgFlD" name="flD" src="theme/images/droite.png" /></a></div>');
	


break;
##############################################################################################################################
##############################################################################################################################
case "voter":

	$idDuel=(int)$_GET['idDuel'];
	$gagnant=(int)$_GET['gagnant'];
	$ip=ip();
	
	// On vérifie que le gars n'a pas déjà voté
	$sqlVerif=mysql_query("SELECT id FROM ".PREFIX."verifduel WHERE id_duel=$idDuel AND ip='".$ip."'");
	$nbVote=mysql_num_rows($sqlVerif);
		if ($nbVote!=0) { 
				
				$sql=mysql_query("SELECT nom1, nom2 FROM ".PREFIX."duels WHERE id='$idDuel'");
				$d=mysql_fetch_object($sql);

			$_SESSION['sess_error']="deja_vote";
			header('location: duel-'.recode(recupBdd($d->nom1)).'_ou_'.recode(recupBdd($d->nom2)).'-'.$idDuel.'.htm');
			exit();
		}
	
	// On vérifie que le duel existe :
	$sqlPre=mysql_query("SELECT nom1 FROM ".PREFIX."duels WHERE id='".$idDuel."'");
	$nb=mysql_num_rows($sqlPre);
		if ($nb==0) {
			$design->template('simple'); 
			$design->zone('contenu', miseEnForme('message', "Le duel pour lequel vous essayer de voter ne semble plus exister.")); 
			$design->zone('titre', 'Duel introuvable');
			$design->afficher();
			exit();

		}
		
	// On ajouter le vote
	if($gagnant==1) $update="note1=note1+1";
	elseif ($gagnant==2) $update="note2=note2+1";
	else exit('error_note');
		$sqlMaj=mysql_query("UPDATE ".PREFIX."duels SET ".$update.", votestotal=votestotal+1 WHERE id=$idDuel");
	
	// On ajoute dans la table de vérification
	$sqlAddVerif=mysql_query("INSERT INTO ".PREFIX."verifduel (`id_duel`,`ip`, `email`, `vote`) VALUES ('$idDuel','$ip', '".$_SESSION['log_email']."','$gagnant')");
	
	// Si il est loggé on ajoute les points
	if ($_SESSION['log_id'])
		$sqlUpdPoints=mysql_query("UPDATE ".PREFIX."membres SET nb_votes=nb_votes+1, points=points+".PT_VOTE." WHERE email='".$_SESSION['log_email']."'");
	
	// On ajoute l'indicateur vote effectué
	$_SESSION['log_vote'][$idDuel]=true;
	
	// On rediriger vers le duel aprés en avoir récupéré le nom
	$sql=mysql_query("SELECT nom1, nom2 FROM ".PREFIX."duels WHERE id='$idDuel'");
	$d=mysql_fetch_object($sql);
	
	header('location: duel-'.recode(recupBdd($d->nom1)).'_ou_'.recode(recupBdd($d->nom2)).'-'.$idDuel.'.htm');

break;

default:
	exit('Accés interdit !');
break;
}

?>