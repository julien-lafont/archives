<?php
securite_admin('editorial');

	$page="?admin-produits-gerer";
	$table=PREFIX."produits";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="edit_ok") $retour=miseEnForme('ok', "Le produit a été modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme('bad', "Le produit n'a pas pu être édité car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme('bad', "Le produit n'a pas pu être édité car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="stock_ok") $retour=miseEnForme('ok', "Le stock du produit a été modifié avec succés");
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="?admin-produits-gerer">Gestion des produits</a> / <strong>Gestion</strong>';
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *, p.nom as nomProduit, p.image as imageProduit, c.nom as nomCat, m.nom as nomMarque
						FROM $table p
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=p.id_cat
						LEFT JOIN ".PREFIX."marques m
						ON m.id_marque=p.id_marque
						ORDER BY p.id_produit DESC
						LIMIT 0,10") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));	

		// Gestion du logo
		if (empty($imageProduit)) $imageP=CHEMIN_DEFAUT.'no_logo1.png';
		else $imageP="pages/fonctions/redim.php?imgfile=".$imageProduit."&max_height=120&max_width=120";
		
		// Gestion du SELECT 'Stock'
		($stock=="stock") ? $s1="selected" : $s1=NULL;
		($stock=="last") ? $s2="selected" : $s2=NULL;
		($stock=="reapp") ? $s3="selected" : $s3=NULL;
		($stock=="epuise") ? $s4="selected" : $s4=NULL;
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Produit <span>#'.$id_produit.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nomProduit.'</li>
							<li><strong>Référence</strong> : '.$reference.'</li>
							<li><strong>Catégorie</strong> : '.$nomCat.'</li>						
							<li><strong>Marque</strong> : '.$nomMarque.'</li>
							
						</ul>
						
						<div class="bas"><span style="font-weight:normal">[Eco: '.$ecotaxe.' &euro;]</span> Prix HT: '.$prix.' &euro; <br />
										Prix TTC: '.round($prix*TAXE,2).' &euro; </div>
					</td>
					
					<td class="c"><h5>Photo</h5><br />
						<p class="centre">
							<img src="'.$imageP.'" alt="'.$nomProduit.'" />
						</p>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="'.$page.'&action=editer&id='.$id_produit.'">Editer infos</a></div>
						<div class="boutonBlanc"><a href="'.$page.'&action=supprimer&id='.$id_produit.'">Supprimer</a></div>
					
						<form action="?admin-produits-gerer&action=stock_live&id='.$id_produit.'" method="post" style="margin:0">
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

case "editer":

	$id=(int)$_GET['id'];
	
	// Sélection des données :
	$sql=mysql_query("SELECT * FROM $table WHERE id_produit=$id");
		extract(recupBdd(mysql_fetch_array($sql)));	

	// Mise en forme des catégories :
	$catOptions='';
	$sqlCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=0");
	while($cat=mysql_fetch_object($sqlCat)) {
		
		// On ajoute la catégorie à la liste:
			if ($id_cat==$cat->id_cat) $s="selected";
			else					   $s="";
		$catOptions.='<option value="'.$cat->id_cat.'" style="font-weight:bold" '.$s.'>'.recupBdd($cat->nom).'</option>';
		
		// Sélection des sous catégories
	 	$sqlSousCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=".$cat->id_cat);
	 	while($scat=mysql_fetch_object($sqlSousCat)) {
	 			if ($id_cat==$scat->id_cat) $s="selected";
				else					    $s="";
			$catOptions.='<option value="'.$scat->id_cat.'" style="padding-left:15px" '.$s.'>'.recupBdd($scat->nom).'</option>';
		}
		
	}
	
	// Mise en forme de la marque
	$marqueOptions='';
	$sqlMar=mysql_query("SELECT * FROM ".PREFIX."marques");
	while($mar=mysql_fetch_object($sqlMar)) {
		
			if ($id_marque==$mar->id_marque) $s="selected";
			else					   $s="";
			
		// On ajoute la marque à la liste
		$marqueOptions.='<option value="'.$mar->id_marque.'" '.$s.'>'.recupBdd($mar->nom).'</option>';
	
	}	
	
	// Gestion du SELECT 'Stock'
		if ($stock=="stock")  $s1="selected";
		if ($stock=="last")   $s2="selected";
		if ($stock=="reapp")  $s3="selected";
		if ($stock=="epuise") $s4="selected";
		
	// Gestion des images supplémentaires :
	if (!empty($images_plus_s)) {
		$liste=unserialize($images_plus_s); $liste_plus='';
		foreach($liste as $cle=>$val) {
			$liste_plus.='<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image_plus_'.$cle.'\'); return false;" >Parcourir</a></div>
							<input type="text" name="image_plus_'.$cle.'" id="image_plus_'.$cle.'" style="margin:5px 20px 10px 25px; width:300px" value="'.$val.'"><br />';

		}
	}
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="?admin-produits-gerer">Gestion des produits</a> / <strong>Editer un produit</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1" onsubmit="$(\'#description\').val(oEdit1.getHTMLBody());$(\'#caracteristiques\').val(oEdit2.getHTMLBody());">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un produit</h3>
			
			<label for="nom"><b><span class="req">*</span>Nom du produit :</b>
				<input id="nom" name="nom" value="'.$nom.'" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
			</label>
			
			<label for="reference"><b>Référence</b>
				<input id="reference" name="reference" value="'.$reference.'" type="text" class="f-name" tabindex="2" /><br />
			</label>

			<label for="prix"><b><span class="req">*</span>Prix en &euro; HT</b>
				<input id="prix" name="prix" value="'.$prix.'" type="text" class="f-name" tabindex="3" /><br />
			</label>

			<label for="ecotaxe"><b><span class="req">*</span>Ecotaxe en &euro;</b>
				<input id="ecotaxe" name="ecotaxe" value="'.$ecotaxe.'" type="text" class="f-name" tabindex="4" /><br />
			</label>

			<label for="stock"><b><span class="req">*</span>Stock</b>
				<select id="stock" name="stock" tabindex="5" />
					<option value="stock" '.@$s1.'>En stock</option>
					<option value="last" '.@$s2.'>Dernières pièces</option>					
					<option value="reapp" '.@$s3.'>En réapprovisionnement</option>
					<option value="epuise" '.@$s4.'>Epuisé</option>
				</select>
			</label>
			
			<label for="id_cat"><b><span class="req">*</span>Catégorie</b>
				<select id="id_cat" name="id_cat" tabindex="6">
					'.$catOptions.'
				</select>
			</label>
			
			<label for="id_marque"><b>Marque</b>
				<select id="id_marque" name="id_marque" tabindex="6">
					'.$marqueOptions.'
				</select>
			</label>
			
			<label for="image"><b>Image principale</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image\'); return false">Parcourir</a></div>
				<input type="text" name="image" id="image" value="'.$image.'" style="margin:5px 20px 0px 25px; width:300px" tabindex="4"><br />
			</label>
			
			<label for="image_plus"><b>Ajouter des photos</b><a href="#" onclick="ajouter_photos(); return false">Afficher un champ supplémentaire</a>
				<div id="image_plus">'.$liste_plus.'</div>
			</label>
			
			<label for="description"><b>Description</b>
				<pre id="descriptionH" name="descriptionH" style="display:none">'.$description.'</pre>
				<input type="hidden" name="description" id="description" />
					
					<script>
						var oEdit1 = new InnovaEditor("oEdit1");
						oEdit1.btnStyles=true;
				
						oEdit1.css="theme/styles_editor.css";
						oEdit1.width=650
						oEdit1.height=400
						oEdit1.features=["XHTMLSource","Preview","Search","SpellCheck",
							"Cut","Copy","Paste","PasteWord","PasteText","|",
							"Undo","Redo","|",
							"Clean","ClearAll","|",
							"Image","Flash","Media","Bookmark","Hyperlink","|",
							
							"BRK",
							"Numbering","Bullets","|","Indent","Outdent","|",
							"Table","Guidelines","Absolute","|",
							"Characters","Line",
							"Form","|","Superscript","Subscript","|",
							"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
							
							"BRK",
							"CssText","StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting","ParagraphFormatting","Styles","|",
							"Paragraph","FontName","FontSize","|",
							"Bold","Italic","Underline","Strikethrough","|",
							"ForeColor","BackColor","|"];
							
						oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
						oEdit1.cmdAssetManager="modalDialogShow(\''.URL_REL.'include/Editor/assetmanager/assetmanager.php?lang=french\',640,465)";
						oEdit1.mode="XHTMLBody";
						
						oEdit1.RENDER($("#descriptionH").html());
					</script><br />
			</label>
			
			<label for="caracteristiques"><b>Caracteristiques</b>
				<pre id="caracteristiquesH" name="caracteristiquesH" style="display:none">'.$caracteristiques.'</pre>
				<input type="hidden" name="caracteristiques" id="caracteristiques" />
					
					<script>
						var oEdit2 = new InnovaEditor("oEdit2");
						oEdit2.btnStyles=true;
				
						oEdit2.css="theme/styles_editor.css";
						oEdit2.width=650
						oEdit2.height=400
						oEdit2.features=["XHTMLSource","Preview","Search","SpellCheck",
							"Cut","Copy","Paste","PasteWord","PasteText","|",
							"Undo","Redo","|",
							"Clean","ClearAll","|",
							"Image","Flash","Media","Bookmark","Hyperlink","|",
							
							"BRK",
							"Numbering","Bullets","|","Indent","Outdent","|",
							"Table","Guidelines","Absolute","|",
							"Characters","Line",
							"Form","|","Superscript","Subscript","|",
							"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
							
							"BRK",
							"CssText","StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting","ParagraphFormatting","Styles","|",
							"Paragraph","FontName","FontSize","|",
							"Bold","Italic","Underline","Strikethrough","|",
							"ForeColor","BackColor","|"];
							
						oEdit2.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
						oEdit2.cmdAssetManager="modalDialogShow(\''.URL_REL.'include/Editor/assetmanager/assetmanager.php?lang=french\',640,465)";
						oEdit2.mode="XHTMLBody";
						
						oEdit2.RENDER($("#caracteristiquesH").html());
					</script><br />
			</label>
			
			
			<input type="submit" value="Submit" class="f-submit" /><br />

		</fieldset>
		</form>';

		//:: Configuration du HTML AREA
		$header='	<script language=JavaScript src="include/Editor/scripts/language/french/editor_lang.js"></script>
					<script language=JavaScript src="include/Editor/scripts/innovaeditor.js"></script>';
		$design->zone('header', $header);
break;

case "editer_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=addslashes_array($_POST);
	
	// Gestions des images supplémentaires
	$liste_image_plus=array(); $img_plus_modif=false;
	foreach($donnees as $cle=>$val) {
		if (strpos($cle, 'image_plus_')!==false) {
			$liste_image_plus[]=$val;
			unset($donnees[$cle]);
			$img_plus_modif=true;
		}
	}
		// On ajoute la listes des images supplémentaires dans un champs sérializé
		if ($img_plus_modif) $donnees['images_plus_s']=serialize($liste_image_plus);
	
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&id='.$id.'&mess=edit_erreurForm', $donnees, array('nom', 'id_cat', 'prix', 'stock'));

	// Ajout dans la bdd 
	$sql=majBdd($table, '`id_produit`='.$id, $donnees);
	
	
	if ($sql) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }
	
break;

case "supprimer":
	
	$id_produit=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_produit=$id_produit");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "stock_live":

	$id=(int)$_GET['id'];
	$stock=$_POST['stock'];
	
	$sql=mysql_query("UPDATE $table SET `stock`='$stock' WHERE `id_produit`=$id");
	header('location: '.$page.'&mess=stock_ok');

break;
}

	$design->zone('titre', 'Gestion des produits');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>