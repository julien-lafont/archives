<?php
securite_admin();

$design->zone('titrePage', 'Les médias');
$design->zone('titre', 'Gérer les médias du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil">&lsaquo; Retour &lsaquo;</a></div>
			
			<br><center><div id="posterNews"><a href="?admin-medias&action=poster">Ajouter un média</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=3 class="liste_header">	Liste des Médias :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Titre</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."medias");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
						<td class="liste_txt">
								'.recupBdd($d->nom).'
						</td>
						
						<td class="liste_txt" style="font-size:9px">
							'.inverser_date($d->date,6).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-medias&action=suppr&id='.$d->id.'" title="Supprimer le média"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-medias&action=editer&id='.$d->id.'" title="Editer le média"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."medias WHERE id=$id");
	header('location: ?admin-medias');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

	$contenu='<div id="retour"><a href="?admin-medias">&lsaquo; Retour &lsaquo;</a></div>
	
				<br><br><div id="infoInscription">
				Utilisez ce formulaire pour ajouter un média au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-medias&action=poster2">
			  <fieldset>
			  		
				<label for="nom" style="font-weight:bold">» Nom du média</label><br />
				<input type="text" name="nom" id="nom" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="description" style="font-weight:bold">» Description du média</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br />
				
				<label for="auteur" style="font-weight:bold">» Réalisateur/Auteur du média</label> <i>(optionnel) (HTML permis)</i><br />
				<input type="text" name="auteur" id="auteur" style="margin-left:25px !important; text-align:left;" /><br /><br />

				<label for="taille" style="font-weight:bold">» Taille du fichier</label><br />
				<input type="text" name="taille" id="taille" style="margin-left:25px !important; text-align:left; width:50px" /> mo<br /><br />
				
				<label for="url" style="font-weight:bold">» Adresse complète du fichier</label><br />
				<input type="text" name="url" id="url" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />

				
				<b>» Vérifier et ajouter le média</b><br />
				<input type="submit" class="submit" value="ajouter le média"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-medias">Retour administration des médias</a> -</center><br />';

break;
case "poster2":

	$nom=addBdd($_POST['nom']);
	$desc=addslashes($_POST['description']);
	$auteur=addslashes($_POST['auteur']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);

	$sql=mysql_query("INSERT INTO ".PREFIX."medias (`nom` , `description` , `nb_dl` , `auteur` , `taille` , `url` , `date` )
										  VALUES ('$nom','$desc',0,'$auteur','$taille','$url',NOW())");
	
	header('location: ?admin-medias');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."medias WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$contenu='<div id="retour"><a href="?admin-medias">&lsaquo; Retour &lsaquo;</a></div>
				
			  <br><br><div id="infoInscription">
				Utilisez ce formulaire pour éditer un média au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-medias&action=editer2&id='.$id.'">
			  <fieldset>
			  		
				<label for="nom" style="font-weight:bold">» Nom du média</label><br />
				<input type="text" name="nom" id="nom" value="'.recupBdd($d->nom).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="description" style="font-weight:bold">» Description du média</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->description).' </textarea><br /><br />
				
				<label for="auteur" style="font-weight:bold">» Réalisateur/Auteur du média</label> <i>(optionnel) (HTML permis)</i><br />
				<input type="text" name="auteur" id="auteur" value="'.recupBdd($d->auteur).'" style="margin-left:25px !important; text-align:left;" /><br /><br />

				<label for="taille" style="font-weight:bold">» Taille du fichier</label><br />
				<input type="text" name="taille" id="taille" value="'.recupBdd($d->taille).'" style="margin-left:25px !important; text-align:left; width:50px" /> mo<br /><br />
				
				<label for="url" style="font-weight:bold">» Adresse complète du fichier</label><br />
				<input type="text" name="url" id="url" value="'.recupBdd($d->url).'" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />

				
				<b>» Vérifier et éditer le média</b><br />
				<input type="submit" class="submit" value="éditer le média"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-medias">Retour administration des médias</a> -</center><br />';

break;
case "editer2":

	$nom=addBdd($_POST['nom']);
	$desc=addslashes($_POST['description']);
	$auteur=addslashes($_POST['auteur']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);
	$id=$_GET['id'];

	$sql=mysql_query("	UPDATE ".PREFIX."medias
						SET
							nom='$nom',
							description='$desc',
							auteur='$auteur',
							taille='$taille',
							url='$url'
						WHERE id=$id");
	
	header('location: ?admin-medias');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>