<?php
is_admin();

// Confiruration du HTMLArea
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

	$sql1=mysql_query("SELECT count(id) as nb from ix_proparticles");
	$prop=mysql_fetch_object($sql1);

	$contenu="<div class=\"titreBS\">Administration des articles :</div>
	<ul class='menu-spe'>
	<li><a href='?page=admin/articles&action=ajouter'>Ajouter un article</a></li>
	<li><a href='?page=admin/articles&action=gerer'>Gérer les articles</a></li>
	<li><a href='?page=admin/articles&action=prop'>Voir les articles soumis ($prop->nb)</a></li>
</ul>";
	
break;
##########################################################################################
##########################################################################################
case "ajouter":

	$contenu="<div class=\"titreBS\">Ajouter un article :</div>";
	      if (isset($_SESSION['message'])) {
            	$contenu.= "<font color=red><center>".stripslashes($_SESSION['message'])."</center></font>";
            unset($_SESSION['message']);
        } 

$contenu.='<form name="form1" method="post" action="?page=admin/articles&action=ajouter2">
  <center><p>Sujet de l\'article : <br>
  <input name="sujet" type="text" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$_SESSION['temp_sujet'].'"></p>
  Texte de l\'article :<br></center>
  <center><textarea id="elm1" name="texte" rows="20" cols="62">'.$_SESSION['temp_texte'].'</textarea></center>
  <p><center><input type="submit" name="Submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" value="&nbsp;&nbsp;Valider&nbsp;&nbsp;"> </p></div>
</form>';
	
	unset ($_SESSION['temp_sujet']); unset ($_SESSION['temp_texte']);


break;
##########################################################################################
##########################################################################################
case "ajouter2":

		if (empty($_POST['sujet']) || empty($_POST['texte'])) {
            @$_SESSION['message'] .= ">> Les champs Sujet et/ou Texte n'ont pas été renseignés.<br>";
            @$erreur++; }   
		    
		if (@$erreur != 0) { 
			$_SESSION['temp_sujet']=$_POST['sujet'];
			$_SESSION['temp_texte']=$_POST['texte'];
            rediriger("?page=admin/articles&action=ajouter"); } 
		else {
			$sujet=addslashes($_POST['sujet']); 		$texte=addslashes($_POST['texte']); 
			$idaut=$_SESSION['sess_id'];  	$date = date("Y-m-d");

            $sql = mysql_query("INSERT INTO ix_articles ( `sujet` ,  `texte` , `date`, `auteur`) VALUES ('$sujet','$texte','$date','$idaut')");
			rediriger("?page=admin/articles"); 
		}
break;
##########################################################################################
##########################################################################################
case "gerer":
	$sql = mysql_query("SELECT * FROM ix_articles ORDER BY id");

	$contenu='<div class="titreBS">Gérer les articles</div>
			  <table class="liste_table" cellpadding=0 cellspacing=2 align="center">
				 <tr>
						<td width="40%" class="liste_titre" style="font-size:10px" align="center"><b>Sujet</b></td>
						<td width="20%" class="liste_titre" style="font-size:10px" align="center"><b>Auteur</b></td>
						<td width="20%" class="liste_titre" style="font-size:10px" align="center"><b>Date</b></td>
						<td width="20%" class="liste_titre" style="font-size:10px" align="center"><b>Actions</b></td>
				 </tr>';
			  
	while($data = mysql_fetch_object($sql)) {
		
		$sql2 = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur") or die;
		$_aut = mysql_fetch_object($sql2);
	
		$contenu.="<tr>
					<td class='liste_txt' style='font-size:10px'><a href='?page=articles&id=$data->id'>".stripslashes(stripslashes($data->sujet))."</a></td>
					<td class='liste_txt' style='font-size:10px'>$_aut->pseudo</td>
					<td class='liste_txt' style='font-size:10px'>".@inverser_date($data->date)."</td>             
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/articles&action=suppr&id=$data->id\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;<a href=\"?page=admin/articles&action=editer&id=$data->id\"><img src=\"images/edit.jpg\" border=0></a></td>
			    </tr>";	
	}
		 
	$contenu.="</table><br><br><center><a href='?page=admin/articles'>- Retour à l'administration des Articles -</a></center>";
break;
#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_articles WHERE id=".$_GET['id']);
	rediriger("?page=admin/articles&action=gerer");
break;

#########################################################################################################
#########################################################################################################
case "editer":

	$sql = mysql_query("SELECT * FROM ix_articles WHERE id=".$_GET['id']);
	$data = mysql_fetch_object($sql);
	
	$contenu="<div class=\"titreBS\">Editer un article :</div>";

        if (isset($_SESSION['message'])) {
            $contenu.= "<font color=red><center>" . stripslashes($_SESSION['message']) . "</center></font>";
            unset($_SESSION['message']); 
			$newsujet=$_SESSION['temp_sujet'];
			$newtexte=$_SESSION['temp_texte'];
		} else {
		$newsujet=stripslashes($data->sujet);
		$newtexte=stripslashes($data->texte);
		}
		
	$contenu.='<form name="formedit" method="post" action="?page=admin/articles&action=editer2">
  <div class="edit_news"><center><p>Sujet de l\'article : <br>
  <input name="sujet" type="text" " class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text"  value="'.$newsujet.'"></p>
  Texte de l\'article :<br>
  <center><textarea id="elm1" name="texte" rows="20" cols="62">'.$newtexte.'</textarea></center>
  <input type="hidden" name="id" value="'.$_GET['id'].'"><p><input type="submit" name="Submit" value="&nbsp;&nbsp;Editer&nbsp;&nbsp;"> </p></div>
	</form></center>';
	
break;
##########################################################################################
##########################################################################################
case "editer2":

		if (empty($_POST['sujet']) || empty($_POST['texte'])) {
            @$_SESSION['message'] .= ">> Les champs Sujet et/ou Texte n'ont pas été renseignés.<br>";
            @$erreur++; }   
		    
		if (@$erreur != 0) { 
			$_SESSION['temp_sujet']=$_POST['sujet'];
			$_SESSION['temp_texte']=$_POST['texte'];
            rediriger("?page=admin/articles&action=editer&id=".$_POST['id']); } 
		else {
			$sujet=addslashes($_POST['sujet']); 		$texte=addslashes($_POST['texte']); 
			$id=$_POST['id'];

            $sql = mysql_query("UPDATE ix_articles SET sujet='$sujet', texte='$texte' WHERE id=$id")or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
			rediriger("?page=admin/articles");
		}
break;
##########################################################################################
##########################################################################################
case "prop":

	$sql = mysql_query("SELECT * FROM ix_proparticles ORDER BY id");

	$contenu='<div class="titreBS">Gérer les articles proposés</div>
			  <table class="liste_table" cellpadding=0 cellspacing=2 align="center">
				 <tr>
						<td width="50%" class="liste_titre" style="font-size:10px" align="center"><b>Sujet</b></td>
						<td width="30%" class="liste_titre" style="font-size:10px" align="center"><b>Auteur</b></td>
						<td width="20%" class="liste_titre" style="font-size:10px" align="center"><b>Actions</b></td>
				 </tr>';
			  
	while($data = mysql_fetch_object($sql)) {
		
		$sql2 = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur") or die;
		$_aut = mysql_fetch_object($sql2);
	
		$contenu.="<tr>
					<td class='liste_txt' style='font-size:10px'><a href='?page=admin/articles&action=voirprop&id=$data->id'>".stripslashes($data->sujet)."</a></td>
					<td class='liste_txt' style='font-size:10px'>$_aut->pseudo</td>           
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/articles&action=supprprop&id=$data->id\"><img src=\"images/suppr.jpg\"  border=0></a></td>
			    </tr>";	
	}
		 
	$contenu.="</table><br><br><center><a href='?page=admin/articles'>- Retour à l'administration des Articles -</a></center>";

break;

#########################################################################################################
#########################################################################################################
case "supprprop":
	$req = mysql_query("DELETE FROM ix_proparticles WHERE id=".$_GET['id']);
	rediriger("?page=admin/articles&action=prop");
break;
#########################################################################################################
#########################################################################################################
case "voirprop":

	$sql = mysql_query("SELECT * FROM ix_proparticles WHERE id=".$_GET['id']);
	$data = mysql_fetch_object($sql);
	$newsujet=stripslashes($data->sujet);
	$newtexte=stripslashes($data->texte);
		$sql2 = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur") or die;
		$_aut = mysql_fetch_object($sql2);

	$contenu="<div class=\"titreBS\">Voir un article proposé :</div>";
	$contenu.='<div class="edit_news"><center><p>Sujet de l\'article : <br>
  <input name="sujet" type="text" " class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text"  value="'.$newsujet.'"></p>
 
 Auteur <br>
  <input name="sujet" type="text" " class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text"  value="'.$_aut->pseudo.'"></p>
  <br><br><br>
  
  Texte de l\'article :<br>
  <center><textarea id="elm1" name="texte" rows="20" cols="62">'.$newtexte.'</textarea></center>
  </center>';
break;

}

	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Administration des articles");
    $afficher->setVar($handle, "contenu.module_texte", $contenu);
    $afficher->CloseSession($handle, "contenu");
?>