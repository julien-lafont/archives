<?php
securite_admin();

$design->zone('titrePage', 'Les fichiers');
$design->zone('titre', 'Gérer les fichiers du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br><center><div id="posterNews"><a href="?admin-files&action=poster">Ajouter un Fichier</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des Fichiers :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Cat</td>
			  <td class="liste_titre">Nom</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."files_movies");
	$nb=mysql_num_rows($sql);
	if ($nb==0) {
		$contenu.='<tr>
					<td colspan="4"><center>Aucun fichier</center></td>
				   </tr>';
	}
	else 
	{ 
		while($d = mysql_fetch_object($sql)) {
			
			$contenu.= '<tr>
							<td class="liste_txt">
									'.ucfirst($d->cat).'
							</td>
							<td class="liste_txt">
									'.recupBdd($d->nom).'
							</td>
							
							<td class="liste_txt" style="font-size:9px">
								'.inverser_date($d->date,6).'
							</td>
							
							<td class="liste_txt">	
								<a href="?admin-files&action=suppr&id='.$d->id.'" title="Supprimer le fichier"><img src="images/boutons/cancel.png" /></a> &nbsp;
								<a href="?admin-files&action=editer&id='.$d->id.'" title="Editer le fichier"><img src="images/boutons/edit.png" /></a>						
							</td>
					   </tr>';	
		}
	} 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."files_movies WHERE id=$id");
	header('location: ?admin-files');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

	$contenu='<div id="retour"><a href="?admin-files"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
				<br><br><div id="infoInscription">
				Utilisez ce formulaire pour ajouter un fichier au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-files&action=poster2">
			  <fieldset style="margin-left:20px">
			  		
				<label for="cat" style="font-weight:bold">» Catégorie</label> <span class="requis">requis</span><br /> 
					<select name="cat" id="cat"  style="margin:2px 0 0 25px; width:120px">
						<option value="movies">Movies</option>
						<option value="files">Files</option>
						<option value="others">Others</option>
					</select><br /><br />
				
				<label>» Nom du fichier : </label><br />
				<input type="text" name="nom" id="nom" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />
				
				<label for="description" style="font-weight:bold">» Description du fichier</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br />
				
				<label for="taille" style="font-weight:bold">» Taille du fichier</label><br />
				<input type="text" name="taille" id="taille" style="margin-left:25px !important; text-align:left; width:50px" /> mo<br /><br />
				
				<label for="url" style="font-weight:bold">» Adresse complète du fichier</label> <span class="requis">requis</span><br />
				<input type="text" name="url" id="url" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />

				
				<b>» Vérifier et ajouter le fichier</b><br />
				<input type="submit" class="submit" value="ajouter le fichier"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-files">Retour administration des fichiers</a> -</center><br />';

break;
case "poster2":

	$cat=addBdd($_POST['cat']);
	$nom=addBdd($_POST['nom']);	
	$desc=addslashes($_POST['description']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);
	$id_mbr=$_SESSION['sess_id'];

	$sql=mysql_query("INSERT INTO ".PREFIX."files_movies (`nom`, `id_membre`, `description` , `nb_dl` , `taille` , `url` , `date` , `cat` )
										  VALUES ('$nom', '$id_mbre', '$desc',0 , '$taille','$url',NOW(), '$cat')");
	
	header('location: ?admin-files');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."files_movies WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
		// Gestion select : CAT
			if ($d->cat=="movies") $catS1="selected";
			if ($d->cat=="files")  $catS2="selected";
			if ($d->cat=="others")  $catS3="selected";
			
	$contenu='<div id="retour"><a href="?admin-files"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
			  <br><br><div id="infoInscription">
				Utilisez ce formulaire pour éditer un fichier au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-files&action=editer2&id='.$id.'">
			  <fieldset style="margin-left:20px">
			  		
				<label for="cat" style="font-weight:bold">» Catégorie</label> <span class="requis">requis</span><br /> 
					<select name="cat" id="cat"  style="margin:2px 0 0 25px; width:120px">
						<option value="movies" '.@$catS1.'>Movies</option>
						<option value="files" '.@$catS2.'>Files</option>
						<option value="others" '.@$catS3.'>Others</option>
					</select><br /><br />

				<label for="nom" style="font-weight:bold">» Nom du fichier</label><br />
				<input type="text" name="nom" id="nom" value="'.recupBdd($d->nom).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="description" style="font-weight:bold">» Description du fichier</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->description).' </textarea><br /><br />
				
				<label for="taille" style="font-weight:bold">» Taille du fichier</label><br />
				<input type="text" name="taille" id="taille" value="'.recupBdd($d->taille).'" style="margin-left:25px !important; text-align:left; width:50px" /> mo<br /><br />
				
				<label for="url" style="font-weight:bold">» Adresse complète du fichier</label><br />
				<input type="text" name="url" id="url" value="'.recupBdd($d->url).'" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />

				
				<b>» Vérifier et éditer le fichier</b><br />
				<input type="submit" class="submit" value="éditer le fichier"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-files">Retour administration des fichiers</a> -</center><br />';

break;
case "editer2":

	$cat=$_POST['cat'];
	$nom=addBdd($_POST['nom']);
	$desc=addslashes($_POST['description']);
	$auteur=addslashes($_POST['auteur']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);
	$id=$_GET['id'];

	$sql=mysql_query("	UPDATE ".PREFIX."files_movies
						SET
							cat='$cat',
							nom='$nom',
							description='$desc',
							taille='$taille',
							url='$url'
						WHERE id=$id");
	
	header('location: ?admin-files');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>