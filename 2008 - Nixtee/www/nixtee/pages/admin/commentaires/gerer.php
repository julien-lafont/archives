<?php
$m->mbre->securite_admin("commentaires");

	$page="admin.php?commentaires-gerer";
	$table=PREFIX."commentaires";

	$fil_ariane="<strong>Commentaires</strong> / ";

	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="suppr_ok") $retour=miseEnForme_admin('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme_admin('bad', "La suppression du commentaire a échouée");	
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "Commentaire modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "Le commentaire n'a pas été modifié : le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "Le commentaire n'a pas été modifié : une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="erreurForm") $retour=miseEnForme_admin('bad', "Vous devez remplir un des 5 champs !");
		$m->design->assign('retour', $retour);
	}
	
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche.= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
				<fieldset>
		
					<h3>Rechercher des commentaires</h3>
			
					<label for="titre"><b>Titre du billet le contenant</b>
						<input id="titre" name="titre" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
					</label>	
					<label for="id_billet"><b>ID du billet</b>
						<input id="id_billet" name="id_billet" type="text" class="f-name" tabindex="2" /><br />
					</label>	

					<label for="auteur"><b>Auteur ( pseudo )</b>
						<input id="auteur" name="auteur" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
					</label>						
					<label for="com"><b>Mot cl&eacute;s<br /> <span style="font-weight:normal; font-size:10px">(un ou pls mots du commentaire)</span></b>
						<input id="com" name="com" type="text" class="f-name" tabindex="2" /><br />
					</label>
				
					<label for="id_com"><b>ID du commentaire</b>
						<input id="id_com" name="id_com" type="text" class="f-name" tabindex="2" /><br />
					</label>	
					<input type="submit" value="Rechercher" class="f-submit" tabindex="5" /><br />
		
				</fieldset>
			</form><br />';
			
switch(@$_GET['action']) {

default:
	
	$fil_ariane='<a href="admin.php?commentaires-gerer">Gestions des commentaires</a> / <strong>Vue globale</strong>';
	
	$c=$recherche;

	// On effectue la requête
	$sql=mysql_query("	SELECT id_com, b.id_billet, titre, pseudo, invite_pseudo, com.date, message, com.id_membre
						FROM ".PREFIX."commentaires com
						LEFT JOIN ".PREFIX."membres m ON m.id_membre=com.id_membre
						LEFT JOIN ".PREFIX."billets b ON com.id_billet=b.id_billet 
						ORDER BY id_com DESC
						LIMIT 0,10") or die(mysql_error());
						
		$c.="<h3>Derniers commentaires</h3>
			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID_COM</strong></td>
				<td class='table_titre' style='width:25%'><strong>TITRE BILLET</strong></td>
				<td class='table_titre' style='width:10%'><strong>AUTEUR_COM</strong></td>
				<td class='table_titre' style='width:45%'><strong>MESSAGE (extrait)</strong></td>
				<td class='table_titre' style='width:10%'><strong>DATE</strong></td>
				<td class='table_titre' style='width:10%'><strong>ACTIONS</strong></td>
			</tr>";
							
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	
			
			// Gestion du pseudo
			$auteur=(!$pseudo) ? "<i>".$invite_pseudo."</i>" : '<a href="membre-'.$id_membre.'-'.recode($pseudo).'.htm">'.$pseudo.'</a>';
			
			$c.= '<tr>
					<td><strong>'.$id_com.'</strong></td>
					<td><a href="billet-'.$id_billet.'-'.fonctions::recode($titre).'.htm" target="_blank">'.$titre.'</td>
					<td>'.$auteur.'</td>
					<td style="font-size:10px">'.fonctions::tronquerChaine($message, 95).'</td>
					<td style="font-size:10px">'.$date.'</td>
					<td><a href="'.$page.'&action=editer&id='.$id_com.'"><img src="images/admin/comment_edit.png" alt="Editer" /></a>&nbsp;
						<a href="'.$page.'&action=supprimer&id='.$id_com.'"><img src="images/admin/comments_delete.png" alt="Supprimer" /></a>
						</td>
				</tr>';
		
		}		
		
		$c.='</table>';	
		

break;

case "editer":

	$id=(int)$_GET['id'];
	
	// Sélection des données :
	$sql=mysql_query("	SELECT * 
						FROM $table com
						LEFT JOIN ".PREFIX."membres m ON m.id_membre=com.id_membre
						WHERE id_com=$id");
		extract(fonctions::recupBdd(mysql_fetch_array($sql)));	

	
	// Statut du com
	if ($statut==0) $c0="checked";
	else		   $c1="checked";

	$fil_ariane.='<a href="admin.php?commentaires-gerer">Gestion des commentaires</a> / <strong>Editer un commentaire</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un commentaire</h3>
			
			<label for="message"><b><span class="req">*</span> Message</b>
				<textarea id="message" name="message" class="f-name" style="width:300px; height:100px">'.$message.'</textarea><br />
			</label>
			
			<label><b>IP de l\'auteur</b> '.$ip.'<br /><br /></label>
			
			<label for="statut"><b>Statut du commentaire :</b><br />
				<div style="margin-left:210px; margin-top:-25px">
					<input name="statut"  type="radio" value="1" style="width:20px;" '.@$c1.'/> Commentaire valid&eacute;<br />
					<input name="statut" type="radio" value="0"  style="width:20px;" '.@$c0.'/> Commentaire en attente de mod&eacute;ration
				</div>
			</label>';
	
	// Posté par un invité
	if (!$pseudo) {
		$c.='<label for="invite_pseudo"><b><span class="req">*</span> Pseudo invit&eacute;</b>
				<input id="invite_pseudo" name="invite_pseudo" type="text" class="f-name"  maxlength="255" value="'.$invite_pseudo.'"/><br />
			 </label>
			 
			 <label for="invite_email"><b>Email invit&eacute;</b>
				<input id="invite_email" name="invite_email" type="text" class="f-name" maxlength="255" value="'.$invite_email.'"/><br />
			 </label>
			 
			 <label for="invite_site"><b>Site invit&eacute;</b>
				<input id="invite_site" name="invite_site" type="text" class="f-name"  maxlength="255" value="'.$invite_site.'"/><br />
			 </label>';
	}


	$c.='	<input type="submit" value="Modifier" class="f-submit"/><br />

		</fieldset>
		</form>';


break;

case "editer_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=fonctions::escape($_POST);
	
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&id='.$id.'&mess=edit_erreurForm', $donnees, array('message'));
	
	// Ajout dans la bdd 
	$sql=majBdd($table, '`id_com`='.$id, $donnees);
	
	
	if ($sql) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }
	
break;

case "supprimer":
	
	$id=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_com=$id");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "search":
	
	$fil_ariane.='<a href="admin.php?billets-revisions">Gestions des billets</a> / <strong>Rechercher un billet</strong>';
	$c=$recherche;
	
	// Gestion de la requete sql : un seul champs nécessaire => Ordre de priorité : nom>id>ref
	$donnees=fonctions::escape($_POST);	

	if 		(!empty($donnees['titre'])) 	$where="b.titre like '%".$donnees['titre']."%'";
	elseif  (!empty($donnees['id_billet']))	$where="b.id_billet = ".$donnees['id'];
	elseif  (!empty($donnees['auteur']))	$where="com.invite_pseudo like '%".$donnees['auteur']."%' OR m.pseudo like '%".$donnees['auteur']."%'";
	elseif  (!empty($donnees['com']))		$where="com.message like '%".$donnees['com']."%'";
	elseif  (!empty($donnees['id_com']))	$where="com.id_com = ".$donnees['id_com'];
	else	{ header('location: '.$page.'&action=rechercher&mess=erreurForm'); die();  }
	
	// On effectue la requête
	$sql=mysql_query("	SELECT id_com, b.id_billet, titre, pseudo, invite_pseudo, com.date, message, com.id_membre
						FROM ".PREFIX."commentaires com
						LEFT JOIN ".PREFIX."membres m ON m.id_membre=com.id_membre
						LEFT JOIN ".PREFIX."billets b ON com.id_billet=b.id_billet 
						WHERE $where 
						ORDER BY id_com DESC") or die(mysql_error());
	
	if (mysql_num_rows($sql)==0) $c.="<div class='error'>Aucun commentaire trouv&eacute;</div>";	
	
	else
		$c.="			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID_COM</strong></td>
				<td class='table_titre' style='width:25%'><strong>TITRE BILLET</strong></td>
				<td class='table_titre' style='width:10%'><strong>AUTEUR_COM</strong></td>
				<td class='table_titre' style='width:45%'><strong>MESSAGE (extrait)</strong></td>
				<td class='table_titre' style='width:10%'><strong>DATE</strong></td>
				<td class='table_titre' style='width:10%'><strong>ACTIONS</strong></td>
			</tr>";
							
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	
			
			// Gestion du pseudo
			$auteur=(!$pseudo) ? "<i>".$invite_pseudo."</i>" : '<a href="membre-'.$id_membre.'-'.recode($pseudo).'.htm">'.$pseudo.'</a>';
			
			$c.= '<tr>
					<td><strong>'.$id_com.'</strong></td>
					<td><a href="billet-'.$id_billet.'-'.fonctions::recode($titre).'.htm" target="_blank">'.$titre.'</td>
					<td>'.$auteur.'</td>
					<td style="font-size:10px">'.fonctions::tronquerChaine($message, 95).'</td>
					<td style="font-size:10px">'.$date.'</td>
					<td><a href="'.$page.'&action=editer&id='.$id_com.'"><img src="images/admin/comment_edit.png" alt="Editer" /></a>&nbsp;
						<a href="'.$page.'&action=supprimer&id='.$id_com.'"><img src="images/admin/comments_delete.png" alt="Supprimer" /></a>
						</td>
				</tr>';

	
	}		
	
	$c.='</table>';
	
		

break;

}

	$m->design->assign('titre', 'Gestion des commentaires');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>