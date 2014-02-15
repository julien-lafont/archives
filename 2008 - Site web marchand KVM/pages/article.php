<?php
/* 
 * KVM E-commerce : article-#ID-Description_facultative.htm
 *
 * Affiche les informations détaillées d'un produit
 */
 
//----------- Bloquer accés si appel incorrect de la page ------------//
if (!$_GET['id'] || empty($_GET['id']) || !is_numeric($_GET['id'])) {
	bloquerAcces('Vous ne pouvez pas accéder à cette page directement');
	die();
}

$id=(int)$_GET['id'];

//-- Sélection des données du produit
$sql=mysql_query("	SELECT *, p.nom as nomProduit, c.nom as nomCategorie, m.nom as nomMarque, p.image as imageProduit, p.description as descriptionProduit
					FROM ".PREFIX."produits p
					LEFT JOIN ".PREFIX."categories  c
					ON c.id_cat=p.id_cat
					LEFT JOIN ".PREFIX."marques m
					ON m.id_marque=p.id_marque
					WHERE p.id_produit=$id") or die(mysql_error());
$nb=mysql_affected_rows(); // ( renvoie -1/0/1 )

//-- Aucun produit lié
if ($nb!=1) 
	bloquerAcces('Cet article ne fait pas ou plus parti de notre base de donnée');

//-- Un produit trouvé dans notre base de donnée	
else {

	extract(recupBdd(mysql_fetch_array($sql)));

	// Gestion de l'image principale :
	if (empty($imageProduit)) 
		$imageP='<img src="pages/fonctions/redim.php?imgfile='.CHEMIN_DEFAUT.'no_logo1.png&&max_height=120&max_width=120" alt="'.$nom.'" id="imageProduit'.$id_produit.'"/>';
	else 
		$imageP=' <img src="pages/fonctions/redim.php?imgfile='.$imageProduit.'&max_height=120&max_width=120" alt="'.$nom.'" id="imageProduit'.$id_produit.'" /><br />
				  <img src="images/boutons/picture.png" /> <a href="'.$imageProduit.'" class="thickbox" title="'.$nom.'">Agrandir</a>'; 
	
	// On liste les photos supplémentaires :
	if (!empty($images_plus_s)) {
		$liste=unserialize($images_plus_s); $liste_plus='<ul class="liste_photos">';
		foreach($liste as $cle=>$val) {
			$liste_plus.='<li><a href="'.$val.'" class="thickbox" rel="liste"><img src="pages/fonctions/redim.php?imgfile='.$val.'&max_height=120&max_width=120" /></a></li>';

		}
		$liste_plus.='</ul><br style="clear:both" />';
	}

	// Gestion de la devise
	/*if (is_numeric($_SESSION['sess_id_devise']) && $_SESSION['sess_id_devise']!=0) {
		$idD=(int)$_SESSION['sess_id_devise'];
		$sql_devise=mysql_query("SELECT symbole_g, symbole_d, convers_euro FROM ".PREFIX."devises WHERE id_devise=".$idD);
		$devise=mysql_fetch_object($sql_devise);
			$prix_regional_ttc=$devise->symbole_g.' '.round($prix*$devise->convers_euro*TAXE,2).' '.$devise->symbole_d;
			$prix_regional_ht=$devise->symbole_g.' '.round($prix*$devise->convers_euro,2).' '.$devise->symbole_d;
			$prix_regional_eco=$devise->symbole_g.' '.round($ecotaxe*$devise->convers_euro,2).' '.$devise->symbole_d;
	}*/
			$prix_regional_ttc=round($prix*TAXE,2).' &euro;';
			$prix_regional_ht=round($prix,2).' &euro;';
			$prix_regional_eco=round($ecotaxe,2).' &euro;';

	
	// Mise en forme du fil d'ariane :
		$chemin='<br /><div id="breadcrumb"><a href="'.URL.'" title="'.DESCRIPTION.'">'.NOM.'</a> / ';
	$sql1=mysql_query("SELECT id_cat_parent, nom FROM ".PREFIX."categories WHERE id_cat=$id_cat");
	$c1=mysql_fetch_object($sql1);
		
		// Y-a-t-il une catégorie principale ?
		if ($c1->id_cat_parent!=0) {
			$sql2=mysql_query("SELECT id_cat, nom FROM ".PREFIX."categories WHERE id_cat=".$c1->id_cat_parent);
			$c2=mysql_fetch_object($sql2);
			
			$chemin.='<a href="categorie-'.$c2->id_cat.'-'.recode(recupBdd($c2->nom)).'.htm" title="Afficher les informations du produit '.recupBdd($c2->nom).'">'.recupBdd($c2->nom).'</a> / ';
		}
	$chemin.='<a href="categorie-'.$id_cat.'-'.recode(recupBdd($c1->nom)).'.htm" title="Afficher les informations du produit '.recupBdd($c1->nom).'">'.recupBdd($c1->nom).'</a> / ';
	$chemin.='<strong>'.recupBdd($nomProduit).'</strong></div>';			
		$design->zone("fil_ariane", $chemin);		
	
	// On met finalement en forme les infps	
	$c='<table class="table_info">
			<tr>
				<td class="a">
					'.$imageP.'
				</td>
				<td class="b"><h4 style="margin:0 0 15px 0">'.$nomProduit.'</h4>
					
					<em>Référence constructeur :</em> <span>'.$reference.'</span><br />
					<em>Référence '.NOM.' :</em> <span>#'.$id_produit.'</span><br />
					<em>Marque :</em> <span>'.$nomMarque.'</span><br /><br />
					
					<div style="width:200px; float:right">
						<img src="images/boutons/cart_put.png" /> <a href="#" onclick="ajouter_panier('.$id_produit.'); return false">Ajouter à mon panier</a>
					</div>
					<div class="prix">
						<em>Prix TTC:</em> <span><strong>'.$prix_regional_ttc.'</strong></span><br />
						<em>Prix HT:</em> <span>'.$prix_regional_ht.'</span><br />
						<em>Ecotaxe:</em> <span>'.$prix_regional_eco.'</span>
					</div>
				</td>
			</tr>
		</table>
		
		<div class="usual" id="usual11"> 
		  <ul> 
			<li><a href="#tab1">Description</a></li> 
			<li><a href="#tab2">Caractéristiques</a></li> 
			<li><a href="#tab3">Photos</a></li> 
		  </ul> 
		  <div id="tab1" ><h3 style="margin:5px 0 15px 15px; color:#333;">Description de l\'article</h3> '.$descriptionProduit.'</div> 
		  <div id="tab2" style="display:none"><h3 style="margin:5px 0 15px 15px; color:#333;">Caractéristiques de l\'article</h3> '.$caracteristiques.'</div> 
		  <div id="tab3" style="display:none"><h3 style="margin:5px 0 15px 15px; color:#333;">Photos supplémentaires</h3> '.$liste_plus.'</div> 
		</div> 
		 
		<script type="text/javascript"> 
		  $(document).ready(function() {
   			 $.tabs("usual11");
		  });
		</script>';
		
	$design->zone("titre", "Informations sur l'article ".$nomProduit);
	$design->zone("contenu", $c);
	
	// Optimisation du référencement
	$design->zone('meta_keywords', KEYWORDS.', article, produit, '.$nom);
	$design->zone('meta_description', tronquerChaine(NOM.' - Information sur l\'article : '.$nom.' : '.strip_tags($descriptionProduit), 200));

	// On incrémente le compteur de 'nombre de fois vues'
	$sql=mysql_query("UPDATE ".PREFIX."produits SET nb_vue=nb_vue+1 WHERE id_produit=$id");
}

?>