<?php
$m->mbre->securite_admin("commentaires");

	$page="admin.php?commentaires-amoderer";
	$table=PREFIX."commentaires";

	$fil_ariane="<strong>Commentaires non-mod&eacute;r&eacute;s</strong> / ";

switch(@$_GET['action']) {

default:
	
	$fil_ariane='<a href="admin.php?commentaires-amoderer">Gestions des commentaires</a> / <strong>A mod&eacute;rer</strong>';
	
	// On effectue la requête
	$sql=mysql_query("	SELECT id_com, b.id_billet, titre, pseudo, invite_pseudo, com.date, message, com.id_membre
						FROM ".PREFIX."commentaires com
						LEFT JOIN ".PREFIX."membres m ON m.id_membre=com.id_membre
						LEFT JOIN ".PREFIX."billets b ON com.id_billet=b.id_billet 
						WHERE statut=0
						ORDER BY id_com DESC
						LIMIT 0,20") or die(mysql_error());
						
	// Nbe de coms à modérer 
	$nb=mysql_nb("SELECT id_com FROM ".PREFIX."commentaires WHERE statut=0");
						
			if ($billet_statut=="en_attente")  $color="#3366FF";
			else if ($billet_statut=="publie") $color="#00CC00";
			else							   $color="#FF6600";	
				
		$c="<h3 style='text-align:center'>En attente de mod&eacute;ration : <strong style='color:#0066FF' id='nb'>".$nb."</strong> commentaires </h3>
			
			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:10%'><strong>AUTEUR</strong></td>
				<td class='table_titre' style='width:80%'><strong>MESSAGE</strong></td>
				<td class='table_titre' style='width:10%; text-align:center'><strong>ACTIONS</strong></td>
			</tr>";
							
		$i=0;
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	
			
			// Gestion du pseudo
			if (!$pseudo) {
				$membre="<strong style='color:#0066FF'>Invit&eacute;</strong><br />
							<i>".$invite_pseudo."</i>";
			} else {
				$membre="<strong style='color:#0066FF'>Membre</strong><br />
				         <a href='membre-".$id_membre."-".recode($pseudo).".htm'>".$pseudo."</a>";
			}
			
			($i%2==0) ? $color="#D8F3FE" : $color="#BCE0FE";
			
			$c.= '<tr id="com_'.$id_com.'" style="background-color:'.$color.'">
					<td style="vertical-align:top; text-align:center">'.$membre.'</td>
					<td style="vertical-align:top">
						<div style="font-size:11px; margin-bottom:20px; padding:5px">
							<strong>'.$titre.'</strong><br />
								'.$message.'
						</div>
					</td>
					<td style="vertical-align:middle; text-align:center">
						<a href="javascript:void(0)" onclick="moderer(\'accepter\', '.$id_com.'); return false"><img src="images/admin/accepter.png" alt="Accepter" /></a>&nbsp;
						<a href="javascript:void(0)" onclick="moderer(\'refuser\', '.$id_com.'); return false"><img src="images/admin/refuser.png" alt="Supprimer" /></a>
						</td>
				</tr>';
				
			$i++;
		
		}		
		
		$c.='</table>
		
		<div style="text-align:right"><i>La page se raffraichira automatiquement lorsque ces 20 commentaires auront &eacute;t&eacute; mod&eacute;r&eacute;s.</i><br /></div>';	
		

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

	$m->design->assign('titre', 'Liste des derniers commentaires non-mod&eacute;r&eacute;s : ');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>