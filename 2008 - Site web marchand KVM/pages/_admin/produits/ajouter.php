<?php
securite_admin('editorial');

	$page="?admin-produits-ajouter";
	$table=PREFIX."produits";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme('ok', "Le nouveau produit a été ajouté avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme('bad', "Le nouveau produit n'a pas pu être ajouté car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme('bad', "Le nouveau produit n'a pas pu être ajouté car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

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
	
	// Mise en forme de la marque
	$marqueOptions='';
	$sqlMar=mysql_query("SELECT * FROM ".PREFIX."marques");
	while($mar=mysql_fetch_object($sqlMar)) {
		
		// On ajoute la marque à la liste
		$marqueOptions.='<option value="'.$mar->id_marque.'">'.recupBdd($mar->nom).'</option>';
	
	}	
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="?admin-produits-gerer">Gestion des produits</a> / <strong>Ajouter un produit</strong>';

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1" onsubmit="$(\'#description\').val(oEdit1.getHTMLBody());$(\'#caracteristiques\').val(oEdit2.getHTMLBody());">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter un produit</h3>
			
			<label for="nom"><b><span class="req">*</span>Nom du produit :</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
			</label>
			
			<label for="reference"><b>Référence</b>
				<input id="reference" name="reference" type="text" class="f-name" tabindex="2" /><br />
			</label>

			<label for="prix"><b><span class="req">*</span>Prix en &euro; HT</b>
				<input id="prix" name="prix" type="text" class="f-name" tabindex="3" /><br />
			</label>

			<label for="ecotaxe"><b><span class="req">*</span>Ecotaxe en &euro;</b>
				<input id="ecotaxe" name="ecotaxe" type="text" class="f-name" tabindex="4" /><br />
			</label>

			<label for="stock"><b><span class="req">*</span>Stock</b>
				<select id="stock" name="stock" tabindex="5" />
					<option value="stock">En stock</option>
					<option value="last">Dernières pièces</option>					
					<option value="reapp">En réapprovisionnement</option>
					<option value="epuise">Epuisé</option>
				</select>
			</label>
			
			<label for="id_cat"><b><span class="req">*</span>Catégorie</b>
				<select id="id_cat" name="id_cat" tabindex="6">
					'.$catOptions.'
				</select>
			</label>
			
			<label for="id_marque"><b>Marque</b>
				<select id="id_marque" name="id_marque" tabindex="6">
					<option value="0"> / </option>
					'.$marqueOptions.'
				</select>
			</label>
			
			<label for="image"><b>Image principale</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image\'); return false">Parcourir</a></div>
				<input type="text" name="image" id="image" style="margin:5px 20px 0px 25px; width:300px" tabindex="4"><br />
			</label>
			
			<label for="image_plus"><b>Ajouter des photos</b><a href="#" onclick="ajouter_photos(); return false">Afficher un champ supplémentaire</a>
				<div id="image_plus"></div>
			</label>
			
			<label for="description"><b>Description</b>
				<pre id="descriptionH" name="descriptionH" style="display:none"></pre>
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
				<pre id="caracteristiquesH" name="caracteristiquesH" style="display:none"></pre>
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

case "ajouter_verif":

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
	verif_champs_requis($page.'&mess=ajout_erreurForm', $donnees, array('nom', 'id_cat', 'prix', 'stock'));

	// Ajout dans la bdd 
	$sql=insererBdd($table, $donnees);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=ajout_erreurSql'); die(); }
	
		
break;
}

	$design->zone('titre', 'Gestion des produits');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>