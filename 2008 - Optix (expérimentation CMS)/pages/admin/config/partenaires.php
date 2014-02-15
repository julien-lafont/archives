<?php
$m->mbre->securite_admin("configuration");

	$page="admin.php?config-partenaires";
	$table=PREFIX."amis";
	
	$fil_ariane="<strong>Configuration</strong> / <a href='".$page."'>'Gestion des amis</a> / ";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme_admin('ok', "Le nouveau partenaire a été ajouté avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme_admin('bad', "Le nouveau partenaire n'a pas pu être ajouté car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme_admin('bad', "Le nouveau partenaire n'a pas pu être ajouté car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="suppr_ok") $retour=miseEnForme_admin('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme_admin('bad', "La suppression du partenaire a échoué");	
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "Le nouveau partenaire a été modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "Le nouveau partenaire n'a pas pu être édité car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "Le nouveau partenaire n'a pas pu être édité car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$m->design->assign('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM ".$table." ORDER BY id_ami DESC");
	
	$fil_ariane.='<strong>Apercu des amis</strong>';
	
	// Mise en forme du bloc principal
	$c='<div class="head_actions a3">
			<div class="boutonBlanc float"><a href="'.$page.'&action=ajouter">Ajouter un partenaire</a></div>
			<br style="clear:both"  />
		</div>';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(fonctions::recupBdd($d));
	
				
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Ami <span>#'.$id_ami.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nom.'</li>
							<li><strong>URL</strong> : '.fonctions::formater_url($url).'</li>						
						</ul>
					</td>
					<td class="c"><h5>Apercu</h5>
						<p class="centre">
							<img src="http://www.thumbzor.com/tel.php?url='.$url.'" class="bordure1" />
						</p>
					</td>
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="'.$page.'&action=editer&id='.$id_ami.'">Editer</a></div>
						<div class="boutonBlanc"><a href="'.$page.'&action=supprimer&id='.$id_ami.'">Supprimer</a></div>
					</td>
				</tr>
			</table>';
	
	}
			
break;

case "ajouter":

	$fil_ariane.='<a href="'.$page.'">Gestion des partenaires</a> / <strong>Nouveau partenaire</strong>';

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter un partenaire</h3>
			
			<label for="nom"><b><span class="req">*</span>Nom du partenaire</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" /><br />
			</label>
			
			<label for="url"><b><span class="req">*</span>Adresse du site</b>
				<input id="url" name="url" type="text" class="f-name" tabindex="2" /><br />
			</label>
			
			<label for="description"><b><span class="req">*</span>Description (title)</b>
				<input id="description" name="description" type="text" class="f-name" tabindex="3" /><br />
			</label>

			<input type="submit" value="Submit" class="f-submit" tabindex="4"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('nom','url'));
	
	// Ajout dans la bdd 
	$sql=insererBdd($table, $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&action=ajouter&mess=ajout_erreurSql'); die(); }	
	
break;

case "supprimer":
	
	$id=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_ami=$id");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "editer":

	// Sélection des données pour cet id
	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".$table." WHERE id_ami=".$id);
		extract(fonctions::recupBdd(mysql_fetch_array($sql)));	

	$fil_ariane.=' <strong>Editer un partenaire</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un partenaire</h3>
			
			<label for="nom"><b><span class="req">*</span>Nom du partenaire</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" value="'.$nom.'" /><br />
			</label>
			
			<label for="url"><b><span class="req">*</span>Adresse du site</b>
				<input id="url" name="url" type="text" class="f-name" tabindex="2" value="'.$url.'" /><br />
			</label>
			
			<label for="description"><b><span class="req">*</span>Description</b>
				<input id="description" name="description" type="text" class="f-name" tabindex="3" value="'.$description.'" /><br />
			</label>
			
			<input type="submit" value="Submit" class="f-submit" tabindex="10"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "editer_verif":

	$id=(int)$_GET['id'];

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=editer&id='.$id.'&mess=edit_erreurForm', $_POST, array('nom','url'));
	
	// modification dans la bdd 
	$sql=majBdd($table, '`id_ami`='.$id.'', $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&action=editer&id='.$id.'&mess=edit_erreurSql'); die(); }	
	
break;



}	
	
	$m->design->assign('titre', 'Gestion des amis');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);

?>