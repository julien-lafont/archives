<?php
securite_admin('membres');

	$page="?admin-membres-gerer";
	$table=PREFIX."membres";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="edit_ok") $retour=miseEnForme('ok', "Le membre a été modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme('bad', "Le membre n'a pas pu être édité car le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme('bad', "Le membre n'a pas pu être édité car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {


default:
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gerer">Gestion des membres</a> / <strong>Gestion</strong>';
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *
						FROM $table m
						LEFT JOIN ".PREFIX."membres_infos mi
						ON mi.id_membre=m.id_membre
						ORDER BY m.id_membre DESC
						LIMIT 0,10") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));	
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Membre <span>#'.$id_membre.'</span></h5>
						<ul>
							<li><strong>Nom</strong> : '.$nom.'</li>
							<li><strong>Prénom</strong> : '.$prenom.'</li>
							<li><strong>Adresse</strong> : '.$adresse.'</li>
							<li><strong>Code postal</strong> : '.$cp.'</li>						
							<li><strong>Ville</strong> : '.$ville.'</li>
						</ul>
					</td>
					
					<td class="c"><h5>Contact</h5><br />
						<ul>
							<li><strong>Tel</strong> : '.$tel.'</li>
							<li><strong>Portable</strong> : '.$portable.'</li>
							<li><strong>Email</strong> : '.$email.'</li>
						</ul>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="?admin-membres-gerer&action=editer&id='.$id_membre.'">Editer infos</a></div>
						<div class="boutonBlanc"><a href="?admin-membres-gerer&action=supprimer&id='.$id_membre.'">Supprimer</a></div>
					</td>
				</tr>
			</table>';
	
	}		

break;

case "editer":

	$id=(int)$_GET['id'];
	
	// Sélection des données :
	$sql=mysql_query("	SELECT * 
						FROM $table m
						LEFT JOIN ".PREFIX."membres_infos mi
						ON mi.id_membre=m.id_membre 
						WHERE m.id_membre=$id") or die(mysql_error());
		extract(recupBdd(mysql_fetch_array($sql)));	
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gerer">Gestion des Membres</a> / <strong>Editer un membre</strong>';

		// Gestion select/radio : GENRE
		if ($genre=="h") $sG1='checked="checked"';
		else			 $sG2='checked="checked"';
		
	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer les infos d\'un membres</h3>
			
			<h5>Coordonnées postales</h5>
			<label for="genre"><b>Civilité</b> <br />
				<div style="margin:-25px 0 0 225px">	<input name="genre" type="radio" value="h" style="width:15px" tabindex="1" '.$sG1.' /> Monsieur <br />
						<input name="genre" type="radio" value="f" style="width:15px" '.$sG2.' /> Madame<br />
				</div>
			</label>
			
			<label for="nom"><b>Nom</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="2" maxlength="50" style="width:130px" value="'.$nom.'" /><br />
			</label>

			<label for="prenom"><b>Prenom</b>
				<input id="prenom" name="prenom" type="text" class="f-name" tabindex="3" maxlength="50" style="width:130px" value="'.$prenom.'" /><br />
			</label>

			<label for="adresse"><b>Adresse postale</b>
				<textarea id="adresse" name="adresse" class="f-comments" rows="4" cols="30" tabindex="4">'.$adresse.'</textarea><br />
			</label>
			
			<label for="cp"><b>Code postal</b>
				<input id="cp" name="cp" type="text" class="f-name" tabindex="5"  maxlength="5" style="width:50px" value="'.$cp.'" /><br />
			</label>

			<label for="ville"><b>Ville</b>
				<input id="ville" name="ville" type="text" class="f-name" tabindex="6" style="width:130px" maxlength="50" value="'.$ville.'" /><br />
			</label>

			<label for="pays"><b>Pays</b>
				<input id="pays" name="pays" type="text" class="f-name" tabindex="7" style="width:130px" maxlength="50" value="'.$pays.'" /><br />
			</label>

			<label for="tel"><b>Téléphone fixe</b>
				<input id="tel" name="tel" type="text" class="f-name" tabindex="8" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$tel.'" /><br />
			</label>
			
			<label for="portable"><b>Téléphone portable</b>
				<input id="portable" name="portable" type="text" class="f-name" tabindex="9" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$portable.'" /><br />
			</label>
			
			<br /><h5>Mon compte '.NOM.'</h5>
			<label for="email"><b>Adresse email</b>
				<input id="email" name="email" type="text" class="f-name" tabindex="10" maxlength="75" value="'.$email.'"/><br />
			</label>

			<label for="pseudo"><b>Pseudo</b>
				<input id="pseudo" name="pseudo" type="text" class="f-name" tabindex="11" maxlength="75" value="'.$pseudo.'"/><br />
			</label>
			
			<!--<label for="newsletter"><b>Recevoir la newsletter ?</b>
				<select name="newsletter" id="newsletter" class="f-name" style="width:130px" tabindex="11">
					<option value="none">Non</option>
					<option value="html">Oui, en html</option>
					<option value="txt">Oui, en texte</option>
				</select>
			</label>-->
			
			
			<input type="submit" value="Submit" class="f-submit" /><br />

		</fieldset>
		</form>';

break;

case "editer_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=addslashes_array($_POST, true);
	extract($donnees);

	
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&id='.$id.'&mess=edit_erreurForm', $donnees, array('pseudo', 'email'));

	// Mise à jour ( manuelle ) de la base de donnée
	$sql_1=mysql_query("UPDATE ".PREFIX."membres SET pseudo='$pseudo', email='$email' WHERE id_membre=".$_SESSION['sess_id']);
	$sql_2=mysql_query("UPDATE ".PREFIX."membres_infos SET 
						genre='$genre', 
						prenom='$prenom',
						nom='$nom',
						adresse='$adresse',
						cp='$cp',
						ville='$ville',
						pays='$pays',
						tel='$tel',
						portable='$portable'
						WHERE id_membre=".$_SESSION['sess_id']);
	
	if ($sql_1 && $sql_2) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 					{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }
	
break;

case "supprimer":
	
	$id_membre=(int)$_GET['id'];
	
	// Suppresion
	$sql1=mysql_query("DELETE FROM ".$table." WHERE id_membre=$id_membre");
	$sql2=mysql_query("DELETE FROM ".$table."_infos WHERE id_membre=$id_membre");
	$sql3=mysql_query("DELETE FROM ".$table."_config WHERE id_membre=$id_membre");
	
	if ($sql1) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "stock_live":

	$id=(int)$_GET['id'];
	$stock=$_POST['stock'];
	
	$sql=mysql_query("UPDATE $table SET `stock`='$stock' WHERE `id_produit`=$id");
	header('location: '.$page.'&mess=stock_ok');

break;
}

	$design->zone('titre', 'Gestion des membres');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>