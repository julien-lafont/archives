<?php
$m->mbre->securite_admin('membre');

	$page="admin.php?membres-admins";
	$table=PREFIX."membres";
	
	$fil_ariane="<strong>Membres - Droits</strong> / ";
	

	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="erreurForm") $retour=miseEnForme_admin('bad', "Vous devez remplir un des 4 champs !");
		if ($mess=="edit_ok") $retour=miseEnForme_admin('ok', "Infos du membre modifiées avec succés !");
		if ($mess=="edit_erreurForm") $retour=miseEnForme_admin('bad', "Les infos du membre n'ont pas été modifiées : le formulaire n'a pas été rempli correctement");		
		if ($mess=="edit_erreurSql") $retour=miseEnForme_admin('bad', "Les infos du membre n'ont pas été modifiées : une erreur est survenue durant l'enregistrement dans la base de donnée");	
		$m->design->assign('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

	
	$fil_ariane.='<a href="admin.php?membres-admins">Gestion des droits des admins/modos</a> / <strong>Liste des membres</strong>';

	$sql=mysql_query("SELECT id_membre, prenom, ville, metier, groupe, email, msn, skype, site, pseudo , last_ip 
					  FROM ".PREFIX."membres 
					  WHERE groupe>1
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
				<th style='width:10%; text-align:center' class='header'><strong>Id</strong></th>
				<th style='width:30%' class='header'><strong>Pseudo</strong></th>
				<th style='width:30%' class='header'><strong>Email</strong></th>
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
				<td style="text-align:center"><strong>'.$id_membre.'</strong></td>
				<td>'.ucfirst($pseudo).'</td>
				<td>'.$email.'</td>
				<td>'.$groupe.'</td>
				<td style="text-align:center">
					<a href="'.$page.'&action=droits&id='.$id_membre.'" title="Gerer les droits de ce membre" style="border:1px solid #F00"><img src="images/admin/award_star_gold_3.png" alt="Droits" /></a> &nbsp;&nbsp;&nbsp;&nbsp; 
					<a href="admin.php?membres-gerer&action=editer&id='.$id_membre.'" title="Editer les infos du membre"><img src="images/admin/user_edit.png" alt="Editer" /></a>&nbsp;
					<a href="admin.php?membres-gerer&action=supprimer&id='.$id_membre.'" title="Supprimer le membre"><img src="images/admin/user_delete.png" alt="Supprimer" /></a>
					
				</td>
			</tr>';
	
	}		
	
	$c.='</tbody>
		</table>';

	
break;

case "droits":

	$fil_ariane.='<a href="admin.php?membres-admins">Gestion des droits des admins/modos</a> / <strong>D&eacute;tail d\'un membre</strong>';
	
	$id=(int)$_GET['id'];
	$sql=mysql_query("	SELECT * FROM ".PREFIX."membres m
						LEFT JOIN ".PREFIX."admin_droits a
						ON a.id_membre=m.id_membre
						WHERE m.id_membre=".$id);
		extract(fonctions::recupBdd(mysql_fetch_array($sql)));
	
	// Level
	if ($groupe==4) $grade="Mod&eacute;rateur";
	else			$grade="Administrateur";
	
	if ($billets_redaction==1) $c1a="checked";
	else					   $c1b="checked";
	if ($billets_edition==1)   $c2a="checked";
	else					   $c2b="checked";
	if ($commentaires==1) 	   $c3a="checked";
	else					   $c3b="checked";
	if ($membre==1) 		   $c4a="checked";
	else					   $c4b="checked";
	if ($configuration==1) 	   $c5a="checked";
	else					   $c5b="checked";
	
	$c='<form action="'.$page.'&action=droits_verif&id='.$id.'" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Gestion des droits de <u>'.ucfirst($pseudo).'</u> - '.$grade.'</h3>
			
			<strong>R&eacute;daction de nouveaux billets</strong><br />
			<input name="billets_redaction" type="radio" value="1" style="width:20px;" '.@$c1a.'/> Autoriser &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="billets_redaction" type="radio" value="0" style="width:20px;" '.@$c1b.'/> Interdire<br /><br />
			
			<strong>Edition et r&eacute;visions des billets d&eacute;j&agrave; publi&eacute;s</strong><br />
			<input name="billets_edition" type="radio" value="1" style="width:20px;" '.@$c2a.'/> Autoriser &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="billets_edition" type="radio" value="0" style="width:20px;" '.@$c2b.'/> Interdire<br /><br />
	
			<strong>Gestion et mod&eacute;ration des commentaires post&eacute;s</strong><br />
			<input name="commentaires" type="radio" value="1" style="width:20px;" '.@$c3a.'/> Autoriser &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="commentaires" type="radio" value="0" style="width:20px;" '.@$c3b.'/> Interdire<br /><br />

			<strong>Gestion des membres et de leurs droits</strong><br />
			<input name="membre" type="radio" value="1" style="width:20px;" '.@$c4a.'/> Autoriser &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="membre" type="radio" value="0" style="width:20px;" '.@$c4b.'/> Interdire<br /><br />

			<strong>Acc&eacute;s au param&egrave;tre de configuration du site</strong><br />
			<input name="configuration" type="radio" value="1" style="width:20px;" '.@$c5a.'/> Autoriser &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="configuration" type="radio" value="0" style="width:20px;"'.@$c5b.' /> Interdire<br /><br />

			<input type="submit" value="Modifier" class="f-submit" /><br />
	
		</fieldset>
		</form>';



break;

case "droits_verif":

	$id=(int)$_GET['id'];
	
	// On protège les données :
	$donnees=fonctions::escape($_POST);
			
	// Ajout dans la bdd 
	$sql=majBdd(PREFIX."admin_droits", '`id_membre`='.$id, $donnees);
	
	if ($sql) 	{ header('location: '.$page.'&id='.$id.'&mess=edit_ok'); die(); }
	else 		{ header('location: '.$page.'&id='.$id.'&mess=edit_erreurSql'); die(); }

break;
}

	$m->design->assign('titre', 'Gestion des membres');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>	