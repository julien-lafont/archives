<?php


//#### Menu administrateur ####//
$mm = '
	<ul id="nav">
		<li class="first"><a href="accueil.htm">Accueil site</a></li>
		<li style="margin-right:25px"><a href="deconnexion.htm">D&eacute;connexion</a></li>
		<li'; if ($page=="admin-accueil") $mm.=' class="active"'; $mm.='><a href="admin.php?accueil">Accueil admin</a></li>';
		
		$mm.='<li'; if (strpos($page, 'billets')!==false) $mm.=' class="active"'; $mm.='><a href="#" onclick="return false">Actus</a>
				<ul>
				<li class="first'; if ($page=="bilelts-rediger") $mm.=' active'; $mm.='"><a href="admin.php?billets-rediger">R&eacute;diger</a></li>
				<li'; if ($page=="billets-revisions") $mm.=' class="active"'; $mm.='><a href="admin.php?billets-revisions">R&eacute;visions (gestion)</a></li>
				<li'; if ($page=="billets-gerer") $mm.=' class="active"'; $mm.='><a href="admin.php?billets-gerer">En attente de publication</a></li>
				</ul>
			</li>';

			
		$mm.='<li'; if (strpos($page, 'membres')!==false) $mm.=' class="active"'; $mm.='><a href="#" onclick="return false">Membres</a>
				<ul>
				<li class="first'; if ($page=="membres-gerer") $mm.=' active'; $mm.='"><a href="admin.php?membres-gerer">Gerer</a></li>
				<li class="last'; if ($page=="membres-gerer") $mm.=' active'; $mm.='"><a href="admin.php?membres-gerer&action=ajouter">Ajouter</a></li>			
				</ul>
			</li>';
			
		$mm.='<li'; if (strpos($page, 'config')!==false) $mm.=' class="active"'; $mm.='><a href="#" onclick="return false">Configuration</a>
				<ul>
				<li class="first'; if ($page=="config-general") $mm.=' active'; $mm.='"><a href="admin.php?config-general">Config du site</a></li>
				<li class="last'; if ($page=="config-partenaires") $mm.=' active'; $mm.='"><a href="admin.php?config-partenaires">Sites amis</a></li>
				</ul>
			</li>';
			
		$mm.='
		</ul>';
	$m->design->assign('menu_admin', $mm);



function miseenforme_admin($type, $texte) {
	switch($type)
	{

		case "bad":
			return '<p class="error"><!--<img src="images/boutons/exclamation.png" />-->'.htmlentities($texte, ENT_QUOTES, "UTF-8").'</p>';
		break;
		case "ok":
			return '<p class="success">'.htmlentities($texte, ENT_QUOTES, "UTF-8").'</p>';
		break;
		default:
			return $texte;
		break;
	}
}

function afficher_htmlarea($champ, $width=600, $height=400, $id=1, $txt="", $style="styles_editor.css") {

	$txt='<pre id="'.$champ.'H" name="'.$champ.'H" style="display:none">'.fonctions::recupBdd($txt).'</pre>
				<input type="hidden" name="'.$champ.'" id="'.$champ.'" />
					
					<script>
						var oEdit'.$id.' = new InnovaEditor("oEdit'.$id.'");
						oEdit'.$id.'.btnStyles=true;
				
						oEdit'.$id.'.css="templates/styles/editeur/'.$style.'";
						oEdit'.$id.'.width='.$width.'
						oEdit'.$id.'.height='.$height.'
						oEdit'.$id.'.features=["XHTMLSource","Preview","Search","SpellCheck",
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
							
						oEdit'.$id.'.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
						oEdit'.$id.'.cmdAssetManager="modalDialogShow(\''.URL_REL.'javascript/editor3/assetmanager/assetmanager.php?lang=french\',640,465)";
						oEdit'.$id.'.mode="XHTMLBody";
						
						oEdit'.$id.'.RENDER($("#'.$champ.'H").html());
					</script><br />';
					
		return $txt;
		
}


// Automatisation verification sql
function verif_champs_requis($redir_erreur, $donnees, $requis){
	
	$etat=true;
	foreach($requis as $cle) {
		if (empty($donnees[$cle])) $etat=false;
	}

	if (!$etat) { header('location: '.$redir_erreur); die(); }
	else return true;
	
}

// Automatisation ajout sql | $protection : array avec la liste des clé à enregister ( facultatif )
function insererBdd($table, $donnees, $protection=false) {
	
	$sql="INSERT INTO ".$table." SET ";
	
	foreach($donnees as $cle=>$val) {
		// Si protection activée, n'insère que les champs inscrits
		if (($protection && in_array($cle, $protection)) || !$protection) {
			//$val=mysql_real_escape_string($val);
			if ($val=="date_now")  $sql.="`$cle` = NOW(), ";
			else				  $sql.="`$cle` = '$val', ";		
		}	
	}
	
	$sql=substr($sql, 0, -2);
	$query=mysql_query($sql);
	return $query;
}

// Automatisation modification sql
function majBdd($table, $where, $donnees, $protection=false) {
	
	$sql="UPDATE ".$table." SET ";
	
	foreach($donnees as $cle=>$val) {
		// Si protection activée, n'insère que les champs inscrits
		if (($protection && in_array($cle, $protection)) || !$protection) {
			if ($val=="date_now")  $sql.="`$cle` = NOW(), ";
			else				  $sql.="`$cle` = '$val', ";		
		}	
	}
	
	$sql=substr($sql, 0, -2);
	$sql.=' WHERE '.$where;
	
	$query=mysql_query($sql) or die(mysql_error());
	
	return $query;
}



?>