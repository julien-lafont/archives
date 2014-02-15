<?php
securite_admin();

$design->zone('titrePage', 'Les articles HTML');
$design->zone('titre', 'Gérer les pages simples, les articles du site');

$header='<script type="text/javascript" src="include/js/-bulle_infos.js" ></script>';

switch(@$_GET['action'])
{
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil">&lsaquo; Retour &lsaquo;</a></div>
			<br><center><div id="posterNews"><a href="?admin-pages_simples&action=poster">Ecrire une nouvelle page</a></div></center>
			
			<center><input type="text" id="temp_url" /></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
			<tr>
			  <td colspan=5 class="liste_header">	Liste des pages :<br />
			  	<span style="font-weight:normal; color:#333">Vous pouvez voir l\'url des pages en cliquant sur la première icone à droite</span><br />&nbsp;</td>
			</tr>
			  <tr>
			  <td class="liste_titre" width="50">Résumé</td>
			  <td class="liste_titre" width="164">Titre</td>
			  <td class="liste_titre" width="90">Auteur</td>
			  <td class="liste_titre" width="70">Date</td>
			  <td class="liste_titre" width="80"></td>
		  </tr>';

	$sql = mysql_query("SELECT p.id, p.titre, p.date, p.contenu , m.pseudo 
						FROM ".PREFIX."pages p
						LEFT JOIN ".PREFIX."membres m
						ON m.id=p.id_auteur
						ORDER BY p.id DESC") or die (mysql_error());		  
	while($d = mysql_fetch_object($sql)) {
/*strip_tags*/
		$contenu.= '<tr>
						<td class="liste_txt">
							<img src="images/boutons/info.png" alt=\'<b>Résumé : </b><br /><br />'.tronquerChaine(recode(strip_tags($d->contenu), false), 400).'\' id="alt'.$d->id.'" onmouseover="montre(this.id)" onmouseout="cache();" />
						</td>
						<td class="liste_txt">
								'.tronquerChaine(recupBdd($d->titre),37).'
						</td>
						
						<td class="liste_txt">
							<a href="profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a>
						</td>
						
						<td class="liste_txt">
							'.inverser_date($d->date,5).'
						</td>
						
						<td class="liste_txt">	
							<a href="#" onclick="showUrl(\''.URL.'_'.$d->id.'/'.recode($d->titre).'/\'); return false" title="Voir l\'url de la page"><img src="images/boutons/url2.png" /></a>&nbsp;
							<a href="?admin-pages_simples&action=suppr&id='.$d->id.'" title="Supprimer la page"><img src="images/boutons/cancel.png" /></a>&nbsp;
							<a href="?admin-pages_simples&action=editer&id='.$d->id.'" title="Editer la page"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";

break;
#########################################################################################################################
#########################################################################################################################
case "poster":

		//:: Configuration du HTML AREA
		if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
			$header.="<script language='JavaScript' src='include/Editor/scripts/editor.js'></script>";
		else
			$header.="<script language='JavaScript' src='include/Editor/scripts/moz/editor.js'></script>";
		$header.='<script language="JavaScript" src="include/Editor/scripts/language/french/editor_lang.js"></script>';

		$contenu='<div id="retour"><a href="?admin-pages_simples">&lsaquo; Retour &lsaquo;</a></div>
				 <br><br><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
					Utilisez ce formulaire pour ajouter une page HTML au site.
				  </div>
				  
				  <form name="rediger" method="post" action="?admin-pages_simples&action=poster2" onsubmit="return verifAjouterNews()">
				  <fieldset id="form">
				  	
					<label for="_titre" style="font-weight:bold">» Indiquez le titre de la page</label> <span class="requis">(requis)</span>  <br /><br />
					<input type="text" name="titre" id="_titre" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

					<label for="contenu" style="font-weight:bold">» Rédaction de la page complète</label> <span class="requis">(requis)</span> <br /><br />
					<pre id="idtextarea" name="idtextarea" style="display:none"></pre>
					<input type="hidden" name="contenu" id="contenu" />
					
					<script>
						var oEdit1 = new InnovaEditor("oEdit1");
						oEdit1.btnStyles=true;
						oEdit1.btnSpellCheck=true;
				
						oEdit1.css="theme/styles_editor.css";
						oEdit1.width=475
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
						
						oEdit1.RENDER($("idtextarea").innerHTML);
					</script><br />
					
					<b>» Vérifier et envoyer la page</b><br /><br />
					<input type="submit" class="submit" value="ajouter la page"  style="margin-left:25px"/><br /><br />

				  </fieldset>
				  </form>';


break;
#########################################################################################################################
#########################################################################################################################
case "poster2":

	$titre=addslashes($_POST['titre']);
	$contenu=addslashes($_POST['contenu']);
	$ip=ip();
	$idAuteur=$_SESSION['sess_id'];
	
	$sql=mysql_query("	INSERT INTO ".PREFIX."pages (`titre` , `contenu` , `id_auteur` , `date` , `ip` )
						VALUES ('$titre', '$contenu', '$idAuteur', NOW(), '$ip')");
						
	header('location: ?admin-pages_simples');

break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=(int)$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."pages WHERE id='$id'");

	header('location: ?admin-pages_simples');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."pages WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	//:: Configuration du HTML AREA
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
		$header.="<script language='JavaScript' src='include/Editor/scripts/editor.js'></script>";
	else
		$header.="<script language='JavaScript' src='include/Editor/scripts/moz/editor.js'></script>";
	$header.='<script language="JavaScript" src="include/Editor/scripts/language/french/editor_lang.js"></script>';

	$contenu='<div id="retour"><a href="?admin-pages_simples">&lsaquo; Retour &lsaquo;</a></div>
				 
		      <div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
				Editer une page
			  </div>
			  
			  <form method="post" action="?admin-pages_simples&action=editer2" onsubmit="return verifAjouterNews()">
			  <fieldset id="form">
				
				<label for="_titre" style="font-weight:bold">» Titre de la page</label> <span class="requis">(requis)</span>  <br /><br />
				<input type="text" name="titre" id="_titre" value="'.recupBdd($d->titre).'" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

				<label for="contenu" style="font-weight:bold">» Rédaction de la page complète</label> <span class="requis">(requis)</span> <br /><br />
				<pre id="idtextarea" name="idtextarea" style="display:none">'.recupBdd($d->contenu).'</pre>
				<input type="hidden" name="contenu" id="contenu" />
				
				<script>
					var oEdit1 = new InnovaEditor("oEdit1");
					oEdit1.btnStyles=true;
					oEdit1.btnSpellCheck=true;
			
					oEdit1.css="theme/styles_editor.css";
					oEdit1.width=475
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
					
					oEdit1.RENDER($("idtextarea").innerHTML);
				</script><br />
				
				<b>» Vérifier et envoyer la page</b><br /><br />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="submit" class="submit" value="éditer la page"  style="margin-left:25px"/><br /><br />

			  </fieldset>
			  </form>';

break;
#########################################################################################################################
#########################################################################################################################
case "editer2":

	$titre=addslashes($_POST['titre']);
	$contenu=addslashes($_POST['contenu']);
	$ip=ip();
	$idAuteur=$_SESSION['sess_id'];
	$id=$_POST['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."pages 	
					  SET titre='$titre',
						contenu='$contenu',
						id_auteur='$idAuteur',
						date=NOW(),
						ip='$ip'
					  WHERE id=$id")
				or die(mysql_error());
		
	header('location: ?admin-pages_simples');

break;
}
$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>