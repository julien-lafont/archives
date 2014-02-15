<?php
$m->mbre->securite_admin("billets_edition");

	$page="admin.php?billets-revisions";
	$table=PREFIX."billets";

	$fil_ariane="<strong>Billets</strong> / ";

	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="suppr_ok") $retour=miseEnForme_admin('ok', "Suppresion confirmée");	
		if ($mess=="suppr_erreur") $retour=miseEnForme_admin('bad', "La suppression du billet a échouée");	
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "Billet modifié avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "Le billet n'a pas été modifié : le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "Le billet n'a pas été modifié : une erreur est survenue durant l'enregistrement dans la base de donnée");	
		if ($mess=="erreurForm") $retour=miseEnForme_admin('bad', "Vous devez remplir un des 3 champs !");
		$m->design->assign('retour', $retour);
	}
	
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche.= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
				<fieldset>
		
					<h3>Rechercher des billets</h3>
			
					<label for="titre"><b>Titre du billet</b>
						<input id="titre" name="titre" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
					</label>	
					<label for="tag"><b>Tag</b>
						<input id="tag" name="tag" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
					</label>						
					<label for="id"><b>ID</b>
						<input id="id" name="id" type="text" class="f-name" tabindex="2" /><br />
					</label>					
					<input type="submit" value="Rechercher" class="f-submit" tabindex="5" /><br />
		
				</fieldset>
			</form><br />';
			
switch(@$_GET['action']) {

default:
	
	$fil_ariane='<a href="admin.php?billets-revisions">Gestions des billets</a> / <strong>Vue globale</strong>';
	
	$c=$recherche;

	// On effectue la requête
	$sql=mysql_query("	SELECT id_billet, titre, date, pseudo, billet_statut
						FROM $table b
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=b.id_cat
						LEFT JOIN ".PREFIX."membres m
						ON m.id_membre=b.id_auteur
						ORDER BY b.id_billet DESC
						LIMIT 0,10") or die(mysql_error());
						
	
				
		$c.="<h3>Derniers billets</h3>
			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID</strong></td>
				<td class='table_titre' style='width:50%'><strong>TITRE</strong></td>
				<td class='table_titre' style='width:10%'><strong>STATUT</strong></td>
				<td class='table_titre' style='width:15%'><strong>AUTEUR</strong></td>
				<td class='table_titre' style='width:15%'><strong>DATE</strong></td>
				<td class='table_titre' style='width:5%'><strong>ACTIONS</strong></td>
			</tr>";
							
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	

			if ($billet_statut=="en_attente")  $color="#3366FF";
			else if ($billet_statut=="publie") $color="#00CC00";
			else							   $color="#FF6600";
						
			$c.= '<tr>
					<td><strong>'.$id_billet.'</strong></td>
					<td><a href="billet-'.$id_billet.'-'.fonctions::recode($titre).'.htm" target="_blank">'.$titre.'</td>
					<td style="font-weight:bold; color:'.$color.'">'.strtoupper($billet_statut).'</td>
					<td>'.$pseudo.'</td>
					<td style="font-size:10px">'.$date.'</td>
					<td><a href="'.$page.'&action=editer&id='.$id_billet.'"><img src="images/admin/page_edit.png" alt="Editer" /></a>&nbsp;
						<a href="'.$page.'&action=supprimer&id='.$id_billet.'"><img src="images/admin/page_delete.png" alt="Supprimer" /></a>
						</td>
				</tr>';
		
		}		
		
		$c.='</table>';	
		

break;

case "editer":

	$id=(int)$_GET['id'];
	
	// Sélection des données :
	$sql=mysql_query("	SELECT * 
						FROM $table  b
						LEFT JOIN ".PREFIX."membres m
						ON m.id_membre=b.id_auteur
						WHERE id_billet=$id");
		extract(fonctions::recupBdd(mysql_fetch_array($sql)));	

	// Mise en forme des catégories :
	$catOptions='';
	$sqlCat=mysql_query("SELECT * FROM ".PREFIX."categories");
	while($cat=mysql_fetch_object($sqlCat)) {
		
		// On ajoute la catégorie à la liste:
			if ($id_cat==$cat->id_cat) $s="selected";
			else					   $s="";
		$catOptions.='<option value="'.$cat->id_cat.'" '.$s.'>'.fonctions::recupBdd($cat->cat).'</option>';
		
	}
	
	// Statut des billets
	switch($billet_statut) {
		case "publie": 		$s1="selected"; break;
		case "en_attente":	$s2="selected"; break;
		case "brouillon":	$s3="selected"; break;
	}
	
	// Statut des coms
	switch($com_statut) {
		case "ouvert":		 $ss1="selected"; break;
		case "ferme":		 $ss2="selected"; break;
		case "membres_only": $ss3="selected"; break;
	}

	$fil_ariane.='<a href="admin.php?billets-revisions">Gestion des billets</a> / <strong>Editer un billet</strong>';

	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1" onsubmit="$(\'#resume\').val(oEdit1.getHTMLBody());$(\'#contenu\').val(oEdit2.getHTMLBody());">
			
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un billet</h3>
			
			<label for="titre"><b><span class="req">*</span> Titre du billet</b>
				<input id="titre" name="titre" type="text" class="f-name" maxlength="255"  style="width:200px" value="'.$titre.'"/> <span style="font-size:10px"> &nbsp;&nbsp;( Taille approximative avant d&eacute;passement)</span><br />
			</label>
			
			<label for="resume"><b>R&eacute;sum&eacute; du billet</b>
				'.afficher_htmlarea('resume', 500, 200, 1, $resume).'
			</label>
			
			<label for="contenu"><b><span class="req">*</span> Contenu du billet</b>
				'.afficher_htmlarea('contenu', 500, 400, 2, $contenu).'
			</label>
			
			<label for="id_cat"><b><span class="req">*</span> Cat&eacute;gorie</b>
				<select id="id_cat" name="id_cat" >
					'.$catOptions.'
				</select><br /><br />
			</label>
			
			<label for="tags"><b>Tags :<br />
			<span style="font-weight:normal">(S&eacute;parer les tags par un espace)</span></b>
				<input id="tags" name="tags" type="text" class="f-name"  maxlength="255" value="'.$tags.'"/>
				<br /><br />
			</label>
			
			<label for="billet_statut"><b>Statut du billet :</b>
				<select id="billet_statut" name="billet_statut" tabindex="6">
					<option value="publie" '.@$s1.'>Publier directement</option>
					<option value="en_attente" '.@$s2.'>Mettre en attente</option>
					<option value="brouillon" '.@$s3.'>Enregistrer dans les brouillons</option>
				</select><br /><br />
			</label>
					
			<label for="com_statut"><b>Statut des commentaires :</b>
				<select id="com_statut" name="com_statut" tabindex="7" >
					<option value="ouvert" '.@$ss1.'>Ouverts</option>
					<option value="ferme" '.@$ss2.'>Ferm&eacute;s</option>
					<option value="membres_only" '.@$ss3.'>Seulement les membres</option>
				</select><br /><br />
			</label>
			
			<label for="points"><b>Points attribu&eacute;s :</b>
				<input id="points" name="points" type="text" class="f-name"  maxlength="255" value="'.$points.'"/><br /><br />
			</label>
			
			<label for="id_auteur"><b>Auteur du message :</b><br />
				<div style="margin-left:210px; margin-top:-25px">
					<input name="id_auteur"  type="radio" value="'.$id_auteur.'" style="width:20px;" checked/> Laisser l\'auteur original : '.$pseudo.'<br />
					<input name="id_auteur" type="radio" value="'.$_SESSION['sess_id'].'"  style="width:20px;"/> Moi
				</div>
			</label>
						
			<label for="date"><b>Date du message :</b><br />
				<div style="margin-left:210px; margin-top:-25px">
					<input name="date"  type="radio" value="'.$date.'" style="width:20px;" checked/> Laisser la date d&eacute;j&agrave; enregistr&eacute;e : '.$date.'<br />
					<input name="date" type="radio" value="date_now"  style="width:20px;"/> Maintenant<br />
					<input name="date" type="radio" value="perso"  style="width:20px;"/> Personnali&eacute; 
						<div style="margin-left:100px; margin-top:-25px">
							<input name="h" type="text" class="f-name"  maxlength="2" style="width:20px" /> h &nbsp;<input name="mn" type="text" class="f-name" maxlength="2" style="width:20px"/> mn &nbsp; le &nbsp; 
							<input name="j" type="text" class="f-name" maxlength="2" style="width:20px"/>/<input name="m" type="text" class="f-name" maxlength="2" style="width:20px"/>/<input name="a" type="text" class="f-name" maxlength="4" style="width:40px"/>
						</div>
				</div>
			</label>


			<input type="submit" value="Modifier" class="f-submit" /><br />

		</fieldset>
		</form>';


break;

case "editer_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=fonctions::escape($_POST);
	
	// Gestion de la date
	if ($donnees['date']=="perso") $donnees['date']=$donnees['a']."-".$donnees['m']."-".$donnees['j']." ".$donnees['h'].":".$donnees['mn'].":00";
	
	// On supprime les champs dates-perso du tableau
	unset($donnees['a'],$donnees['m'],$donnees['j'],$donnees['h'],$donnees['mn']);

	// Verifications des champs obligatoires
	verif_champs_requis($page.'&id='.$id.'&mess=edit_erreurForm', $donnees, array('titre', 'contenu'));
	
	// Ajout dans la bdd 
	$sql=majBdd($table, '`id_billet`='.$id, $donnees);
	
	
	if ($sql) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }
	
break;

case "supprimer":
	
	$id=(int)$_GET['id'];
	
	// Suppresion
	$sql=mysql_query("DELETE FROM ".$table." WHERE id_billet=$id");
	
	if ($sql) 	{ header('location: '.$page.'&mess=suppr_ok'); die(); }
	else 		{ header('location: '.$page.'&mess=suppr_erreur'); die(); }

break;

case "search":
	
	$fil_ariane.='<a href="admin.php?billets-revisions">Gestions des billets</a> / <strong>Rechercher un billet</strong>';
	$c=$recherche;
	
	// Gestion de la requete sql : un seul champs nécessaire => Ordre de priorité : nom>id>ref
	$donnees=fonctions::escape($_POST);	

	if 		(!empty($donnees['titre'])) 	$where="b.titre like '%".$donnees['titre']."%'";
	elseif  (!empty($donnees['id']))		$where="b.id_billet = ".$donnees['id'];
	elseif  (!empty($donnees['tag']))		$where="b.tags like '%".$donnees['tag']."%'";
	else	{ header('location: '.$page.'&action=rechercher&mess=erreurForm'); die();  }
	
	// On effectue la requête
	$sql=mysql_query("	SELECT id_billet, titre, date, pseudo, billet_statut
						FROM $table b
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=b.id_cat
						LEFT JOIN ".PREFIX."membres m
						ON m.id_membre=b.id_auteur
						WHERE $where 
						ORDER BY b.id_billet DESC") or die(mysql_error());
	
	if (mysql_num_rows($sql)==0) $c.="<div class='error'>Aucun titre trouvé</div>";	
	
	else
	
		$c.="<h3>Derniers billets</h3>
			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID</strong></td>
				<td class='table_titre' style='width:50%'><strong>TITRE</strong></td>
				<td class='table_titre' style='width:10%'><strong>STATUT</strong></td>
				<td class='table_titre' style='width:15%'><strong>AUTEUR</strong></td>
				<td class='table_titre' style='width:15%'><strong>DATE</strong></td>
				<td class='table_titre' style='width:5%'><strong>ACTIONS</strong></td>
			</tr>";
							
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	

			if ($billet_statut=="en_attente")  $color="#3366FF";
			else if ($billet_statut=="publie") $color="#00CC00";
			else							   $color="#FF6600";
						
			$c.= '<tr>
					<td><strong>'.$id_billet.'</strong></td>
					<td><a href="billet-'.$id_billet.'-'.fonctions::recode($titre).'.htm" target="_blank">'.$titre.'</td>
					<td style="font-weight:bold; color:'.$color.'">'.strtoupper($billet_statut).'</td>
					<td>'.$pseudo.'</td>
					<td style="font-size:10px">'.$date.'</td>
					<td><a href="'.$page.'&action=editer&id='.$id_billet.'"><img src="images/admin/page_edit.png" alt="Editer" /></a>&nbsp;
						<a href="'.$page.'&action=supprimer&id='.$id_billet.'"><img src="images/admin/page_delete.png" alt="Supprimer" /></a>
						</td>
				</tr>';
	
	}		
	
	$c.='</table>';
	
		

break;

}

	$m->design->assign('titre', 'Gestion des billets');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>