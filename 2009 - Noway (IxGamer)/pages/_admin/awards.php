<?php

securite_admin();

$design->zone('titrePage', 'Nos récompenses ');
$design->zone('titre', 'Gérer les récompenses de la team');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br /><div class="titreMessagerie">Gérer les palmarès</div>
			
			<br><center><div id="posterNews"><a href="?admin-awards&action=poster">Ajouter un palmarès</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=3 class="liste_header">	Liste des Palmarès :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Infos sur le palmarès</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."awards ORDER BY id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
						<td class="liste_txt" style="font-size:10px">
								<u>'.$d->place.'</u> lors du '.recupBdd($d->nom).'  <img src="'.CHEMIN_PAYS.$d->pays.'.gif" />
						</td>
						
						<td class="liste_txt" style="font-size:9px">
							'.recupBdd($d->jour).' / '.recupBdd($d->mois).' / '.recupBdd($d->annee).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-awards&action=suppr&id='.$d->id.'" title="Supprimer le match"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-awards&action=editer&id='.$d->id.'" title="Editer le match"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."awards WHERE id=$id");
	header('location: ?admin-awards');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

	$contenu='<div id="retour"><a href="?admin-awards"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
			<br><div class="titreMessagerie">Ajouter un Palmarès</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour ajouter un  palmarès au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-awards&action=poster2">
			  <fieldset style="margin-left:20px">
			  				
				<label for="nom" style="font-weight:bold">» Nom de l\'évènement</label>  &nbsp;<span class="requis">requis</span><br />
					<input type="text" name="nom" id="nom" style="margin-left:25px" /><br /><br />

				<label for="site" style="font-weight:bold">» Site internet de l\'évènement</label><br />
					<input type="text" name="site" id="site" style="margin-left:25px; width:350px" /><br /><br />

				<label for="pays" style="font-weight:bold">» Pays organisateur</label> &nbsp;<span class="requis">requis</span><br />
				<select name="pays" id="pays" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom').'
				</select><br /><br />
				
				<label for="annee" style="font-weight:bold">» Date du palmarès </label> &nbsp;<span class="requis">requis</span> <br />
					<input type="text" name="jour" id="jour" style="width:20px; margin-left:25px" maxlength="2"/> / <input type="text" name="mois" id="mois" style="width:20px" maxlength="2"/> / <input type="text" name="annee" id="annee" style="width:30px" maxlength="4"/><br /><br />

				<label for="jeu" style="font-weight:bold">» Jeu</label>  &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:150px; margin-left:25px">
					<option value="cs">CS</option>
					<option value="css">Cs:Source</option>
					<option value="dod">DoD:s</option>
					<option value="dota">DotA</option>
					<option value="war3">War3</option>
				</select><br /><br />
				
				<label for="place" style="font-weight:bold">» Classement </label> &nbsp;<span class="requis">requis</span> <br />
				<select name="place" id="place" style="margin-left:25px">
					<option value="1er">1er</option>
					<option value="2nd">2nd</option>
					<option value="3ème">3ème</option>
					<option value="4ème">4ème</option>
					<option value="5ème">5ème</option>
					<option value="6ème">6ème</option>
					<option value="7ème">7ème</option>
					<option value="8ème">8ème</option>
					<option value="9ème">9ème</option>
					<option value="10ème">10ème</option>
					<option value="11ème">11ème</option>
					<option value="12ème">12ème</option>
					<option value="13ème">13ème</option>
					<option value="14ème">14ème</option>
					<option value="15ème">15ème</option>
					<option value="> 15èmme">> 15ème</option>
				</select><br /><br />


				<label style="font-weight:bold">» Line UP</label> <br />
					'.liste_gamers(1).'
					'.liste_gamers(2).'
					'.liste_gamers(3).'
					'.liste_gamers(4).'
					'.liste_gamers(5).'
					'.liste_gamers(6).'<br />

				
				<label for="detail" style="font-weight:bold">» Plus d\'infos sur ce palmarès</label> &nbsp;<span class="requis">HTML OK</span><br />
				<textarea name="detail" id="detail" style="margin-left:25px !important; text-align:left; width:300px" /></textarea><br /><br />


				<b>» Ajouter le palmarès</b><br />
				<input type="submit" class="submit" value="ajouter le palmarès"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-awards">Retour administration des Palmarès</a> -</center><br />';

break;
case "poster2":

	$nom=addBdd($_POST['nom']);
	$annee=addBdd($_POST['annee']);
	$mois=addBdd($_POST['mois']);
	$jour=addBdd($_POST['jour']);
	$jeu=addBdd($_POST['jeu']);
	$pays=addBdd($_POST['pays']);
	$place=addBdd($_POST['place']);	
	$site=addBdd($_POST['site']);
	$detail=addslashes($_POST['detail']);
	
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
		
	$sql=mysql_query("INSERT INTO ".PREFIX."awards (`nom` , `site` , `jeu`, `pays` , `annee`,`mois`,`jour`, `detail` , `j1` , `j2` , `j3` , `j4` , `j5` , `j6`, `place` )
										  VALUES ('$nom', '$site', '$jeu', '$pays', '$annee', '$mois', '$jour', '$detail','$j1','$j2','$j3','$j4','$j5','$j6','$place' )") or die(mysql_error());

	
 header('location: ?admin-awards'); 

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."awards WHERE id=$id");
	$d=mysql_fetch_object($sql);
		
		
			// Gestion select : JEUX
			if ($d->jeu=="cs") $jeuS1="selected";
			if ($d->jeu=="css") $jeuS2="selected";
			if ($d->jeu=="dod") $jeuS3="selected";
			if ($d->jeu=="dota") $jeuS4="selected";
			if ($d->jeu=="war3") $jeuS5="selected";
			
	$contenu='<div id="retour"><a href="?admin-awards"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
			<br><div class="titreMessagerie">Editer un palmarès</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour editer un palmarès au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-awards&action=editer2&id='.$id.'">
			  <fieldset style="margin-left:20px">
			  		
				<label for="nom" style="font-weight:bold">» Nom de l\'évènement</label>  &nbsp;<span class="requis">requis</span><br />
					<input type="text" name="nom" id="nom" value="'.recupBdd($d->nom).'" style="margin-left:25px" /><br /><br />

				<label for="site" style="font-weight:bold">» Site internet de l\'évènement</label><br />
					<input type="text" name="site" id="site" value="'.recupBdd($d->site).'"style="margin-left:25px; width:350px" /><br /><br />

				<label for="natadv" style="font-weight:bold">» Pays organisateur</label> &nbsp;<span class="requis">requis</span><br />
				<select name="pays" id="pays" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom', $d->pays).'
				</select><br /><br />
				
				<label for="annee" style="font-weight:bold">» Date du palmarès </label> &nbsp;<span class="requis">requis</span> <br />
					<input type="text" name="jour" id="jour" value="'.recupBdd($d->jour).'" style="width:20px; margin-left:25px" maxlength="2"/> / <input type="text" name="mois" id="mois" value="'.recupBdd($d->mois).'" style="width:20px" maxlength="2"/> / <input type="text" name="annee" id="annee" value="'.recupBdd($d->annee).'" style="width:30px" maxlength="4"/><br /><br />

				<label for="jeu" style="font-weight:bold">» Jeu</label>  &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:150px; margin-left:25px">
					<option value="cs" '.@$jeuS1.'>CS</option>
					<option value="css" '.@$jeuS2.'>Cs:Source</option>
					<option value="dod" '.@$jeuS3.'>DoD:s</option>
					<option value="dota" '.@$jeuS4.'>DotA</option>
					<option value="war3" '.@$jeuS5.'>War3</option>
				</select><br /><br />
				
				<label for="place" style="font-weight:bold">» Classement </label> &nbsp;<span class="requis">requis</span> <br />
				<input type="text" name="place" id="place" value="'.recupBdd($d->place).'"style="margin-left:25px" /><br /><br />
				
				<label style="font-weight:bold">» Line Up</label> <br />
					'.liste_gamers(1, $d->j1).'<br />
					'.liste_gamers(2, $d->j2).'<br />
					'.liste_gamers(3, $d->j3).'<br />
					'.liste_gamers(4, $d->j4).'<br />
					'.liste_gamers(5, $d->j5).'<br />
					'.liste_gamers(6, $d->j6).'<br /><br />


				<label for="detail" style="font-weight:bold">» Résumé</label><br />
				<textarea name="detail" id="detail" style="margin-left:25px !important; text-align:left; width:300px" />'.recupBdd($d->detail).'</textarea><br /><br />

				<b>» Éditer le palmarès</b><br />
				<input type="submit" class="submit" value="éditer le palmarès"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-awards">Retour administration des matchs</a> -</center><br />';

break;
case "editer2":

	$id=$_GET['id'];
	
	$nom=addBdd($_POST['nom']);
	$annee=addBdd($_POST['annee']);
	$mois=addBdd($_POST['mois']);
	$jour=addBdd($_POST['jour']);
	$jeu=addBdd($_POST['jeu']);
	$pays=addBdd($_POST['pays']);
	$place=addBdd($_POST['place']);	
	$site=addBdd($_POST['site']);
	$detail=addslashes($_POST['detail']);
	
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

	$sql=mysql_query("	UPDATE ".PREFIX."awards
						SET
							nom='$nom',
							site='$site',
							jeu='$jeu',
							pays='$pays',
							annee='$annee',
							mois='$mois',
							jour='$jour',
							detail='$detail',
							j1='$j1',
							j2='$j2',
							j3='$j3',
							j4='$j4',
							j5='$j5',
							j6='$j6',
							place='$place'
						WHERE id=$id") or die(mysql_error());
	
	header('location: ?admin-awards');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>