<?php
securite_admin();

$design->template('admin');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil">&lsaquo; Retour &lsaquo;</a></div>
			<br><center><div id="posterNews"><a href="?admin-news&action=poster">Poster une News</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des News :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Titre</td>
			  <td class="liste_titre">Catégorie</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT n.id, n.titre, n.idcat, n.date, nc.nom
						FROM ".PREFIX."news n 
						LEFT JOIN ".PREFIX."news_cat nc
						ON nc.id=n.idcat
						ORDER BY n.id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
						<td class="liste_txt">
								'.tronquerChaine(recupBdd($d->titre),50).'
						</td>
						
						<td class="liste_txt">
							'.$d->nom.'
						</td>
						
						<td class="liste_txt">
							'.inverser_date($d->date,5).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-news&action=suppr&id='.$d->id.'" title="Supprimer la news"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-news&action=editer&id='.$d->id.'" title="Editer la news"><img src="images/boutons/edit.png" /></a>						
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

		$contenu='<div id="retour"><a href="?admin-news">&lsaquo; Retour &lsaquo;</a></div>
				  
				  <br><br><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
					Utilisez ce formulaire pour ajouter une news au site.
				  </div>
				  
				  <form name="rediger" method="post" action="?admin-news&action=poster2" onsubmit="return verifAjouterNews()">
				  <fieldset id="form">
				  	
					<label for="_titre" style="font-weight:bold">» Indiquez le titre de la news</label>  <br /><br />
					<input type="text" name="titre" id="_titre" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

					<label for="_url" style="font-weight:bold">» Indiquez l\'url de le news</label> <br /><br />
					<input type="text" name="url" id="_url" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

					<label for="resume" style="font-weight:bold">» Résumé de la news</label> <br /><br />
					<textarea name="resume" id="resume" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br /><br />
					
					<label for="contenu" style="font-weight:bold">» Rédaction de la news complète</label><br /><br />
					<pre id="idtextarea" name="idtextarea" style="display:none"></pre>
					<input type="hidden" name="contenu" id="_contenu" />
					
					<script>
						var oEdit1 = new InnovaEditor("oEdit1");
						oEdit1.btnStyles=true;
						oEdit1.btnSpellCheck=true;
				
						oEdit1.css="theme/styles_editor.css";
						oEdit1.width=600
						oEdit1.height=500
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
					
					<label for="_cat" style="font-weight:bold">» Catégorie de la news ?</label> <br /><br />
					<select name="cat" id="_cat" style="margin-left:25px !important; text-align:left; width:250px" >';
						$sql_cat=mysql_query("SELECT id, nom FROM ".PREFIX."news_cat ORDER BY id");
						while ($cat=mysql_fetch_object($sql_cat)) {
							$contenu.="<option value='".$cat->id."'>".$cat->nom."</option>";
						}
					$contenu.='</select><br /><br /><br />
					
					<b>» Vérifier et envoyer la news</b><br /><br />
					<input type="submit" class="submit" value="ajouter la news"  style="margin-left:25px"/><br /><br />

				  </fieldset>
				  </form>';


break;
#########################################################################################################################
#########################################################################################################################
case "poster2":

	$titre=addslashes($_POST['titre']);
	$resume=addslashes($_POST['resume']);
	$url=addslashes($_POST['url']);
	$contenu=addslashes($_POST['contenu']);
	$cat=addslashes($_POST['cat']);
	$ip=ip();
	
	$sql=mysql_query("	INSERT INTO ".PREFIX."news 	(`titre` , `apercu` , `contenu` , `url` , `date` , `ip`, `idcat` )
						VALUES ('$titre', '$resume', '$contenu', '$url', NOW(), '$ip', '$cat')");
						
	header('location: ?admin-news');



break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=(int)$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."news WHERE id='$id'");

	header('location: ?admin-news');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."news WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	//:: Configuration du HTML AREA
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
		$header.="<script language='JavaScript' src='include/Editor/scripts/editor.js'></script>";
	else
		$header.="<script language='JavaScript' src='include/Editor/scripts/moz/editor.js'></script>";
	$header.='<script language="JavaScript" src="include/Editor/scripts/language/french/editor_lang.js"></script>';

	$contenu='<div id="retour"><a href="?admin-news">&lsaquo; Retour &lsaquo;</a></div>
	          <br><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
				Editer une news
			  </div>
			  
			  <form method="post" action="?admin-news&action=editer2" onsubmit="return verifAjouterNews()">
			  <fieldset id="form">
				
				<label for="_titre" style="font-weight:bold">» Titre de la news</label><br /><br />
				<input type="text" name="titre" id="_titre" value="'.recupBdd($d->titre).'" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />
				
				<label for="_url" style="font-weight:bold">» Indiquez l\'url de le news</label> <br /><br />
				<input type="text" name="url" id="_url" value="'.recupBdd($d->titre).'" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

				<label for="resume" style="font-weight:bold">» Résumé de la news</label> <br />
				<textarea name="resume" id="resume" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->apercu).'</textarea><br /><br /><br />
				
				<label for="contenu" style="font-weight:bold">» Rédaction de la news complète</label> <br /><br />
				<pre id="idtextarea" name="idtextarea" style="display:none">'.recupBdd($d->contenu).'</pre>
				<input type="hidden" name="contenu" id="_contenu" />
				
				<script>
					var oEdit1 = new InnovaEditor("oEdit1");
					oEdit1.btnStyles=true;
					oEdit1.btnSpellCheck=true;
			
					oEdit1.css="theme/styles_editor.css";
					oEdit1.width=700
					oEdit1.height=600
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
					
				<label for="_cat" style="font-weight:bold">» Catégorie de la news ?</label> <br /><br />
				<select name="cat" id="_cat" style="margin-left:25px !important; text-align:left; width:250px" >';
					$sql_cat=mysql_query("SELECT id, nom FROM ".PREFIX."news_cat ORDER BY id");
					while ($cat=mysql_fetch_object($sql_cat)) {
						if ($d->idcat==$cat->id) $contenu.="<option value='".$cat->id."' selected>".$cat->nom."</option>";
						else $contenu.="<option value='".$cat->id."'>".$cat->nom."</option>";
					}
				$contenu.='</select><br /><br /><br />
				
				<b>» Vérifier et envoyer la news</b><br /><br />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="submit" class="submit" value="éditer la news"  style="margin-left:25px"/><br /><br />

			  </fieldset>
			  </form>';

break;
#########################################################################################################################
#########################################################################################################################
case "editer2":

	$titre=addslashes($_POST['titre']);
	$resume=addslashes($_POST['resume']);
	$contenu=addslashes($_POST['contenu']);
	$url=addslashes($_POST['url']);
	$ip=ip();
	$id=$_POST['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."news 	
					  SET titre='$titre',
						apercu='$resume',
						contenu='$contenu',
						url='$url',
						date=NOW(),
						ip='$ip'
					  WHERE id=$id")
				or die(mysql_error());
		
	header('location: ?admin-news');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);


?>