<?php
securite_admin('commandes');


	// Mode imprimer ?
	if ($_GET['mode'] && $_GET['mode']=="imprimer") $design->template('impression');
	
	$page="?admin-commandes-infos";
	$table=PREFIX."commandes";
	$id=(int)$_GET['id'];
	
	if (empty($id)) header('location: ?admin-commandes-attentes');
	
	// Sélection des infos sur la commande
	$sql=mysql_query("SELECT * FROM $table WHERE id_commande=$id");
		@extract(recupBdd(mysql_fetch_array($sql)));
		
	// Sélections des infos sur le membre :
	$sqlMembre=mysql_query("SELECT *
							FROM ".PREFIX."membres m
							LEFT JOIN ".PREFIX."membres_config mc
							ON mc.id_membre=$id_membre
							LEFT JOIN ".PREFIX."membres_infos mi
							ON mi.id_membre=$id_membre
							WHERE m.id_membre=$id_membre");
		$m=mysql_fetch_object($sqlMembre);
	
	$c='<h2>Informations sur l\'acheteur : '.recupBdd($m->pseudo).'</h2><br />
	
		<table class="table1 infos">
			<tbody>
				<th style="width:50%">Adresse postale</th>
				<th>Autres informations</th>
			</tbody>
			<tr>
				<td style="padding-left:15px">
					<strong>Genre : </strong> '.$m->genre.'<br />
					<strong>Nom : </strong>'.recupBdd($m->nom).' '.recupBdd($m->prenom).'<br />
					<strong>Adresse : </strong>'.recupBdd($m->adresse).'<br />
					<strong>CP : </strong>'.recupBdd($m->cp).'<br />
					<strong>Ville : </strong>'.recupBdd($m->ville).'<br />
					<strong>Pays : </strong>'.recupBdd($m->pays).'<br />
				</td>
				<td style="padding-left:15px">
					<strong>Email : </strong> '.$m->email.'<br />
					<strong>Langue : </strong> '.$m->lengue.'<br />
					<strong>Téléphone : </strong> '.$m->tel.'<br />
					<strong>Portable : </strong> '.$m->portable.'<br />
				
				</td>
			</tr>
		</table>
		
		<h2>Liste des produits</h2><br />
		
		<table class="table1 infos">
			<tbody>
				<th style="width:120px">Photo</th>
				<th>Infos</th>
				<th style="width:10%">Prix/Ecotaxe</th>
				<th style="width:5%">Qtté</th>
				<th style="width:10%">Total</th>
			</tbody>';
		
		
	// Gestion du panier
		$panier=unserialize($liste_produits_s); $liste_panier=''; $i=0;
		foreach($panier as $cle=>$val) {
			$idProd=$val[0];
			$nbProd=$val[1];
			
			$sqlP=mysql_query("SELECT id_produit, nom, stock, image, prix, ecotaxe FROM ".PREFIX."produits WHERE id_produit=$idProd");
			$p=mysql_fetch_object($sqlP);
			
				// Stock de chaques produits
				if ($p->stock=="stock")  { $couleur="vert"; $stockP="En stock"; }
				if ($p->stock=="last") 	 { $couleur="bleu"; $stockP="Dernières pièces"; }
				if ($p->stock=="reapp")  { $couleur="orange"; $stockP="En Réapprovisionnement"; }
				if ($p->stock=="epuise") { $couleur="rouge"; $stockP="Produit épuisé"; }
			
				// Gestion du logo
				if (empty($p->image)) $imageP=CHEMIN_DEFAUT.'no_logo1.png';
				else $imageP="pages/fonctions/redim.php?imgfile=".$p->image."&max_height=120&max_width=120";
							
			$c.='<tr>
					<td style="text-align:center"><img src="'.$imageP.'" /></td>
					<td><strong>Nom : </strong>'.recupBdd($p->nom).'<br />
						<strong>Id / Référence : </strong>'.$p->id_produit.' / '.recupBdd($p->reference).'<br />
						<strong>Stock : </strong><img src="theme/admin/css/images/puce_'.$couleur.'.png" /> '.$stockP.'</td>
					<td>'.$p->prix.' &euro;<br />
						+ '.$p->ecotaxe.' &euro; éco</td>					
					<td style="vertical-align:middle; text-align:center">x '.$nbProd.'</td>					
					<td style="color:#0066FF"><strong><strong>'.($p->prix*$nbProd).'</strong> &euro;<br />
						 + <strong>'.($p->ecotaxe*$nbProd).'</strong> &euro; éco</td>					
				</tr>';
		}
		
		$c.='<tr>
				<td colspan="4" style="text-align:right; padding-right:20px; font-weight:bold; border-bottom:1px solid #333">
					Total HT<br />
					Total TTC<br />
					Ecotaxe</td>
				<td style="color:#FF6600; font-weight:bold; border-bottom:1px solid #333">
					'.$total_prix.' &euro;<br />
					'.round(($total_prix*(float)TAXE),2).' &euro;<br />
					'.$total_ecotaxe.' &euro;
				</td>
			</tr>';
			
	// Sélections des données sur les frais de port
	$sqlFdp=mysql_query("SELECT * FROM ".PREFIX."frais_de_ports WHERE id_fdp=$id_fdp");
	$f=mysql_fetch_object($sqlFdp);
		
		// Gestion du logo
		if (empty($f->logo)) $imageF=CHEMIN_DEFAUT.'no_logo1.png';
		else $imageF="pages/fonctions/redim.php?imgfile=".$f->logo."&max_height=70&max_width=70";
		
		$c.='<tr>
				<td style="text-align:center; border-bottom:1px solid #333"><img src="'.$imageF.'" /></td>
				<td style="border-bottom:1px solid #333">'.recupBdd($f->mode_envoie).'</td>
				<td colspan="2" style="text-align:right; padding-right:20px; font-weight:bold; border-bottom:1px solid #333">Frais de port</td>
				<td style="border-bottom:1px solid #333">'.$f->prix_euros.' &euro;</td>
			</tr>
			
			<tbody>
				
				<th colspan="4" style="text-align:right; padding-right:20px; font-weight:bold; ">
					Total TTC+Eco+Fdp
				</td>
				<th  style="text-align:right; padding-right:20px; font-weight:bold;">
					'.round( ($total_prix*(float)TAXE) + $total_ecotaxe + $f->prix_euros ,2) .' &euro;
				</td>
			</tbody	
		</table>
		
		
		<h2>Informations sur la commande</h2><br />
		<ul>
			<li><strong>Statut</strong> : '.$statut.'</li>
			<li><strong>Mode paiement</strong> : '.$mode_paiement.'</li>
			<li><strong>Référence paiement</strong> : '.$ref_paiement.'</li>
			<li><strong>Validation le </strong> : '.inverser_date($validation_date,6).'</li>
			<li><strong>Paiement le </strong> : '.inverser_date($paiement_date,6).'</li>
			<li><strong>Expédition le </strong> : '.inverser_date($envoie_date,6).'</li>
		</ul>';
	

	$design->zone('titre', 'Information sur une commande');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
?>