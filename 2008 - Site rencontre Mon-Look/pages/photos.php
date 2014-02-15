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
	new Effect.BlindUp("logOn", { duration:.8});
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth ");
	}
	</script>';
	


echo '<script language=JavaScript> m=\'%3Cbr%3E%3Cbr%3E%3Ccenter%3E%3Cb%20style%3D%22font-size%3A14px%3B%20%22%3EAvant%20de%20rentrer%20dans%20votre%20espace%20personnel%2C%20merci%20de%20bien%20vouloir%20soutenir%20le%20site%20en%20visisant%20le%20site%20de%20notre%20partenaire%3C/b%3E%3C/center%3E%3Cbr%3E%3Cbr%3E%3Cbr%3E%0A%3Cdiv%20class%3D%22round%22%20style%3D%22background-color%3A%23FFFFFF%3B%20%20width%3A400px%3Btext-align%3Acenter%3B%20margin-left%3Aauto%3B%20margin-right%3Aauto%22%20id%3D%22part%22%3E%0A%09%3Cb%20style%3D%22color%3A%230099FF%3B%20font-size%3A15px%22%3EPartenaire%3C/b%3E%3Cbr%3E%3Cbr%3E%20%3Ca%20href%3D%22%23%22%20OnClick%3D%22clickk%28%29%3B%20return%20false%22%3E%0A%09%3Cimg%20src%3D%22http%3A//action.metaffiliation.com/suivi.php%3Fmaff%3DS341B443B91120%22%20border%3D%220%22%3E%3C/a%3E%0A%3Cbr%3E%0A%09%3Cp%3EUne%20%3Cb%3Eclic%3C/b%3E%20sur%20cette%20banni%E8re%20et%20ensuite%20un%20%3Cb%20style%3D%22color%3A%23F33%22%3Eclic%20dans%20le%20site%3C/b%3E%20qui%20va%20s%27ouvrir.%20Merci%20%21%0A%3C/p%3E%3C/div%3E%3Cbr%3E%3Cbr%3E%0A%0A%3Cdiv%20class%3D%22round%22%20style%3D%22background-color%3A%23FFFFFF%3B%20width%3A400px%3B%20padding%3A5px%3B%20text-align%3Acenter%3B%20margin-left%3Aauto%3B%20margin-right%3Aauto%3B%20display%3Anone%22%20id%3D%22lien%22%3E%0A%09%3Cbr%3E%3Cbr%3E%3Ca%20href%3D%22%3Fp%3Dmembre/home%22%3E%3Cb%20style%3D%22color%3A%230099FF%22%3EEntrer%3C/b%3E%3C/a%3E%3Cbr%3E%3Cbr%3E%3Cbr%3E%0A%3C/div%3E%3Cbr%3E%3Cbr%3E\';d=unescape(m);document.write(d);</script>';


foot();

?>