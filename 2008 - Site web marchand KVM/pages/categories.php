<?php

/* 
 * KVM E-commerce : categories.htm et categorie-#ID-Description_facultative.htm
 *
 * Première partie : affiche la liste des catégories
 * Seconde partie : Affiche les produits d'une catégorie spécifique
 */
 
 
   // -------------------------------------------------------------------------------------------------- //
  //								Page principale : affiches toutes les catégories					//
 //                                               /categories.htm                                      // 
// -------------------------------------------------------------------------------------------------- //

if (!$_GET['id']) {
	
	// Sélection de la liste des catégories
	$sql=mysql_query("	SELECT *
						FROM ".PREFIX."categories
						WHERE id_cat_parent=0
						ORDER BY nom ASC") or die (mysql_error());
						
	$c='<ul id="liste_cat">'; $keyword='';
	
	while($d=mysql_fetch_array($sql)) {
		extract(recupBdd($d));
		
		// Nombres de produits liés :
		$sqlL=mysql_query("SELECT count(id_produit) as nb FROM ".PREFIX."produits WHERE id_cat=$id_cat");
		$queryL=mysql_fetch_object($sqlL) or die(mysql_error());
			$nb=$queryL->nb;
			
		// Sous catégories ?
		$sqlS=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=$id_cat");
		if (mysql_affected_rows()>0) {
			$sousCat='';
			while($s=mysql_fetch_object($sqlS)) {
				$sousCat.='<a href="categorie-'.$s->id_cat.'-'.recode(recupBdd($s->nom)).'.htm" title="Afficher les produits de la sous-catégorie '.recupBdd($s->nom).'">'.recupBdd($s->nom).'</a> - ';
			}
			$sousCat=substr($sousCat,0, -3);
		} else $sousCat='';
		
		// Mise en forme de la catégorie
		$c.='<li>
				<strong>'.$nom.'</strong> ('.$nb.')<br />
				<a href="categorie-'.$id_cat.'-'.recode($nom).'.htm" title="Afficher les produits de la gamme '.$nom.'">
					<img src="'.$image.'" alt="'.$nom.'" />
				</a><br />
				<span>'.$sousCat.'</span>
			</li>';
		
		// Gestion de la description, keyword pour référencement
		$keyword.=$nom.' ';
	
	}

	$c.='</ul>';
	
	// Gestion des zones + optimisation référencement
	$design->zone('titre', "Nos produits par catégories");
	$design->zone('meta_keywords', KEYWORDS.' '.$keyword);
	$design->zone('meta_description', tronquerChaine(NOM.' - Liste de nos produits classés par catégorie : '.$keyword, 200));

}

   // -------------------------------------------------------------------------------------------------- //
  //								Affiche une catégorie : liste des produits							//
 //                                 /categorie-#ID-Description_facultative.htm                         // 
// -------------------------------------------------------------------------------------------------- //

else if (is_numeric($_GET['id'])) {
	
	$id=(int)$_GET['id'];
	$sql=mysql_query("	SELECT *
						FROM ".PREFIX."categories
						WHERE id_cat=$id") or die (mysql_error());
	$d=mysql_fetch_object($sql);
					

		//--> Sous catégories ?
		$sqlS=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=".$d->id_cat);
		if (mysql_affected_rows()>0) {
			$c='<h3>Catégories liées</h3>
				<ul id="liste_cat">';
			while($s=mysql_fetch_object($sqlS)) {
				$c.='	<li>
								<strong>'.recupBdd($s->nom).'</strong><br />
								<a href="categorie-'.$s->id_cat.'-'.recode(recupBdd($s->nom)).'.htm" title="Afficher les produits de la sous-catégorie '.recupBdd($s->nom).'">
								<img src="'.$s->image.'" alt="'.recupBdd($s->nom).'" />
								</a>
							</li>';
			}
			$c.='</ul><hr />';
			
		} else $c='';
		
		
		
			//--------------------/ Pagination  /--------------------//
			$sql_pre=mysql_query("SELECT count(id_produit) as nb FROM ".PREFIX."produits WHERE id_cat=".$id);
			$pre=mysql_fetch_object($sql_pre);
				$nbG=$pre->nb;
		
			$page=(int)$_GET['page'];
			$first=($page*NB_ARTICLES)-(NB_ARTICLES);
				if ($first<0) $first=0;
			if ($first==null) $limit="LIMIT 0,".NB_ARTICLES; 
			else $limit="LIMIT $first,".NB_ARTICLES;
			
			$nbpages=ceil($nbG/NB_ARTICLES); $current=(round($first/NB_ARTICLES))+1;
			if ($nbpages>1) {
				$pagination='<div class="pagination"><p>';
				
					// Affichage de la case précédent :
					if ($current>1) $pagination.='<strong><a href="categorie-'.$id.'-'.recode(recupBdd($d->nom)).'.htm">&lsaquo;&lsaquo;</a></strong> 
												  <strong><a href="categorie-'.$id.'-'.recode(recupBdd($d->nom)).'-page-'.($current-1).'.htm">&lsaquo;</a></strong>&nbsp;&nbsp; ';
					
					// Affichage des 2 pages précédentes et des 2 pages suivantes ( si elles existent )
					$debut=$current-2; if ($debut<1) $debut=1;
					for ($i=$debut; $i<($debut+5); $i++) {
						if ($i>=1 && $i<=$nbpages) {
							if ($i==$current) 	$pagination.='<span><b>'.$i.'</b></span> ';
							else				$pagination.='<a href="categorie-'.$id.'-'.recode(recupBdd($d->nom)).'-page-'.$i.'.htm">'.$i.'</a> ';
						}
					}
					
					// Affichage de la case suivant :
					if ($current!=$nbpages) $pagination.='&nbsp;&nbsp;<strong><a href="categorie-'.$id.'-'.recode(recupBdd($d->nom)).'-page-'.($current+1).'.htm">&rsaquo;</a></strong> 
																	  <strong><a href="categorie-'.$id.'-'.recode(recupBdd($d->nom)).'-page-'.$nbpages.'.htm"">&rsaquo;&rsaquo;</a></strong>';
		
					// On affiche la page en cours pour finir
					$pagination.='<h4>Page '.$current.' sur '.$nbpages.'</h4></div>';
			}
			//--------------------/ Fin Pagination  /--------------------//


		//--> Sélection de tous les produits :
		$sqlP=mysql_query("	SELECT * 
							FROM ".PREFIX."produits 
							WHERE id_cat=$id 
							ORDER BY id_produit DESC
							".$limit);
			
		// Aucun article ?
		if (mysql_affected_rows()==0) 
			$c.='<div class="error"><br /><img src="images/boutons/exclamation.png" /> Aucun article dans cette catégorie<br /><br /></div>';
			
		//--> Des articles
		else {
		
			$c.=  $pagination.
				  '<table class="table_articles"  cellspacing="0" cellpadding="0">';
						
			$i=0; $keyword='';
			while ($p=mysql_fetch_array($sqlP)) {  extract(recupBdd($p));
				
			
				// Style alternatif une ligne sur deux
				if ($i%2==0) $class='class="a"';
				else		 $class='class="b"';
				
				// Gestion du logo
				if (empty($image)) $imageP=CHEMIN_DEFAUT.'no_logo1.png';
				else $imageP="pages/fonctions/redim.php?imgfile=".$image."&max_height=100&max_width=100";
				
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
						<td class="c">
							<strong>'.$prix_regional.' </strong> <img src="images/boutons/money.png" /><br />
							<a href="article-'.$id_produit.'-'.recode($nom).'.htm" title="Afficher les informations sur l\'article '.$nom.'">
								Informations
							</a> <img src="images/boutons/zoom.png" /><br />
							<a href="#" onclick="ajouter_panier('.$id_produit.'); return false;">Ajouter au panier</a> <img src="images/boutons/cart_put.png" />
						</td>
					</tr>';	
				
				$i++;
				$keyword.=', '.recupBdd($nom);
			
			}
			$c.='</table>'
				.$pagination;
				
			$keyword=substr($keyword, 2);
			
		}
			

	//--> Gestion des zones : optimisation référencement
	$design->zone('titre', "Articles liés à la catégorie ".recupBdd($d->nom));
	$design->zone('meta_keywords', KEYWORDS.', '.recupBdd($d->nom).$keyword);
	$design->zone('meta_description', tronquerChaine(NOM.' - Nos articles de la catégorie '.recupBdd($d->nom).' : '.$keyword, 200));

}

else die('Accés interdit');

	 $design->zone('contenu', $c);
	
	
		
?>