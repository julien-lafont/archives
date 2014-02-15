<?php
$m->mbre->securite_admin('billets_redaction');

	$page="admin.php?billets-categories";
	$table=PREFIX."categories";
	
	$fil_ariane='<a href="'.$page.'">Gestion des catégories</a> / ';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme_admin('ok', "La nouvelle categorie a été ajoutée avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme_admin('bad', "La nouvelle categorie n'a pas pu être ajoutée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme_admin('bad', "La nouvelle categorie n'a pas pu être ajoutée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="suppr_ok") $retour=miseEnForme_admin('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme_admin('bad', "La suppression de la nouvelle categorie a échoué");	
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "La nouvelle categorie a été modifiée avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "La nouvelle categorie n'a pas pu être éditée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "La nouvelle categorie n'a pas pu être éditée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$m->design->assign('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM $table ORDER BY id_cat DESC");
	
	$fil_ariane.='<strong>Apercu des cat&eacute;gories</strong>';
	
	// Mise en forme du bloc principal
	$c='<div class="head_actions a3">
			<div class="boutonBlanc float"><a href="'.$page.'&action=ajouter">Ajouter une categorie</a></div>
			<br style="clear:both"  />
		</div><br />';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(fonctions::recupBdd($d));

		
		// Nombre de billets liés ?
		$sqlN=mysql_query("SELECT count(id_cat) as nb FROM ".PREFIX."billets WHERE id_cat=$id_cat");
		$n=mysql_fetch_object($sqlN);
			$nb=round($n->nb);
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Categorie <span>#'.$id_cat.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$cat.'</li>
							<li><strong>Nom url</strong> : <i>'.$cat_url.'</i></li>
							<li><strong>Billets liés</strong> : '.$nb.'</li>
				
						</ul>
					</td>
					
					<td class="c"><h5>Description</h5><br />
						<p class="centre">
							'.$cat_desc.'
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
	
	
	$fil_ariane.='<strong>Ajouter une catégorie</strong>';


	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter une cat&eacute;gorie</h3>
		
			<label for="cat"><b><span class="req">*</span>Nom :</b>
				<input id="cat" name="cat" type="text" class="f-name" tabindex="1" maxlength="50"/><br />
			</label>

			<label for="cat_url"><b>Nom rewrité <span style="font-weight:normal">(<i>facultatif</i>)</span> :</b>
				<input id="cat_url" name="cat_url" type="text" class="f-name" tabindex="1" maxlength="50"/><br />
			</label>
						
			<label for="cat_desc"><b>Description en quelques mots</b>
				<textarea id="cat_desc" name="cat_desc" class="f-comments" rows="4" cols="30" tabindex="2"></textarea><br />
			</label>
			
			<br /><input type="submit" value="Ajouter" class="f-submit" tabindex="5"/><br />

		</fieldset>
		</form>';

break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('cat'));
	
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
		extract(fonctions::recupBdd(mysql_fetch_array($sql)));	
			

	// Mise en forme du formulaire
	$fil_ariane.='<strong>Editer une categorie</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer une categorie</h3>
	
			<label for="cat"><b><span class="req">*</span>Nom :</b>
				<input id="cat" name="cat" type="text" class="f-name" tabindex="1" maxlength="50" value="'.$cat.'"/><br />
			</label>

			<label for="cat_url"><b>Nom rewrité <span style="font-weight:normal">(<i>facultatif</i>)</span> :</b>
				<input id="cat_url" name="cat_url" type="text" class="f-name" tabindex="1" maxlength="50" value="'.$cat_url.'"/><br />
			</label>
						
			<label for="cat_desc"><b>Description en quelques mots</b>
				<textarea id="cat_desc" name="cat_desc" class="f-comments" rows="4" cols="30" tabindex="2" >'.$cat_desc.'</textarea><br />
			</label>
			
			<br /><input type="submit" value="Modifier" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "editer_verif":

	$id=(int)$_GET['id'];

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=editer&mess=edit_erreurForm', $_POST, array('cat'));

	
	// modification dans la bdd 
	$sql=majBdd($table, '`id_cat`='.$id.'', $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&action=editer&id='.$id.'&mess=edit_erreurSql'); die(); }	
	
break;

}	
	
	$m->design->assign('titre', 'Gestion des categories');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);

?>