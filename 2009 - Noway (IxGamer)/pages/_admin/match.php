<?php

securite_admin();

$design->zone('titrePage', 'Les matchs');
$design->zone('titre', 'Gérer les matchs du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br><center><div id="posterNews"><a href="?admin-match&action=poster">Ajouter un match</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=3 class="liste_header">	Liste des Match :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Adversaire</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."war ORDER BY id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
						<td class="liste_txt">
								'.recupBdd($d->adversaire).'
						</td>
						
						<td class="liste_txt" style="font-size:9px">
							'.recupBdd($d->date).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-match&action=suppr&id='.$d->id.'" title="Supprimer le match"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-match&action=editer&id='.$d->id.'" title="Editer le match"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."war WHERE id=$id");
	header('location: ?admin-match');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

		
		
	$contenu='<div id="retour"><a href="?admin-match"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
			<br><div class="titreMessagerie">Ajouter un match</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour ajouter un match au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-match&action=poster2">
			  <fieldset style="margin-left:20px">
			  	
				<label for="jeu" style="font-weight:bold">» Jeu</label> &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:80px; margin-left:25px">
					<option value="cs">CS</option>
					<option value="css">Cs:Source</option>
					<option value="dod">DoD:s</option>
					<option value="dota">DotA</option>
					<option value="war3">War3</option>
					<option value="tf2">TeamFortress²</option>
				 </select><br /><br />
				
				<label for="natadv" style="font-weight:bold">» Adversaire</label> &nbsp;<span class="requis">requis</span><br />
				<select name="natadv" id="natadv" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom').'
				</select>
				<input type="text" name="adversaire" id="adversaire" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />
				
				<label for="adv_site" style="font-weight:bold">» Site internet de l\'adversaire</label><br />
					<input type="text" name="adv_site" id="adv_site" style="margin-left:25px !important; text-align:left; width:350px" /><br /><br />

				<label for="date" style="font-weight:bold">» Date du match </label> &nbsp;<span class="requis">requis</span> <br />
					<input type="text" name="date" id="date" style="margin-left:25px !important; text-align:left; width:80px" maxlength="10"/><br /><br />
				
				<label for="map" style="font-weight:bold">» Map jouée 1</label> <br />
				<select name="map" id="map" style="margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					<option value="autre" onclick="$(\'#mapb\').show();">Autres</option>
					'.liste_maps().'
				</select> <input type="text" id="mapb" name="mapb" style="display:none" /><br /><br />

				<label for="map2" style="font-weight:bold">» Map jouée 2</label> <br />
				<select name="map2" id="map2" style="margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					<option value="autre" onclick="$(\'#map2b\').show();">Autres</option>
					'.liste_maps().'
				</select> <input type="text" id="map2b" name="map2b" style="display:none" /><br /><br />

				<label style="font-weight:bold">» Line UP</label> <br />
					'.liste_gamers(1).'
					'.liste_gamers(2).'
					'.liste_gamers(3).'
					'.liste_gamers(4).'
					'.liste_gamers(5).'
					'.liste_gamers(6).'<br />

			<label for="type" style="font-weight:bold;">» Type de match</label> <br />
			<select name="type" id="type" style=" margin-left:25px">
				<option value="mr12">MR12</option>
				<option value="mr15">MR15</option>
				<option value="1vs1">1vs1</option>
				<option value="2vs2">2vs2</option>
				<option value="3vs3">3vs3</option>
				<option value="4vs4">4vs4</option>
				<option value="5vs5">5vs5</option>
				<option value="6vs6">6vs6</option>
				<option value="perso">Perso</option>
			</select><br /><br />

			<label for="scoret" style="font-weight:bold">» Score -wL- vs Adversaire</label> &nbsp;<span class="requis">requis</span><br />
				<input type="text" name="scoret" id="scoret" value="'.NOM.'" onfocus="if (this.value==\''.NOM.'\') this.value=\'\'" style="margin-left:25px !important; text-align:left; width:50px" /> &nbsp; &nbsp; vs <input type="text" name="scoreadv" id="scoreadv" style="margin-left:25px !important; text-align:left; width:50px" value="Advers" onfocus="if (this.value==\'Advers\') this.value=\'\'"/><br /><br />
				
			<label for="style" style="font-weight:bold">» Style de match</label> <br />
				<select name="style" ud="style" style="margin-left:25px">
					<option value="ESL Official">ESL Official</option>
					<option value="ES France">ES France</option>
					<option value="WCG">WCG</option>
					<option value="ClanBase">ClanBase</option>
					<option value="Amical">Amical</option>
					<option value="Training">Train</option>
					<option value="autre" onclick="$(\'#styleb\').show()">Autre</option>
				</select> <input type="text" id="styleb" name="styleb" style="display:none" /><br /><br />
				
				<label for="resume" style="font-weight:bold">» Résumé du match</label><br />
				<textarea name="resume" id="resume" style="margin-left:25px !important; text-align:left; width:300px" /></textarea><br /><br />

				<label for="url" style="font-weight:bold">» Joindre un fichier (url)</label><br />
				<input type="text" name="url" id="url" style="margin-left:25px !important; text-align:left; width:350px" /><br /><br />

				<b>» Ajouter le match</b><br />
				<input type="submit" class="submit" value="ajouter le match"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-match">Retour administration des matchs</a> -</center><br />';

break;
case "poster2":

	$adv=addBdd($_POST['adversaire']);
	$advSite=addBdd($_POST['adv_site']);
	$natadv=addBdd($_POST['natadv']);
	$date=addslashes($_POST['date']);	
	$scoret=addBdd($_POST['scoret']);
	$scoreadv=addBdd($_POST['scoreadv']);
	$resume=addslashes($_POST['resume']);
	$type=addBdd($_POST['type']);
	$url=addBdd($_POST['url']);
	$jeu=addBdd($_POST['jeu']);
	
	$idPseudo=$_SESSION['sess_id'];
	
		if ($_POST['j1']=="autre") $j1=addBdd($_POST['j1b']);
		else					   $j1=addBdd($_POST['j1']);
		if ($_POST['j2']=="autre") $j2=addBdd($_POST['j2b']);
		else					   $j2=addBdd($_POST['j2']);
		if ($_POST['j3']=="autre") $j3=addBdd($_POST['j3b']);
		else					   $j3=addBdd($_POST['j3']);
		if ($_POST['j4']=="autre") $j4=addBdd($_POST['j4b']);
		else					   $j4=addBdd($_POST['j4']);
		if ($_POST['j5']=="autre") $j5=addBdd($_POST['j5b']);
		else					   $j5=addBdd($_POST['j5']);
		if ($_POST['j6']=="autre") $j6=addBdd($_POST['j6b']);
		else					   $j6=addBdd($_POST['j6']);
		
		if ($_POST['map']=="autre") $map=addBdd($_POST['mapb']);
		else						$map=addBdd($_POST['map']);
		if ($_POST['map2']=="autre") $map2=addBdd($_POST['map2b']);
		else						 $map2=addBdd($_POST['map2']);

		if ($_POST['style']=="autre") $style=addBdd($_POST['styleb']);
		else						  $style=addBdd($_POST['style']);
    
	$sql=mysql_query("INSERT INTO ".PREFIX."war (`jeu`, `adversaire` , `adversaire_site`, `nata` , `date` , `map` , `map2` , `scoret` , `scoreadv` , `resume` , `id_pseudo` , `j1` , `j2` , `j3` , `j4` , `j5` , `j6` ,`style` , `type`, `url`)
										  VALUES ('$jeu', '$adv', '$adv_site', '$natadv','$date','$map','$map2','$scoret','$scoreadv','$resume','$idPseudo','$j1','$j2','$j3','$j4','$j5','$j6', '$style','$type', '$url')") or die(mysql_error());

	
 header('location: ?admin-match'); 

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."war WHERE id=$id");
	$d=mysql_fetch_object($sql);
		
		// Gestion des SELECT : jeu 
			if ($d->jeu=="cs")		$s1="selected";
			if ($d->jeu=="css")		$s2="selected";
			if ($d->jeu=="dod")		$s3="selected";
			if ($d->jeu=="dota") 	$s4="selected";
			if ($d->jeu=="war3")	$s5="selected";
			if ($d->jeu=="tf2")		$s6="selected";
			
	$contenu='<div id="retour"><a href="?admin-match"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
			<br><div class="titreMessagerie">Editer un match</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour editer un match au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-match&action=editer2&id='.$id.'">
			  <fieldset style="margin-left:20px">
			  		
				<label for="jeu" style="font-weight:bold">» Jeu</label> &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:80px; margin-left:25px">
					<option value="cs" '.@$s1.'>CS</option>
					<option value="css" '.@$s2.'>Cs:Source</option>
					<option value="dod" '.@$s3.'>DoD</option>
					<option value="dota" '.@$s4.'>DotA</option>
					<option value="war3" '.@$s5.'>War3</option>
					<option value="tf2" '.@$s6.'>TeamFortress²</option>
				 </select><br /><br />

				<label for="natadv" style="font-weight:bold">» Adversaire</label> &nbsp;<span class="requis">requis</span><br />
				<select name="natadv" id="natadv" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom', $d->nata).'
				</select>
				<input type="text" name="adversaire" id="adversaire" value="'.recupBdd($d->adversaire).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="adv_site" style="font-weight:bold">» Site internet de l\'adversaire</label><br />
					<input type="text" name="adv_site" id="adv_site" value="'.recupBdd($d->adversaire_site).'" style="margin-left:25px !important; text-align:left; width:350px" /><br /><br />

				<label for="date" style="font-weight:bold">» Date</label>  (YYYY-MM-DD) <br />
				<input type="text" name="date" id="date" style="margin-left:25px; !important; text-align:left;" value="'.recupBdd($d->date).'" /><br /><br />
				
				<label for="map" style="font-weight:bold">» Map 1</label> <br />
				<input type="text" name="map" id="map" value="'.recupBdd($d->map).'" style="margin-left:25px !important; text-align:left;" /><br /><br />
				
				<label for="map2" style="font-weight:bold">» Map 2</label> <br />
				<input type="text" name="map2" id="map2" value="'.recupBdd($d->map2).'" style="margin-left:25px !important; text-align:left;" /><br /><br />
				
				<label style="font-weight:bold">» Line Up</label> <br />
					'.liste_gamers(1, $d->j1).'<br />
					'.liste_gamers(2, $d->j2).'<br />
					'.liste_gamers(3, $d->j3).'<br />
					'.liste_gamers(4, $d->j4).'<br />
					'.liste_gamers(5, $d->j5).'<br />
					'.liste_gamers(6, $d->j6).'<br /><br />

			<label for="type" style="font-weight:bold">» Type de match</label> <br />
				<input type="text" name="type" id="type" value="'.recupBdd($d->type).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="scoret" style="font-weight:bold">» Score -wL- vs Adversaire</label><br />
				<input type="text" name="scoret" id="scoret" value="'.recupBdd($d->scoret).'" onfocus="if (this.value==\''.NOM.'\') this.value=\'\'" style="margin-left:25px !important; text-align:left; width:50px" /> &nbsp; &nbsp; vs <input type="text" name="scoreadv" id="scoreadv" value="'.recupBdd($d->scoreadv).'" onfocus="if (this.value==\'Advers\') this.value=\'\'" style="margin-left:25px !important; text-align:left; width:50px" /><br /><br />
				
				<label for="style" style="font-weight:bold">» Style de match</label> <br />
				<input type="text" name="style" id="style" value="'.recupBdd($d->style).'" style="margin-left:25px !important; text-align:left; width:175px" /><br /><br />

				<label for="resume" style="font-weight:bold">» Résumé</label><br />
				<textarea name="resume" id="resume" style="margin-left:25px !important; text-align:left; width:300px" />'.recupBdd($d->resume).'</textarea><br /><br />

				<label for="url" style="font-weight:bold">» Joindre un fichier (url)</label><br />
				<input type="text" name="url" id="url" style="margin-left:25px !important; text-align:left; width:350px" value="'.recupBdd($d->url).'" /><br /><br />
				
				<b>» Éditer le match</b><br />
				<input type="submit" class="submit" value="éditer le match"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-match">Retour administration des matchs</a> -</center><br />';

break;
case "editer2":

	$id=$_GET['id'];
	
	$adv=addBdd($_POST['adversaire']);
	$natadv=addBdd($_POST['natadv']);
	$date=addBdd($_POST['date']);
	$map=addBdd($_POST['map']);
	$map2=addBdd($_POST['map2']);
	$scoret=addBdd($_POST['scoret']);
	$scoreadv=addBdd($_POST['scoreadv']);
	$resume=addslashes($_POST['resume']);
	$style=addBdd($_POST['style']);
	$type=addBdd($_POST['type']);
	$url=addBdd($_POST['url']);
	$jeu=addBdd($_POST['jeu']);
	
	$idPseudo=$_SESSION['sess_id'];
	
		if ($_POST['j1']=="autre") $j1=addBdd($_POST['j1b']);
		else					   $j1=addBdd($_POST['j1']);
		if ($_POST['j2']=="autre") $j2=addBdd($_POST['j2b']);
		else					   $j2=addBdd($_POST['j2']);
		if ($_POST['j3']=="autre") $j3=addBdd($_POST['j3b']);
		else					   $j3=addBdd($_POST['j3']);
		if ($_POST['j4']=="autre") $j4=addBdd($_POST['j4b']);
		else					   $j4=addBdd($_POST['j4']);
		if ($_POST['j5']=="autre") $j5=addBdd($_POST['j5b']);
		else					   $j5=addBdd($_POST['j5']);
		if ($_POST['j6']=="autre") $j6=addBdd($_POST['j6b']);
		else					   $j6=addBdd($_POST['j6']);

	$sql=mysql_query("	UPDATE ".PREFIX."war
						SET
							jeu='$jeu',
							adversaire='$adv',
							nata='$natadv',
							date='$date',
							map='$map',
							map2='$map2',
							scoret='$scoret',
							scoreadv='$scoreadv',
							resume='$resume',
							id_pseudo='$idPseudo',
							j1='$j1',
							j2='$j2',
							j3='$j3',
							j4='$j4',
							j5='$j5',
							j6='$j6',
							style='$style',
							type='$type',
							url='$url'
						WHERE id=$id") or die(mysql_error());
	
	header('location: ?admin-match');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>