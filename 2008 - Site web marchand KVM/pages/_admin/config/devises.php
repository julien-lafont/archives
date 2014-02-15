<?php
securite_admin('config');

	$page="?admin-config-devises";
	$table=PREFIX."devises";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme('ok', "La nouvelle devise a été ajoutée avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme('bad', "La nouvelle devise n'a pas pu être ajoutée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme('bad', "La nouvelle devise n'a pas pu être ajoutée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="suppr_ok") $retour=miseEnForme('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme('bad', "La suppression de la nouvelle devise a échoué");	
		if ($mess=="edit_ok") $retour=miseEnForme('ok', "La nouvelle devise a été modifiée avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme('bad', "La nouvelle devise n'a pas pu être éditée car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme('bad', "La nouvelle devise n'a pas pu être éditée car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM $table ORDER BY id_devise DESC");
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <strong>Gestion des devises';
	
	// Mise en forme du bloc principal
	$c='<div class="head_actions a3">
			<div class="boutonBlanc float"><a href="'.$page.'&action=ajouter">Ajouter une devise</a></div>
			<br style="clear:both"  />
		</div>';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));

		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Devise <span>#'.$id_devise.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nom.'</li>
							<li><strong>Symbole gauche</strong> : '.$symbole_g.'</li>						
							<li><strong>Symbole droite</strong> : '.$symbole_d.'</li>
						</ul>
					</td>
					
					<td class="c"><h5>Taux</h5><br />
						<form name="editDevise" action="'.$page.'&action=modifLive" method="post">
						<fieldset class="centre">
							 1 &euro; = 
							
							'.$symbole_g.' <input id="convers_euro" name="convers_euro" style="width:100px" type="text" class="f-name" value="'.$convers_euro.'" maxlength="25" /> '.$symbole_d.'<br />
							<input type="hidden" name="id" value="'.$id_devise.'" />
							<input type="submit" value="Mettre à jour" class="f-submit" style="margin-bottom:5px" /><br />
							
							<span style="font-size:11px">MAJ : '.inverser_date($last_maj,6).'</span>
						</fieldset>
						</form>	
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="'.$page.'&action=editer&id='.$id_devise.'">Editer</a></div>
						<div class="boutonBlanc"><a href="'.$page.'&action=supprimer&id='.$id_devise.'">Supprimer</a></div>
					</td>
				</tr>
			</table>';
	
	}
			
break;

case "ajouter":

	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <a href="'.$page.'">Gestion des frais de ports</a> / <strong>Nouveau mode de transport</strong>';

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter une devise</h3>
			
			<label for="nom"><b style="width:240px"><span class="req">*</span>Nom :</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="50"/><br />
			</label>
			
			<label for="symbole_g"><b style="width:240px"><span class="req">*</span>Symbole sur la gauche</b>
				<input id="symbole_g" name="symbole_g" style="width:20px" type="text" class="f-name" tabindex="2" maxlength="12" /><br />
				&nbsp; &nbsp; &nbsp; &nbsp; OU
			</label>

			<label for="symbole_d"><b style="width:240px"><span class="req">*</span>Symbole sur la droite</b>
				<input id="symbole_d" name="symbole_d" style="width:20px" type="text" class="f-name" tabindex="3" maxlength="12" /><br />
			</label>

			<label for="convers_euro"><b style="width:240px"><span class="req">*</span>Conversion de 1&euro; dans la devise</b>
				<input id="convers_euro" name="convers_euro" style="width:100px" type="text" class="f-name" tabindex="4" maxlength="25" /><br />
			</label>
	
			<input type="submit" value="Ajouter" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('nom','convers_euro'));
	
	// On ajoute la date dans le tableau $_POST
	$_POST['last_maj']=date('Y-m-d H:i:s');
	// On encode les symboles
	$_POST['symbole_g']=htmlspecialchars($_POST['symbole_g']);
	$_POST['symbole_d']=htmlspecialchars($_POST['symbole_d']);
	
	// Ajout dans la bdd 
	$sql=insererBdd($table, $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&action=ajouter&mess=ajout_erreurSql'); die(); }	
	
break;

case "supprimer":
	
	$id_devise=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_devise=$id_devise");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "editer":

	// Sélection des données pour cet id
	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM $table WHERE id_devise=".$id);
		extract(recupBdd(mysql_fetch_array($sql)));	

	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <a href="'.$page.'">Gestion des devises</a> / <strong>Editer une devise</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer une devise</h3>
			
			<label for="nom"><b style="width:240px"><span class="req">*</span>Nom :</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="50" value="'.$nom.'" /><br />
			</label>
			
			<label for="symbole_g"><b style="width:240px"><span class="req">*</span>Symbole sur la gauche</b>
				<input id="symbole_g" name="symbole_g" style="width:20px" type="text" class="f-name" tabindex="2" maxlength="12" value="'.$symbole_g.'"/><br />
				&nbsp; &nbsp; &nbsp; &nbsp; OU
			</label>

			<label for="symbole_d"><b style="width:240px"><span class="req">*</span>Symbole sur la droite</b>
				<input id="symbole_d" name="symbole_d" style="width:20px" type="text" class="f-name" tabindex="3" maxlength="12" value="'.$symbole_d.'"/><br />
			</label>

			<label for="convers_euro"><b style="width:240px"><span class="req">*</span>Conversion de 1&euro; dans la devise</b>
				<input id="convers_euro" name="convers_euro" style="width:100px" type="text" class="f-name" tabindex="4" maxlength="25" value="'.$convers_euro.'" /><br />
			</label>
			
			<input type="submit" value="Submit" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "editer_verif":

	$id=(int)$_GET['id'];

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=editer&mess=edit_erreurForm', $_POST, array('nom','convers_euro'));
	
	// On ajoute la date dans le tableau $_POST
	$_POST['last_maj']=date('Y-m-d H:i:s');
	// On encode les symboles
	$_POST['symbole_g']=htmlspecialchars($_POST['symbole_g']);
	$_POST['symbole_d']=htmlspecialchars($_POST['symbole_d']);	
	
	// modification dans la bdd 
	$sql=majBdd($table, '`id_devise`='.$id.'', $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&action=editer&id='.$id.'&mess=edit_erreurSql'); die(); }	
	
break;

case "modifLive":

	$id=(int)$_POST['id'];
	$val=$_POST['convers_euro'];
	
	$sql=mysql_query("UPDATE $table SET `convers_euro`='$val' WHERE `id_devise`='$id'");
	header('location: '.$page);

break;
}	
	
	$design->zone('titre', 'Gestion des devises');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);

?>