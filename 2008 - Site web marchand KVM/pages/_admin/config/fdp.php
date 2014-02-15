<?php
securite_admin('config');

	$page="?admin-config-fdp";
	$table=PREFIX."frais_de_ports";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme('ok', "Le nouveau mode de transport a été ajouté avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseEnForme('bad', "Le nouveau mode de transport n'a pas pu être ajouté car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseEnForme('bad', "Le nouveau mode de transport n'a pas pu être ajouté car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="suppr_ok") $retour=miseEnForme('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme('bad', "La suppression du mode de transport a échoué");	
		if ($mess=="edit_ok") $retour=miseEnForme('ok', "Le nouveau mode de transport a été modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme('bad', "Le nouveau mode de transport n'a pas pu être édité car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme('bad', "Le nouveau mode de transport n'a pas pu être édité car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM ".$table." ORDER BY id_fdp DESC");
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <strong>Gestion des frais de ports';
	
	// Mise en forme du bloc principal
	$c='<div class="head_actions a3">
			<div class="boutonBlanc float"><a href="'.$page.'&action=ajouter">Ajouter un type de fdp</a></div>
			<br style="clear:both"  />
		</div>';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));
	
		// Gestion du logo ?
		if (empty($logo)) $logo=CHEMIN_DEFAUT.'no_logo1.png';
				
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Mode transport <span>#'.$id_fdp.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$mode_envoie.'</li>
							<li><strong>Délais</strong> : '.$delais.'</li>						

						</ul>
						
						<div class="bas">Prix : '.$prix_euros.'&euro;;</div>
					</td>
					<td class="c"><h5>Logo</h5>
						<p class="centre">
							<img src="'.$logo.'" class="bordure1" alt="'.$mode_envoie.'" />
						</p>
					</td>
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="'.$page.'&action=editer&id='.$id_fdp.'">Editer</a></div>
						<div class="boutonBlanc"><a href="'.$page.'&action=supprimer&id='.$id_fdp.'">Supprimer</a></div>
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
			
			<h3>Ajouter un mode de transport</h3>
			
			<label for="mode_envoie"><b><span class="req">*</span>Nom du mode de transport:</b>
				<input id="mode_envoie" name="mode_envoie" type="text" class="f-name" tabindex="1" /><br />
			</label>
			
			<label for="prix_euros"><b><span class="req">*</span>Frais de transports en euros</b>
				<input id="prix_euros" name="prix_euros" type="text" class="f-name" tabindex="2" /><br />
			</label>

			<label for="delais"><b><span class="req">*</span>Délais du transport</b>
				<input id="delais" name="delais" type="text" class="f-name" tabindex="3" /><br />
			</label>

			<label for="logo"><b>Logo (70*70)</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'logo\'); return false">Parcourir</a></div>
				<input type="text" name="logo" id="logo" style="margin:0 20px 95px 25px; width:300px" tabindex="4">
				<img src="'.CHEMIN_DEFAUT.'no_logo1.png" width="70" height="70" id="img_select"/><br />
			</label>

			<label for="description"><b>Description en quelques mots</b>
				<textarea id="description" name="description" class="f-comments" rows="4" cols="30" tabindex="5"></textarea><br />
			</label>
			
			<input type="submit" value="Submit" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('mode_envoie','prix_euros','delais'));
	
	// Ajout dans la bdd 
	$sql=insererBdd($table, $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&action=ajouter&mess=ajout_erreurSql'); die(); }	
	
break;

case "supprimer":
	
	$id_fdp=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_fdp=$id_fdp");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "editer":

	// Sélection des données pour cet id
	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".$table." WHERE id_fdp=".$id);
		extract(recupBdd(mysql_fetch_array($sql)));	

	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <a href="'.$page.'">Gestion des frais de ports</a> / <strong>Editer un mode de transport</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un mode de transport</h3>
			
			<label for="mode_envoie"><b><span class="req">*</span>Nom du mode de transport:</b>
				<input id="mode_envoie" name="mode_envoie" type="text" class="f-name" tabindex="1" value="'.$mode_envoie.'" /><br />
			</label>
			
			<label for="prix_euros"><b><span class="req">*</span>Frais de transports en euros</b>
				<input id="prix_euros" name="prix_euros" type="text" class="f-name" tabindex="2" value="'.$prix_euros.'" /><br />
			</label>

			<label for="delais"><b><span class="req">*</span>Délais du transport</b>
				<input id="delais" name="delais" type="text" class="f-name" tabindex="3" value="'.$delais.'" /><br />
			</label>

			<label for="logo"><b>Logo (70*70)</b>
				<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'logo\'); return false">Parcourir</a></div>
				<input type="text" name="logo" id="logo" value="'.$logo.'" style="margin:0 20px 95px 25px; width:300px" tabindex="4">
				<img src="'.$logo.'" width="70" height="70" id="img_select"/><br />
			</label>

			<label for="description"><b>Description en quelques mots</b>
				<textarea id="description" name="description" class="f-comments" rows="4" cols="30" tabindex="5">'.$description.'</textarea><br />
			</label>
			
			<input type="submit" value="Submit" class="f-submit" tabindex="6"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "editer_verif":

	$id=(int)$_GET['id'];

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=editer&id='.$id.'&mess=edit_erreurForm', $_POST, array('mode_envoie','prix_euros','delais'));
	
	// modification dans la bdd 
	$sql=majBdd($table, '`id_fdp`='.$id.'', $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&action=editer&id='.$id.'&mess=edit_erreurSql'); die(); }	
	
break;



}	
	
	$design->zone('titre', 'Gestion des frais de port');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);

?>