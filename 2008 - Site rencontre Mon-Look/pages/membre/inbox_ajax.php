<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();


		function is_log() {
			if (isset($_SESSION['sess_pseudo'])) return 1;
			else return 0;
		}
		if (is_log()==0) { echo " Ta rien à foutre ici !"; exit; }

include '../../include/config.inc.php';
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");

switch($_GET['act']) {

case "supprmp":

	$id=round($_GET['id']);
	$sql=mysql_query("SELECT count(id) as nb FROM mp WHERE id_dest=".$_SESSION['sess_id']." AND id=$id");
	$dat=mysql_fetch_object($sql);
	if ($dat->nb!=1) { echo "error"; exit; }
	else {
		$sql2=mysql_query("DELETE FROM mp WHERE id_dest=".$_SESSION['sess_id']." AND id=$id");
		echo "ok";
	}
break;
##############################################################################################
##############################################################################################
case "listemsg": 

	$my_id=$_SESSION['sess_id'];
	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,members.username FROM mp LEFT JOIN members ON mp.id_exped=members.id_membre WHERE mp.id_dest=$my_id ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));
		
		if ($nb1!=0) {
			echo '<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>
			<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td width="28"> </td>
						<td style="text-align:left; color:#0066FF" width="200">Sujet</td>
						<td width="75" style="color:#0066FF">Auteur</td>
						<td width="75" style="color:#0066FF"><center>Date</td>
						<td width="30"> </td>
					</tr>';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
			
				if ($data->etat=="nouveau") $etat = "icon_new.png";
				if ($data->etat=="important") $etat = "icon_fav.png";
				if ($data->etat=="lu") $etat = "icon_lu.png";
				if ($data->etat=="auto") $etat = "icon_auto.png";
					    
				list($a, $m, $j) = explode("-", substr($data->date,0,10));
				$date1 = "$j.$m.$a";
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				echo'<tr>
						<td style="border-left:3px solid #0099FF;"><img src="images/inbox/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" Onclick="viewMp('.$data->id.')">'.ucfirst(stripslashes($data->sujet)).'</a></td>
						<td id="linkpseudo"><a href="?p=infos&username='.$data->username.'" >'.ucfirst($data->username).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
						<td><a href="#" OnClick="SupprMpNoBug('.$data->id.')"><img src="images/inbox/agt_stop.png"></a></td>
					</tr>';
			}
			
			echo '</table><br>
			<center><div style="width:408px; padding:2px; border:1px solid #0088FF;">
						<img src="images/inbox/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
		<img src="images/inbox/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
		<img src="images/inbox/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
		<img src="images/inbox/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center><br>';
		} else {
		echo '<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div><br><br><center><span style="color:#3399FF">Aucun message</span></center><br><br>';
		}
		
break;
##############################################################################################
##############################################################################################
case "viewmp";

	$id=$_GET['id'];
	$my_id=$_SESSION['sess_id'];
	
	$sql=mysql_query("SELECT mp.id,mp.id_exped,mp.sujet,mp.message,mp.etat,mp.date,members.username, members.img_principale, members.img_valid FROM mp LEFT JOIN members ON mp.id_exped=members.id_membre WHERE mp.id_dest=$my_id AND mp.id=$id") or die('Erreur de selection '.mysql_error());
	$data=mysql_fetch_object($sql);
	
	$sql2=mysql_query("UPDATE mp SET `etat`='lu' WHERE id=$id AND id_dest=$my_id");

	if (isset($data->img_principale) && ($data->img_valid==1)) $src="upload/principal/".$data->img_principale;
	else $src="images/profil/nophoto_little.png";
	
	list($a, $m, $j) = explode("-", substr($data->date,0,10));
	$date1 = "$j.$m.$a";
	$date2 = substr($data->date,11,2);
	$date3 = substr($data->date,14,2);
	$date = "Envoyé le ".$date1." à ".$date2."h".$date3;
	
	echo '<table style="border:1px dashed #0099FF; border-left:3px solid #0099FF; width:100%">
			<tr>
				<td rowspan=3 width="120" align="center" id="first"><a href="#">'.trim(ucfirst($data->username)).'</a><br><br>
					 <img src="'.$src.'" id="img2"><br><a href="#" OnClick="SupprMpNoBug('.$data->id.')" title="Supprimer" ><img src="images/inbox/button_cancel.png"></a> &nbsp;&nbsp; <a href="#" onClick="alert(\'Fonction non disponible pour le moment\nVous pouvez tout de même répondre à ce message en suivant le lien : \n-Ecrire un message- \' )"  title="Répondre"><img src="images/inbox/reply.png"></a></td>
				<td  align="center" style="height:15px;font-family:verdana; font-size:12px; color:#0066FF;">'.stripslashes($data->sujet).'</td>
			</tr>
			
				<tr><td>'.stripslashes($data->message).'</td></tr>
				<tr><td style="color:#555555; text-align:right; height:15px; vertical-align:bottom">'.$date.'</td></tr>
			
		</table><div id="wait"></div>';

break;
##############################################################################################
##############################################################################################
case "write";

	$sql=mysql_query("SELECT SQL_BIG_RESULT id_membre, username FROM members ORDER BY username ");
	while ($d=mysql_fetch_object($sql)) {
		@$liste.='<option value="'.$d->id_membre.'">'.ucfirst($d->username).'</option>';
	}
	echo '<table style="border:1px dashed #0099FF; border-left:3px solid #0099FF; width:100%" id="profil">
			<tr>
				<td style="width:85px;color:#555; vertical-align:top">Destinataire</td>
				<td><div id="wait" style="display:none; float:right; margin-right:23px"><img src="images/indicator2.gif"></div>
				<select name="dest" id="dest">
					  '.$liste.'
					</select>
					</td>
			</tr>
			<tr>
				<td style="color:#555; vertical-align:top">Sujet</td>
				<td><input type="text" name="sujet" id="sujet" maxlength="255"  style="width:291px" value=""></td>
			</tr>
			<tr>
				<td style="color:#555; vertical-align:top">Message<br></td>
				<td><textarea name="mess" id="mess" cols="42" rows="6" style="border-color:#777 #DDD #EEE #777;"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><div class="envoyer" id="send" style="width:135px;" OnClick="sendMsg()">Envoyer</div></td>
			</tr>
		</table>';

break;
##############################################################################################
##############################################################################################
case "write2";

		$exp=$_SESSION['sess_id'];
		$dest=(int)$_POST['dest'];
		$message=nl2br(addslashes(htmlspecialchars($_POST['mess'])));
		$sujet=addslashes(htmlspecialchars($_POST['sujet']));
		
				function ip() {
					if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
					elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
					else {$ip = $_SERVER['REMOTE_ADDR']; }
					return $ip;
				}

		$sql=mysql_query("INSERT INTO mp ( `id_exped` , `id_dest` , `sujet` , `message` , `date` , `ip` )  
								VALUES ('$exp' , '$dest', '$sujet' , '$message', NOW( ) , '".ip()."')");

		echo 'ok|:|<br><br><br><br><div style="width:100%; text-align:center"><b>Message envoyé avec succés</b><br><br><img src="images/indicator_arrows.gif"><br><i>Redirection en cours</i></div>';

break;
##############################################################################################
##############################################################################################
case "historique": 

	$my_id=$_SESSION['sess_id'];
	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,members.username FROM mp LEFT JOIN members ON mp.id_dest=members.id_membre WHERE mp.id_exped=$my_id ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));
		
		if ($nb1!=0) {
			echo '<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>
			<center style="color:#555">Historique de vos messages envoyés<br><br>
			<br><table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td width="28"> </td>
						<td style="text-align:left; color:#0066FF" width="230">Sujet</td>
						<td width="75" style="color:#0066FF">Auteur</td>
						<td width="75" style="color:#0066FF"><center>Date</td>
					</tr>';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
			
				if ($data->etat=="nouveau") $etat = "icon_new.png";
				if ($data->etat=="important") $etat = "icon_fav.png";
				if ($data->etat=="lu") $etat = "icon_lu.png";
				if ($data->etat=="auto") $etat = "icon_auto.png";
					    
				list($a, $m, $j) = explode("-", substr($data->date,0,10));
				$date1 = "$j.$m.$a";
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				echo'<tr>
						<td style="border-left:3px solid #0099FF;"><img src="images/inbox/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" Onclick="viewMpHist('.$data->id.')">'.ucfirst(stripslashes($data->sujet)).'</a></td>
						<td id="linkpseudo"><a href="?p=infos&username='.$data->username.'" >'.ucfirst($data->username).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
					</tr>';
			}
			
			echo '</table><br>
			<center><div style="width:408px; padding:2px; border:1px solid #0088FF;">
						<img src="images/inbox/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
		<img src="images/inbox/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
		<img src="images/inbox/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
		<img src="images/inbox/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center><br>';
		}
break;
##############################################################################################
case "viewmpHist";

	$id=$_GET['id'];
	$my_id=$_SESSION['sess_id'];
	
	$sql=mysql_query("SELECT mp.id,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,members.username, members.img_principale, members.img_valid FROM mp LEFT JOIN members ON mp.id_dest=members.id_membre WHERE mp.id_exped=$my_id AND mp.id=$id") or die('Erreur de selection '.mysql_error());
	$data=mysql_fetch_object($sql);
	
	if (isset($data->img_principale) && ($data->img_valid==1)) $src="upload/principal/".$data->img_principale;
	else $src="images/profil/nophoto.png";
	
	list($a, $m, $j) = explode("-", substr($data->date,0,10));
	$date1 = "$j.$m.$a";
	$date2 = substr($data->date,11,2);
	$date3 = substr($data->date,14,2);
	$date = "Envoyé le ".$date1." à ".$date2."h".$date3;
	
	echo '<table style="border:1px dashed #0099FF; border-left:3px solid #0099FF; width:100%">
			<tr>
				<td rowspan=3 width="120" align="center" id="first"><a href="#">'.trim(ucfirst($data->username)).'</a></td>
				<td  align="center" style="height:15px;font-family:verdana; font-size:12px; color:#0066FF;">'.stripslashes($data->sujet).'</td>
			</tr>
			
				<tr><td>'.stripslashes($data->message).'</td></tr>
				<tr><td style="color:#555555; text-align:right; height:15px; vertical-align:bottom">'.$date.'</td></tr>
			
		</table><div id="wait" style="height:0px"></div>';

break;



}
?>