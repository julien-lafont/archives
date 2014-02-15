<?php
securite_admin();

$design->zone('titrePage', 'Les médias');
$design->zone('titre', 'Gérer les médias du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br><center><div id="posterNews"><a href="?admin-medias&action=poster">Ajouter un média</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des Médias :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Cat</td>
			  <td class="liste_titre">Infos</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."demos");		  
	$nb=mysql_num_rows($sql);
	
	if ($nb==0) {
		$contenu.='<tr>
					<td colspan="4"><center>Aucun fichier</center></td>
				   </tr>';
	}
	else 
	{ 
		while($d = mysql_fetch_object($sql)) {
			
			// Gestion cat :
			if ($d->cat=="hltv") $cat="HLTV"; else $cat="In-Eyes";
			
			// Gestion versus :
			if (!empty($d->pays)) $versus="<img src='".CHEMIN_PAYS.$d->pays.".gif' alt='$d->pays' /> ";
			@$versus.="<b>$d->versus</b>";
			
			$contenu.= '<tr>
							<td class="liste_txt">
									'.$cat.'
							</td>
							<td class="liste_txt">
									'.recupBdd($d->player).' <span style="color:#0066FF">vs</span> '.$versus.'
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
	}	 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."demos WHERE id=$id");
	header('location: ?admin-medias');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

	$contenu='<div id="retour"><a href="?admin-medias"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
				<br><br><div id="infoInscription">
				Utilisez ce formulaire pour ajouter un média au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-medias&action=poster2">
			  <fieldset style="margin-left:20px">
			  		
				<label for="cat" style="font-weight:bold">» Catégorie</label> <span class="requis">requis</span><br /> 
					<select name="cat" id="cat"  style="margin:2px 0 0 25px; width:120px">
						<option value="ineyes">Demo In-Eyes</option>
						<option value="hltv">HLTV</option>
					</select><br /><br />
				
				<label>» Infos sur le média : </label><br />
					
					<table style="border:0; margin-left:25px">
						<tr>
							<td>Si In-Eyes, nom du player &nbsp;&nbsp;</td>
							<td><input type="text" name="player" id="player" style="text-align:left; width:120px " /></td>
						</tr>
						<tr>
							<td>Team/Player concurrent</td>
							<td> <select name="pays" id="pays" style="width:65px">
									<option value="" selected> &nbsp; &nbsp; /</option>
									'.liste_pays('nom').'
									</select>
									&nbsp;&nbsp;&nbsp;
								<input type="text" name="versus" id="versus" style="text-align:left; width:120px" /> <span class="requis">requis</span> 
							</td>
						</tr>
						<tr>
							<td>Jeu </td>
							<td><select name="jeu" id="jeu" style="width:80px">
								<option value="cs">CS</option>
								<option value="css">Cs:Source</option>
								<option value="dod">DoD:s</option>
								<option value="dota">DotA</option>
								<option value="war3">War3</option>
						  	   </select> <span class="requis">requis</span>
						    </td>
					</tr>
						<tr>
							<td>Map</td>
							<td><select name="map" id="map" style="width:120px">
								<option value="">  &nbsp; &nbsp; &nbsp; &nbsp; /</option>
								'.liste_maps().'
						  	   </select>
						    </td>
					</tr>
				</table><br />
				
				<label for="description" style="font-weight:bold">» Description du média</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br />
				
				<label for="taille" style="font-weight:bold">» Taille du fichier</label><br />
				<input type="text" name="taille" id="taille" style="margin-left:25px !important; text-align:left; width:50px" /> mo<br /><br />
				
				<label for="url" style="font-weight:bold">» Adresse complète du fichier</label> <span class="requis">requis</span><br />
				<input type="text" name="url" id="url" style="margin-left:25px !important; text-align:left; width:300px" /><br /><br />

				
				<b>» Vérifier et ajouter le média</b><br />
				<input type="submit" class="submit" value="ajouter le média"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-medias">Retour administration des médias</a> -</center><br />';

break;
case "poster2":

	$cat=addBdd($_POST['cat']);

	$player=addBdd($_POST['player']);
	$versus=addBdd($_POST['versus']);
	$pays=addBdd($_POST['pays']);
	
	$map=addBdd($_POST['map']);
	$jeu=addBdd($_POST['jeu']);
	
	$desc=addslashes($_POST['description']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);

	$sql=mysql_query("INSERT INTO ".PREFIX."demos (`description` , `nb_dl` , `taille` , `url` , `date` , `cat` , `jeu` , `player` , `versus` , `pays`,`map` )
										  VALUES ('$desc',0 , '$taille','$url',NOW(), '$cat', '$jeu', '$player', '$versus', '$pays', '$map')");
	
	header('location: ?admin-medias');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."demos WHERE id=$id");
	$d=mysql_fetch_object($sql);
		
		// Gestion select : CAT
			if ($d->cat=="ineyes") $catS1="selected";
			else 				   $catS2="selected";
			
		// Gestion select : JEUX
			if ($d->jeu=="cs") $jeuS1="selected";
			if ($d->jeu=="css") $jeuS2="selected";
			if ($d->jeu=="dod") $jeuS3="selected";
			if ($d->jeu=="dota") $jeuS4="selected";
			if ($d->jeu=="war3") $jeuS5="selected";
	
	$contenu='<div id="retour"><a href="?admin-medias"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
			  <br><br><div id="infoInscription">
				Utilisez ce formulaire pour éditer un média au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-medias&action=editer2&id='.$id.'">
			  <fieldset style="margin-left:20px">
			  		
				<label for="cat" style="font-weight:bold">» Catégorie</label> <span class="requis">requis</span><br /> 
					<select name="cat" id="cat"  style="margin:2px 0 0 25px; width:120px">
						<option value="ineyes" '.@$catS1.'>Demo In-Eyes</option>
						<option value="hltv" '.@$catS2.'>HLTV</option>
					</select><br /><br />

				<label>» Infos sur le média : </label><br />
					
					<table style="border:0; margin-left:25px">
						<tr>
							<td>Si In-Eyes, nom du player &nbsp;&nbsp;</td>
							<td><input type="text" name="player" id="player" value="'.recupBdd($d->player).'" style="text-align:left; width:120px " /></td>
						</tr>
						<tr>
							<td>Team/Player concurrent</td>
							<td> <select name="pays" id="pays" style="width:65px">
									<option value=""> &nbsp; &nbsp; /</option>
									'.liste_pays('nom', recupBdd($d->pays)).'
									</select>
									&nbsp;&nbsp;&nbsp;
								<input type="text" name="versus" id="versus" value="'.recupBdd($d->versus).'" style="text-align:left; width:120px" /> <span class="requis">requis</span> 
							</td>
						</tr>
						<tr>
							<td>Jeu </td>
							<td><select name="jeu" id="jeu" style="width:80px">
								<option value="cs" '.@$jeuS1.'>CS</option>
								<option value="css" '.@$jeuS2.'>Cs:Source</option>
								<option value="dod" '.@$jeuS3.'>DoD</option>
								<option value="dota" '.@$jeuS4.'>DotA</option>
								<option value="war3" '.@$jeuS5.'>War3</option>
						  	   </select> <span class="requis">requis</span>
						    </td>
					</tr>
						<tr>
							<td>Map</td>
							<td><select name="map" id="map" style="width:120px">
								<option value="">  &nbsp; &nbsp; &nbsp; &nbsp; /</option>
								'.liste_maps(recupBdd($d->map)).'
						  	   </select>
						    </td>
					</tr>
				</table><br />

				<label for="description" style="font-weight:bold">» Description du média</label> <br />
				<textarea name="description" id="description" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->description).' </textarea><br /><br />
				
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

	$cat=addBdd($_POST['cat']);

	$player=addBdd($_POST['player']);
	$versus=addBdd($_POST['versus']);
	$pays=addBdd($_POST['pays']);
	
	$map=addBdd($_POST['map']);
	$jeu=addBdd($_POST['jeu']);
	
	$desc=addslashes($_POST['description']);
	$taille=addBdd($_POST['taille']);
	$url=addBdd($_POST['url']);

	$id=$_GET['id'];
	
	$sql=mysql_query("	UPDATE ".PREFIX."demos
						SET
							description='$desc',
							taille='$taille',
							url='$url',
							jeu='$jeu',
							player='$player',
							versus='$versus',
							pays='$pays',
							map='$map'
						WHERE id=$id")or die (mysql_error());
	
	header('location: ?admin-medias');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>