<?php
is_membre();

switch (@$_GET['action']) {

default:

		$sql_nbnew = mysql_query("SELECT * FROM ix_mp WHERE id_dest=".$_SESSION['sess_id']." AND etat='nouveau'");
		$nb_new = mysql_num_rows($sql_nbnew);
		
		$sql_nbtot = mysql_query("SELECT * FROM ix_mp WHERE id_dest=".$_SESSION['sess_id']);
		$nb_tot = mysql_num_rows($sql_nbtot);

		$sql = mysql_query("SELECT * FROM ix_mp WHERE id_dest=".$_SESSION['sess_id']);
		
	$texte='<br><table width="300" align="center">
                    <tr>
                      <td align="center"><b class=\'txt2\'>MP Reçus</b></td>
                      <td align="center"><b class=\'txt2\'>Nouveau MP</b></td>
                      <td align="center"><b class=\'txt2\'>MP Envoyés</b></td>
                    </tr>
					<tr>
                      <td align="center" id="tdadmin"><a href="?page=mp"><img src="images/mp_inbox.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
                      <td align="center" id="tdadmin"><a href="?page=mp&action=ecrire"><img src="images/mp_ecrire.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></td>
                      <td align="center" id="tdadmin"><a href="?page=mp&action=mpsend"<img src="images/mp_send.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
                    </tr>
                  </table><br>
				  
			<center><br>Vous avez '.$nb_tot.' messages dont '.$nb_new.' nouveaux messages</center><br>';
			
	if ($nb_tot!=0) {
		$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
				  <tr>
					<td class="liste_titre" width=6%></td>
					<td class="liste_titre" style="text-align:left" width=50%>Sujet</td>
					<td class="liste_titre" width=20%>Auteur</td>
					<td class="liste_titre" width=20%>Date</td>
					<td class="liste_titre" width=4%></td>
				  </tr>';
			
		while ( $data = mysql_fetch_object($sql) ) {
		
				if ($data->etat=="nouveau") $etat = "new2.png";
				if ($data->etat=="important") $etat = "fav2.png";
				if ($data->etat=="lu") $etat = "lu2.png";
				if ($data->etat=="repondu") $etat = "rep2.png";
				
				$sql_aut = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->id_exped");
				$d2 = mysql_fetch_object($sql_aut);
				$pseudo=ucfirst($d2->pseudo);
				
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				$texte.="<tr>
							<td class='liste_txt'><img src=\"images/mp/$etat\"></td>
							<td class='liste_txt' style='text-align:left'><a href=\"?page=mp&action=lire&id=$data->id\">$data->sujet</a></td>
							<td class='liste_txt'><a href=\"?page=profil&action=detail&id=$data->id_dest\">$pseudo</a></td>
							<td class='liste_txt'>$date</td>
							<td class='liste_txt'><a href=\"?page=mp&action=suppr&id=$data->id\"><img src=\"images/suppr2.jpg\" border=0></a></td>
					    </tr>";	
		 		}
			
		$texte.='</table><br>
				<div style="background-color:#FFFFFF; border:1px solid #000000; color:#333333; padding-top:3px; padding-bottom:3px; width:90%; margin-left:auto; margin-right:auto">&nbsp;&nbsp;<font color="#FF0000">Status des messages</font> :  <img src=\'images/mp/new2.png\' align="absmiddle"> Nouveau &nbsp;<img src=\'images/mp/lu2.png\'  align="absmiddle"> Lu &nbsp;<img src=\'images/mp/fav2.png\' align="absmiddle"> Important &nbsp;<img src=\'images/mp/rep2.png\' align="absmiddle"> Réponse<br></div>';
	}
	
break;

#########################################################################################################
#########################################################################################################
case "suppr":

	$id=$_GET['id'];
	$idmbre=$_SESSION['sess_id'];
	
	$sql1 = "DELETE FROM ix_mp WHERE id=$id AND id_dest=$idmbre";
	$sql2 = mysql_query("SELECT * FROM ix_mp WHERE id_dest=$idmbre AND id=$id");
		$data = mysql_fetch_object($sql2);
		
		// Protection anti-intrus
		if (!empty($data->message)) { mysql_query($sql1); }
		else { message_redir("C'est pas gentil d'essayer de supprimer les messages des autres","?page=mp"); }
		
	rediriger("?page=mp");
break;

#########################################################################################################
#########################################################################################################
case "lire":

	$id=$_GET['id'];
	$idmbre=$_SESSION['sess_id'];
	
	$sql = mysql_query("SELECT * FROM ix_mp WHERE id_dest=$idmbre AND id=$id");
		$data = mysql_fetch_object($sql);

	// Protection anti-intrus
	if (empty($data->message)) { message_redir("C'est pas gentil d'essayer de lire les messages des autres","?page=mp"); }

	
		
		// Expéditeur
			$sql_exp = mysql_query("SELECT pseudo, niveau FROM ix_membres WHERE id=$data->id_exped");
			$d_exped = mysql_fetch_object($sql_exp);
			$exped = "<a href=\"?page=profil&id=$data->id_exped\">".ucfirst($d_exped->pseudo)."</a>";
			
			if ($d_exped->niveau==0) $niveau="Membre"; 
			if ($d_exped->niveau==1) $niveau="Modérateur"; 
			if ($d_exped->niveau==2) $niveau="Administrateur";
	
			$sql_avatar = mysql_query("SELECT avatar FROM ix_membres_detail WHERE id_mbre=$data->id_exped");
			$d_avatar = mysql_fetch_object($sql_avatar);
			$avatar = '<div style="margin:2px; float:right"><img src="'.$d_avatar->avatar.'" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"><br><b class="txt2"><center>'.$niveau.'</center></b></div>';
		
		// Sujet - Message
			$sujet = $data->sujet;
			$message = nl2br(stripslashes(bbcode($data->message)));
		
		// Date :
			$date1 = inverser_date(substr($data->date,0,10));
			$date2 = substr($data->date,11,2);
			$date3 = substr($data->date,14,2);
			$date = $date1." - ".$date2."h".$date3;
			
		// Etat :
			if ($data->etat=="nouveau") $etat="Nouveau Message";
			if ($data->etat=="lu") $etat="Message déjà lu";
			if ($data->etat=="important") $etat="Message important";
			if ($data->etat=="repondu") $etat="Conversation suivie";
			


			if ($data->etat=="nouveau") { $sql_etat2 = mysql_query("UPDATE ix_mp SET etat='lu' WHERE id=$id");  }

		
		$texte="$avatar<br>
				<span class='txt2'>Expéditeur :</span> $exped<br>
				<span class='txt2'>Date d'envoie :</span> $date<br>
				<span class='txt2'>Etat :</span> $etat<br><br><br><br>
				<span class='txt2'>Sujet :</span> <b>$sujet</b><br><br>
				<span class='txt2'>Message :</span><br><br>$message<br>
				
				<br><div id='barresouligner'></div><br>
				<center><input type='button' value='&nbsp;Répondre' class='case_inscript' style='width:100px' onmouseover='this.style.border=\"1px solid #73BEF7\"' onmouseout='this.style.border=\"1px solid #666666\"' OnClick='document.location=\"?page=mp&action=repondre&id=$id\"'> &nbsp;&nbsp;<input type='button' value='&nbsp;Effacer' style='width:100px' class='case_inscript' onmouseover='this.style.border=\"1px solid #73BEF7\"' onmouseout='this.style.border=\"1px solid #666666\"' OnClick='document.location=\"?page=mp&action=suppr&id=$id\"'> &nbsp;&nbsp;<input type='button' value='&nbsp;Retour' style='width:100px' class='case_inscript' onmouseover='this.style.border=\"1px solid #73BEF7\"' onmouseout='this.style.border=\"1px solid #666666\"'  OnClick='history.back()'></center>";

break;

#########################################################################################################
#########################################################################################################
case "ecrire":

		$sql = mysql_query("SELECT id, pseudo FROM ix_membres");

		$texte='<br><table width="300" align="center">
				<tr>
				  <td align="center"><b class=\'txt2\'>MP Reçus</b></td>
				  <td align="center"><b class=\'txt2\'>Nouveau MP</b></td>
				  <td align="center"><b class=\'txt2\'>MP Envoyés</b></td>
				</tr>
				<tr>
				  <td align="center" id="tdadmin"><a href="?page=mp"><img src="images/mp_inbox.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
				  <td align="center" id="tdadmin"><a href="?page=mp&action=ecrire"><img src="images/mp_ecrire.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></td>
				  <td align="center" id="tdadmin"><a href="?page=mp&action=mpsend"<img src="images/mp_send.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
				</tr>
			  </table><br><div id="barresouligner"></div><br>';

			// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

		$texte.=' <center>
				<form name="post" method="post" action="?page=mp&action=ecrire2">
				Destinataire <!-- [<a href="#" OnClick="window.open(\'?page=profil&action=search\', \'titre\', \'resizable=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,width=340,height=300,top=50,left=50\')">Rechercher</a>]--><br>
				<!-- <input name="dest" class="case_inscript" size="20" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:center" value=""><br>-->
				<select name="dest" style="color:#FF6600; text-align:center">
				<option value=""></option>';
					
		while ($data = mysql_fetch_object($sql) ) {
			$texte.='<option value="'.$data->id.'" style="color:#0066FF; text-align:center">'.ucfirst($data->pseudo).'</option>
			';
		}
		$texte.='
					</select><br>
					<br>Sujet du message privé<br>
					<input name="titre" class="case_inscript" size="45" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:center" value="'.@$_SESSION['titre'].'"><br><br>
					<br>
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
				
					<textarea name="message" id="newst" rows="10" wrap="virtual" cols="45" class="txt_comnews" style="border:1px solid #000000">'.@$_SESSION['message'].'</textarea><br>
					
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
					
					<center><br><input type="submit" value="&nbsp;Envoyer" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></center>
					</form>
					</center>';
			unset ( $_SESSION['titre'] );
			unset ( $_SESSION['texte'] );

break;

#########################################################################################################
#########################################################################################################
case "ecrire2":

	if ( empty($_POST['dest']) ||  empty($_POST['message']) ||  empty($_POST['titre']) ) {
		$_SESSION['message'] = "<center>Tous les champs doivent être obligatoirement remplis</center>";
		$_SESSION['titre'] = $_POST['titre'];
		$_SESSION['texte'] = $_POST['message'];
		rediriger("?page=mp&action=ecrire");
	}
	
	$idexped = $_SESSION['sess_id'];
	$iddest = intval($_POST['dest']);
	$sujet = htmlspecialchars($_POST['titre']);
	$message = trim(addslashes(htmlspecialchars($_POST['message'])));
	$date = date("Y-m-d H:m:s");
	$ip = $_SERVER['REMOTE_ADDR'];

		$sql = mysql_query("INSERT INTO ix_mp (`id_exped`,`id_dest`,`sujet`,`message`,`date`, `ip` ) VALUES ( '$idexped' , '$iddest' , '$sujet' , '$message' , '$date', '$ip') ");
		rediriger("?page=mp");
break;	


#########################################################################################################
#########################################################################################################
case "repondre":

	$id = $_GET['id'];
	$idmbre=$_SESSION['sess_id'];

	$sql = mysql_query("SELECT * FROM ix_mp WHERE id_dest=$idmbre AND id=$id");
		$data = mysql_fetch_object($sql);

	// Protection anti-intrus
	if (empty($data->message)) { message_redir("C'est pas gentil d'essayer de lire les messages des autres","?page=mp"); }
		
		// Expéditeur
			$sql_dest = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->id_exped");
			$d_dest = mysql_fetch_object($sql_dest);
			$dest = ucfirst($d_dest->pseudo);
					
		// Sujet - Message
			$titre = "Re : ".$data->sujet;
			$message = "
--------------------------------------------------
[i]Message original :[/i]

".stripslashes($data->message)."";
	
		$texte='<br><table width="300" align="center">
				<tr>
				  <td align="center"><b class=\'txt2\'>MP Reçus</b></td>
				  <td align="center"><b class=\'txt2\'>Nouveau MP</b></td>
				  <td align="center"><b class=\'txt2\'>MP Envoyés</b></td>
				</tr>
				<tr>
				  <td align="center" id="tdadmin"><a href="?page=mp"><img src="images/mp_inbox.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
				  <td align="center" id="tdadmin"><a href="?page=mp&action=ecrire"><img src="images/mp_ecrire.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></td>
				  <td align="center" id="tdadmin"><a href="?page=mp&action=mpsend"<img src="images/mp_send.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
				</tr>
			  </table><br><div id="barresouligner"></div><br>';

			// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

		$texte.=' <center>
				<form name="post" method="post" action="?page=mp&action=repondre2">
					Destinataire <!-- [<a href="#" OnClick="window.open(\'?page=profil&action=search\', \'titre\', \'resizable=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,width=340,height=300,top=50,left=50\')">Rechercher</a>]--><br>
					<input class="case_inscript" size="20" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:center" value="'.$dest.'" readonly="">
					<input type="hidden" name="dest" value="'.$data->id_exped.'"><br>
					<br>Sujet du message privé<br>
					<input name="titre" class="case_inscript" size="45" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" style="text-align:center" value="'.$titre.'"><br><br>
					<br>
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
				
					<textarea name="message" id="newst" rows="10" wrap="virtual" cols="45" class="txt_comnews" style="border:1px solid #000000">'.$message.'</textarea><br>
					
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
					
					<center><br>
					<input type="hidden" name="idrep" value="'.$id.'">
					<input type="submit" value="&nbsp;Envoyer" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"></center>
					</form>
					</center>';
			unset ( $_SESSION['titre'] );
			unset ( $_SESSION['texte'] );

break;

#########################################################################################################
#########################################################################################################
case "repondre2":

	$id = $_POST['idrep'];
	$idmbre=$_SESSION['sess_id'];

	$sqlverif = mysql_query("SELECT * FROM ix_mp WHERE id_dest=$idmbre AND id=$id");
		$verif = mysql_fetch_object($sqlverif);

	// Protection anti-intrus
	if (empty($verif->message)) { message_redir("C'est pas gentil d'essayer de lire les messages des autres","?page=mp"); }

	
	$idexped = $_SESSION['sess_id'];
	$iddest = intval($_POST['dest']);
	$sujet = htmlspecialchars($_POST['titre']);
	$message = addslashes(htmlspecialchars($_POST['message']));
	$date = date("Y-m-d H:m:s");
	$ip = $_SERVER['REMOTE_ADDR'];

		$sql = mysql_query("INSERT INTO ix_mp (`id_exped`,`id_dest`,`sujet`,`message`,`date`, `ip` ) VALUES ( '$idexped' , '$iddest' , '$sujet' , '$message' , '$date', '$ip') ");
		$sql_etat = mysql_query("UPDATE ix_mp SET etat='repondu' WHERE id=$id"); 

		rediriger("?page=mp");
break;	

#########################################################################################################
#########################################################################################################
case "mpsend":

		$sql_nbnew = mysql_query("SELECT * FROM ix_mp WHERE id_exped=".$_SESSION['sess_id']);
		$nb_new = mysql_num_rows($sql_nbnew);
		
		$sql = mysql_query("SELECT * FROM ix_mp WHERE id_exped=".$_SESSION['sess_id']);
		
	$texte='<br><table width="300" align="center">
                    <tr>
                      <td align="center"><b class=\'txt2\'>MP Reçus</b></td>
                      <td align="center"><b class=\'txt2\'>Nouveau MP</b></td>
                      <td align="center"><b class=\'txt2\'>MP Envoyés</b></td>
                    </tr>
					<tr>
                      <td align="center" id="tdadmin"><a href="?page=mp"><img src="images/mp_inbox.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
                      <td align="center" id="tdadmin"><a href="?page=mp&action=ecrire"><img src="images/mp_ecrire.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></td>
                      <td align="center" id="tdadmin"><a href="?page=mp&action=mpsend"<img src="images/mp_send.png" width="64" height="64" border="0" style="border:1px solid #000000; background-color:#FFFFFF; padding:3px" onMouseover="this.style.border=\'1px solid #0099FF\'" onMouseout="this.style.border=\'1px solid #000000\'"/></div></td>
                    </tr>
                  </table><br>
				  
			<center><br>Vous avez déjà envoyé '.$nb_new.' messages</center><br>';
			
	if ($nb_new!=0) {
		$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
				  <tr>
					<td class="liste_titre" width=6%></td>
					<td class="liste_titre" style="text-align:left" width=50%>Sujet</td>
					<td class="liste_titre" width=22%>Destinataire</td>
					<td class="liste_titre" width=22%>Date</td>
				  </tr>';
			
		while ( $data = mysql_fetch_object($sql) ) {
		
				if ($data->etat=="nouveau") $etat = "new2.png";
				if ($data->etat=="important") $etat = "fav2.png";
				if ($data->etat=="lu") $etat = "lu2.png";
				if ($data->etat=="repondu") $etat = "rep2.png";
				
				$sql_aut = mysql_query("SELECT pseudo FROM ix_membres WHERE id=$data->id_dest");
				$d2 = mysql_fetch_object($sql_aut);
				$pseudo=ucfirst($d2->pseudo);
				
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				$texte.="<tr>
							<td class='liste_txt'><img src=\"images/mp/$etat\"></td>
							<td class='liste_txt' style='text-align:left'><a href=\"?page=mp&action=lire&id=$data->id\">$data->sujet</a></td>
							<td class='liste_txt'><a href=\"?page=profil&action=detail&id=$data->id_dest\">$pseudo</a></td>
							<td class='liste_txt'>$date</td>
							
					    </tr>";	
		 		}
			
		$texte.='</table><br>
				<div style="background-color:#FFFFFF; border:1px solid #000000; color:#333333; padding-top:3px; padding-bottom:3px; width:90%; margin-left:auto; margin-right:auto">&nbsp;&nbsp;<font color="#FF0000">Status des messages</font> :  <img src=\'images/mp/new2.png\' align="absmiddle"> Nouveau &nbsp;<img src=\'images/mp/lu2.png\'  align="absmiddle"> Lu &nbsp;<img src=\'images/mp/fav2.png\' align="absmiddle"> Important &nbsp;<img src=\'images/mp/rep2.png\' align="absmiddle"> Réponse<br></div>';
	}
	
break;



}

		$afficher->AddSession($handle, "contenu");
		$afficher->setVar($handle, "contenu.module_titre", "Messagerie de ".ucfirst($_SESSION['sess_pseudo']));
		$afficher->setVar($handle, "contenu.module_texte", $texte );
		$afficher->CloseSession($handle, "contenu"); 

?>