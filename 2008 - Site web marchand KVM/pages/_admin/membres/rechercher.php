<?php
securite_admin('membres');

	$page="?admin-membres-rechercher";
	$table=PREFIX."membres";
	
	
	// Formulaire de recherche ( par nom/ref/id ) 
	$recherche= '<form action="'.$page.'&action=search" method="post" class="f-wrap-1" >
			<fieldset>

				<h3>Rechercher un membre</h3>
		
				<label for="nom"><b>Par son nom</b>
					<input id="nom" name="nom" type="text" class="f-name" tabindex="1" maxlength="255"/><br />
				</label>
				<label for="id"><b>Par son ID</b>
					<input id="id" name="id" type="text" class="f-name" tabindex="3" /><br />
				</label>
				<label for="email"><b>Par son email</b>
					<input id="email" name="email" type="text" class="f-name" tabindex="2" /><br />
				</label>
						
				<input type="submit" value="Rechercher" class="f-submit" /><br />

		</fieldset>
	</form>';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="erreurForm") $retour=miseEnForme('bad', "Vous devez remplir un des 3 champs !");
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:

	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gerer">Gestion des membres</a> / <strong>Rechercher un membre</strong>';
	$c=$recherche;
	
break;

case "search":
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gerer">Gestion des membres</a> / <strong>Rechercher un membre</strong>';
	$c=$recherche;
	
	// Gestion de la requete sql : un seul champs nécessaire => Ordre de priorité : nom>id>ref
	$donnees=addslashes_array($_POST);	

	if 		(!empty($donnees['nom'])) 		$where="mi.nom like '%".$donnees['nom']."%'";
	elseif  (!empty($donnees['id']))		$where="m.id_membre = ".$donnees['id'];
	elseif  (!empty($donnees['email'])) $where="m.email like '%".$donnees['email']."%'";
	else	{ header('location: '.$page.'&mess=erreurForm'); die();  }
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *
						FROM $table m
						LEFT JOIN ".PREFIX."membres_infos mi
						ON mi.id_membre=m.id_membre
						WHERE $where 
						ORDER BY m.id_membre DESC") or die(mysql_error());
						
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

}

	$design->zone('titre', 'Gestion des membres');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>