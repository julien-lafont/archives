<?php
securite_admin('editorial');

	$page="?admin-produits-categories";
	$table=PREFIX."categories";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme('ok', "La nouvelle categorie a été ajoutée avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme('bad', "La nouvelle categorie n'a pas pu être ajoutée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme('bad', "La nouvelle categorie n'a pas pu être ajoutée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="suppr_ok") $retour=miseEnForme('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme('bad', "La suppression de la nouvelle categorie a échoué");	
		if ($mess=="edit_ok") $retour=miseEnForme('ok', "La nouvelle categorie a été modifiée avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme('bad', "La nouvelle categorie n'a pas pu être éditée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme('bad', "La nouvelle categorie n'a pas pu être éditée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM $table ORDER BY id_cat DESC");
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <strong>Gestion des categories';
	
	// Mise en forme du bloc principal
	$c='<div class="head_actions a3">
			<div class="boutonBlanc float"><a href="'.$page.'&action=ajouter">Ajouter une categorie</a></div>
			<br style="clear:both"  />
		</div>';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));

		// Gestion du logo
		if (empty($image)) $image=CHEMIN_DEFAUT.'no_logo1.png';
		
		// Nombre de produits liés ?
		$sqlN=mysql_query("SELECT count(id_cat) as nb FROM ".PREFIX."produits WHERE id_cat=$id_cat");
		$n=mysql_fetch_object($sqlN);
			$nb=round($n->nb);
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Categorie <span>#'.$id_cat.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nom.'</li>
							<li><strong>Produits liés</strong> : '.$nb.'</li>
							<li><strong>Description</strong> : '.tronquerChaine($description).'</li>						
						</ul>
					</td>
					
					<td class="c"><h5>Logo</h5><br />
						<p class="centre">
							<img src="'.$image.'" class="bordure1" alt="'.$nom.'" width="120" height="120" />
						</p>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="'.$page.'&action=editer&id='.$id_cat.'">Editer</a></div>
						<div class="boutonBlanc"><a href="'.$page.'&action=supprimer&id='.$id_cat.'">Supprimer</a></div>
					</td>
				</tr>
			</table>';
	
	}
			
break;

case "ajouter":
	
	// Liste des catégories parentes :
	$s_options="<option value='0'>--- Racine ---</option>";
	$sql=mysql_query("SELECT id_cat, nom FROM $table WHERE id_cat_parent=0 ORDER BY id_cat DESC");
	while($d=mysql_fetch_object($sql)) {
		$s_options.='<option value="'.$d->id_cat.'">'.recupBdd($d->nom).'</option>';
	}
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="'.$page.'">Gestion des catégories</a> / <strong>Ajouter une catégorie</strong>';


	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter une categorie</h3>
		
			<label for="nom"><b><span class="req">*</span>Nom :</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="50"/><br />
			</label>
			
			<label for="description"><b>Description en quelques mots</b>
				<textarea id="description" name="description" class="f-comments" rows="4" cols="30" tabindex="2"></textarea><br />
			</label>
	
			<label for="image"><b>Logo (120*120)</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image\'); return false">Parcourir</a></div>
				<input type="text" name="image" id="image" style="margin:0 20px 95px 25px; width:300px" tabindex="3">
				<img src="'.CHEMIN_DEFAUT.'no_logo1.png" width="120" height="120" id="img_select"/><br />
			</label>
			
			
			
			<label for="id_cat_parent"><b>Catégorie parente ?</b>
				<select name="id_cat_parent" id="id_cat_parent" tabindex="4">
					'.$s_options.'
				</select><br />
			</label>
			
			<br /><input type="submit" value="Ajouter" class="f-submit" tabindex="5"/><br />

		</fieldset>
		</form>';

break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('nom'));
	
	// Ajout dans la bdd 
	$sql=insererBdd($table, $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&action=ajouter&mess=ajout_erreurSql'); die(); }	
	
break;

case "supprimer":
	
	$id_cat=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_cat=$id_cat");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "editer":

	$id=(int)$_GET['id'];
	
	// Sélection des données pour cet id
	$sql=mysql_query("SELECT * FROM $table WHERE id_cat=".$id);
		extract(recupBdd(mysql_fetch_array($sql)));	
			
	// Liste des catégories parentes :
	$s_options="<option value='0'>--- Racine ---</option>";
	$sql=mysql_query("SELECT id_cat, id_cat_parent, nom FROM $table WHERE id_cat_parent=0 AND id_cat!=$id ORDER BY id_cat DESC");
	while($d=mysql_fetch_object($sql)) {

		if ($id_cat_parent==$d->id_cat) $select="selected";
		else				 $select="";
		
		$s_options.='<option value="'.$d->id_cat.'" '.$select.'>'.recupBdd($d->nom).'</option>';
	}
	



	
	// Gestion du logo
	if (empty($image)) $image=CHEMIN_DEFAUT.'no_logo1.png';	
	
	
	// Mise en forme du formulaire
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Produits</a> / <a href="'.$page.'">Gestion des categories</a> / <strong>Editer une categorie</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer une categorie</h3>
	
			<label for="nom"><b><span class="req">*</span>Nom :</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="50" value="'.$nom.'" /><br />
			</label>
			
			<label for="description"><b>Description en quelques mots</b>
				<textarea id="description" name="description" class="f-comments" rows="4" cols="30" tabindex="5">'.$description.'</textarea><br />
			</label>
	
			<label for="image"><b>Logo</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image\'); return false">Parcourir</a></div>
				<input type="text" name="image" id="image" style="margin:0 20px 95px 25px; width:300px" value="'.$image.'">
				<img src="'.$image.'" width="120" height="120" id="img_select"/><br />
			</label>
			
			<label for="id_cat_parent"><b>Catégorie parente ?</b>
				<select name="id_cat_parent" id="id_cat_parent">
					'.$s_options.'
				</select><br />
			</label>
			
			<br /><input type="submit" value="Modifier" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "editer_verif":

	$id=(int)$_GET['id'];

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=editer&mess=edit_erreurForm', $_POST, array('nom'));

	
	// modification dans la bdd 
	$sql=majBdd($table, '`id_cat`='.$id.'', $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&action=editer&id='.$id.'&mess=edit_erreurSql'); die(); }	
	
break;

}	
	
	$design->zone('titre', 'Gestion des categories');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);

?>