<?php
$m->mbre->securite_admin('membre');

	$page="admin.php?membres-gerer";
	$table=PREFIX_F."users";
	
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
						<option value="1">Membre</option>
						<option value="4">Modérateur</option>
						<option value="5">Administrateur</option>
					</select><br />
				</label>						
				<input type="submit" value="Rechercher" class="f-submit" tabindex="5" /><br />

		</fieldset>
	</form>';
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="erreurForm") $retour=miseEnForme('bad', "Vous devez remplir un des 4 champs !");
		$design->zone('retour', $retour);
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
	elseif  (!empty($donnees['groupe'])) 	$where="groupe = ".$donnees['groupe'];
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
		switch($group_id) {
			case 5: $groupe="Administrateur"; break;
			case 4: $groupe="Modérateur"; break;
			case 1: $groupe="Membre"; break;
			case 0: $groupe="Invité"; break;
		}
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Membre <span>#'.$id.'</span></h5>
						<ul>
							<li><strong>Pseudo</strong> : '.$username.'</li>
							<li><strong>Nom</strong> : '.$realname.'</li>
							<li><strong>Lieu</strong> : '.$location.'</li>
						</ul>
						<div class="bas" style="text-align:center">'.$groupe.'</div>
					</td>
					
					<td class="c"><h5>Contact</h5><br />
						<ul>
							<li><strong>Email</strong> : '.$msn.'</li>
							<li><strong>Msn</strong> : '.$url.'</li>
							<li><strong>Email</strong> : '.$email.'</li>
						</ul>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="admin.php?membres-gerer&action=editer&id='.$id_membre.'">Editer infos</a></div>
						<div class="boutonBlanc"><a href="admin.php?membres-gerer&action=supprimer&id='.$id_membre.'">Supprimer</a></div>
					</td>
				</tr>
			</table>';
	
	}		

break;

}

	$m->design->assign('titre', 'Gestion des membres');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);
	
?>