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

case "suppr":

	echo "
		<img src='images/title/confirm_suppr.png'>
		<div style='width:220px; height:129px; background-image:url(images/title/bgfond2.png);'>
			<div style='padding:2px; text-align:center'><br><center>Etes vous sur de vouloir supprimer cette photo de votre galerie ? </center><br><br>
				<table width=100%>
					<tr>
						<td width=43% align='right'><div class='envoyer' id='send' style='width:50px;' ><a href='?p=membre/galerie&act=suppr&id=".$_GET['id']."'>OUI</a>&nbsp;</div></td>
						<td width=14%>&nbsp;</td>
						<td width=43% align='left'><div class='envoyer' id='TB_closeWindowButton' style='width:50px;'>NON</div></td>
					</tr>
				</table>
				<img id='img_attente' src='images/indicator.gif' style='display:none;padding-top:4px; margin-left:auto; margin-right:auto'>
			</div>
		</div>";
break;

case "majdes";

	$mess=htmlspecialchars(addslashes($_GET['mess']));
	$id=htmlspecialchars(round($_GET['id']));
	
	$sql=mysql_query("UPDATE photos SET description='".$mess."' WHERE id=$id AND id_membre=".$_SESSION['sess_id']);
	echo 'ok';
	
break;	


}
?>