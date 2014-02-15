<?php
securite_admin('commandes');

	$page="?admin-commandes-attentes";
	$table=PREFIX."commandes";
	

switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("	SELECT * 
						FROM ".$table." c
						LEFT JOIN ".PREFIX."membres_infos mi
						ON mi.id_membre=c.id_membre
						WHERE statut='en_attente' 
						ORDER BY id_commande ASC");
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Commandes</a> / <strong>Gestions des commandes en attente de paiement';
	
	// Mise en forme du bloc principal
	$c='';
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
							<li><strong>Nom</strong> : '.$nom.' '.$prenom.'</li>
							<li><strong>Paiement</strong> : '.$mode_paiement.'</li>						

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
						<div class="boutonBlanc"><a href="?admin-commandes-gestion&action=payer&id='.$id_commande.'">Signaler comme payé</a></div>
						<div class="boutonBlanc"><a href="?admin-commandes-gestion&action=expedier&id='.$id_commande.'">Signaler comme expédié</a></div>
					</td>
				</tr>
			</table>';
	
	}
			
break;
}

	$design->zone('titre', 'Commandes en attente de paiement');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
?>