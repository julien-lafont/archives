<?php
/*  ---------------------------------------------------------------------------------------------------------------
	Page appellée en ajax : Actions sur les duels :
	  -> Changer le duel en cours ( id/suivant/précédent )
	  -> Se déplacer dans la liste des duels 
    --------------------------------------------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';

switch(@$_GET['act'])
{
case "afficher":
	
	// Sélectionne le nouveau duel
	$action=htmlspecialchars($_GET['action']);
	$idCurrent=(int)$_GET['idCurrent'];
	
	if ($action=='precedent') {
		$sql=mysql_query("SELECT * FROM ".PREFIX."duels WHERE id<'$idCurrent' ORDER BY id DESC LIMIT 0,1");
	}
	else if ($action=='suivant') {
		$sql=mysql_query("SELECT * FROM ".PREFIX."duels WHERE id>'$idCurrent' ORDER BY id ASC LIMIT 0,1");
	}
	else  {
		$action=(int)$action;
		$sql=mysql_query("SELECT * FROM ".PREFIX."duels WHERE id='$action'") or die(mysql_error());
	}
	
	$d=mysql_fetch_object($sql);
	$id=$d->id;
	
		// Calcul des pourcentages
		$note1P=round((($d->note1*100)/$d->votestotal),1);
		$note2P=round((($d->note2*100)/$d->votestotal),1);				
		
		// A-t-il déjà voté pour ce duel ?
		if ($_SESSION['log_email']) $where="AND ( ip='".ip()."' OR email='".$_SESSION['log_email']."')";
		else						$where="AND ip='".ip()."'";
		$sqlVerif=mysql_query("SELECT id, vote FROM ".PREFIX."verifduel WHERE id_duel=".$d->id." ".$where);
		$v=mysql_fetch_object($sqlVerif);
		if ($v->id) $vote=$v->vote;
		else		$vote=0;

		// Duel suivant ? Duel précédent ?
		$sqlpre=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id<$id");
			$pre=mysql_num_rows($sqlpre);
			if ($pre>=1) $pre=1;
		$sqlsuiv=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id>$id");
			$suiv=mysql_num_rows($sqlsuiv);
			if ($suiv>=1) $suiv=1;
		

	// On affiche la requête Json
	echo ('var infosDuel = { 
			  "id": \''.$id.'\',
			  "img1": \''.json(recupBdd($d->img1)).'\',
			  "img2": \''.json(recupBdd($d->img2)).'\',
			  "nom1": \''.json(recupBdd($d->nom1)).'\',
			  "nom2": \''.json(recupBdd($d->nom2)).'\',
			  "nom1r": \''.json(recode(recupBdd($d->nom1))).'\',
			  "nom2r": \''.json(recode(recupBdd($d->nom2))).'\',
			  "note1": \''.json($note1P).'\',
			  "note2": \''.json($note2P).'\',  
			  "vote": \''.$vote.'\',
			  "suivant": \''.$suiv.'\',
			  "precedent": \''.$pre.'\'
			} ');

break;
##############################################################################################################################
##############################################################################################################################
case "liste":

	if ($_GET['ordre']=="suivant") {
		$dernier=(int)$_GET['dernier'];
		$sql=mysql_query("SELECT id, nom1, nom2, date FROM ".PREFIX."duels WHERE id<$dernier ORDER BY id DESC LIMIT 0,10");
		$nbSuiv=mysql_num_rows($sql);
	
		// Encore aprés ?
			$sqlsuiv=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id<$dernier ORDER BY id DESC LIMIT 0,11") or die(mysql_error());
			$nbTestSuiv=mysql_num_rows($sqlsuiv);
			if ($nbSuiv!=$nbTestSuiv) $suivant=1;
		// Avant ?
			$sqlprec=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id>$dernier ORDER BY id DESC LIMIT 0,1") or die(mysql_error());
			$nbTestPrec=mysql_num_rows($sqlprec);
			if ($nbTestPrec!=0) $precedent=1;

	} 
	else if ($_GET['ordre']=="precedent") {
		$premier=(int)$_GET['premier'];
		$sql=mysql_query("SELECT id, nom1, nom2, date FROM ".PREFIX."duels WHERE id<".($premier+11)." ORDER BY id DESC LIMIT 0,10");
		$nbPrec=mysql_num_rows($sql);
		
		// Encore aprés ?
			$sqlsuiv=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id<".($premier+11)." ORDER BY id DESC LIMIT 0,11") or die(mysql_error());
			$nbTestSuiv=mysql_num_rows($sqlsuiv);
			if ($nbSuiv!=$nbTestSuiv) $suivant=1;
		// Avant ?
			$sqlprec=mysql_query("SELECT id FROM ".PREFIX."duels WHERE id>".($premier+11)." ORDER BY id ASC LIMIT 0,1") or die(mysql_error());
			$nbTestPrec=mysql_num_rows($sqlprec);
			if ($nbTestPrec!=0) $precedent=1;

	} 
	
				
	$duels="";
	$i=1;
	while ($duel=mysql_fetch_object($sql)) {
	
		// Déjà voté ?
		if ($_SESSION['log_vote'][$duel->id]==true) $vote="<b id='indic".$duel->id."'>&bull;</b>";
		else										$vote="<u id='indic".$duel->id."'>&bull;</u>";

		if ($i==1) 		{ if ($precedent) $plus='<a href="#"  onclick="liste_precedent(); return false"><img src="images/fleche_haut.gif" style="float:right; margin-top:-15px"/></a>'; }
		elseif ($i==10) { if ($suivant) $plus='<a href="#" onclick="liste_suivant(); return false"><img src="images/fleche_bas.gif" style="float:right; margin-top:-15px" /></a>'; }
		else 			$plus='';
		
		if (!$first) $first=$duel->id;
		$last=$duel->id;
		
		$duels.='<li>'.$vote.' <a href="duel-'.recode(recupBdd($duel->nom1)).'_ou_'.recode(recupBdd($duel->nom2)).'-'.$duel->id.'.htm" title="Afficher le duel '.recupBdd($duel->nom1).' contre '.recupBdd($duel->nom2).'" onclick="afficher_duel('.$duel->id.'); return false" title="Afficher le duel : '.recupBdd($duel->nom1).' VS '.recupBdd($duel->nom2).'"><span>'.$duel->date.'</span> '.recupBdd($duel->nom1).' <i>ou</i> '.recupBdd($duel->nom2).'</a> '.$plus.'</li>';
		$i++;
	}

	echo $first.'|:|'.$last.'|:|'.$duels;



break;
}

?>
 
