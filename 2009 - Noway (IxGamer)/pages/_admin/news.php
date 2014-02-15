<?php
securite_admin();

$design->zone('titrePage', 'Les news');
$design->zone('titre', 'Gérer les news du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			<br><center><div id="posterNews"><a href="?admin-news&action=poster">Poster une News</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des News :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Titre</td>
			  <td class="liste_titre">Auteur</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT n.id, n.titre, n.date, n.apercu, m.pseudo 
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."membres m
						ON m.id=n.id_auteur
						ORDER BY n.id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		$contenu.= '<tr>
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
	$header.='<script language=JavaScript src="javascript/Editor/scripts/language/french/editor_lang.js"></script>
			  <script language=JavaScript src="javascript/Editor/scripts/innovaeditor.js"></script>';
	

		$contenu='<div id="retour"><a href="?admin-news"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				  
				  <br><br><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
					Utilisez ce formulaire pour ajouter une news au site.
				  </div>
				  
				  <form name="rediger" method="post" action="?admin-news&action=poster2" onsubmit="return verifAjouterNews()">
				  <fieldset id="form" style="margin-left:20px">
				  	
					<label for="_titre" style="font-weight:bold">» Indiquez le titre de la news</label> <span class="requis">(requis)</span>  <br /><br />
					<input type="text" name="titre" id="_titre" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

					<label for="resume" style="font-weight:bold">» Résumé de la news</label> <br />
					<blockquote style="margin-left:10px">- Si vous souhaitez que la news apparaissent entière, c\'est à dire sans résumé, laissez ce champs vide.<br />
														 - HTML autorisé</blockquote><br />
					<textarea name="resume" id="resume" class="size100" style="margin-left:25px; width:440px"></textarea><br /><br /><br />

					<label for="image" style="font-weight:bold">» Image illustrant la news : </label> <span class="requis">(requis)</span> <br />
						
						<br /><a class="button" style="margin-left:25px" href="#" onclick="this.blur(); openAsset(\'inpURL\'); return false"><span>Parcourir</span></a>
						<input type="text" name="inpURL" id="inpURL" style="margin-left:25px; margin-bottom:30px" value=""  onchange="/*$(\'img_select\').src=this.value*/";>
						<img src="images/no_news.png" id="img_select" style="margin-left:70px"/><br />
						
					<label for="contenu" style="font-weight:bold">» Rédaction de la news complète</label> <span class="requis">(requis)</span> <br /><br />
					
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
	$contenu=addslashes($_POST['contenu']);
	$image=addslashes($_POST['inpURL']);
	$ip=ip();
	$idAuteur=$_SESSION['sess_id'];
	
	$sql=mysql_query("	INSERT INTO ".PREFIX."news 	(`titre` , `apercu` , `contenu` , `image`, `id_auteur` , `date` , `ip` )
						VALUES ('$titre', '$resume', '$contenu', '$image', '$idAuteur', NOW(), '$ip')");
						
	header('location: ?admin-news');



break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=(int)$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."news WHERE id='$id'");
	$sql2=mysql_query("DELETE FROM ".PREFIX."news_com WHERE id_news='$id'");

	header('location: ?admin-news');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."news WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	//:: Configuration du HTML AREA
	$header.='<script language=JavaScript src="javascript/Editor/scripts/language/french/editor_lang.js"></script>
			  <script language=JavaScript src="javascript/Editor/scripts/innovaeditor.js"></script>';

	$contenu='<div id="retour"><a href="?admin-news"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	          
			  <br /><br /><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
				Editer une news
			  </div>
			  
			  <form method="post" action="?admin-news&action=editer2" onsubmit="return verifAjouterNews()">
			  <fieldset id="form" style="margin-left:20px">
				
				<label for="_titre" style="font-weight:bold">» Titre de la news</label> <span class="requis">(requis)</span>  <br /><br />
				<input type="text" name="titre" id="_titre" value="'.recupBdd($d->titre).'" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />

				<label for="resume" style="font-weight:bold">» Résumé de la news</label> <br />
				<blockquote style="margin-left:10px">- Si vous souhaitez que la news apparaissent entière, c\'est à dire sans résumé, laissez ce champs vide.<br />
													 - HTML autorisé</blockquote><br />
				<textarea name="resume" id="resume" class="size100" style="margin-left:25px; width:440px">'.recupBdd($d->apercu).'</textarea><br /><br /><br />

				<label for="image" style="font-weight:bold">» Image illustrant la news : </label> <span class="requis">(requis)</span> <br />
					
					<br /><a class="button" style="margin-left:25px" href="#" onclick="this.blur(); openAsset(\'inpURL\'); return false"><span>Parcourir</span></a>
					<input type="text" name="inpURL" id="inpURL" style="margin-left:25px; margin-bottom:30px" value="'.recupBdd($d->image).'"  onchange="/*$(\'img_select\').src=this.value*/";>
					<img src="'.recupBdd($d->image).'" id="img_select" style="margin-left:70px"/><br />
				
				<label for="contenu" style="font-weight:bold">» Rédaction de la news complète</label> <span class="requis">(requis)</span> <br /><br />
				<pre id="idtextarea" name="idtextarea" style="display:none">'.recupBdd($d->contenu).'</pre>
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
	$image=addslashes($_POST['inpURL']);
	$ip=ip();
	$idAuteur=$_SESSION['sess_id'];
	$id=$_POST['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."news 	
					  SET titre='$titre',
						apercu='$resume',
						contenu='$contenu',
						image='$image',
						ip='$ip'
					  WHERE id=$id")
				or die(mysql_error());
		
	header('location: ?admin-news');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>