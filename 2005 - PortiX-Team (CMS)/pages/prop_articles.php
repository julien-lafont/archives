<?php

$header='<script language="javascript" type="text/javascript" src="include/tiny_mce/tiny_mce.js"></script>
 <script language="javascript" type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			elements : "elm1",
			theme : "advanced",
			language : "fr",
			plugins : "preview",
					plugin_preview_width : "500",
					plugin_preview_height : "300",
					
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_path_location : "bottom",
					
					theme_advanced_buttons1 : "bold,underline,italic,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,fontselect,fontsizeselect,separator",
					theme_advanced_buttons2 : "bullist,numlist,outdent,indent,separator,link,unlink,image,charmap,hr,separator,undo,redo,separator,forecolor,backcolor,separator,cleanup,help,code,preview",
					theme_advanced_buttons3 : "",
					extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
				});
			</script>';
$afficher->setVar($handle,"header",$header);

switch (@$_GET['action']) {
default:
	
	      if (isset($_SESSION['message'])) {
            	$contenu.= "<font color=red><center>".stripslashes($_SESSION['message'])."</center></font>";
            unset($_SESSION['message']);
        } 

$contenu.='<br><form name="form1" method="post" action="?page=prop_articles&action=ajouter">
  <center>En tant que membre, vous pouvez proposé un article qui devra être validé par un admin pour apparaitre sur le site.<br><br>
  <p>Sujet de l\'article : <br>
  <input name="sujet" type="text" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$_SESSION['temp_sujet'].'"></p>
  Texte de l\'article :<br></center>
  <center><textarea id="elm1" name="texte" rows="20" cols="62">'.$_SESSION['temp_texte'].'</textarea></center>
  <p><center><input type="submit" name="Submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" value="&nbsp;&nbsp;Valider&nbsp;&nbsp;"> </p></div>
</form>';
	
	unset ($_SESSION['temp_sujet']); unset ($_SESSION['temp_texte']);

break;
case "ajouter":

		if (empty($_POST['sujet']) || empty($_POST['texte'])) {
            @$_SESSION['message'] .= ">> Les champs Sujet et/ou Texte n'ont pas été renseignés.<br>";
            @$erreur++; }   
		    
		if (@$erreur != 0) { 
			$_SESSION['temp_sujet']=$_POST['sujet'];
			$_SESSION['temp_texte']=$_POST['texte'];
            rediriger("?page=prop_articles"); } 
		else {
			$sujet=addslashes($_POST['sujet']); 		$texte=addslashes($_POST['texte']); 
			$idaut=$_SESSION['sess_id'];
            $sql = mysql_query("INSERT INTO ix_proparticles ( `sujet` , `texte` , `auteur`) VALUES ('$sujet','$texte','$idaut')");
			rediriger("?page=prop_articles&action=ok"); 
		}

break;
case "ok":

	$contenu="<br><br><br><center>Votre article a été soumis à un modérateur avec succés.<br><br><br><br>";
break;
}
	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Articles du site");
    $afficher->setVar($handle, "contenu.module_texte", $contenu);
    $afficher->CloseSession($handle, "contenu");

?>
