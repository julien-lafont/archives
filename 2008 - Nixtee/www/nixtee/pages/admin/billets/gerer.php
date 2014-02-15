<?php
$m->mbre->securite_admin("billets_edition");

	$page="admin.php?billets-gerer";
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
		if ($mess=="erreurForm") $retour=miseEnForme_admin('bad', "Vous devez remplir un des 2 champs !");
		$m->design->assign('retour', $retour);
	}
	
	

			
switch(@$_GET['action']) {

default:
	
	$fil_ariane='<a href="admin.php?billets-revisions">Gestions des billets</a> / <strong>Billets en attente de publication</strong>';
	
	$c=$recherche;

	// On effectue la requête
	$sql=mysql_query("	SELECT id_billet, titre, date, pseudo, billet_statut
						FROM $table b
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=b.id_cat
						LEFT JOIN ".PREFIX."membres m
						ON m.id_membre=b.id_auteur
						WHERE billet_statut!='publie'
						ORDER BY b.id_billet DESC") or die(mysql_error());
						
	
		$c.="<h3>Billets en en attente de publications</h3>
			<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID</strong></td>
				<td class='table_titre' style='width:40%'><strong>TITRE</strong></td>
				<td class='table_titre' style='width:10%'><strong>STATUT</strong></td>
				<td class='table_titre' style='width:20%'><strong>AUTEUR</strong></td>
				<td class='table_titre' style='width:20%'><strong>DATE</strong></td>
				<td class='table_titre' style='width:5%'><strong>ACTIONS</strong></td>
			</tr>";
							
		while($d=mysql_fetch_array($sql)) {
			
			// On récupère les données 
			extract(fonctions::recupBdd($d));	
			
			if ($billet_statut=="en_attente") $color="#3366FF";
			else							  $color="#FF6600";
			
			$c.= '<tr>
					<td><strong>'.$id_billet.'</strong></td>
					<td><a href="billet-'.$id_billet.'-'.fonctions::recode($titre).'.htm" target="_blank">'.$titre.'</td>
					<td style="font-weight:bold; color:'.$color.'">'.strtoupper($billet_statut).'</td>
					<td>'.$pseudo.'</td>
					<td style="font-size:10px">'.$date.'</td>
					<td><a href="admin.php?billets-revisions&action=editer&id='.$id_billet.'"><img src="images/admin/page_edit.png" alt="Editer" /></a>&nbsp;
						<a href="admin.php?billets-revisions&action=supprimer&id='.$id_billet.'"><img src="images/admin/page_delete.png" alt="Supprimer" /></a>
						</td>
				</tr>';
		
		}		
		
		$c.='</table>';	
		

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
	$sql=mysql_query("	SELECT id_billet, titre, date, pseudo
						FROM $table b
						LEFT JOIN ".PREFIX."categories c
						ON c.id_cat=b.id_cat
						LEFT JOIN ".PREFIX."membres m
						ON m.id_membre=b.id_auteur
						WHERE $where 
						ORDER BY b.id_billet DESC") or die(mysql_error());
	
	if (mysql_num_rows($sql)==0) $c.="<div class='error'>Aucun billet trouv&eacute;</div>";	
	
	else
		$c.="<table style='width:90%; border:1px solid #ccc !important; padding:5px; margin:0 0 10px 30px'>
			<tr>
				<td class='table_titre' style='width:5%'><strong>ID</strong></td>
				<td class='table_titre' style='width:50%'><strong>Titre</strong></td>
				<td class='table_titre' style='width:20%'><strong>Auteur</strong></td>
				<td class='table_titre' style='width:20%'><strong>Date</strong></td>
				<td class='table_titre' style='width:5%'><strong>ACTIONS</strong></td>
			</tr>";
							
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(fonctions::recupBdd($d));	
		
		$c.= '<tr>
				<td><strong>'.$id_billet.'</strong></td>
				<td>'.$titre.'</td>
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