<?php
securite_membre();

	$id=@(int)$_GET['id'];

// Page principale : affiche les dernières commandes :
if (empty($id)) {

	$design->zone("titre", "Mes commandes en cours");
	
	$c='<div class="centre">Cette page vous permet de suivre étape par étape l\'avancée de vos commandes</div>';
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."commandes WHERE id_membre=".$_SESSION['sess_id']." AND ( envoie_date>(NOW()-3600*24*7) OR envoie_date=0 OR envoie_date='' )") or die(mysql_error());
	while($d=mysql_fetch_array($sql)){
		
		@extract(recupBdd($d));
		
		// Mise en forme du statut 
		if ($statut=="en_attente")  { $st="En attente de paiement"; $last_action=$validation_date; }
		if ($statut=="paye") 	    { $st="Commande payée"; $last_action=$paiement_date; }
		if ($statut=="preparation") { $st="En préparation"; $last_action=$paiement_date; }
		if ($statut=="expedie")     { $st="Commande expédiée"; $last_action=$envoie_date; }
		
		// Sélections des infos sur le moyen de transport sélectionné
		$sqlFdp=mysql_query("SELECT * FROM ".PREFIX."frais_de_ports WHERE id_fdp=$id_fdp");
		$fdp=mysql_fetch_object($sqlFdp);
	
			// Gestion du logo
			if (empty($fdp->logo)) $imageP="pages/fonctions/redim.php?imgfile=".URL.CHEMIN_DEFAUT."no_logo1.png&max_height=80&max_width=8";
			else $imageP="pages/fonctions/redim.php?imgfile=".$fdp->logo."&max_height=80&max_width=80";
			
		// Gestion du panier
		$panier=unserialize($liste_produits_s); $liste_panier=''; $i=0;
		foreach($panier as $cle=>$val) {
			$idProd=$val[0];
			$nbProd=$val[1];
			
			$sqlP=mysql_query("SELECT nom, stock FROM ".PREFIX."produits WHERE id_produit=$idProd");
			$p=mysql_fetch_object($sqlP);
			
				// Stock de chaques produits
				if ($p->stock=="stock")  $couleur="vert";
				if ($p->stock=="last") 	 $couleur="bleu";
				if ($p->stock=="reapp")  $couleur="orange";
				if ($p->stock=="epuise") $couleur="rouge";
				
			$liste_panier.='<li><img src="theme/admin/css/images/puce_'.$couleur.'.png" alt="'.$p->stock.'" /> &nbsp; '.tronquerChaine(recupBdd($p->nom),18).'<span class="right" style="color:#00A8FF">x '.$nbProd.'</span></li>';
			$i++;
		
			if ($i==4) { $liste_panier.='<li class="centre" style="border-bottom:0"><strong>. . .</strong></li>'; break; }
		}
		
		
		$c.='<h2>Commande du '.inverser_date($validation_date, 6).'</h2>';
		
		$c.= '<table class="table_3" style="width:80%">
				<tr>
					<td class="g"><h5>Commande <span>#'.$id_commande.'</span></h5>
						<ul>
							<li><strong>Statut</strong> : <span style="color:#00A8FF">'.$st.'</span></li>						
							<li><strong>Depuis le </strong> : <span style="color:#00A8FF">'.inverser_date($last_action, 6).'</span></li>
						</ul>	
						<div class="bas">TOTAL TTC : '.round($total_prix*TAXE+$total_ecotaxe+$fdp->prix_euros,2).' &euro;</div>
					</td>
					
					<td class="c"><h5>Panier</h5>
						<ul class="panier">
							'.$liste_panier.'
						</ul>
					</td>
					
					<td class="d"><h5>Transporteur</h5>
						<img src="'.$imageP.'" alt="'.recupBdd($fdp->mode_envoie).'" style="margin-top:8px" />
						<div class="boutonBlanc"><a href="?id='.$id_commande.'">Voir le panier complet</a></div>
					</td>
				</tr>
			</table>';
	}
	
}

// Affiche une commande en détail :
else
{
	
	$design->zone("titre", "Informations sur une commande");
	
	// Sélection des données du panier
	$sqlPanier=mysql_query("SELECT liste_produits_s, id_membre, id_fdp FROM ".PREFIX."commandes WHERE id_commande=".$id);
		$pan=mysql_fetch_object($sqlPanier);
		$liste_produits=unserialize($pan->liste_produits_s);
		
		if ($pan->id_membre!=$_SESSION['sess_id']) bloquerAcces("Vous n'avez pas accés à cette page !");
		
	//>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<//	
	//> > > > Copié Coller de la page 'panier.php' < < < <//	
	//>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<//	
	
	// Infos sur le mode de transport
	$sqlFdp=mysql_query("SELECT * FROM ".PREFIX."frais_de_ports WHERE id_fdp=".$pan->id_fdp) or die (mysql_error());
		$fdp=mysql_fetch_object($sqlFdp);
		
		// Gestion du logo FDP
		if (empty($fdp->logo)) $imageFdp="pages/fonctions/redim.php?imgfile=".URL.CHEMIN_DEFAUT."no_logo1.png&max_height=80&max_width=8";
		else $imageFdp="pages/fonctions/redim.php?imgfile=".$fdp->logo."&max_height=80&max_width=80";
	
	
	$c='<table class="table_articles"  cellspacing="0" cellpadding="0">';
	
		if (count($liste_produits)==0) $c.='<tr><td colspan="4"><div class="error">Votre panier ne contient aucun article</div></td></tr>';
		$total=0; $total_eco=0;	
		foreach($liste_produits as $idArray=>$infosArray) {
		
			list($idProduit, $nbProduit) = $infosArray;		
			
			// Sélection des infos sur le produit :
			$sqlP=mysql_query("	SELECT * FROM ".PREFIX."produits WHERE id_produit=$idProduit");
			@extract(recupBdd(mysql_fetch_array($sqlP)));
			
			// Style alternatif une ligne sur deux
			if ($i%2==0) $class='class="a"';
			else		 $class='class="b"';
			
			// Gestion du logo
			if (empty($image)) $imageP="pages/fonctions/redim.php?imgfile=".URL.CHEMIN_DEFAUT."no_logo1.png&max_height=80&max_width=8";
			else $imageP="pages/fonctions/redim.php?imgfile=".$image."&max_height=80&max_width=80";
			
			/*// Gestion de la devise
			if (is_numeric($_SESSION['sess_id_devise']) && $_SESSION['sess_id_devise']!=0) {
				$idD=(int)$_SESSION['sess_id_devise'];
				$sql_devise=mysql_query("SELECT symbole_g, symbole_d, convers_euro FROM ".PREFIX."devises WHERE id_devise=".$idD);
				$devise=mysql_fetch_object($sql_devise);
					$prix_regional=$devise->symbole_g.' '.round($prix*$devise->convers_euro,2).' '.$devise->symbole_d;
			}*/
				$prix_regional=round($prix,2).' &euro;';
				
				// Gestion pluriel
				if ($nbProduit==1) $terme="article";
				else			   $terme="articles";	
						
			// Mise en forme des produits
			$c.='<tr '.$class.'>
					<td class="a">
						<a href="article-'.$id_produit.'-'.recode($nom).'.htm" title="Afficher les informations sur l\'article '.$nom.'">
							<img src="'.$imageP.'" id="imageProduit'.$id_produit.'" />
						</a>
					</td>
					<td class="b">
						<a href="article-'.$id_produit.'-'.recode($nom).'.htm" title="Afficher les informations sur l\'article '.$nom.'">
							'.$nom.'
						</a><br />
						&nbsp; &nbsp;<span style="font-family:verdana">'.$reference.'</span>
					</td>
					<td class="b2">							
						<span style="font-weight:bold; font-size:14px; color:#000">'.$nbProduit.'</span> '.$terme.'
					</td>
					<td class="c2">
							
						<strong>Prix TTC &rsaquo;</strong> <span style="color:#06F" class="right2">'.round($nbProduit*$prix*TAXE,2).' &euro;</span><br />
						<strong>Prix HT &rsaquo;</strong> <span class="right2">'.round($nbProduit*$prix,2).' &euro;</span><br /><br />
						<div style="font-size:11px"><strong style="font-size:11px">Ecotaxe &rsaquo;</strong> <span class="right2">'.($nbProduit*$ecotaxe).'  &euro;</span></div>
					</td>
				</tr>';	
			
			$i++;
			$total+=$nbProduit*$prix;
			$total_eco+=$nbProduit*$ecotaxe;
		
		}
		
		// Affiche le sous-total du panier
		$c.='<tr>
				<td colspan="2"></td>
				<td class="total1">
					SOUS-TOTAL TTC<br />
					Sous-total HT<br />
					Dont Ecotaxe<br />
				</td>
				<td class="total2">
					<span>'.round($total*TAXE,2).'</span> &euro;<br />
					<span>'.round($total,2).'</span> &euro;<br />
					<span>'.round($total_eco,2).'</span> &euro;
				</td>
			</tr>';
		
		// Affiche le mode de transport	
		$c.='<tr>
				<td class="fdp"><img src="'.$imageFdp.'" alt="FDP" /></td>
				<td class="fdp">'.recupBdd($fdp->description).'</td>
				<td class="cfdp"><strong>'.recupBdd($fdp->mode_envoie).'<strong> </td>
				<td class="dfdp"><strong>'.recupBdd($fdp->prix_euros).' &euro;</strong> (TTC)</td>
			</tr>';
			
		// Total définitif, FDP inclus
		$c.='<tr>
				<td colspan="2"></td>
				<td class="total1">
					<span class="gras">Total TTC</span>
				</td>
				<td class="total2">
					<span class="gras" id="totalTTC">'.round($total*TAXE+$fdp->prix_euros,2).'</span><span> &euro;</span><br />
				</td>
			</tr>			
		</table>';
	
	
}

	$design->zone("contenu", $c);
?>