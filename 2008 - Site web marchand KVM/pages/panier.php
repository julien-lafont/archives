<?php

/* 
 * KVM E-commerce : panier.htm
 *
 * Affichage détaillé des articles présents dans le paniers du membres/visiteur
 */
 
 
	// On gère la condition pour récupérer le panier courant du membre/de l'invité
	if (is_log()) {
		$champ="id_membre";
		$valeur=$_SESSION['sess_id'];
	}
	else {
		$idInvite=(int)$_COOKIE['sess_invite_id'];
			
			// Vérification de la session invité :
			$sqlVerif=mysql_query("SELECT ip, cle, last_activitee FROM ".PREFIX."session_invites WHERE id_session=$idInvite");
			$verif=mysql_fetch_object($sqlVerif);
			
			if ( $verif->ip==ip() && $verif->cle==$_COOKIE['sess_invite_cle'] && $verif->last_activitee>(time()-(3600*24)*7) ) {
				$champ="id_sess_invite";
				$valeur=$idInvite;
			} else bloquerAcces("Votre session n'est plus valide");
	}


switch(@$_GET['action']) {

  // -------------------------------------------------------------------------------------------------- //
 //								Page principale : affiches tous les articles						   //
// -------------------------------------------------------------------------------------------------- //

default:


	// Sélection des données du panier
	$sqlPanier=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE $champ=$valeur");
		$pan=mysql_fetch_object($sqlPanier);
		$liste_produits=$pan->liste_produits_s;
		
		if (!empty($liste_produits)) $liste_produits=unserialize($liste_produits);
		else						 $liste_produits=array();
		
	// Page s'ouvrant à la validation de la commande
	if (is_log()) 	$pageVal="commander-coordonnees.htm";
	else			$pageVal="commander-connexion.htm";
	
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
							
							<a href="#Ajouter_un_article" title="Ajouter un article '.$nom.' au panier" onclick="modif_quantite(\'+\', '.$idProduit.'); return false"><img src="images/boutons/basket_put.png" /></a>
							&nbsp; <span style="font-weight:bold; font-size:14px; color:#000"  id="nbProduit'.$idProduit.'">'.$nbProduit.'</span> &nbsp;
							<a href="#Retirer_un_article" title="Retirer un article '.$nom.' du panier" onclick="modif_quantite(\'-\', '.$idProduit.'); return false"><img src="images/boutons/basket_remove.png" /></a><br />

					</td>
					<td class="c2">
							
						<strong>Prix TTC &rsaquo;</strong> <span style="color:#06F" class="right2" id="prixTTC'.$idProduit.'">'.round($nbProduit*$prix*TAXE,2).' &euro;</span><br />
						<strong>Prix HT &rsaquo;</strong> <span class="right2" id="prixHT'.$idProduit.'">'.round($nbProduit*$prix,2).' &euro;</span><br /><br />
						<div style="font-size:11px"><strong style="font-size:11px">Ecotaxe &rsaquo;</strong> <span class="right2" id="prixECO'.$idProduit.'">'.($nbProduit*$ecotaxe).'  &euro;</span></div>
					</td>
				</tr>';	
			
			$i++;
			$total+=$nbProduit*$prix;
			$total_eco+=$nbProduit*$ecotaxe;
		
		}
		
		// Affiche les différents Sous-totaux
		$c.='<tr>
				<td colspan="2"></td>
				<td class="total1">
					<span class="gras">Sous-total TTC</span><br />
					Sous-total HT<br />
					Dont Ecotaxe<br />
				</td>
				<td class="total2">
					<span class="gras" id="totalTTC">'.round($total*TAXE,2).'</span><span> &euro;</span><br />
					<span id="totalHT">'.round($total,2).'</span> &euro;<br />
					<span id="totalECO">'.round($total_eco,2).'</span> &euro;
				</td>
			</tr>
		</table>
		
		<table style="width:80%; margin:20px auto">
			<tr>
				<td style="width:33%">
					<div class="boutonBlanc float"><a href="#Rafraichir" onclick="javascript:history.go(0); return false"><img src="images/boutons/transmit.png" /> Rafraichir</a></div>
				</td>
				<td style="width:33%">
					<div class="boutonBlanc float"><a href="vider-panier.htm" onclick="return confirm(\'Êtes-vous sûr de vouloir vider votre panier ?\')"><img src="images/boutons/cart_error.png" /> Vider la panier</a></div>
				</td>
				<td style="width:33%">			
					<div class="boutonBlanc float"><a href="'.$pageVal.'"><img src="images/boutons/money.png" /> Commander</a></div>
				</td>
			</tr>
		</table>';


break;



// Action secondaire: vide le panier
case "vider":

	$sql=mysql_query("UPDATE ".PREFIX."paniers_membres SET liste_produits_s='' WHERE $champ=$valeur");
	header('location: mon-panier.htm');
	
break;

}
	
	$design->zone("titre", "Qu'y a-t-il dans mon panier ?");
	$design->zone("contenu", $c);
	
?>