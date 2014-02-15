<?php
securite_membre(); /* Sécurisation */

/* 
 * KVM E-commerce : paiement.htm et paiement-$action.htm
 *
 * - Appel direct : Gérer le paiement en fonction du mode de paiement choisi !!!! A REALISER !!!!
 * - Validation : Retour de la page paiement : ajoutes les infos du panier, et les infos de la commande dans la BDD
 * - Confirmation : Message affichant à l'utilisateur que sa commande a été enregistrée
 */
 
 
switch(@$_GET['action']) {


   // -------------------------------------------------------------------------------------------------- //
  //			Page principale : Affiche le module de paiement en fonction du moyen choisi  			//
 //                                               /paiement.htm                                        // 
// -------------------------------------------------------------------------------------------------- //
default:	
	
	
	// On enregistre le type de paiement ( cb, cheque ... )
	$_SESSION['moyen_paiement']=addBdd($_POST['paiement']);
	
	$design->zone("titre", "Paiement de votre commande");
	
	
	
	
	
	  /* ---------------------------------------------------------------------------------------- \\
	    \\																						   \\
	     \\          	GESTION DU PAIEMENT ICI EN FONCTION DU MOYEN DE PAIEMENT CHOISI             \\
	      \\																    (commander.php)		 \\
	   	   \\ ----------------------------------------------------------------------------------------*/
		 
		 
		 $c='<form name="exemple" action="paiement-validation.htm">
		 		<label>Exemple vide</label>
		 		<input type="submit" class="f-submit" value="Envoyer mon paiement" />
		 	</form>';
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 	
		 
break;


   // -------------------------------------------------------------------------------------------------- //
  //			Page de validation appellée à la fin du paiement : enregistre la commande   			//
 //                                               /paiement-validation.htm                             // 
// -------------------------------------------------------------------------------------------------- //

case "validation":
	
	
	// Vérifier l'accés à cette page
	// Penser à distinguer paiement en ligne ( déjà effectué ) et paiment lent ( chèque )
	
	
	$statut="en_attente";
	
	// On récupère les infos du panier :
	$sqlPanier=mysql_query("SELECT * FROM ".PREFIX."paniers_membres WHERE id_membre=".$_SESSION['sess_id']);
	$pan=mysql_fetch_object($sqlPanier);
		$liste_produits=addBdd($pan->liste_produits_s);
		$total=$_SESSION['sess_panier_totalHT'];
		$total_eco=$_SESSION['sess_panier_totalEco'];
		
		// On vérifie l'intégrité du panier :
		if (md5($pan->liste_produits_s)!=$_SESSION['sess_panier_md5']) 
			bloquerAcces("	Votre panier semble avoir changé depuis la validation de votre commande.<br />
							Si la confirmation de votre commande a déjà été affichée, revenez simplement à l'accueil du site.");
		// On vérifie l'intégrité des totaux enregistrés
		if ($_SESSION['sess_panier_total_md5']!=md5($total.$total_eco.$_SESSION['sess_id'])) 
			bloquerAcces("	Votre panier semble avoir changé depuis la validation de votre commande.<br />
							Si la confirmation de votre commande a déjà été affichée, revenez simplement à l'accueil du site.");
		
		
	// Insertion des données dans la base sql
	$sql=mysql_query("	INSERT INTO `".PREFIX."commandes` 
						( `id_membre` , `liste_produits_s` , `total_prix` , `total_ecotaxe` , `mode_paiement` , `id_fdp` , `statut` , `validation_date` )
						VALUES 
						( ".$_SESSION['sess_id']." , '$liste_produits' , '$total' , '$total_eco' , '".$_SESSION['moyen_paiement']."' , '".$_SESSION['sess_panier_fdp']."' , '$statut', NOW() )");
						
		$id_commande=mysql_insert_id();
			
							
	//>> Si le paiement a été effectué en même temps que la commande, décomentez cette partie
	/*	$ref_paiement="LOREM IPSUM";
	$sqlPaiement=mysql_query("	UPDATE ".PREFIX."commandes 
								SET 
									statut='paye',
									paiement_date=NOW(),
									ref_paiement='$ref_paiement'
								WHERE id_commande=$id_commande ") or die(mysql_error());*/
								
	
	// On met à jour le compteur d'achat
	foreach(unserialize($pan->liste_produits_s) as $arrayId=>$arrayProduit) {
		list($idProduit, $nbProduit)=$arrayProduit;
		$idProduit=(int)$idProduit; $nbProduit=(int)$nbProduit;
		mysql_query("UPDATE ".PREFIX."produits SET nb_achat=nb_achat+$nbProduit WHERE id_produit=$idProduit");
	}
	
					
	// On vide les sessions contenant des infos du panier, plus le panier en cours
	unset($_SESSION['sess_panier_totalHT'], $_SESSION['sess_panier_totalEco'], $_SESSION['sess_panier_total_md5'], $_SESSION['sess_panier_md5'], $_SESSION['moyen_paiement'], $_SESSION['sess_panier_fdp']);
	$sqlSuppr=mysql_query("DELETE FROM ".PREFIX."paniers_membres WHERE id_membre=".$_SESSION['sess_id']);
	$_SESSION['commande_id']=$id_commande;
	
	header('location: paiement-confirmation.htm');

break;



   // -------------------------------------------------------------------------------------------------- //
  //						Indique à l'utilisateur que sa commande a été enregistrée 					//
 //                                         /paiement-confirmation.htm                                 // 
// -------------------------------------------------------------------------------------------------- //

case "confirmation":

	$design->zone("titre", "Confirmation de votre commande");
	
	
	$c='<div class="centre">
			<strong>Nous avons recu votre paiement, votre commande vous sera expédiée dans les plus brefs délais</strong><br /><br />
			
			Nous vous remercions de la confiance accordée à notre site pour l\'achat de cette commande.<br />
			Vous pourrez suivre l\'évolution de celle-ci à partir de votre espace personnel.<br /><br />
			
			Pour toute correspondance, merci de joindre le numéro de votre commande : <strong>#'.$_SESSION['commande_id'].'</strong>
			
		</div>';

break;
}	
	
	$design->zone("contenu", $c);

?>