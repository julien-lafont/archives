<?php
is_admin();

$mode = $ixteam['mode_news'];
switch (@$_GET['action']) {

default:

		$sql = mysql_query('SELECT * FROM ix_news ORDER BY id DESC'); 
		
		$texte= '<div class="titreBS">Administrer les News :</div>
				<div class="ajouter_centre" style="height:35px"><a href="?page=admin/news&action=ajouter_'.$mode.'">» Ajouter une News «</a>
									<br><a href="?page=admin/news&action=cat">» Gérer les cathégories «</a></div><br>
				
				<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
				  <tr>
						<td class="liste_titre" style="font-size:10px" width="5%">ID</td>
						<td class="liste_titre" style="font-size:10px" width="40%">Sujet</td>
						<td class="liste_titre" style="font-size:10px" width="20%">Auteur</td>
						<td class="liste_titre" style="font-size:10px" width="20%">Date</td>
						<td class="liste_titre" style="font-size:10px" width="15%">Suppr-Edit-Comm</td>
				 </tr>';
	 
	while($data = mysql_fetch_object($sql)) {
	
		if (strlen($data->titre)>=30){ $titre= substr($data->titre,0,30)." ..."; }
		else { $titre = $data->titre; }
		$date = inverser_date(substr($data->date,0,10));
		
		$sql_aut = mysql_query ("SELECT pseudo FROM ix_membres WHERE id=$data->auteur");
		$data_a = mysql_fetch_object($sql_aut);
		(!empty($data_a->pseudo)) ? $auteur = ucfirst($data_a->pseudo) : $auteur="Inconnu";
		
		$texte.="<tr>
		<td class='liste_txt' style='font-size:10px'><a href=\"#\"><b>$data->id</b></a></td>
		<td class='liste_txt' style='font-size:10px'>$titre</td>
		<td class='liste_txt' style='font-size:10px'>$auteur</td>
		<td class='liste_txt' style='font-size:10px'>$date</td>
		<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/news&action=suppr&id=$data->id\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?page=admin/news&action=editer_".$mode."&id=$data->id\"><img src=\"images/edit.jpg\" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?page=admin/news&action=com&id=$data->id\"><img src=\"images/comm2.jpg\" border=0></a></td>
		 </tr>";	
   }
		
	$texte.="</table>";

break;

#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_news WHERE id=".$_GET['id']);
	rediriger("?page=admin/news");
break;

#########################################################################################################
#########################################################################################################
case "ajouter_bbcode":

		$texte='<div class="titreBS">Ajouter une News :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='
			<form name="post" method="post" action="?page=admin/news&action=ajouter2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tr>
			   <td width="100px">Titre</td>
			   <td colspan="2"><input name="titre" class="case_inscript"  maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:left; width:90%" value="'.@$_SESSION['titre'].'">
			   </td>
			 </tr>
			 <tr>
			   <td>Texte</td>
			   <td colspan="2"><br>';
			   
	include "include/bbcode.php";			
	
	$texte.='<input type="text" name="helpbox" maxlength="100" style="width:90%; font-size:10px; color:#FF6600"  value="Astuce: Une mise en forme peut être appliquée au texte sélectionné." />
			<textarea name="message" rows="10" class="case_inscript" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'" style="text-align:left; width:90%">'.@$_SESSION['texte'].'</textarea>';
	$texte.='<br><div class="smileys" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #000000\'">';
			
			for ($i=0;$i<=count($smy1);$i++) {
				$texte.='<a href="javascript:emoticon(\''.$smy1[$i].'\')"><img src="images/smileys/'.$smy2[$i].'" style="border:0"/></a> '; 
			}
			
	$texte.='</div><br>
	 		  </td>
			 </tr>
			 <tr>
			   <td valign="top">Cathégorie<br> </td>
			   <td><select name="cat">';
				$sql_cat = mysql_query("SELECT * FROM ix_news_cat");
				while ($_cat = mysql_fetch_object($sql_cat)) {
					$texte.='<option value="'.$_cat->id.'">'.$_cat->nom.'</option>';
				}
		$texte.='</select> &nbsp;&nbsp; <a href="?page=admin/news&action=voiravatar" target="_blank">[Voir les images associées]</a>
				</td>
			  </tr>
			 <tr>
			 	<td></td>
				<td><br><input name="Submit" value="Ajouter" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/></td>
			 </tr>
			</table>';
			
	 // On efface les variables sessions
	 unset($_SESSION['titre']);
	 unset($_SESSION['texte']);

break;

#########################################################################################################
#########################################################################################################
case "ajouter2":

	   if (empty($_POST['titre']) || empty($_POST['message']) ) {
              $_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de remplir les champs Titre et Texte.<br>";
              $_SESSION['titre'] = $_POST['titre'];
			  $_SESSION['message'] = $_POST['message'];
			rediriger("?page=admin/news&action=ajouter_bbcode");
			exit;
}


	$idauteur = $_SESSION['sess_id'];
	$date = date("Y-m-d H:m:s");
	$cat = $_POST['cat'];
	$titre = $_POST['titre'];
	$txt = $_POST['message'];
		
	$sql = mysql_query("INSERT INTO ix_news ( `titre` , `texte` , `auteur` , `date` , `cat` ) VALUES ( '$titre','$txt','$idauteur','$date','$cat' ) ");
	rediriger("?page=admin/news");
	
break;

#########################################################################################################
#########################################################################################################
case "voiravatar":

		 $num=0;
		$num2=0;
		$texte.= "<br><br><center class=\"txt2\">Voici les différentes cathégories pour les news :</center><br>
				<table border=0 align=center>";
		
			$sql = mysql_query("SELECT * FROM ix_news_cat");
			$nb = mysql_num_rows($sql);
			$nblignes = round ($nb/5);
		
			while ($num<=($nblignes+1) ) {
			$texte.= "<tr>";
			
				while ($num2 <=4 && $data=mysql_fetch_object($sql)) {
							
					if ($data->image!="" && $data->nom!="") {
					$texte.= "<td width=\"20%\"><center><img src=\"".$data->image."\"  width=\"50\" height=\"50\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"><br>".$data->nom."</center></td>";
					$num2++; }
					
			
				}
			$num2=0; $num++;	
			$texte.= "</tr>";
			}
			$texte.="</table>";

break;

#########################################################################################################
#########################################################################################################
case "editer_bbcode":

	$id = $_GET['id'];
	$sql = mysql_query("SELECT * FROM ix_news WHERE id=$id");
	$data = mysql_fetch_object($sql);
	
	$sql2 = mysql_query("SELECT * FROM ix_news_cat");
	
		$texte='<div class="titreBS">Editer une news :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='
			<form name="post" method="post" action="?page=admin/news&action=editer2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tr>
			   <td width="100px">Titre</td>
			   <td colspan="2"><input name="titre" class="case_inscript"  maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:left; width:90%" value="'.$data->titre.'">
			   </td>
			 </tr>
			 <tr>
			   <td>Texte</td>
			   <td colspan="2"><br>';
			   
	include "include/bbcode.php";			
	
	$texte.='<input type="text" name="helpbox" maxlength="100" style="width:90%; font-size:10px; color:#FF6600"  value="Astuce: Une mise en forme peut être appliquée au texte sélectionné." /><br>
			<textarea name="message" rows="10" class="case_inscript" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'" style="text-align:left; width:90%">'.$data->texte.'</textarea>';
	$texte.='<br><div class="smileys" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #000000\'">';
			
			for ($i=0;$i<=count($smy1);$i++) {
				$text = $texte.='<a href="javascript:emoticon(\''.$smy1[$i].'\')"><img src="images/smileys/'.$smy2[$i].'" style="border:0"/></a> '; 
			}
			
	$texte.='</div><br>
	 		  </td>			 
			</tr>
			 <tr>
			   <td valign="top">Cathégorie<br> </td>
			   <td><select name="cat">';

					while ($data2 = mysql_fetch_object($sql2)) 
					{   
						if ($data2->id == $data->cat) $select=" selected";
						$texte.="<option value='$data2->id'$select>$data2->nom</option";
						unset($select);
					}
					
			$texte.='</select>   &nbsp;&nbsp; <a href="?page=admin/news&action=voiravatar" target="_blank">[Voir les Cathégories]</a></td>
			  </tr>
			 <tr>
			 	<td></td>
				<td><br><input type="hidden" name="id" value="'.$id.'"><input name="Submit" value="Modifier" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/></td>
			 </tr>
			</table>';
			
break;

#########################################################################################################
#########################################################################################################
case "editer2":

	   if (empty($_POST['titre']) || empty($_POST['message']) ) {
              $_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de remplir les champs Titre et Texte.<br>";  
			rediriger("?page=admin/news&action=editer_bbcode&id=".$_POST['id']);
			exit;
}

	$cat = $_POST['cat'];
	$titre = $_POST['titre'];
	$txt = $_POST['message'];
	
	$sql = mysql_query("UPDATE ix_news SET titre='$titre', texte='$txt', cat='$cat' WHERE id=".$_POST['id']);
	rediriger("?page=admin/news");
	
break;

#########################################################################################################
#########################################################################################################
//                                    CATHEGORIES  
#########################################################################################################
#########################################################################################################
case "cat":

	$sql = mysql_query("SELECT * FROM ix_news_cat");
	
		$texte='<div class="titreBS">Gérer les cathégories :</div>';
		$texte.='<span class="txt2" style="font-size:12px; font-weight:bold">» Ajouter une cathégorie</span>
		<blockquote><form name="newcat" method="post" action="?page=admin/news&action=newcat">
					<table>
					  <tr>
					  	<td width=30%>Nom</td>
						<td><input type="text" name="nomcat" class="case_inscript"  maxlength="20" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></td>
					  </tr>
					  <tr>
					  	<td>Image</td>
						<td><input type="text" name="imagecat" size="50" class="case_inscript"  maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"><br>
							Dimension conseillé : 50px*50px<br>
							Vous pouvez uplaodé l\'image par le <a href="?page=admin/upload" target="_blank">Center d\'Upload</a>.</td>
					  </tr>
					  <tr>
					  	
					    <td><input type="submit" value="&nbsp;Ajouter" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></td>
					  <td></td></tr>
					 </table></form>
		</blockquote><br>
		
		<span class="txt2" style="font-size:12px; font-weight:bold">» Supprimer une cathégorie</span>
		<blockquote><form name="supprcat" method="post" action="?page=admin/news&action=supprcat">
					<table>
					  <tr>
					  	<td width=30%><select name="supprcat" class="case_inscript" style="padding:0px">';
							while ($_cat = mysql_fetch_object($sql)) {
								if ($_cat->nom!="") 
								$texte.='<option value="'.$_cat->id.'">'.$_cat->nom.'</option>';
							}
		$texte.='</select> </td>
						<td><input type="submit" value="&nbsp;Supprimer" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></td>
					  </tr>
					 </table></form>
		</blockquote><br>
		
		<span class="txt2" style="font-size:12px; font-weight:bold">» Editer une cathégorie :</span>
		<blockquote><form name="editcat" method="post" action="?page=admin/news&action=editcat">
					<table>
					  <tr>
					  	<td width=30%><select name="editcat" class="case_inscript" style="padding:0px">';
							$sql = mysql_query("SELECT * FROM ix_news_cat");
							while ($_cat = mysql_fetch_object($sql)) {
								if ($_cat->nom!="") 
								$texte.='<option value="'.$_cat->id.'">'.$_cat->nom.'</option>';
							}
		$texte.='</select> </td>
						<td><input type="submit" value="&nbsp;Editer" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></td>
					  </tr>
					 </table></form>
		</blockquote>';
		
 // On rajoute le code de VOIR-AVATAR :
		 $num=0;
		$num2=0;
		$texte.= "<br><br><center class=\"txt2\">Voici les différentes cathégories pour les news :</center><br>
				<table border=0 align=center>";
		
			$sql = mysql_query("SELECT * FROM ix_news_cat");
			$nb = mysql_num_rows($sql);
			$nblignes = round ($nb/5);
		
			while ($num<=($nblignes+1) ) {
			$texte.= "<tr>";
			
				while ($num2 <=4 && $data=mysql_fetch_object($sql)) {
							
					if ($data->image!="" && $data->nom!="") {
					$texte.= "<td width=\"20%\"><center><img src=\"".$data->image."\"  width=\"50\" height=\"50\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"><br>".$data->nom."</center></td>";
					$num2++; }
					
			
				}
			$num2=0; $num++;	
			$texte.= "</tr>";
			}
			$texte.="</table>";

		
break;

#########################################################################################################
#########################################################################################################
case "newcat":

	if (empty($_POST['nomcat'])) {
			message_redir("Le nom de la cathégorie doit obligatoirement être renseigné." , "?page=admin/news&action=cat");
	}
	
	if (!empty($_POST['imagecat'])) {
		$extension = strtolower(array_pop(explode(".", $_POST['imagecat'])));
		if ($extension!="jpg" && $extension!="png" && $extension!="gif" && $extension!="jpeg") {
				message_redir("Le format de l'image semble invalide. Les extensions autorisés sont jpg/png/gif.","?page=admin/news&action=cat");
		}
	}

	$nom=$_POST['nomcat'];
	$image=$_POST['imagecat'];
	$sql = mysql_query("INSERT INTO ix_news_cat ( `nom`, `image` ) VALUES ( '$nom','$image') ");
	rediriger("?page=admin/news&action=cat");
	
break;

#########################################################################################################
#########################################################################################################
case "supprcat":

	$id=$_POST['supprcat'];
	$sql = mysql_query("DELETE FROM ix_news_cat WHERE id=$id") or die ("erreur sql " . mysql_error());
	rediriger("?page=admin/news&action=cat");

break;

#########################################################################################################
#########################################################################################################
case "editcat":

	$id=$_POST['editcat'];
	$sql = mysql_query("SELECT * FROM ix_news_cat WHERE id=$id");
	$data=mysql_fetch_object($sql);
	
	$texte='<br><span class="txt2" style="font-size:12px; font-weight:bold">» Editer une cathégorie</span>
		<blockquote><form name="newcat" method="post" action="?page=admin/news&action=editcat2">
					<table>
					  <tr>
					  	<td width=30%>Nom</td>
						<td><input type="text" name="nomcat" class="case_inscript"  maxlength="20" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" value="'.$data->nom.'"></td>
					  </tr>
					  <tr>
					  	<td>Image</td>
						<td><input type="text" name="imagecat" size="50" class="case_inscript"  maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" value="'.$data->image.'">
							<br>[<a href="'.$data->image.'" target="_blank">Aperçu</a>]  : Afficher l\'image actuelle
							<br>[<a href="?page=admin/upload" target="_blank">Center d\'Upload</a>] : Uploader votre image</td>
					  </tr>
					  <tr>
					  	
					    <td><input type="hidden" name="id" value="'.$id.'">
							<input type="submit" value="&nbsp;Modifier" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></td>
					  <td></td></tr>
					 </table></form>
		</blockquote><br>';
		
break;

#########################################################################################################
#########################################################################################################
case "editcat2":

	$id=$_POST['id'];
	$nom=$_POST['nomcat'];
	$image=$_POST['imagecat'];
	
	$sql = mysql_query("UPDATE ix_news_cat SET nom='$nom', image='$image' WHERE id=$id");
	rediriger("?page=admin/news&action=cat");
	
break;

#########################################################################################################
#########################################################################################################
case "com":

	$id=$_GET['id'];

	#### En premier on affiche la news :
	$sql=mysql_query("SELECT * FROM ix_news WHERE id=$id");
	$data = mysql_fetch_object($sql);

			// Auteur :
				$sql_ps = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur");
				$_pseudo = mysql_fetch_object($sql_ps);
				if (empty($_pseudo->pseudo)) $pseudo="Inconnu";
				else $pseudo = '<a href="?page=profil&id='.$data->auteur.'">'.ucfirst($_pseudo->pseudo).'</a>';
				
			// Date :
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1." à ".$date2."h".$date3;
			
			// Cathégorie :
				$sql_cat =mysql_query("SELECT nom, image FROM ix_news_cat WHERE id=$data->cat");
				$_cat = mysql_fetch_object($sql_cat);
				if ($data->cat!=1) $image = '<div style="margin:2px; float:right"><img src="'.$_cat->image.'" width="50" height="50" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div>';
		
				$afficher->AddSession($handle,"news");
				$afficher->setVar($handle,"news.news_cathegorie",$_cat->nom);
				$afficher->setVar($handle,"news.news_titre",$data->titre);
				$afficher->setVar($handle,"news.news_texte",$image.nl2br(bbcode($data->texte)));
				$afficher->setVar($handle,"news.news_auteur",$pseudo);
				$afficher->setVar($handle,"news.news_date",$date);
				$afficher->setVar($handle,"news.news_commentaires","");
				$afficher->CloseSession($handle,"news");
				
	
	#### Puis on AFFICHE les commentaires de la news :
	$sql2=mysql_query("SELECT * FROM ix_news_com WHERE idnews=$id");
	while ($com = mysql_fetch_object($sql2)) {
	
			// Auteur 
			$sql_aut = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$com->idauteur");
				$_pseudo = mysql_fetch_object($sql_aut);
				$pseudo = ucfirst($_pseudo->pseudo);
			$sql_aut2 = mysql_query("SELECT avatar FROM ix_membres_detail WHERE id_mbre=$com->idauteur");
				$_avatar = mysql_fetch_object($sql_aut2);
				$avatar = $_avatar->avatar;
				
	$texte.='<table width="100%">
			<tr>
			  <td width="105px" valign="top"><b class="txt2"><center>'.$pseudo.'</center></b>
			  					<center><div align="center" style="background-color:#FFFFFF; border:1px solid #000000; width:75%; padding:3px;" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #000000\'"><a href="?page=admin/news&action=com_suppr&id='.$com->id.'"><img src="images/suppr.jpg"  border=0></a>&nbsp;<a href="?page=admin/news&action=com_edit&id='.$com->id.'"><img src="images/edit.jpg" border=0></a></div></center></td>
			  <td>'.stripslashes(nl2br(bbcode($com->texte))).'</td>
			</tr>
		  </table>
		  <br><div id="barresouligner"></div><br>';
	}

break;

#########################################################################################################
#########################################################################################################
case "com_suppr":
	$req = mysql_query("DELETE FROM ix_news_com WHERE id=".$_GET['id']);
	rediriger("?page=admin/news");
break;

#########################################################################################################
#########################################################################################################
case "com_edit":

	$sql = mysql_query("SELECT * FROM ix_news_com WHERE id=".$_GET['id']);
	$data = mysql_fetch_object($sql);

		$texte= '<div class="titreBS">Editer un commentaire:</div>
			<center>
			<form name="post" method="post" action="?page=admin/news&action=com_edit2">';
			
						include "include/bbcode.php";			

		$texte.='<input type="text" name="helpbox" size="45" maxlength="100" style="width:320px; font-size:10px" class="helpline" value="Astuce: Une mise en forme peut être appliquée au texte sélectionné." /><br>			
			<textarea name="message" id="newst" rows="10" wrap="virtual" cols="45" class="txt_comnews" style="border-style:solid">'.$data->texte.'</textarea><br>
			<div class="smileys" style="width:350px" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #000000\'">';
			
			for ($i=0;$i<=count($smy1);$i++) {
				$texte.='<a href="javascript:emoticon(\''.$smy1[$i].'\')"><img src="images/smileys/'.$smy2[$i].'" style="border:0"/></a> '; 
			}
			
		$texte.='</div><input type="hidden" name="idcom" value="'.$_GET['id'].'">
			<center><br><input type="submit" value="&nbsp;Editer" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></center>
			</form>
			</center></div><br>';
			 
break;
#########################################################################################################
#########################################################################################################
case "com_edit2":
		
	$idnews=$_POST['idcom'];
	$txt=trim(addslashes(htmlspecialchars($_POST['message'])));
	
	$sql = mysql_query("UPDATE ix_news_com SET texte='$txt' WHERE id=$idnews");
	rediriger("?page=admin/news");

break;
}
		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Administration des News");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");

?>
