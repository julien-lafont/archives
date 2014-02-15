<?php
securite_admin();

switch(@$_GET['action']) {

default:
	
	$sql=mysql_query("SELECT valeur FROM ".PREFIX."config WHERE cle='SPONSOR'");
	$d=mysql_fetch_object($sql);
		$sponsor=recupBdd($d->valeur);
	
	$c='<div class="titreMessagerie">Module Head Sponsor</div>
	
		<center>Utilisez ce formulaire pour modifier le contenu du menu <b>header sponsor</b></center><br /><br />
		
		<form name="sponsor" action="?admin-sponsor&action=edit" method="post" onsubmit="return modifSponsor()">
		<fieldset style="margin-left:50px; width:450px; text-align:center" id="form">
		
			<pre id="idtextarea" name="idtextarea" style="display:none;" >'.$sponsor.'</pre>
			<input type="hidden" name="contenu" id="contenu" />
					
			<script>
				var oEdit1 = new InnovaEditor("oEdit1");
				oEdit1.btnStyles=true;
		
				oEdit1.width=450
				oEdit1.height=300
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

			<input type="submit" class="submit" value="Mettre à jour" /><br /><br />
			
		</fieldset>
		</form>';

break;

case "edit":
	
	$val=addslashes($_POST['contenu']);
	
	// Met à jour l'élément ds la bdd
	$sql=mysql_query("UPDATE ".PREFIX."config SET `valeur`='$val' WHERE `cle`='SPONSOR'");
	
	header('location: ?admin-sponsor');

break;

}

$design->zone('contenu', $c);
$design->zone('titrePage', 'Les sponsors');
$design->zone('titre', 'Gérer les sponsors du site');
	$header.='<script language=JavaScript src="javascript/Editor/scripts/language/french/editor_lang.js"></script>
			  <script language=JavaScript src="javascript/Editor/scripts/innovaeditor.js"></script>';
$design->zone('header', $header);

?>