<?php
/*  ---------------------------------------------------------------------------------------------------------------
	  Version ajax des actions sur les thèmes :
	    -> Afficher un nouveau thème et afficher le premier duel ( choisi aléatoirement )
		-> Voter pr un duel 'type thème'
		-> Naviguer dans la liste des photos ( le classement )
    --------------------------------------------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';

//--------------- FONCTION : RETOURNE TOUTES LES INFOS SUR UN NOUVEAU DUEL DANS UN THEME ---------------//
				function theme_nouveau_duel($idTheme) {
					
					// On sélectionne deux images au hasard dans la catégorie
					do { // On répète si l'utilisateur a déjà voté pr les deux images
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
							
					} while ($nb==2);
						
						
					// On prépare la requete Json du Duel
					$json1='var infosDuel = { 
							  "idTheme": \''.json($idTheme).'\',
							  "id1": \''.json($id1).'\',
							  "id2": \''.json($id2).'\',
							  "img1": \''.json(recupBdd($img1)).'\',
							  "img2": \''.json(recupBdd($img2)).'\',
							  "nom1": \''.json(recupBdd($nom1)).'\',
							  "nom2": \''.json(recupBdd($nom2)).'\',
							  "nom1r": \''.json(recode(recupBdd($nom1))).'\',
							  "nom2r": \''.json(recode(recupBdd($nom2))).'\',
							  "note1": \''.json($note1).'\',
							  "note2": \''.json($note2).'\'
							} ';
							
					return $json1;
					
				}

switch(@$_GET['act'])
{
case "afficherFirst": 

	$idTheme=(int)$_GET['id'];
	
	// Récupère les infos d'un nouveau duel par thème
	$json1=theme_nouveau_duel($idTheme);

	// On récupère toutes les photos de la catégorie
	$sqlListe=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id_theme=$idTheme ORDER BY nb_votes DESC");
	
		$i=1;
		
		// On prépare la liste
		while ($l=mysql_fetch_object($sqlListe)) {
			if ($l->nb_votes<2) $vote=$l->nb_votes.' vote';
			else				 $vote=$l->nb_votes.' votes';
			
			if ($i==1)  $refresh="<a href='#' onclick='maj_liste_theme(); return false' title='Mettre à jour le classement dans le thème'><img src='images/recur.png' style='float:right; margin-top:-15px'/></a>";
			else 		$refresh='';
			$liste.='<li style="color:#666"><span style="font-weight:bold">'.$i.'</span><a href="?theme_photo&id='.$l->id.'" onclick="Modalbox.show(this.title, this.href, {height:350 }); return false">'.recupBdd($l->nom).'</a> &nbsp;&nbsp;<span>'.$vote.'</span>'.$refresh.'</li>';
			$i++;
		}
		
	// On récupère vite fait le nom du thème :
		$sqlTh=mysql_query("SELECT nom FROM ".PREFIX."themes WHERE id=$idTheme");
		$th=mysql_fetch_object($sqlTh);
		$nomTheme=recupBdd($th->nom);
		
	// Et on affiche le tout :
	echo2($nomTheme.'|:|'.$idTheme.'|:|'.$json1.'|:|'.$liste.'|:|'.recode($nomTheme));

break;
##################################################################################################################
##################################################################################################################
case "voterDuel":

	
	$idGagnant=(int)$_GET['idGagnant']; 
	$idTheme=(int)$_GET['idTheme']; 
	$idPerdant=(int)$_GET['idPerdant']; 
	$win1ou2=(int)$_GET['win1ou2'];
	
	$ip=ip();
		
	// On ajouter le vote
	$sqlMaj=mysql_query("UPDATE ".PREFIX."themes_photos SET nb_votes=nb_votes+1 WHERE id=$idGagnant");
	
	// On ajoute dans la table de vérification
	$sqlAddVerif=mysql_query("INSERT INTO ".PREFIX."themes_verif (`idphoto`,`ip`, `date`) VALUES ('$idGagnant','$ip', NOW() )");
	
	// Si il est loggé on ajoute les points
	if ($_SESSION['log_id'])
		$sqlUpdPoints=mysql_query("UPDATE ".PREFIX."membres SET nb_votes=nb_votes+1, points=points+".PT_VOTE." WHERE email='".$_SESSION['log_email']."'");

	// On récupère les nouveaux pourcentages
	$sqlNote1=mysql_query("SELECT nb_votes FROM ".PREFIX."themes_photos WHERE id=$idGagnant");
		$d1=mysql_fetch_object($sqlNote1);
		$vote1=$d1->nb_votes;
	$sqlNote2=mysql_query("SELECT nb_votes FROM ".PREFIX."themes_photos WHERE id=$idPerdant");
		$d2=mysql_fetch_object($sqlNote2);
		$vote2=$d2->nb_votes;
		
		$note1=(100*$vote1)/($vote1+$vote2);
		$note2=(100*$vote2)/($vote1+$vote2);
	
	// On récupère vite fait le nom du thème :
		$sqlTh=mysql_query("SELECT nom FROM ".PREFIX."themes WHERE id=$idTheme");
		$th=mysql_fetch_object($sqlTh);
		$nomTheme=recupBdd($th->nom);

	// On affiche un nouveau duel :
	echo2('ok|:|'.$win1ou2.'|:|'.round($note1,1).'|:|'.round($note2,1).'|:|'.theme_nouveau_duel($idTheme).'|:|'.recode($nomTheme));


break;
##################################################################################################################
##################################################################################################################
case "refreshListe":

	$idTheme=(int)$_GET['idTheme'];
	
	// On récupère toutes les photos de la catégorie
	$sqlListe=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id_theme=$idTheme ORDER BY nb_votes DESC");
	
	$i=1;
	
	// On prépare la liste
	while ($l=mysql_fetch_object($sqlListe)) {
		if ($l->nb_votes<2) $vote=$l->nb_votes.' vote';
		else				 $vote=$l->nb_votes.' votes';
		
		/* Premier : affiche l'image refresh */
		if ($i==1)  $refresh="<a href='#' onclick='maj_liste_theme(); return false'><img src='images/recur.png' style='float:right; margin-top:-15px'/></a>";
		else 		$refresh='';
		
		$liste.='<li style="color:#666"><span style="font-weight:bold">'.$i.'</span>'.recupBdd($l->nom).'</div> &nbsp;&nbsp;<span>'.$vote.'</span>'.$refresh.'</li>';
		$i++;
	}


	echo2($liste);

break;
default:
	exit("Accés interdit");
break;
}


?>