<?php

	
	$m->mbre->securite_admin(/*"billets_redaction"*/);
	$fil_ariane="<strong>Billets</strong> / ";


	$page="admin.php?billets-rediger";
	$table=PREFIX."billets";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseenforme_admin('ok', "Le nouveau billet a été publié avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseenforme_admin('bad', "Le nouveau billet n'a pas pu être ajouté car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseenforme_admin('bad', "Le nouveau billet n'a pas pu être ajouté car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$m->design->assign('retour', $retour);
	}
	
	
switch(@$_GET['action']) {

default:

	// Mise en forme des catégories :
	$catOptions='';
	$sqlCat=mysql_query("SELECT * FROM ".PREFIX."categories ORDER BY cat ASC");
	while($cat=mysql_fetch_object($sqlCat)) {
		// On ajoute la catégorie à la liste:
		$catOptions.='<option value="'.$cat->id_cat.'">'.fonctions::recupBdd($cat->cat).'</option>';
	}
	
					
	$fil_ariane.="<a href='admin.php?billets-rediger'>R&eacute;diger</a>";

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1" onsubmit="$(\'#resume\').val(oEdit1.getHTMLBody());$(\'#contenu\').val(oEdit2.getHTMLBody());">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter un billet</h3>
			
			<label for="titre"><b><span class="req">*</span> Titre du billet</b>
				<input id="titre" name="titre" type="text" class="f-name" tabindex="1" maxlength="255" style="width:200px" /> <span style="font-size:10px"> &nbsp;&nbsp;( Taille approximative avant d&eacute;passement)</span><br />
			</label>
			
			<label for="resume"><b>R&eacute;sum&eacute; du billet</b>
				'.afficher_htmlarea('resume', 500, 200, 1).'
			</label>
			
			<label for="contenu"><b><span class="req">*</span> Contenu du billet</b>
				'.afficher_htmlarea('contenu', 500, 400, 2).'
			</label>
			
			<label for="id_cat"><b><span class="req">*</span> Cat&eacute;gorie</b>
				<select id="id_cat" name="id_cat" tabindex="4">
					'.$catOptions.'
				</select><br /><br />
			</label>
			
			<label for="tags"><b>Tags :<br />
			<span style="font-weight:normal">(S&eacute;parer les tags par un espace)</span></b>
				<input id="tags" name="tags" type="text" class="f-name" tabindex="5" maxlength="255"/>
				<br /><br />
			</label>
			
			<label for="billet_statut"><b>Statut du billet :</b>
				<select id="billet_statut" name="billet_statut" tabindex="6">
					<option value="publie">Publier directement</option>
					<option value="en_attente">Mettre en attente</option>
					<option value="brouillon">Enregistrer dans les brouillons</option>
				</select><br /><br />
			</label>
					
			<label for="com_statut"><b>Statut des commentaires :</b>
				<select id="com_statut" name="com_statut" tabindex="7" >
					<option value="ouvert">Ouverts</option>
					<option value="ferme">Ferm&eacute;s</option>
					<option value="membres_only">Seulement les membres</option>
				</select><br /><br />
			</label>
						
			<input type="submit" value="Submit" class="f-submit"tabindex="8" /><br />

		</fieldset>
		</form>';


break;

case "ajouter_verif":

	// On protège les données :
	$donnees=fonctions::escape($_POST);
	$donnees['id_auteur']=$_SESSION['sess_id'];
	$donnees['date']="date_now";
	
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&mess=ajout_erreurForm', $donnees, array('titre', 'contenu'));

	// Ajout dans la bdd 
	$sql=insererBdd($table, $donnees);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=ajout_erreurSql'); die(); }
	
		
break;
}

	$m->design->assign('titre', 'Gestion des billets : Redaction');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
?>
