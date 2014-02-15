<?php

securite_admin();

$design->zone('titrePage', 'Nos évènements');
$design->zone('titre', 'Gérer les évènements de la team');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br /><div class="titreMessagerie">Gérer les évènements</div>
			
			<br><center><div id="posterNews"><a href="?admin-coverage&action=poster">Ajouter un evènement</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=3 class="liste_header">	Liste des Evènements :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Infos sur l\'evènement</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."coverage ORDER BY id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
						<td class="liste_txt" style="font-size:10px">
							<img src="'.CHEMIN_JEU.$d->jeu.'.png" style="vertical-align:middle" />
							'.recupBdd($d->nom).'  <img src="'.CHEMIN_PAYS.$d->pays.'.gif" />
						</td>
						
						<td class="liste_txt" style="font-size:9px">
							'.inverser_date($d->date,4).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-coverage&action=suppr&id='.$d->id.'" title="Supprimer le match"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-coverage&action=editer&id='.$d->id.'" title="Editer le match"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."coverage WHERE id=$id");
	header('location: ?admin-coverage');
	
break;
#########################################################################################################################
#########################################################################################################################
case "poster":

		//:: Configuration du HTML AREA
	$header.='<script language=JavaScript src="javascript/Editor/scripts/language/french/editor_lang.js"></script>
			  <script language=JavaScript src="javascript/Editor/scripts/innovaeditor.js"></script>';

	$contenu='<div id="retour"><a href="?admin-coverage"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
			<br><div class="titreMessagerie">Ajouter un Evènements</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour ajouter un  evènement au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-coverage&action=poster2" onsubmit="$(\'#contenu\').val(oEdit1.getHTMLBody());">
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

				<label for="ville" style="font-weight:bold">» Localisation précise ( ville ) de l\'évènement</label><br />
					<input type="text" name="ville" id="ville" style="margin-left:25px;" /> 
						&nbsp;&nbsp; ou &nbsp;&nbsp; 
					<input name="online" id="online" type="checkbox" value="online" style="width:25px"/> <label for="online">Online</label><br /><br />
				
				<label for="annee" style="font-weight:bold">» Date de l\'évènement </label> &nbsp;<span class="requis">requis</span> <br />
					<!--<input type="text" name="jour" id="jour" style="width:20px; margin-left:25px" maxlength="2"/> / <input type="text" name="mois" id="mois" style="width:20px" maxlength="2"/> / <input type="text" name="annee" id="annee" style="width:30px" maxlength="4"/> -->
					<input type="text" name="date" id="date" style="margin-left:25px; width:75px" />
					&nbsp;&nbsp;  à &nbsp;&nbsp;
					 <input type="text" name="heure" id="heure" style="width:20px" maxlength="2"/> h <input type="text" name="mn" id="mn" style="width:20px" maxlength="2"/> mn<br /><br />

				<label for="jeu" style="font-weight:bold">» Jeu</label>  &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:150px; margin-left:25px">
					<option value="cs">CS</option>
					<option value="css">Cs:Source</option>
					<option value="dod">DoD:s</option>
					<option value="dota">DotA</option>
					<option value="war3">War3</option>
				</select><br /><br />

				
				<label for="detail" style="font-weight:bold">» Plus d\'infos sur cet évènement</label> &nbsp;<span class="requis">HTML OK</span><br />
						<select onchange="oUtil.obj.insertHTML(this.value)" style="width:150px; float:right; margin-right:40px">
							<option value="" selected>Drapeau</option>
							'.liste_pays().'
						</select>

					<pre id="idtextarea" name="idtextarea" style="display:none"></pre>
					<input type="hidden" name="contenu" id="contenu" />

						<script>
							var oEdit1 = new InnovaEditor("oEdit1");
							oEdit1.btnStyles=true;
					
							oEdit1.css="theme/styles_editor.css";
							oEdit1.width=530
							oEdit1.height=400
							oEdit1.features=["XHTMLSource","Preview","Search","SpellCheck",
								"Cut","Copy","Paste","PasteWord","PasteText","|",
								"Undo","Redo","|",
								"Clean","ClearAll","|",
								"Image","Flash","Media","Bookmark","Hyperlink","|",
								
								"BRK",
								"Numbering","Bullets","|","Indent","Outdent","|",
								"Table","Guidelines","Absolute","|",
								"Characters","Line",
								"Form","|","Superscript","Subscript","|",
								"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
								
								"BRK",
								"CssText","StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting","ParagraphFormatting","Styles","|",
								"Paragraph","FontName","FontSize","|",
								"Bold","Italic","Underline","Strikethrough","|",
								"ForeColor","BackColor","|"];
								
							oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
							oEdit1.cmdAssetManager="modalDialogShow(\''.URL_REL.'javascript/Editor/assetmanager/assetmanager.php?lang=french\',640,465)";
							oEdit1.mode="XHTMLBody";
							
							oEdit1.RENDER($("#idtextarea").html());
						</script><br />

				<b>» Ajouter l\'évènement</b><br />
				<input type="submit" class="submit" value="ajouter le evènement"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-coverage">Retour administration des Evènements</a> -</center><br />';

break;
case "poster2":

	$nom=addBdd($_POST['nom']);
	$jeu=addBdd($_POST['jeu']);
	$site=addBdd($_POST['site']);
	$pays=addBdd($_POST['pays']);
	($_POST['online']=='online') ? $ville="online" : $ville=addBdd($_POST['ville']);
	
	list($jour, $mois, $annee) = explode("-", $_POST['date']);

	$heure=addBdd($_POST['heure']);
	$mn=addBdd($_POST['mn']);
		$date=$annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$mn.':00';
		
	$contenu=addslashes($_POST['contenu']);
	
		
	$sql=mysql_query("INSERT INTO `".PREFIX."coverage` ( `nom` , `date` , `lieu` , `pays` , `jeu` , `infos` , `site` ) 
										  		VALUES ('$nom', '$date', '$ville', '$pays', '$jeu', '$contenu', '$site')") or die(mysql_error());
	
	
 header('location: ?admin-coverage'); 

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."coverage WHERE id=$id");
	$d=mysql_fetch_object($sql);
		
		
			// Gestion select : JEUX
			if ($d->jeu=="cs") $jeuS1="selected";
			if ($d->jeu=="css") $jeuS2="selected";
			if ($d->jeu=="dod") $jeuS3="selected";
			if ($d->jeu=="dota") $jeuS4="selected";
			if ($d->jeu=="war3") $jeuS5="selected";
			
			// Gestion checkbox : ONLINE
			if ($d->lieu=="online") $online="checked";
			else					$ville=recupBdd($d->lieu);
			
			// Formatage de la date :
		list($date, $heure) = explode(" ", $d->date);
		list($annee, $mois, $jour) = explode("-", $date);
		list($h, $mn, $sec) = explode(":", $heure);

		//:: Configuration du HTML AREA
	$header.='<script language=JavaScript src="javascript/Editor/scripts/language/french/editor_lang.js"></script>
			  <script language=JavaScript src="javascript/Editor/scripts/innovaeditor.js"></script>';
		
	$contenu='<div id="retour"><a href="?admin-coverage"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
			<br><div class="titreMessagerie">Editer un evènement</div>
			  <div id="infoInscription">
				Utilisez ce formulaire pour editer un evènement au site</b>
			  </div><br />
			  
			  <form id="form" method="post" action="?admin-coverage&action=editer2&id='.$id.'" onsubmit="$(\'#contenu\').val(oEdit1.getHTMLBody());">
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

				<label for="ville" style="font-weight:bold">» Localisation précise ( ville ) de l\'évènement</label><br />
					<input type="text" name="ville" id="ville" style="margin-left:25px;" value="'.@$ville.'" /> 
						&nbsp;&nbsp; ou &nbsp;&nbsp; 
					<input name="online" id="online" type="checkbox" value="online" style="width:25px" '.@$online.' /> <label for="online">Online</label><br /><br />
			
				<label for="annee" style="font-weight:bold">» Date de l\'evènement </label> &nbsp;<span class="requis">requis</span> <br />
					<input type="text" name="jour" id="jour" value="'.$jour.'" style="width:20px; margin-left:25px" maxlength="2"/> / <input type="text" name="mois" id="mois" value="'.$mois.'" style="width:20px" maxlength="2"/> / <input type="text" name="annee" id="annee" value="'.$annee.'" style="width:30px" maxlength="4"/><br /><br />
					  &nbsp;&nbsp;  à &nbsp;&nbsp;
					<input type="text" name="heure" id="heure" style="width:20px" maxlength="2" value="'.$h.'" /> h <input type="text" name="mn" id="mn" value="'.$mn.'" style="width:20px" maxlength="2"/> mn<br /><br />

				<label for="jeu" style="font-weight:bold">» Jeu</label>  &nbsp;<span class="requis">requis</span><br />
				<select name="jeu" id="jeu" style="width:150px; margin-left:25px">
					<option value="cs" '.@$jeuS1.'>CS</option>
					<option value="css" '.@$jeuS2.'>Cs:Source</option>
					<option value="dod" '.@$jeuS3.'>DoD:s</option>
					<option value="dota" '.@$jeuS4.'>DotA</option>
					<option value="war3" '.@$jeuS5.'>War3</option>
				</select><br /><br />
				

				<label for="detail" style="font-weight:bold">» Infos en plus</label><br />
						<select onchange="oUtil.obj.insertHTML(this.value)" style="width:150px; float:right; margin-right:40px">
							<option value="" selected>Drapeau</option>
							'.liste_pays().'
						</select>

					<pre id="idtextarea" name="idtextarea" style="display:none">'.recupBdd($d->infos).'</pre>
					<input type="hidden" name="contenu" id="contenu" />

						<script>
							var oEdit1 = new InnovaEditor("oEdit1");
							oEdit1.btnStyles=true;
					
							oEdit1.css="theme/styles_editor.css";
							oEdit1.width=530
							oEdit1.height=400
							oEdit1.features=["XHTMLSource","Preview","Search","SpellCheck",
								"Cut","Copy","Paste","PasteWord","PasteText","|",
								"Undo","Redo","|",
								"Clean","ClearAll","|",
								"Image","Flash","Media","Bookmark","Hyperlink","|",
								
								"BRK",
								"Numbering","Bullets","|","Indent","Outdent","|",
								"Table","Guidelines","Absolute","|",
								"Characters","Line",
								"Form","|","Superscript","Subscript","|",
								"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
								
								"BRK",
								"CssText","StyleAndFormatting","TextFormatting","ListFormatting","BoxFormatting","ParagraphFormatting","Styles","|",
								"Paragraph","FontName","FontSize","|",
								"Bold","Italic","Underline","Strikethrough","|",
								"ForeColor","BackColor","|"];
								
							oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
							oEdit1.cmdAssetManager="modalDialogShow(\''.URL_REL.'javascript/Editor/assetmanager/assetmanager.php?lang=french\',640,465)";
							oEdit1.mode="XHTMLBody";
							
							oEdit1.RENDER($("#idtextarea").html());
						</script><br />

				<b>» Éditer l\'évènement</b><br />
				<input type="submit" class="submit" value="éditer le evènement"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
			  <br /><center> - <a href="?admin-coverage">Retour administration des matchs</a> -</center><br />';

break;
case "editer2":

	$id=$_GET['id'];
	
	$nom=addBdd($_POST['nom']);
	$jeu=addBdd($_POST['jeu']);
	$site=addBdd($_POST['site']);
	$pays=addBdd($_POST['pays']);
	($_POST['online']=='online') ? $ville="online" : $ville=addBdd($_POST['ville']);
	
	$annee=addBdd($_POST['annee']);
	$mois=addBdd($_POST['mois']);
	$jour=addBdd($_POST['jour']);
	$heure=addBdd($_POST['heure']);
	$mn=addBdd($_POST['mn']);
		$date=$annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$mn.':00';
		
	$contenu=addslashes($_POST['contenu']);
	
	$sql=mysql_query("	UPDATE ".PREFIX."coverage
						SET
							nom='$nom',
							site='$site',
							jeu='$jeu',
							pays='$pays',
							date='$date',
							lieu='$ville',
							infos='$contenu'
						WHERE id=$id") or die(mysql_error());
	
	header('location: ?admin-coverage');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>