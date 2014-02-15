<?php
securite_admin('editorial');

	$page="?admin-produits-pageaccueil";
	$table=PREFIX."produits";


switch(@$_GET['action']) {

default:

	$c='<h2>Choisissez la zone que vous souhaitez modifier :</h2>
	<ul>
		<li><a href="'.$page.'&action=zone&nom=coup_de_coeur">Coup de coeur</a></li>
		<li><a href="'.$page.'&action=zone&nom=test">Test ( non réel )</a></li>
	</ul>';

break;

case "zone":

	$nomZone=$_GET['nom'];
	
	// Mise en forme des catégories :
	$catOptions='';
	$sqlCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=0");
	while($cat=mysql_fetch_object($sqlCat)) {
		
		// On ajoute la catégorie à la liste:
		$catOptions.='<option value="'.$cat->id_cat.'" style="font-weight:bold">'.recupBdd($cat->nom).'</option>';
		
		// Sélection des sous catégories
	 	$sqlSousCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=".$cat->id_cat);
	 	while($scat=mysql_fetch_object($sqlSousCat)) {
			$catOptions.='<option value="'.$scat->id_cat.'" style="padding-left:15px">'.recupBdd($scat->nom).'</option>';
		}
		
	}
	
	
	// Sélection des produits de la zone
		$liste_produits='';
	$sql=mysql_query("SELECT zone_".$nomZone." as liste FROM ".PREFIX."produits_accueil");
	$d=mysql_fetch_object($sql);
		if (empty($d->liste)) $liste_produits='<li class="error">Aucun produit</li>';
		else {
			foreach(unserialize($d->liste) as $key=>$idProduit) {
			
				// Sélection des infos sur le produit
				$sqlP=mysql_query("SELECT nom FROM ".PREFIX."produits WHERE id_produit=$idProduit");
				$p=mysql_fetch_object($sqlP);
				
				$liste_produits.='<li><a href="'.$page.'&action=suppr&zone='.$nomZone.'&id='.$idProduit.'">
										<img src="images/boutons/button_cancel.png" />
								      </a> '.recupBdd($p->nom).'
								  </li>';
			}
		}
		
	
	$c='<h2>Modifier les articles affichés dans la zone "'.$nomZone.'"</h2>
	
		<table class="zonesProduit">
			<tr>
				<td class="a">
					<strong>Produits présents dans la zone</strong><br /><br />
					<ul>
						'.$liste_produits.'
					</ul>
					
				</td>
				<td class="b"></td>
				<td class="c">
					<strong>Ajouter un produit</strong><br /><br />
					
						<form name="prem" action="#" method="post" class="f-wrap-1"><fieldset>
						<label for=""><b>Catégorie : </b>
							<select name="id_cat" id="select_cat" onChange="affichers_produits(\''.$nomZone.'\'); return false">
								<option value="0">Sélectionnez une catégorie</option>
								<option value="0"> </option>
								'.$catOptions.'
							</select>
						</label>
						</fieldset></form>
				
				</td>
				<td class="d" id="liste_produits">

				</td>			
			</tr>
		</table>';

break;

case "ajouter":

	$idProduit=(int)$_GET['id'];
	$zone=$_GET['zone'];
	
	// On récupère la liste actuelle
	$sqlRecup=mysql_query("SELECT zone_".$zone." as liste FROM ".PREFIX."produits_accueil");
	$d=mysql_fetch_object($sqlRecup);
	
		$liste=$d->liste;
		if (empty($liste)) 	$liste_array=array();
		else				$liste_array=unserialize($liste);
		
	// On y ajoute l'id du produit
	$liste_array[]=$idProduit;
	
	// On enregistre la nouvelle liste sérializée
	$liste_s=serialize($liste_array);
	$sqlUpd=mysql_query("UPDATE ".PREFIX."produits_accueil SET zone_".$zone."='$liste_s'");
	
	header('location: '.$page.'&action=zone&nom='.$zone);
	
break;


case "suppr":

	$idProduit=(int)$_GET['id'];
	$zone=$_GET['zone'];
	
	// On récupère la liste actuelle
	$sqlRecup=mysql_query("SELECT zone_".$zone." as liste FROM ".PREFIX."produits_accueil");
	$d=mysql_fetch_object($sqlRecup);
	
		$liste=$d->liste;
		if (!empty($liste)) {
			// On parcours puis on supprime l'article
			$liste_array=unserialize($liste);
			foreach($liste_array as $key=>$id) {
				if ($id==$idProduit) { unset($liste_array[$key]); break; }
			}
		
		}
	
	
	// On enregistre la nouvelle liste sérializée
	$liste_s=serialize($liste_array);
	$sqlUpd=mysql_query("UPDATE ".PREFIX."produits_accueil SET zone_".$zone."='$liste_s'");
	
	header('location: '.$page.'&action=zone&nom='.$zone);
	
break;
}

	$design->zone('titre', 'Gestion des produits affichés en page d\'accueil');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);

?>