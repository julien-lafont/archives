<?php
securite_admin();

$design->zone('titrePage', 'Les brèves');
$design->zone('titre', 'Gérer les brèves du site');

switch(@$_GET['action'])
{
default:

	$contenu='<div id="curseur" class="infobulle"></div>
			
			<div id="retour"><a href="?admin-accueil">&lsaquo; Retour &lsaquo;</a></div>
			<br><center><div id="posterNews"><a href="?admin-breves&action=poster">Poster une Brève</a></div></center>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des Brèves :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Titre</td>
			  <td class="liste_titre">Auteur</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT b.id, b.titre, b.date, m.pseudo 
						FROM ".PREFIX."breves b
						LEFT JOIN ".PREFIX."membres m
						ON m.id=b.id_auteur
						ORDER BY b.id DESC");		  
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
							<a href="?admin-breves&action=suppr&id='.$d->id.'" title="Supprimer la brève"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-breves&action=editer&id='.$d->id.'" title="Editer la brève"><img src="images/boutons/edit.png" /></a>						
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
			$header="<script language='JavaScript' src='include/Editor/scripts/editor.js'></script>";
		else
			$header="<script language='JavaScript' src='include/Editor/scripts/moz/editor.js'></script>";
		$header.='<script language="JavaScript" src="include/Editor/scripts/language/french/editor_lang.js"></script>';

		$contenu='<div id="retour"><a href="?admin-breves">&lsaquo; Retour &lsaquo;</a></div>
				  
				  <br><br><div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
					Utilisez ce formulaire pour ajouter une brève au site.
				  </div>
				  
				  <form name="rediger" method="post" action="?admin-breves&action=poster2" onsubmit="return verifAjouterNews()">
				  <fieldset id="form">
				  	
					<label for="_titre" style="font-weight:bold">» Indiquez le titre de la brève</label> <span class="requis">(requis)</span>  <br /><br />
					<input type="text" name="titre" id="_titre" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />
					
					<label for="contenu" style="font-weight:bold">» Rédaction de la brève complète</label> <span class="requis">(requis)</span> <br /><br />
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
					
					<b>» Vérifier et envoyer la brève</b><br /><br />
					<input type="submit" class="submit" value="ajouter la brève"  style="margin-left:25px"/><br /><br />

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
	
	$sql=mysql_query("	INSERT INTO ".PREFIX."breves (`titre` , `contenu` , `id_auteur` , `date` , `ip` )
						VALUES ('$titre', '$contenu', '$idAuteur', NOW(), '$ip')");
						
	header('location: ?admin-breves');



break;
#########################################################################################################################
#########################################################################################################################
case "suppr":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."breves WHERE id='$id'");
	$sql2=mysql_query("DELETE FROM ".PREFIX."breves_com WHERE id_news='$id'");

	header('location: ?admin-breves');

break;
#########################################################################################################################
#########################################################################################################################
case "editer":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."breves WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	//:: Configuration du HTML AREA
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
		$header.="<script language='JavaScript' src='include/Editor/scripts/editor.js'></script>";
	else
		$header.="<script language='JavaScript' src='include/Editor/scripts/moz/editor.js'></script>";
	$header.='<script language="JavaScript" src="include/Editor/scripts/language/french/editor_lang.js"></script>';

	$contenu='<div id="retour"><a href="?admin-breves">&lsaquo; Retour &lsaquo;</a></div>
			  <div style="text-align:center; font-size:11px; margin:10px 0 20px 0; color:#FF4F98; font-weight:bold">
				Editer une brève
			  </div>
			  
			  <form method="post" action="?admin-breves&action=editer2" onsubmit="return verifAjouterNews()">
			  <fieldset id="form">
				
				<label for="_titre" style="font-weight:bold">» Titre de la brève</label> <span class="requis">(requis)</span>  <br /><br />
				<input type="text" name="titre" id="_titre" value="'.recupBdd($d->titre).'" style="margin-left:25px !important; text-align:left; width:250px" /><br /><br /><br />
				
				<label for="contenu" style="font-weight:bold">» Rédaction de la brève complète</label> <span class="requis">(requis)</span> <br /><br />
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
				
				<b>» Vérifier et envoyer la brève</b><br /><br />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="submit" class="submit" value="éditer la brève"  style="margin-left:25px"/><br /><br />

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
	
	$sql=mysql_query("UPDATE ".PREFIX."breves 	
					  SET titre='$titre',
						contenu='$contenu',
						id_auteur='$idAuteur',
						date=NOW(),
						ip='$ip'
					  WHERE id=$id")
				or die(mysql_error());
		
	header('location: ?admin-breves');

break;
}

$design->zone('contenu', $contenu);
$design->zone('header', $header);

?>