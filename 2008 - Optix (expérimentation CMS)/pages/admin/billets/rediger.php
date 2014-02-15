<?php

	
	$m->mbre->securite_admin(/*"billets_redaction"*/);
	$fil_ariane="<strong>Billets</strong> / ";


	$page="admin.php?billets-rediger";
	$table=PREFIX."news";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseenforme_admin('ok', "La nouvelle actu a été publiée avec succés !");
		if ($mess=="ajout_erreurForm") $retour=miseenforme_admin('bad', "La nouvelle actu n'a pas pu être ajouté car le formulaire n'a pas été rempli correctement");		
		if ($mess=="ajout_erreurSql") $retour=miseenforme_admin('bad', "La nouvelle actun'a pas pu être ajouté car une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$m->design->assign('retour', $retour);
	}
	
	
switch(@$_GET['action']) {

default:

	// Mise en forme des catégories :

	
					
	$fil_ariane.="<a href='admin.php?billets-rediger'>R&eacute;diger</a>";

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1" onsubmit="">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter une actu</h3>
			
			<label for="titre"><b><span class="req">*</span> Titre du billet</b>
				<input id="titre" name="titre" type="text" class="f-name" tabindex="1" maxlength="255" style="width:200px" /> <span style="font-size:10px"> &nbsp;&nbsp;( Taille approximative avant d&eacute;passement)</span><br />
			</label>
			
			
			<label for="contenu"><b><span class="req">*</span> Contenu du billet</b></label><br />
				<div style="width:80%"><textarea name="contenu" id="contenu" tabindex="2" class="wymeditor"></textarea></div>
			
		
		
		<script type="text/javascript"> 
			jQuery(function() {
			    jQuery(".wymeditor").wymeditor({
			    
			        lang: "fr",
			         
			        postInit: function(wym) {
			            jQuery(wym._box).find(wym._options.containersSelector)
			                .removeClass("wym_dropdown")
			                .addClass("wym_panel");
			        }
			    });
			});
			 
		</script> 
			
			<br />
			<label for="billet_statut"><b>Statut du billet :</b>
				<select id="billet_statut" name="billet_statut" tabindex="6">
					<option value="en ligne">Publier directement</option>
					<option value="en attente">Mettre en attente</option>
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
						
			<input type="submit" value="Ajouter" class="f-submit wymupdate" tabindex="8" /><br />

		</fieldset>
		</form>';


break;

case "ajouter_verif":

	// On protège les données :
	$donnees=fonctions::escape($_POST);
	$donnees['id_auteur']=$_SESSION['sess_id'];
	$donnees['date']="date_now";
	
	// Pas encore de gestion des com donc on vire l'option
	unset($donnees['com_statut']);
	
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&mess=ajout_erreurForm', $donnees, array('titre', 'contenu'));

	// Ajout dans la bdd 
	$sql=insererBdd($table, $donnees);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=ajout_erreurSql'); die(); }
	
		
break;
}

	$m->design->assign('titre', 'Gestion des actus : Redaction');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
?>
