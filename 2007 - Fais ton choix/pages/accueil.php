<?php

/*  ------------------------------------------------------------------------------------------------------------------
	   Page appellée lors de l'arrivée sur le site : affiche le dernier thème et affiche tous les blocs secondaires 
    ------------------------------------------------------------------------------------------------------------------ */

	// Sélection du dernier duel
	$sqlChoixDuel=mysql_query("SELECT * FROM ".PREFIX."duels ORDER BY id DESC LIMIT 0,1");
	$d=mysql_fetch_object($sqlChoixDuel);
	
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
		if ($v->id) {  // Si oui //
			$design->zone("statut_vote", "<span style='font-size:10px'>Vous avez déjà voté !</span>"); 
			if ($v->vote==1) $etoile1=""; // on affiche les deux étoiles
			if ($v->vote==2) $etoile2="";
		}
		
	// Mise en forme du duel	 
	$cadreImg1='<div id="image1" >
					<a id="lien1" href="voter_pour_'.recode(recupBdd($d->nom1)).'-'.$d->id.'-1.htm" title="Vote pour '.recupBdd($d->nom1).' sur Faistonchoix.fr" onclick="voterDuel('.$d->id.',1); return false">
						<img id="img1" src="'.DUEL.recupBdd($d->img1).'" style="z-index:10" alt="Duel Premier opposant"/>
						<div id="etoile1" '.$etoile1.'><img src="images/star.png" alt="star" /></div>
					</a>
				</div>
				<img id="waitImg1" src="images/loader_blue.gif" alt="load" class="waitImg" style="display:none" />
				
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
				<img id="waitImg2" src="images/loader_blue.gif" class="waitImg" style="display:none" alt="load" />
				
				<br /><b id="nom2">'.recupBdd($d->nom2).'</b><br />
				
				<div class="barre_pourcentage" id="fond-barre2">
					<div id="barre2" style="width:'.$note2P.'%" class="barre_couleur">
						<span class="nombre_pourcentage" id="pourcentage2">'.$note2P.' %</span>
				</div>
				</div>';

	$design->zone('interImage1', $cadreImg1);
	$design->zone('interImage2', $cadreImg2);
	$design->zone('numDuel', $d->id);
	
	// no-jvs users : Duel précédent :
	$sqlPrec=mysql_query("SELECT id, nom1, nom2 FROM ".PREFIX."duels WHERE id<".$d->id." ORDER BY id DESC LIMIT 0,1");
	$prec=mysql_fetch_object($sqlPrec);
	
	$design->zone('fleche_gauche', '<div id="fleche_gauche"><a id="lienFlG" href="duel-'.recode(recupBdd($prec->nom1)).'_ou_'.recode(recupBdd($prec->nom2)).'-'.$prec->id.'.htm" title="Afficher le duel '.recupBdd($prec->nom1).' contre '.recupBdd($prec->nom2).'" onclick="afficher_duel(\'precedent\'); return false"><img id="imgFlG" src="theme/images/gauche.png" name="flG" onMouseOver= "if (document.images) document.flG.src=\'theme/images/gauche_hover.png\';" onMouseOut= "if (document.images) document.flG.src=\'theme/images/gauche.png\';"/></a></div>');
	$design->zone('fleche_droite', '<div id="fleche_droite"><a id="lienFlD" href=""><img id="imgFlD" name="flD" src="theme/images/droite.png" /></a></div>');
	
	//------------- AFFICHAGE DE MODULES PARTICULIERS ------------------ // ( SI APPEL EN NO-JVS )
	switch(@$_GET['module']) {
		case "classement":
		
			// Combien de jours avant la fin du mois ?
			$now=time();
			$diff=mktime(0, 0, 0, date("m")+1, 1, date("Y"))-$now;
			if ($diff<=60) $r=$diff."s";
			if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
			if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
			if ($diff>86400) $r=round(($diff/86400))."j";
			
			
			$sqlC=mysql_query("SELECT email, points FROM ".PREFIX."membres ORDER BY points DESC LIMIT 0,10");
			$c="<table style='border:0; padding:0; width:100%; text-align:left'>
					<tr>
					  <td colspan='2' style='text-align:center'><br />
					  <span style='font-size:13px; color:#FF6600'>Les 10 membres les plus actifs</span><br />
					  Prochain tirage au sort dans ".$r."<br /><br />
					  </td>
					</tr></table>
					<div style=' margin-left:35px; height:150px; overflow:auto; border:1px solid #ccc; border-left:0; border-right:0'>
					<table style='border:0; padding:0;width:100%; text-align:left;'>";
					
			while ($d=mysql_fetch_object($sqlC)) {
				$temp=explode('@', $d->email);
				if ($d->points>PT_MEMBRE_PLATINIUM) $bonus=' <img src="images/level4.png" style="vertical-align:middle"/>';
				elseif ($d->points>PT_MEMBRE_OR) $bonus=' <img src="images/level3.png"  style="vertical-align:middle"/>';
				elseif ($d->points>PT_MEMBRE_ARGENT) $bonus=' <img src="images/level2.png"  style="vertical-align:middle"/>';
				elseif ($d->points>PT_MEMBRE_BRONZE) $bonus=' <img src="images/level1.png"  style="vertical-align:middle"/>';
				else $bonus='';
				
				$c.="<tr><td style='width:50%; text-align:left; border-left:2px solid #00A8FF; padding-left:5px'> ".$bonus." <b>".tronquerChaine($temp[0],20)."</b></td><td style='text-align:left'>".$d->points." points</td></tr>";
			}
			
			$c.='</table></div>';
	
			$design->zone('espace_kdos', $c);
		
		break;
	}
	

?>