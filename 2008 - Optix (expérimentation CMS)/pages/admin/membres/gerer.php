<?php
$m->mbre->securite_admin('membre');

	$page="admin.php?membres-gerer";
	$table=PREFIX."membres";
	
	$fil_ariane="<strong>Membres</strong> / ";
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
			<fieldset>

				<h3>Rechercher un membre</h3>
		
				<label for="pseudo"><b>Par son pseudo</b>
					<input id="pseudo" name="pseudo" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
				</label>
				<label for="id"><b>Par son ID</b>
					<input id="id" name="id" type="text" class="f-name" tabindex="2" /><br />
				</label>
				<label for="email"><b>Par son email</b>
					<input id="email" name="email" type="text" class="f-name" tabindex="3" /><br />
				</label>
				<label for="groupe"><b>Par son groupe</b>
					<select name="groupe" id="groupe" class="f-name" tabindex="4" style="text-align:center; width:150px">
						<option value=""> / </option>
						<option value="0">Invit&eacute;</option>
						<option value="1">Membre</option>
						<option value="4">Mod&eacute;rateur</option>
						<option value="5">Administrateur</option>
					</select><br />
				</label>						
				<input type="submit" value="Rechercher" class="f-submit" tabindex="5" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="admin.php?membres-gerer&action=liste">Liste de tous les membres</a><br />
		</fieldset>
	</form>';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="erreurForm") $retour=miseEnForme_admin('bad', "Vous devez remplir un des 4 champs !");
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "Infos du membre modifiées avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "Les infos du membre n'ont pas été modifiées : le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "Les infos du membre n'ont pas été modifiées : une erreur est survenue durant l'enregistrement dans la base de donnée");
		if ($mess=="suppr_ok") $retour=miseEnForme_admin('ok', "Suppression du membre effectuée avec succès !");
		$m->design->assign('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

	
	$fil_ariane.='<a href="admin.php?membres-gerer">Gestion des membres</a> / <strong>Rechercher un membre</strong>';
	$c=$recherche;
	
break;

case "search":
	
	$fil_ariane.='<a href="admin.php?membres-gerer">Gestion des membres</a> / <strong>Rechercher un membre</strong>';
	$c=$recherche;
	
	// Gestion de la requete sql : un seul champs nécessaire => Ordre de priorité : nom>id>ref
	$donnees=fonctions::escape($_POST);	

	if 		(!empty($donnees['pseudo'])) 	$where="pseudo like '%".$donnees['pseudo']."%'";
	elseif  (!empty($donnees['id']))		$where="id_membre = ".$donnees['id'];
	elseif  (!empty($donnees['email'])) 	$where="email like '%".$donnees['email']."%'";
	elseif  (isset($donnees['groupe'])) 		$where="groupe = ".$donnees['groupe'];
	else	{ header('location: '.$page.'&mess=erreurForm'); die();  }
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *
						FROM $table membres 
						WHERE $where 
						ORDER BY id_membre DESC") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(fonctions::recupBdd($d));	
		
		// Gestion du groupe
		switch($groupe) {
			case 5: $groupe="Administrateur"; break;
			case 4: $groupe="Mod&eacute;rateur"; break;
			case 1: $groupe="Membre"; break;
			case 0: $groupe="Invit&eacute;"; break;
		}
		
		// Gestion avatar
		if ($avatar) $image_avatar="<img src='upload/avatars/".$avatar."' style='float:right; margin:10px 10px 0 0; border:1px dashed #AAA'/>";
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5><span>'.ucfirst($pseudo).'</span></h5>
						'.$image_avatar.'
						<ul>
							<li><strong>ID Membre</strong> : '.$id_membre.'</li>
							<li><strong>Identite</strong> : '.$realname.'</li>
						</ul>
						
						<div class="bas" style="text-align:center">'.$groupe.'</div>
					</td>
					
					<td class="c"><h5>Contact</h5>
						<ul>
							<li><strong>Email</strong> : '.$email.'</li>
						</ul>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="admin.php?membres-gerer&action=editer&id='.$id_membre.'">Editer infos</a></div>
						<div class="boutonBlanc"><a href="admin.php?membres-gerer&action=supprimer&id='.$id_membre.'">Supprimer</a></div>
						<div class="boutonBlanc"><a href="admin.php?membres-admins&action=droits&id='.$id_membre.'">Gestions de ses droits</a></div>
					</td>
				</tr>
			</table>';
	
	}		

break;

case "liste":

	$fil_ariane.='<a href="admin.php?membres-gerer">Gestion des membres</a> / <strong>Liste des membres</strong>';
	
	$sql=mysql_query("SELECT id_membre, identite, groupe, email, pseudo , last_ip 
					  FROM ".PREFIX."membres 
					  ORDER BY id_membre ASC") or die(mysql_error());

	$c="
	<script>
		$(document).ready(function() 
			{ 
				$('#liste_membres').tablesorter({ sortList: [[1,0]] }); 
			} 
		);
	</script>
     
	<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px' class='table1 tablesorter' id='liste_membres'>
			<thead> 
			<tr>
				<th style='width:10%' class='header'><strong>Id</strong></th>
				<th style='width:20%' class='header'><strong>Pseudo</strong></th>
				<th style='width:20%' class='header'><strong>Email</strong></th>
				<th style='width:15%' class='header'><strong>Identite</strong></th>
				<th style='width:15%' class='header'><strong>Derni&egrave;re ip</strong></th>
				<th style='width:10%' class='header'><strong>Groupe</strong></th>
				<th style='width:10%' class='header'><strong>Actions</strong></th>
			</tr>
			</thead>
			<tbody>";
			
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(fonctions::recupBdd($d));	
		
		// Gestion du groupe
		switch($groupe) {
			case 5: $groupe="Admin"; break;
			case 4: $groupe="Modo"; break;
			case 1: $groupe="Mbre"; break;
			case 0: $groupe="Invit&eacute;"; break;
		}
		
		$c.= '<tr>
				<td><strong>'.$id_membre.'</strong></td>
				<td>'.ucfirst($pseudo).'</td>
				<td>'.$email.'</td>
				<td>'.$identite.'</td>
				<td>'.$last_ip.'</td>
				<td>'.$groupe.'</td>
				<td style="text-align:center"><a href="'.$page.'&action=editer&id='.$id_membre.'" title="Editer les infos du membre"><img src="images/admin/user_edit.png" alt="Editer" /></a>&nbsp;
					<a href="'.$page.'&action=supprimer&id='.$id_membre.'" title="Supprimer le membre"><img src="images/admin/user_delete.png" alt="Supprimer" /></a>
				</td>
			</tr>';
	
	}		
	
	$c.='</tbody>
		</table>';
	
break;

case "editer":

	$id=(int)$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."membres m
					  WHERE m.id_membre=".$id);
					  
	extract(fonctions::recupBdd(mysql_fetch_array($sql)));
	
	switch($groupe) {
		case 0: $s1="selected"; break;
		case 1: $s2="selected"; break;
		case 4: $s3="selected"; break;
		case 5: $s4="selected"; break;
	}
	
	$fil_ariane.="<a href='admin.php?membres-gerer'>Gestion des membres</a> / <strong>Editer les infos d'un membre</strong>";
	
	$c= '<form action="'.$page.'&action=editer_verif&id='.$id.'" method="post" class="f-wrap-1" onsubmit="$(\'#resume\').val(oEdit1.getHTMLBody());$(\'#contenu\').val(oEdit2.getHTMLBody());">
			
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Editer un membre</h3>
			
			<label for="pseudo"><b><span class="req">*</span>Pseudo</b>
				<input id="pseudo" name="pseudo" type="text" class="f-name" maxlength="255" value="'.$pseudo.'"/><br />
			</label>
			
			<label for="email"><b><span class="req">*</span>Email</b>
				<input id="email" name="email" type="text" class="f-name" maxlength="255"  value="'.$email.'"/><br />
			</label>

			<label for="identite"><b>Identite</b>
				<input id="identite" name="identite" type="text" class="f-name" maxlength="255"  value="'.$identite.'"/><br />
			</label>
						
			<label for="groupe"><b>Groupe</b>
				<select id="groupe" name="groupe">
					<option value="0" '.@$s1.'>Invit&eacute;</option>
					<option value="1" '.@$s2.'>Membre</option>
					<option value="4" '.@$s3.'>Mod&eacute;rateur</option>
					<option value="5" '.@$s4.'>Administrateur</option>
				</select>
			</label><br />
					
			<input type="submit" value="Modifier" class="f-submit" /><br />

		</fieldset>
		</form>';


 
break;

case "editer_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=fonctions::escape($_POST);
	// Verifications des champs obligatoires
	verif_champs_requis($page.'&id='.$id.'&mess=edit_erreurForm', $donnees, array('pseudo', 'email'));
	
	
		
	// Ajout dans la bdd 
	$sql=majBdd($table, '`id_membre`='.$id, $donnees);
	
	if ($sql) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }
	
break;

case "supprimer":

	$id=(int)$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."membres WHERE id_membre=$id");
	
	header('location: '.$page.'&id='.$id.'&mess=suppr_ok'); die();

break;


case "ajouter":

	$fil_ariane.='<a href="'.$page.'">Gestion des membres</a> / <strong>Nouveau membre</strong>';

	$c= '<form action="'.$page.'&action=ajouter_verif" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Ajouter un membre</h3>
			
			<label for="pseudo"><b><span class="req">*</span>Pseudo</b>
				<input id="pseudo" name="pseudo" type="text" class="f-name" maxlength="255" value=""/><br />
			</label>
			
			<label for="pass"><b><span class="req">*</span>Mot de passe</b>
				<input id="pass" name="pass" type="text" class="f-name" maxlength="255" value=""/><br />
			</label>
			
			<label for="email"><b><span class="req">*</span>Email</b>
				<input id="email" name="email" type="text" class="f-name" maxlength="255"  value=""/><br />
			</label>

			<label for="identite"><b>Identite</b>
				<input id="identite" name="identite" type="text" class="f-name" maxlength="255"  value=""/><br />
			</label>
						
			<label for="groupe"><b>Groupe</b>
				<select id="groupe" name="groupe">
					<option value="0">Invit&eacute;</option>
					<option value="1">Membre</option>
					<option value="4">Mod&eacute;rateur</option>
					<option value="5">Administrateur</option>
				</select>
			</label><br />
			
			<input type="hidden" name="cle" value="'.fonctions::GenKey(10).'" />
			
			<input type="submit" value="Submit" class="f-submit" tabindex="4"/><br />

		</fieldset>
		</form>';

	//TODO:Gérer le logo
	
break;

case "ajouter_verif":

	// Vérifications des champs obligatoires
	verif_champs_requis($page.'&action=ajouter&mess=ajout_erreurForm', $_POST, array('pseudo', 'email', 'identite', 'groupe', 'pass', 'cle'));
	
	// Ajout dans la bdd 
	$sql=insererBdd($table, $_POST);
	
	if ($sql) 	{ header('location: '.$page.'&mess=ajout_ok'); die(); }
	else 		{ header('location: '.$page.'&action=ajouter&mess=ajout_erreurSql'); die(); }	
	
break;
}

	$m->design->assign('titre', 'Ajouter des membres');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>