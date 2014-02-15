<?php

/* 
 * KVM E-commerce : Panier - Appels ajax
 *
 * Permet de modifier la quantité d'articles dans le panier du membre
 */
 
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';

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
			} else die('hack attempt !');
	}
	
	// On récupère les données du panier, si il n'existe pas on le cré.
	$sql=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE $champ=$valeur LIMIT 0,1");
	$nb=mysql_num_rows($sql);
	if ($nb==0) {
		$sqlCreerPanier=mysql_query("INSERT INTO ".PREFIX."paniers_membres (`$champ`) VALUES ($valeur)");
		$liste_produits=array();
	}
	else
	{
		$d=mysql_fetch_object($sql);
		if (empty($d->liste_produits_s)) $liste_produits=array();
		else	$liste_produits=unserialize($d->liste_produits_s);
	}
	
switch(@$_GET['action']) {

case "ajouter_article":

	$id=(int)$_GET['id']; $modif=false;
	
	// Le produit est-il déjà dans le panier ? Si oui on modifie juste la quantité
	foreach($liste_produits as $arrayId=>$arrayInfos) {
		list($idProduit, $nbProduit)=$arrayInfos;
		if ($idProduit==$id) { $liste_produits[$arrayId]=array($idProduit, $nbProduit+1); $modif=true; break;}
	}
	
	// Sinon, on ajoute le produit à la liste
	if (!$modif) $liste_produits[]=array($id,1);
	
	// On met à jour la bdd
	$liste_produits_s=serialize($liste_produits);
	$sqlUpd=mysql_query("UPDATE ".PREFIX."paniers_membres SET `liste_produits_s`='$liste_produits_s' WHERE $champ=$valeur");
	
	// Retour pour utilisation ajax
	echo2(lister_panier($liste_produits)); 

break;




case "modif_qtt":

	$id=(int)$_GET['id']; $modif=false;
	
	// On parcours le panier et on modifie la quantité lorsque l'article est trouvé
	foreach($liste_produits as $arrayId=>$arrayInfos) {
		list($idProduit, $nbProduit)=$arrayInfos;
		if ($idProduit==$id) { 
			if ($_GET['val']==1) $newNb=$nbProduit+1;
			else				 $newNb=$nbProduit-1;
			
			// Protection : Quantité must be > 0 :
			if ($newNb<=0) {
				$newNb=0;
				unset($liste_produits[$arrayId]); break;
			}
			
			// On remplace la ligne en y inscrivant la nouvelle quantitée
			$liste_produits[$arrayId]=array($idProduit, $newNb); $modif=true; break;
		}
	}
	// Qtté initiale à O : on cré l'article dans la liste
	if (!$modif && $_GET['val']==1) {$liste_produits[]=array($id, 1); $newNb=1; }
	
	// On sélectionne les infos ( prix ) de ce produit:
	$sqlI=mysql_query("SELECT prix, ecotaxe FROM ".PREFIX."produits WHERE id_produit=$id");
	$d=mysql_fetch_object($sqlI);
		$prix=$d->prix;
		$ecotaxe=$d->ecotaxe;
	
	// Par mesure de sécurité, on recalcule totalement le prix TOTAL du panier
		$total=0; $total_eco=0;
		foreach($liste_produits as $idArray=>$infosArray) {		
			list($idProduit, $nbProduit) = $infosArray;		
			$sqlP=mysql_query("SELECT prix, ecotaxe FROM ".PREFIX."produits WHERE id_produit=$idProduit");
			$p=mysql_fetch_object($sqlP);
			
			$total+=$nbProduit*$p->prix;
			$total_eco+=$nbProduit*$p->ecotaxe;
	}

	
	// On sauvegarde le nouveau panier
	$sqlMaj=mysql_query("UPDATE ".PREFIX."paniers_membres SET liste_produits_s='".serialize($liste_produits)."' WHERE $champ=$valeur");
	
	// On envoie les données au format json
	echo2 ('var modifQtt = { 
			  "id": '.$id.',
			  
			  "new_prix_HT": '.round($prix*$newNb,2).',
			  "new_prix_TTC": '.round($prix*TAXE*$newNb,2).',
			  "new_prix_ECO": '.round($ecotaxe*$newNb,2).',
				
			  "total_prix_HT": '.round($total,2).',
			  "total_prix_TTC": '.round($total*TAXE,2).',
			  "total_prix_ECO": '.round($total_eco,2).',
			  
			  "nb": \''.round($newNb).'\'
		} ');


break;


}

?>