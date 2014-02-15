<?php
securite_admin();

	$design->zone('titrePage', 'Administration Team');
	$design->zone('titre', 'Gérer les membres de la team');
	
switch(@$_GET['action'])
{
default:

	$contenu='<div id="infoInscription">
				Utilisez cette page pour éditer/créer de nouvelles Teams et gérer les membres y appartenants.
			  </div><br />
			  
	  <div id="team"><div class="cadreLien"><a class="lienTeam">&raquo; Liste des teams</a></div></div><br />
	  
	  	<table>';
	
		$sqlTeam=mysql_query("SELECT * FROM ".PREFIX."team_cat");
		while ($team=mysql_fetch_object($sqlTeam)) {
		 $contenu.='<tr><td>&nbsp;&nbsp;&nbsp; - '.recupBdd($team->nom).'</td><td>&nbsp;&nbsp; 
		 				<a href="?admin-team&action=editCat&id='.$team->id.'">Editer team</a> . 
						<a href="?admin-team&action=supprCat&id='.$team->id.'">Suppr team</a> . 
						<a href="?admin-team&action=players&id='.$team->id.'"><b>Players</b></a>
					</td></tr>';
		}
		$contenu.='</table>
		<br />&nbsp;&nbsp;&nbsp; - <a href="#" onclick="Effect.Phase(\'addCat\'); return false">Ajouter une team</a><br /><br />
		<center>
		  <div id="addCat" style="border:1px solid #ccc; background-color:#FAFAFA; padding:5px; display:none; width:50%">
			<b>Ajouter une Team</b><br /><br />
			<form name="newCat" method="post" action="?admin-team&action=newCat" id="form">
				<input type="text" name="nom" maxlength="150" value="Nom de la team" style="text-align:center" onfocus="this.value=\'\'"/><br />
				<input type="submit" value="Ajouter" style="width:75px" />
			</form>
		  </div>
		</center>
		
		<br />';
		
	$design->zone('contenu', $contenu);
break;

case "newCat":

	$nom=addBdd($_POST['nom']);
	if (strlen($nom)=="") die("<center>Vous devez spécifier un nom !<br /><br />- <a href='?admin-team'>Retour</a> -"); 

	$sql=mysql_query("INSERT INTO ".PREFIX."team_cat (`nom`) VALUES ('$nom')");
	header('location: ?admin-team');
break;

case "supprCat":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."team_cat WHERE id=$id");
	header('location: ?admin-team');

break;

case "editCat":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT nom FROM ".PREFIX."team_cat WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$contenu='<center>
		  <div style="border:1px solid #ccc; background-color:#FAFAFA; padding:5px;width:50%">
			<b>Editer une Team</b><br /><br />
			<form name="newCat" method="post" action="?admin-team&action=editCat2" id="form">
				<input type="text" name="nom" maxlength="150" value="'.recupBdd($d->nom).'" style="text-align:center" /><br />
				<input type="submit" value="Ajouter" style="width:75px" />
				<input type="hidden" name="id" value="'.$id.'" />
			</form>
		  </div>
		</center>';
		
	$design->zone('contenu', $contenu);
break;

case "editCat2":

	$id=$_POST['id'];
	$nom=addBdd($_POST['nom']);
	if (strlen($nom)=="") die("<center>Vous devez spécifier un nom !<br /><br />- <a href='?admin-team'>Retour</a> -"); 

	$sql=mysql_query("UPDATE ".PREFIX."team_cat SET nom='$nom' WHERE id=$id");
	header('location: ?admin-team');
	
break;

case "players":

	$idTeam=$_GET['id'];
	
	$sqlTeam=mysql_query("SELECT nom FROM ".PREFIX."team_cat WHERE id=$idTeam");
	$team=mysql_fetch_object($sqlTeam);
		$nomTeam=recupBdd($team->nom);
	
	$sqlPlayers=mysql_query("SELECT t.id, t.pseudoAff, t.description, t.photo, t.ville, t.age, m.pseudo
							 FROM ".PREFIX."team t
							 LEFT JOIN ".PREFIX."membres m
							 ON m.id=t.id_membre
							 WHERE t.id_team=$idTeam") or die (mysql_error());
	
	  
	  $contenu.='
	  	<div id="team"><div class="cadreLien"><a class="lienTeam">&raquo; La team : '.$nomTeam.'</a></div></div><br />
		
		<center><div id="posterNews"><a href="?admin-team&action=ajouterPlayer&idTeam='.$idTeam.'">Ajouter un Player</a></div></center><br />

		<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:97%">
			<tr>
			  <td colspan=5 class="liste_header">	Liste players dans cette team<br /><br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre" style="vertical-align:bottom">Photo & <br />Description</td>
			  <td class="liste_titre" style="vertical-align:bottom">Pseudo</td>
			  <td class="liste_titre" style="vertical-align:bottom">Ville/Age</td>
			  <td class="liste_titre" style="vertical-align:bottom">Relation</td>
			  <td class="liste_titre"></td>
		  </tr>';
		  
	while ($p=mysql_fetch_object($sqlPlayers)) {
	
		if (isset($p->pseudo)) $corres='<b>OK</b><br />-> '.$p->pseudo;
		else				   $corres='<b>INTROUVABLE</b><br />Vérifier id !';
		
		$contenu.='
			<tr>
				<td class="liste_txt"><img src="images/players/'.recupBdd($p->photo).'" /></td>
				<td class="liste_txt">'.recupBdd($p->pseudoAff).'</td>
				<td class="liste_txt">'.recupBdd($p->ville).'<br>'.recupBdd($p->age).' ans</td>
				<td class="liste_txt">'.$corres.'</td>
				<td class="liste_txt">
					<a href="?admin-team&action=supprPlayer&id='.$p->id.'" title="Supprimer le player"><img src="images/boutons/cancel.png" /></a> &nbsp;
					<a href="?admin-team&action=editerPlayer&id='.$p->id.'" title="Editer le player"><img src="images/boutons/edit.png" /></a>						
				</td>
			</tr>';
	}
	
	$contenu.='</table><br /><br /><center> - <a href="?admin-team">Retour administration de la Team</a> -</center>';
		
		
		$design->zone('contenu', $contenu);

break;

case "supprPlayer":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."team WHERE id=$id");
	
	header('location: ?admin-team');
	
break;

case "ajouterPlayer":
	
	$idTeam=$_GET['idTeam'];
	
	$sqlTeam=mysql_query("SELECT nom FROM ".PREFIX."team_cat WHERE id=$idTeam");
	$team=mysql_fetch_object($sqlTeam);
		$nomTeam=recupBdd($team->nom);

	$contenu='<div id="infoInscription">
				Utilisez ce formulaire pour ajouter un player à la team :<br><b>'.$nomTeam.'</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-team&action=ajouterPlayer2">
			  <fieldset>
			  		
				<label for="_pseudo" style="font-weight:bold">» Indiquez le pseudo du player</label> <span class="requis">(Possibilité de mettre en forme le pseudo)</span>  <br />
				<input type="text" name="pseudo" id="_pseudo" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="description" style="font-weight:bold">» Description du player</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br />
				
				<label for="age" style="font-weight:bold">» Indiquez son age</label> <br />
				<input type="text" name="age" id="age" style="margin-left:25px !important; text-align:left; width:20px" /> ans<br /><br />

				<label for="ville" style="font-weight:bold">» Indiquez sa ville</label><br />
				<input type="text" name="ville" id="ville" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="id_membre" style="font-weight:bold">» Indiquez l\'ID du membre</label><br />
				<table><tr>
					<td><input type="text" name="id_membre" id="id_membre" style="margin-left:25px !important; text-align:left; width:20px"" /></td>
					<td><blockquote style="margin-left:10px">- INDISPENSABLE pour faire la relation avec le profil du membre<br />
						- <a href="#" onclick="showIdPseudo(); return false">Utilisez cette page pour trouver la correspondace</a> </blockquote></td>
				</tr></table><br />
				
				<label for="photo" style="font-weight:bold">» Nom de la photo</label> <span class="requis">(A partir de images/players/)</span>  <br />
				<input type="text" name="photo" id="photo" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<input type="hidden" name="idTeam" value="'.$idTeam.'" />
				<b>» Vérifier et ajouter le player</b><br />
				<input type="submit" class="submit" value="ajouter le player"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-team">Retour administration de la Team</a> -</center><br />';
	
	$design->zone('contenu', $contenu);
	
break;

case "ajouterPlayer2":

	$pseudoAff=addBdd($_POST['pseudo']);
	$description=addBdd($_POST['description']);
	$age=addBdd($_POST['age']);
	$ville=addBdd($_POST['ville']);
	$idMembre=addBdd($_POST['id_membre']);
	$photo=addBdd($_POST['photo']);
	$idTeam=$_POST['idTeam'];

	$sql=mysql_query("INSERT INTO ".PREFIX."team (`id_team`,`id_membre`,`pseudoAff`,`description`,`photo`,`age`,`ville`)
										  VALUES ('$idTeam','$idMembre','$pseudoAff','$description','$photo','$age','$ville')");
	
	header('location: ?admin-team&action=players&id='.$idTeam);
										  
break;

case "editerPlayer":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."team WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$sql2=mysql_query("SELECT pseudo FROM ".PREFIX."membres WHERE id=".$d->id_membre);
	$p=mysql_fetch_object($sql2);
		if (mysql_affected_rows()==0) $pseudo="<b>!! INCONNU !!</b>";
		else						  $pseudo=ucfirst($p->pseudo);
	
	$contenu='<div id="infoInscription">
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-team&action=editerPlayer2">
			  <fieldset>
			  		
				<label for="_pseudo" style="font-weight:bold">» Indiquez le pseudo du player</label> <span class="requis">(Possibilité de mettre en forme le pseudo)</span>  <br />
				<input type="text" name="pseudo" id="_pseudo" value="'.recupBdd($d->pseudoAff).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="description" style="font-weight:bold">» Description du player</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->description).'</textarea><br /><br />
				
				<label for="age" style="font-weight:bold">» Indiquez son age</label> <br />
				<input type="text" name="age" id="age" value="'.recupBdd($d->age).'" style="margin-left:25px !important; text-align:left; width:20px" /> ans<br /><br />

				<label for="ville" style="font-weight:bold">» Indiquez sa ville</label><br />
				<input type="text" name="ville" id="ville" value="'.recupBdd($d->ville).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="id_membre" style="font-weight:bold">» Indiquez l\'ID du membre</label><br />
				<table><tr>
					<td><input type="text" name="id_membre" id="id_membre" value="'.recupBdd($d->id_membre).'" style="margin-left:25px !important; text-align:left; width:20px"" /></td>
					<td><blockquote style="margin-left:10px"><b style="color:#FF3333">-> Correspondance avec : '.$pseudo.'</b> <br />
						- INDISPENSABLE pour faire la relation avec le profil du membre<br />
						- <a href="#" onclick="showIdPseudo(); return false">Utilisez cette page pour trouver la correspondace</a>
						</blockquote></td>
				</tr></table><br />
				
				<label for="photo" style="font-weight:bold">» Nom de la photo</label> <span class="requis">(A partir de images/players/)</span>  <br />
				<input type="text" name="photo" id="photo" value="'.recupBdd($d->photo).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<input type="hidden" name="id_team" value="'.recupBdd($d->id_team).'" />
				<input type="hidden" name="id" value="'.recupBdd($id).'" />
				
				<b>» Editer le player</b><br />
				<input type="submit" class="submit" value="éditer le player"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-team">Retour administration de la Team</a> -</center><br />';
	
	$design->zone('contenu', $contenu);

break;

case "editerPlayer2":

	$pseudoAff=addBdd($_POST['pseudo']);
	$description=addBdd($_POST['description']);
	$age=addBdd($_POST['age']);
	$ville=addBdd($_POST['ville']);
	$idMembre=addBdd($_POST['id_membre']);
	$photo=addBdd($_POST['photo']);
	$idTeam=$_POST['id_team'];
	$id=$_POST['id'];

	$sql=mysql_query("UPDATE ".PREFIX."team 
					  SET
					  	id_team='$idTeam',
						id_membre='$idMembre',
						pseudoAff='$pseudoAff',
						description='$description',
						photo='$photo',
						age='$age',
						ville='$ville'
					 WHERE id=$id");
	
	header('location: ?admin-team&action=players&id='.$idTeam);
										  
break;

}
?>