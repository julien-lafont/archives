<?php

/* 
 * KVM E-commerce : commander.htm et commander-$action.htm
 *
 * Différentes parties :
 *  - Connexion : S'affiche si l'utilisateur n'est pas logué une fois son panier validé. Choix offert : login ou inscription
 *  - Coordonnees : Demande à l'utilisateur d'entrer/vérifier ces coordonnees
 *    - ModifAdresse : Met à jour les coordonnées précédemment inscrites
 *  - Livraison : Permet à l'utilisateur de choisir son mode de livraison
 *  - Résumé : Résumé final du panier ( protection contre modification ) + Choix du moyen de paiement
 *  -> Suite sur paiement.php
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

// ############################################################################################	
//     Connexion : S'affiche si l'utilisateur n'est pas logué une fois son panier validé. Choix offert : login ou inscription
// ############################################################################################
case "connexion":

	$design->zone("titre", "Avant de poursuivre votre commande, veuillez vous identifier");
	
	$c='<table class="double_login" cellspacing="5">
			<tr>
				<td>
					<strong>Nouveau client</strong>
					<p>En créant un compte sur le site '.NOM.', vous aurez la possibilité de passer une commande en ligne, de suivre l\'avancement de celle-ci ainsi que de garder une trace de vos précédents achats.
						<form method="post" action="inscription.htm">
							<input type="submit" value="Inscription" class="f-submit" style="float:right; margin:15px 10px 5px 0" />
						</form>
					</p>
				</td>
				<td>
					<strong>Client membre</strong><br /><br />
					
					<form name="login" action="#" method="post" class="nomargin" onsubmit="connexion(\'inPage\'); return false" id="form_connexion_in" >
					<fieldset>
					
						<table style="border:0;">
							<tr>
								<td><b>Adresse Email</b></td>
								<td><input type="text" name="log_pseudo_in" id="log_pseudo_in" style="" tabindex="5" /></td>
							</tr>
							<tr>
								<td><b>Mot de passe</b></td>
								<td><input type="password" name="log_pass_in" id="log_pass_in" style="" tabindex="6" /></td>
							</tr>
							<tr>
								<td colspan="2" id="log_submit_in"><input type="submit" value="Connexion" class="f-submit" tabindex="7" style="float:right; margin:15px 10px 5px 0"/></td>	
							</tr>
							<tr>
								<td colspan="2" id="log_statut_in" style="display:none"><img src="images/indicator2.gif" style="vertical-align:middle" /> Connexion en cours</td>
							</tr>					
						</table>
							 
					</fieldset>
					</form>				
				</td>
			</tr>
		</table>';

break;



// ############################################################################################
//        Coordonnees : Demande à l'utilisateur d'entrer/vérifier ces coordonnees
// ############################################################################################
case "coordonnees":
	securite_membre(); // A partir d'ici l'utilisateur est nécessairement enregistré et loggé
	
	$design->zone("titre", "Confirmer ma commande");
			
	// Sélection des données : coordonnées du membres
	$sql=mysql_query("	SELECT * 
						FROM ".PREFIX."membres_infos mi
						LEFT JOIN  ".PREFIX."membres m
						ON m.id_membre=mi.id_membre
						WHERE m.id_membre=".$_SESSION['sess_id']) or die(mysql_error());
		@extract(recupBdd(mysql_fetch_array($sql)));
		
	// Gestion select/radio : GENRE
	if ($genre=="h") $sG1='checked="checked"';
	else			 $sG2='checked="checked"';
	
	$c= '<form action="commander-modifAdresse.htm" method="post" class="f-wrap-1">
			
			<fieldset>
			
			<h3>Adresse de livraison</h3>
			<div style="text-align:center; margin-bottom:10px">Indiquez les coordonnées postales du lieu où vous souhaitez recevoir vos articles.</div>
			
			<h5>Coordonnées postales</h5>
			<label for="genre"><b>Civilité</b> <br />
				<div style="margin:-25px 0 0 225px">	<input name="genre" type="radio" value="h" style="width:15px" tabindex="1" '.$sG1.' /> Monsieur <br />
						<input name="genre" type="radio" value="f" style="width:15px" '.$sG2.' /> Madame<br />
				</div>
			</label>
			
			<label for="nom"><b>Nom</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="2" maxlength="50" style="width:130px" value="'.$nom.'" /><br />
			</label>

			<label for="prenom"><b>Prenom</b>
				<input id="prenom" name="prenom" type="text" class="f-name" tabindex="3" maxlength="50" style="width:130px" value="'.$prenom.'" /><br />
			</label>

			<label for="adresse"><b>Adresse postale</b>
				<textarea id="adresse" name="adresse" class="f-comments" rows="4" cols="30" tabindex="4">'.$adresse.'</textarea><br />
			</label>
			
			<label for="cp"><b>Code postal</b>
				<input id="cp" name="cp" type="text" class="f-name" tabindex="5"  maxlength="5" style="width:50px" value="'.$cp.'" /><br />
			</label>

			<label for="ville"><b>Ville</b>
				<input id="ville" name="ville" type="text" class="f-name" tabindex="6" style="width:130px" maxlength="50" value="'.$ville.'" /><br />
			</label>

			<label for="pays"><b>Pays</b>
				<input id="pays" name="pays" type="text" class="f-name" tabindex="7" style="width:130px" maxlength="50" value="'.$pays.'" /><br />
			</label>

			<label for="tel"><b>Téléphone fixe</b>
				<input id="tel" name="tel" type="text" class="f-name" tabindex="8" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$tel.'" /><br />
			</label>
			
			<label for="portable"><b>Téléphone portable</b>
				<input id="portable" name="portable" type="text" class="f-name" tabindex="9" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$portable.'" /><br />
			</label>
			
			<br /><br />
			<input type="submit" value="Enregistrer ces informations" class="f-submit" tabindex="12" /><br />

		</fieldset>
		</form>';

break;

		case "modifAdresse":
			securite_membre();
			
			// Récupère et vérifie les données envoyées
			$donnes_postales = addslashes_array( $_POST, true );
			
			// Met à jours les données de la table membres_infos : infos de livraisons
			$sql1 = majBdd( PREFIX."membres_infos", '`id_membre`='.$_SESSION['sess_id'], $donnes_postales );
			
			header('location: commander-livraison.htm');
			
		break;


// ############################################################################################
//              Livraison : Permet à l'utilisateur de choisir son mode de livraison
// ############################################################################################
case "livraison":
	securite_membre();
	
	$design->zone("titre", "Choix de mode de livraison");
	
	$c='<div class="centre">
		Pour que notre service corresponde au mieux à vos attentes, nous vous proposons plusieurs modes de transport.<br />
		Dans tous les cas, sachez que toutes les commandes seront préparées et protégées avec la même rigueur pour rendre quasi-inexistants les problèmes liées au transit de votre colis.</div>
	
	<form name="choix_fdp" action="commander-resume.htm" method="post"><fieldset>
	
	<table class="table_articles"  style="margin-top:20px" cellspacing="0" cellpadding="0">
		<tr>
			<td class="titre"></td>
			<td class="titre">INFORMATIONS</td>
			<td class="titre">DELAIS</td>
			<td class="titre">PRIX</td>
			<td class="titre"></td>
		</tr>';
	
	
	// Sélection des différents modes de transports
	$sql=mysql_query("SELECT * FROM  ".PREFIX."frais_de_ports ORDER BY prix_euros ASC");
	
	$i=0;
	while ($d=mysql_fetch_array($sql)) {
		@extract(recupBdd($d));
		
		// Style alternatif une ligne sur deux
		if ($i%2==0) $class='class="a"';
		else		 $class='class="b"';
		
		// On coche la première case
		if ($i==0) 	$radio="checked";
		else		$radio="";
		
		// Gestion du logo
		if (empty($logo)) $imageP="pages/fonctions/redim.php?imgfile=".URL.CHEMIN_DEFAUT."no_logo1.png&max_height=80&max_width=8";
		else $imageP="pages/fonctions/redim.php?imgfile=".$logo."&max_height=80&max_width=80";
			
		// Mise en forme des produits
		$c.='<tr '.$class.'>
					<td class="a">
						<img src="'.$imageP.'" id="imageProduit'.$id_produit.'" />					
					</td>
					<td class="b b3">
						'.nl2br($description).'
					</td>
					<td class="c3">
						<strong>'.$delais.'</strong>
					</td>
					<td class="d3">
						<strong>'.$prix_euros.' &euro;</strong>
					</td>
					<td class="e3">
					 	<input type="radio" value="'.$id_fdp.'" name="fdp_id" '.$radio.'/> 
					</td>
				</tr>';	
		
		$i++;	
	
	}
	
	$c.='<tr>
			<td colspan="2"></td>
			<td colspan="3" style="text-align:right; padding-top:10px"><input type="submit" value="Finaliser ma commande" class="f-submit" /></td>
		</tr>
	</table>
	
	</fieldset></form>';

break;



// ############################################################################################
//       Résumé : Résumé final du panier ( protection du panier ) + Choix du moyen de paiement
// ############################################################################################
case "resume":
	securite_membre();
	
	$design->zone("titre",'Résumé de votre commande');	
	
	// Protection contre les appels directes :
	if (!POST) bloquerAcces('Accés direct à cette page interdit');
	
	// On met le type de FDP en session
	$_SESSION['sess_panier_fdp']=(int)$_POST['fdp_id'];


	
		
	// Sélection des données du panier
	$sqlPanier=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE id_membre=".$_SESSION['sess_id']);
		$pan=mysql_fetch_object($sqlPanier);
		$liste_produits=unserialize($pan->liste_produits_s);
		
		// Si le panier est vide, on bloquer l'accés
		if (empty($pan->liste_produits_s)) {
			$c="<div class='centre'>Vous ne pouvez pas passer une commande car votre panier est vide !</div>";
			$design->zone("contenu", $c);
			$design->afficher();
			die();
		}

		
	//>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<//	
	//> > > > Copié Coller de la page 'panier.php' < < < <//	
	//>>>>>>>>>>>>>>>>>>>>>>><<<<<<<<<<<<<<<<<<<<<<<<<<<<<//	
	
	// Infos sur le mode de transport
	$sqlFdp=mysql_query("SELECT * FROM ".PREFIX."frais_de_ports WHERE id_fdp=".$_SESSION['sess_panier_fdp']) or die (mysql_error());
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
						<span style="font-weight:bold; font-size:14px; color:#000">'.$nbProduit.'</span> articles
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
		</table>
		
		
		
		<h1>Moyen de paiement</h1>
		<div class="centre" style="margin:25px 0 25px 0">
			Merci de choisir le mode de paiment que vous souhaitez utilisez pour régler votre commande.
			Si vous choisissez un mode paiement en ligne, vous serez redirigé vers une page totalement sécurisée pour effectuer votre achat en toute sérénité <br />
		</div>
		
		<form name="paiement" action="paiement.htm" method="POST">
		<ul class="moyen_paiement">
			<li><input type="radio" value="cb" name="paiement" checked /> <strong>Paiement par CB</strong>
				<p>Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. <br />
				   Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. </p>
			</li>
			<li><input type="radio" value="cheque" name="paiement" /> <strong>Paiement par chèque</strong>
				<p>Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. <br />
				   Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. </p>
			</li>			
			<li><input type="radio" value="paypal" name="paiement" /> <strong>Paiement par Paypal</strong>
				<p>Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. <br />
				   Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. Lorem dolor sit amet. </p>
			</li>
		</ul>
		
		<input type="submit" class="f-submit" value="Accéder à la page de paiement" />
		</form>';


		// On sécurise le contenu du panier	:
		$_SESSION['sess_panier_totalHT']=$total;
		$_SESSION['sess_panier_totalEco']=$total_eco;
		
		$_SESSION['sess_panier_md5']=md5($pan->liste_produits_s);
		$_SESSION['sess_panier_total_md5']=md5($total.$total_eco.$_SESSION['sess_id']);
		
break;

default:
	die();
break;
}

	
	$design->zone("contenu", $c);
	
?>