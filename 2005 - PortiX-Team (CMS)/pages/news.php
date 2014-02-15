<?php

switch (@$_GET['action']) {
default:

	$sql=mysql_query('SELECT * FROM ix_news ORDER BY id DESC LIMIT '.$ixteam['nb_news']);
	while($data = mysql_fetch_object($sql)) {

	// Auteur :
		$sql_ps = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur");
		$_pseudo = mysql_fetch_object($sql_ps);
		if (empty($_pseudo->pseudo)) $pseudo="Inconnu";
		else $pseudo = '<a href="?page=profil&id='.$data->auteur.'">'.ucfirst($_pseudo->pseudo).'</a>';
		
	// Commentaires :
		$sql_com = mysql_query("SELECT id FROM ix_news_com WHERE idnews=".$data->id);
		$nbcom= mysql_num_rows($sql_com);
		$commentaire = '<a href="?page=news&action=detail&id='.$data->id.'">Poster un commentaire </a>('.$nbcom.')';
		
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
	$afficher->setVar($handle,"news.news_commentaires",$commentaire);
	$afficher->CloseSession($handle,"news");
	}

break;

#########################################################################################################
#########################################################################################################
case "archives":

	$texte='<div class="titreBS">Archive des News :</div><table width="100%">';

	$sql = mysql_query ("SELECT * FROM ix_news ORDER BY id DESC");
	while ($data=mysql_fetch_object($sql)) {
	
		// Auteur :
		$sql_ps = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->auteur");
		$_pseudo = mysql_fetch_object($sql_ps);
		if (empty($_pseudo->pseudo)) $pseudo="Inconnu";
		else $pseudo = '<a href="?page=profil&id='.$data->auteur.'">'.ucfirst($_pseudo->pseudo).'</a>';
		
	// Commentaires :
		$sql_com = mysql_query("SELECT id FROM ix_news_com WHERE idnews=".$data->id);
		$nbcom= mysql_num_rows($sql_com);
			
	// Date :
		$date1 = inverser_date(substr($data->date,0,10));
	
	// Cathégorie :
		$sql_cat =mysql_query("SELECT nom, image FROM ix_news_cat WHERE id=$data->cat");
		$_cat = mysql_fetch_object($sql_cat);

		$texte.="<tr><td width=50%> » <a href=\"?page=news&action=detail&id=$data->id\">$data->titre</a> ($nbcom)</td><td>Par $pseudo</td><td>Le $date1</td></tr>";
	}

		$texte.="</table>";
		
		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Archives");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");
break;

#########################################################################################################
#########################################################################################################
case "detail":

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
				
				
	//------------------------------------------------------------------------------			
	#### ECRIRE un commentaire
				
			#|#|#|#|# Version 2 #|#|#|#|#
			$texte.='<center><br><input type="button" name="Submit" value="&nbsp;Poster un commentaire" class="case_inscript" onclick="afficher()"></center>
					 <div id="poster_com" style="display:none"><a onclick="cacher()"><img src="images/croix.gif" style="float:right; cursor:pointer"/></a><b>Poster un Commentaire</b><br /><br />';
				
				if (!isset($_SESSION['sess_pseudo'])) { 
					$texte.="<center><font color=#FF0000>Vous devez être enregistré pour poster un commentaire.<br><br></center>"; }
				else  { 
					$texte.='<center>
					<form name="post" method="post" action="?page=news&action=post_com">
					
						<img src="images/bbcode/tb_bold.gif" width="24" height="24" onclick="bbstyle(0)" onMouseOver="helpline(\'b\'); this.src=\'images/bbcode/tb_bold_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_bold.gif\'" onMouseDown="this.src=\'images/bbcode/tb_bold_down.gif\'; ">
						<img src="images/bbcode/tb_italic.gif" width="24" height="24" onclick="bbstyle(2)" onMouseOver="helpline(\'i\'); this.src=\'images/bbcode/tb_italic_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_italic.gif\'" onMouseDown="this.src=\'images/bbcode/tb_italic_down.gif\'; ">
						<img src="images/bbcode/tb_underline.gif" width="24" height="24" onclick="bbstyle(4)" onMouseOver="helpline(\'u\'); this.src=\'images/bbcode/tb_underline_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_underline.gif\'" onMouseDown="this.src=\'images/bbcode/tb_underline_down.gif\'; ">&nbsp;&nbsp;
						<img src="images/bbcode/tb_hyperlink.gif" width="24" height="24" onclick="bbstyle(16)" onMouseOver="helpline(\'w\'); this.src=\'images/bbcode/tb_hyperlink_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_hyperlink.gif\'" onMouseDown="this.src=\'images/bbcode/tb_hyperlink_down.gif\'; ">
						<img src="images/bbcode/tb_image_insert.gif" width="24" height="24" onclick="bbstyle(14)" onMouseOver="helpline(\'p\'); this.src=\'images/bbcode/tb_image_insert_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_image_insert.gif\'" onMouseDown="this.src=\'images/bbcode/tb_image_insert_down.gif\'; ">&nbsp;&nbsp;
						<img src="images/bbcode/tb_left.gif" width="24" height="24" onclick="bbstyle(18)" onMouseOver="helpline(\'l\'); this.src=\'images/bbcode/tb_left_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_left.gif\'" onMouseDown="this.src=\'images/bbcode/tb_left_down.gif\'; ">
						<img src="images/bbcode/tb_center.gif" width="24" height="24" onclick="bbstyle(20)" onMouseOver="helpline(\'m\'); this.src=\'images/bbcode/tb_center_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_center.gif\'" onMouseDown="this.src=\'images/bbcode/tb_center.gif\'; ">
						<img src="images/bbcode/tb_right.gif" width="24" height="24" onclick="bbstyle(22)" onMouseOver="helpline(\'r\'); this.src=\'images/bbcode/tb_right_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_right.gif\'" onMouseDown="this.src=\'images/bbcode/tb_right_down.gif\'; ">
						<select name="addbbcode18" onChange="bbfontstyle(\'[color=\' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" onMouseOver="helpline(\'s\')" style="vertical-align:top">
							<option style="color:black; background-color: #FAFAFA" value="#444444">Couleur</option>
							<option style="color:darkred; background-color: #FAFAFA" value="darkred">Rouge foncé</option>
							<option style="color:red; background-color: #FAFAFA" value="red">Rouge</option>
							<option style="color:orange; background-color: #FAFAFA" value="orange">Orange</option>
							<option style="color:brown; background-color: #FAFAFA" value="brown">Marron</option>
							<option style="color:yellow; background-color: #FAFAFA" value="yellow">Jaune</option>
							<option style="color:green; background-color: #FAFAFA" value="green">Vert</option>
							<option style="color:olive; background-color: #FAFAFA" value="olive">Olive</option>
							<option style="color:cyan; background-color: #FAFAFA" value="cyan">Cyan</option>
							<option style="color:blue; background-color: #FAFAFA" value="blue">Bleu</option>
							<option style="color:darkblue; background-color: #FAFAFA" value="darkblue">Bleu foncé</option>
							<option style="color:indigo; background-color: #FAFAFA" value="indigo">Indigo</option>
							<option style="color:violet; background-color: #FAFAFA" value="violet">Violet</option>
							<option style="color:white; background-color: #FAFAFA" value="white">Blanc</option>
							<option style="color:black; background-color: #FAFAFA" value="black">Noir</option>
							</select><br>
							
					<input type="text" name="helpbox" size="45" maxlength="100" style="width:320px; font-size:10px; color:#FF6600" value="Astuce: Une mise en forme peut être appliquée au texte sélectionné." /><br>			
					<textarea name="message" id="newst" rows="10" wrap="virtual" cols="45" class="txt_comnews"></textarea><br>
					
					  <a href="javascript:emoticon(\'8-:\')"><img src="images/smileys/blink.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\'^:\')"><img src="images/smileys/CADQ0UD5.png" width="19" height="19" border="0" /></a>
					  <a href="javascript:emoticon(\':cool:\')"><img src="images/smileys/cool.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':pet:\')"><img src="images/smileys/cool40.gif" width="21" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':evil:\')"><img src="images/smileys/evil.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':D\')"><img src="images/smileys/06.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':bad:\')"><img src="images/smileys/128.gif" width="29" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':good:\')"><img src="images/smileys/ok.gif" width="21" height="21" border="0" /></a>
					  <a href="javascript:emoticon(\':lang:\')"><img src="images/smileys/130.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':rah:\')"><img src="images/smileys/32.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':??:\')"><img src="images/smileys/91.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':)\')"><img src="images/smileys/original.gif" width="18" height="18" border="0" /></a>
					  <a href="javascript:emoticon(\':scotch:\')"><img src="images/smileys/shutup.gif" width="20" height="20" border="0" /></a>
					  <a href="javascript:emoticon(\':intello:\')"><img src="images/smileys/smartass.gif" width="25" height="22" border="0" /></a>
					  <a href="javascript:emoticon(\':whaou:\')"><img src="images/smileys/w00t.gif" width="18" height="20" border="0" /></a> 
					  <a href="javascript:emoticon(\':!:\')"><img src="images/smileys/sign56.gif" width="20" height="20" border="0" /></a><br>
					
					<input type="hidden" name="idnews" value="'.$id.'">
					<center><br><input type="submit" value="&nbsp;Valider" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></center>
					</form>
					</center>';
			 }
			$texte.='</div><br>';

	//------------------------------------------------------------------------------		
	
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
			  <td width="105px"><b class="txt2"><center>'.$pseudo.$ip.'</center></b></td>
			  <td rowspan="2">'.stripslashes(nl2br(bbcode($com->texte))).'</td>
			</tr>
			<tr>
			  <td width="30%"><center><img src="'.$avatar.'" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'" /></center></td>
			</tr>
		  </table>';
	}
		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Les commentaires");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");

break;

#########################################################################################################
#########################################################################################################
case "post_com":
is_membre();
	
		if (empty($_POST['message'])) {
			message_redir("Erreur :\\n Votre commentaire est vide.","?page=news&action=detail&id=".$_POST['idnews']."");
		}
		
	$idnews=$_POST['idnews'];
	$idmbre=$_SESSION['sess_id'];
	$txt=trim(addslashes(htmlspecialchars($_POST['message'])));
	
	$sql = mysql_query("INSERT INTO ix_news_com (`idnews` , `idauteur` , `texte` ) VALUES ( '$idnews','$idmbre','$txt' )");
	rediriger("?page=news&action=detail&id=".$_POST['idnews']);
	
break;
}
?>