<?php

switch($_GET['act']) {
default:	

	securite_membre();
		$add='<style type="text/css" media="all">
		@import "include/effet/global.css";
		</style>		<script src="include/effet/prototype.js" type="text/javascript" ></script>
		<script src="include/effet/scriptaculous.js" type="text/javascript"></script>
		<script src="include/effet/jquery.js" type="text/javascript"></script>
		<script src="include/effet/thickbox.js" type="text/javascript"></script>
		<script src="include/script.js" type="text/javascript"></script>';
	head($add);
	
	$my_id=$_SESSION['sess_id'];

	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,members.username FROM mp LEFT JOIN members ON mp.id_exped=members.id_membre WHERE mp.id_dest=$my_id ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));

	$sql_new=mysql_query("SELECT count(id) as nb FROM mp WHERE `id_dest`=$my_id AND (`etat`='nouveau' OR `etat`='important'OR `etat`='auto')");
	$d1=mysql_fetch_object($sql_new);
	$nb2=round($d1->nb);


	echo '
	<div style="width:95%; margin-left:auto; margin-right:auto; background-color:#FFF; border:1px solid #666; padding:5px">
		
		<table style="width:100%; border:0; text-align:center"> 
			<tr>
				<td width="33%"><a href="javascript:listeMsg()" OnCLick="listeMsg()"><img src="images/inbox/mp_in.png" name="img3" onMouseOver= "if (document.images) document.img3.src=\'images/inbox/mp_in2.png\';" onMouseOut= "if (document.images) document.img3.src=\'images/inbox/mp_in.png\';"></a></td>
				<td width="34%"><a href="javascript:writeMsg()" OnCLick="writeMsg()"><img src="images/inbox/mp_ecrire.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/inbox/mp_ecrire2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/inbox/mp_ecrire.png\';"></a></td>
				<td width="33%"><a href="javascript:listeHist()" OnCLick="listeHist()"><img src="images/inbox/mp_sent.png" name="img2" onMouseOver= "if (document.images) document.img2.src=\'images/inbox/mp_sent2.png\';" onMouseOut= "if (document.images) document.img2.src=\'images/inbox/mp_sent.png\';"></a></td>
			</tr>
			<tr>
				<td><div class="menuinbox" style="margin-top:5px"><a href="javascript:listeMsg()" OnCLick="listeMsg()" style="display:block; width:90%">Mes messages ('.$nb2.')</a></div></td>
				<td><div class="menuinbox" style="margin-top:5px"><a href="javascript:writeMsg()" OnCLick="listeMsg()"style="display:block; width:90%">Ecrire un message</a></div></td>
				<td><div class="menuinbox" style="margin-top:5px"><a href="javascript:listeHist()" OnCLick="listeHist()" style="display:block; width:90%">Historique</a></div></td>
		</table><br>
		
	<div id="messagerie" style="width:100%">
		<center style="color:#555">Vous avez <span style="color:#F0F">'.$nb1.'</span> messages dont <span style="color:#F0F">'.$nb2.'</span> nouveaux messages<br><br>
			<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>';
		
		if ($nb1!=0) {
			echo '<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td width="28"> </td>
						<td style="text-align:left; color:#0066FF" width="200">Sujet</td>
						<td width="75" style="color:#0066FF">Auteur</td>
						<td width="75" style="color:#0066FF"><center>Date</td>
						<td width="30"> </td>
					</tr>
	';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
			
				if ($data->etat=="nouveau") $etat = "icon_new.png";
				if ($data->etat=="important") $etat = "icon_fav.png";
				if ($data->etat=="lu") $etat = "icon_lu.png";
				if ($data->etat=="auto") $etat = "icon_auto.png";
				
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				echo'<tr>
						<td style="border-left:3px solid #0099FF;"><img src="images/inbox/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" Onclick="viewMp('.$data->id.')">'.ucfirst(stripslashes($data->sujet)).'</a></td>
						<td id="linkpseudo"><a href="?p=infos&username='.$data->username.'" >'.ucfirst($data->username).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
						<td><a href="pages/membre/inbox.php?act=suppr&id='.$data->id.'&height=130&width=220" title="ajax" class="thickbox"><img src="images/inbox/agt_stop.png"></a></td>
					</tr>';
			}
			
			echo '</table><br>
			<div style="width:408px; padding:2px; border:1px solid #0088FF;">
						<img src="images/inbox/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
		<img src="images/inbox/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
		<img src="images/inbox/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
		<img src="images/inbox/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div>';
		}
		

	echo '</div>
		
</div>
	<div style="display:none" class="preload"><img src="images/inbox/mp_in2.png"><img src="images/inbox/mp_ecrire2.png";><img src="images/inbox/mp_sent2.png";></div>';
	foot();
	
break;	
##############################################################################################
##############################################################################################
case "suppr";

	 // variables et fonctions indispensables ... bricolage pas trés correct !
	session_start();
	include '../../include/config.inc.php';
	
	$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
	mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");
		function ip() {
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
			elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
			else {$ip = $_SERVER['REMOTE_ADDR']; }
			return $ip; }
		function securite_membre() { // Vérifie de façon sécurisée que l'utilisateur est loggué en tant que membre
			if (!isset($_SESSION['sess_pseudo'])) { rediriger('?p=erreur&code=01'); } 
			$sql = mysql_query("SELECT ip FROM members WHERE username='" . $_SESSION['sess_pseudo'] . "'");
			$result = mysql_fetch_object($sql);
			if ($result->ip != ip()) { rediriger('?p=erreur&code=02'); } }
	securite_membre();
		
	echo "
		<img src='images/title/confirm_suppr.png'>
		<div style='width:220px; height:129px; background-image:url(images/title/bgfond2.png);'>
			<div style='padding:2px; text-align:center'><br><center>Etes vous sur de vouloir supprimer ce message priv&eacute; ? </center><br><br>
				<table width=100%>
					<tr>
						<td width=43% align='right'><div class='envoyer' id='send' style='width:50px;' OnClick='supprMp(".$_GET['id'].")'>OUI&nbsp;</div></td>
						<td width=14%>&nbsp;</td>
						<td width=43% align='left'><div class='envoyer' id='TB_closeWindowButton' style='width:50px;'>NON</div></td>
					</tr>
				</table>
				<img id='img_attente' src='images/indicator.gif' style='display:none;padding-top:4px; margin-left:auto; margin-right:auto'>
			</div>
		</div>";
break;

}


?>