<?php
securite_admin('editorial');

	$page="?admin-produits-rechercher";
	$table=PREFIX."produits";
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
			<fieldset>

				<h3>Rechercher un produit</h3>
		
				<label for="nom"><b>Par son nom</b>
					<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
				</label
				<label for="id"><b>Par son ID</b>
					<input id="id" name="id" type="text" class="f-name" tabindex="3" /><br />
				</label>
				<label for="reference"><b>Par sa référence</b>
					<input id="reference" name="reference" type="text" class="f-name" tabindex="2" /><br />
				</label>
						
				<input type="submit" value="Rechercher" class="f-submit" /><br />

		</fieldset>
	</form>';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="erreurForm") $retour=miseEnForme('bad', "Vous devez remplir un des 3 champs !");
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="?admin-produits-gerer">Gestion des produits</a> / <strong>Rechercher un produit</strong>';
	$c=$recherche;
	
break;

case "search":
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="?admin-produits-gerer">Gestion des produits</a> / <strong>Rechercher un produit</strong>';
	$c=$recherche;
	
	// Gestion de la requete sql : un seul champs nécessaire => Ordre de priorité : nom>id>ref
	$donnees=addslashes_array($_POST);	

	if 		(!empty($donnees['nom'])) 		$where="p.nom like '%".$donnees['nom']."%'";
	elseif  (!empty($donnees['id']))		$where="p.id_produit = ".$donnees['id'];
	elseif  (!empty($donnees['reference'])) $where="p.reference like '%".$donnees['reference']."%'";
	else	{ header('location: '.$page.'&mess=erreurForm'); die();  }
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *, p.nom as nomProduit, c.nom as nomCat, m.nom as nomMarque
						FROM $table p
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=p.id_cat
						LEFT JOIN ".PREFIX."marques m
						ON m.id_marque=p.id_marque
						WHERE $where 
						ORDER BY p.id_produit DESC") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));	

		// Gestion du logo
		if (empty($image)) $image=CHEMIN_DEFAUT.'no_logo1.png';
		else $image="pages/fonctions/redim.php?imgfile=".$image."&max_height=120&max_width=120";
		
		// Gestion du SELECT 'Stock'
		if ($stock=="stock")  $s1="selected";
		if ($stock=="last")   $s2="selected";
		if ($stock=="reapp")  $s3="selected";
		if ($stock=="epuise") $s4="selected";
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Produit <span>#'.$id_produit.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nomProduit.'</li>
							<li><strong>Référence</strong> : '.$reference.'</li>
							<li><strong>Catégorie</strong> : '.$nomCat.'</li>						
							<li><strong>Marque</strong> : '.$nomMarque.'</li>
							
						</ul>
						
						<div class="bas"><span style="font-weight:normal">[Eco: '.$ecotaxe.' &euro;]</span> Prix: '.$prix.' &euro; </div>
					</td>
					
					<td class="c"><h5>Photo</h5><br />
						<p class="centre">
							<img src="'.$image.'" alt="'.$nomProduit.'" />
						</p>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="?admin-produits-gerer&action=editer&id='.$id_produit.'">Editer infos</a></div>
						<div class="boutonBlanc"><a href="?admin-produits-gerer&action=supprimer&id='.$id_produit.'">Supprimer</a></div>
					
						<form action="?admin-produits-gerer&action=stock_live&id='.$id_produit.'" style="margin:0" method="POST">
							<select name="stock">
								<option value="stock" '.@$s1.'>En stock</option>
								<option value="last" '.@$s2.'>Dernières pièces</option>					
								<option value="reapp" '.@$s3.'>En réapprovisionnement</option>
								<option value="epuise" '.@$s4.'>Epuisé</option>
							<input type="submit" value="Mettre à jour" class="f-submit"/>
						</form>
		
					
					</td>
				</tr>
			</table>';
	
	}		

break;

}

	$design->zone('titre', 'Gestion des produits');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>