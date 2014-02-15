<?php
securite_admin('commandes');

	$page="?admin-commandes-rechercher";
	$table=PREFIX."commandes";
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
			<fieldset>

				<h3>Rechercher une commande</h3>
		

				<label for="id"><b>Par son id</b>
					<input id="id" name="id" type="text" class="f-name" tabindex="3" /><br />
				</label>
				<label for="nom"><b>Par le nom de l\'acheteur</b>
					<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
				</label				
				<label for="email"><b>Par l\'email de l\'acheteur</b>
					<input id="email" name="email" type="text" class="f-name" tabindex="2" /><br />
				</label>
						
				<input type="submit" value="Rechercher" class="f-submit" /><br />

		</fieldset>
	</form>';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="mbre_bad") $retour=miseEnForme('bad', "Aucun membre n'a été trouvé avec les informations entrées");
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Commandes</a> / <a href="?admin-commandes-attentes">Gestion des commandes</a> / <strong>Rechercher une commande</strong>';
	$c=$recherche;
	
break;

case "search":
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Commandes</a> / <a href="??admin-commandes-attentes">Gestion des commandes</a> / <strong>Rechercher une commande</strong>';
	$c=$recherche;
	
	// Protection
	$donnees=addslashes_array($_POST);	

	//:: Recherche pas l'id de la commande
	if (!empty($donnees['id']))	
		$where="c.id_commande = ".$donnees['id'];
		
	//: Recherche d'une commande par le nom de l'acheteur
	elseif 	(!empty($donnees['nom'])) 	{
		// Recherche de l'id du membre par son nom
		$sqlMembre=mysql_query("SELECT id_membre as id FROM ".PREFIX."membres_infos WHERE `nom` like '%".$donnees['nom']."%'");
			$m=mysql_fetch_object($sqlMembre);
			$idMembre=$m->id;
			
			if (empty($idMembre)) header('location: '.$page.'&mess=mbre_bad');
		
		$where="c.id_membre=$idMembre";
	}
	
	//: Recherche d'une commande par l'email de l'acheteur
	elseif  (!empty($donnees['email'])) {
		// Recherche de l'id du membre par son nom
		$sqlMembre=mysql_query("SELECT id_membre as id FROM ".PREFIX."membres WHERE `email` like '%".$donnees['email']."%'") or die(mysql_error());
			$m=mysql_fetch_object($sqlMembre);
			$idMembre=$m->id;
			
			if (empty($idMembre)) header('location: '.$page.'&mess=mbre_bad');
		
		$where="c.id_membre=$idMembre";
	}
	else	{ header('location: '.$page.'&mess=erreurForm'); die();  }
	
	// On effectue la requête
		$sql=mysql_query("	SELECT * 
							FROM $table c
							LEFT JOIN ".PREFIX."membres_infos mi
							ON mi.id_membre=c.id_membre
							WHERE $where
							ORDER BY id_commande ASC") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));
		
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
				
			$liste_panier.='<li><img src="theme/admin/css/images/puce_'.$couleur.'.png" alt="'.$p->stock.'" /> &nbsp; '.recupBdd($p->nom).'<span class="right" style="color:#00A8FF">x '.$nbProd.'</span></li>';
			$i++;
		
			if ($i==5) { $liste_panier.='<li class="centre" style="border-bottom:0"><strong>. . .</strong></li>'; break; }
		}
		
		
				
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Commande <span>#'.$id_commande.'</span></h5>
						<ul>
							<li><strong>Validation le </strong> : '.inverser_date($validation_date,6).'</li>
							<li><strong>Paiement le </strong> : '.inverser_date($paiement_date,6).'</li>
							<li><strong>Expédition le </strong> : '.inverser_date($envoie_date,6).'</li>
							<li><strong>Nom</strong> : '.$nom.' '.$prenom.'</li>				
						</ul>
						
						<div class="bas">Total HT : '.$total_prix.'&euro;; + '.$total_ecotaxe.'&euro;; éco</div>
					</td>
					
					<td class="c"><h5>Panier</h5>
						<ul class="panier">
							'.$liste_panier.'
						</ul>
					</td>
					
					<td class="d">
						<div class="boutonBlanc"><a href="?admin-commandes-infos&id='.$id_commande.'">Infos sur la commande</a></div>
						<div class="boutonBlanc"><a href="?admin-commandes-gestion&action=annulerPaiement&id='.$id_commande.'">Annuler paiement</a></div>
						<div class="boutonBlanc"><a href="?admin-commandes-gestion&action=annulerExpedition&id='.$id_commande.'">Annuler expédition</a></div>						
					</td>
				</tr>
			</table>';
	
	}		

break;

}

	$design->zone('titre', 'Gestion des commandes');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>