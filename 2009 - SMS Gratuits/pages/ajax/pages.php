<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
security();

switch(@$_GET['p']) {
case "home":

if ($_SESSION['sess_pseudo']!="demo") {
	$sql1=mysql_query("SELECT * FROM stats");
	$d1=mysql_fetch_object($sql1);
	$sql2=mysql_query("SELECT jour, mois, total FROM membres WHERE id=".$_SESSION['sess_id']);
	$d2=mysql_fetch_object($sql2);
	
	mt_srand((float) microtime()*1000000);
	$number=mt_rand(0, 3)+1; 
	

	// Protection : Génération d'une Key pour vérifier le click //
	$key=genKey(10); 	
	$pre=mysql_query("SELECT `key_click` FROM secure WHERE sess_id=".$_SESSION['sess_id']);
	$nb=mysql_num_rows($pre);
	if ($nb==0)
		$sql=mysql_query("INSERT INTO secure (`sess_id`, `key_click`, `click` ) VALUES ('".$_SESSION['sess_id']."','$key','0')") or die (mysql_error());
	else 
		$sql=mysql_query("UPDATE secure SET `key_click`='$key', `click`='0' WHERE sess_id=".$_SESSION['sess_id']);
	
	
  echo 'OK|:| Nifty("div.roundall", "smooth");Nifty("div.roundstat", "smooth");Nifty("div.roundpub", "smooth"); |:| 
  
  <h2>Envoyer des SMS gratuitement</h2><br /><br />
  
  <div style="height:565px !important; height:590px">
  
  	<div class="left">
	
	  <div class="roundall">
	  	<h3>Etape 1/3</h3>
		<form name="send" action="#" method="post">
			
			Numéro du destinataire<br/>
			<input type="text" name="num" id="num" style="width:110px" maxlength="10" onKeypress="return valid_mail(event);" onBlur="verifNum()" /> <a href="#" onclick="ajouterNum(); return false" title="Ajouter ce numéro dans mon répertoire"><img src="images/plus.png" style="vertical-align:middle"></a> <br />
			<a href="#" onclick="afficherRep(); return false" title="Afficher mon répertoire"><img src="images/repertoire.png" style="vertical-align:bottom"></a><br/><br/>
			
			<div id="liens_repertoire"></div>

			Message<br/>
			<textarea style="width:250px; height:85px" name="mess" id="mess" onKeyPress="return limit(event);";></textarea><br/>
			<div id="limit">0/160</div>
			
			<br/><br/>
		</form>
	  </div>
	   
	  <div class="roundpub" id="etape2">
	  	<h3>Etape 2/3</h3>
		Comme vous vous en doutez, on ne me donne pas les SMS, je dois <b>les payer</b>.<br /><br />
		Si vous voulez que je continue à vous proposer ce service <b>gratuitement</b>, vous devez <b>absolument cliquer</b> sur une des bannières publicitaires présentes dans la page ci-dessous<br /><br/> 
		
		»  <b><a href="#" onclick="etape2('.$number.'); return false">Ouvrir la page</a></b>  «<br/><br />
		<em>Cliquez ici pour ouvrir la page avec les bannières publicitaires et passer à <b>l\'étape 3/3</b>.</em><br /><br />
	  </div>		
	  
	 </div>
	 
	  <div class="roundstat" >
		
		  <strong>Stats perso</strong> <br /><br />
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:90%;"><u>Sms total</u></td>   <td><b>'.$d2->total.'</b></td>   </tr>
		  	<tr>   <td><u>Sms aujourd\'hui </u></td>    <td><b>'.$d2->jour.'</b></td>   </tr>
		  	<tr>   <td><u>Sms ce mois </u></td>   <td><b>'.$d2->mois.'</b></td>   </tr>
		   </table><br />
		   
		  <strong>Stats générales</strong> <br /><br /> 
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:90%;"><u>Sms total</u></td>   <td><b>'.$d1->total.'</b></td>   </tr>
		  	<tr>   <td><u>Sms aujourd\'hui </u></td>    <td><b>'.$d1->jour.'</b></td>   </tr>
		  	<tr>   <td><u>Sms ce mois </u></td>   <td><b>'.$d1->mois.'</b></td>   </tr>
		   </table><br />
		   
		  <strong>Banque</strong> <br /><br /> 
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:75%;"><u>Stock</u></td>   <td><b>'.$d1->stock.'sms</b></td>   </tr>
		  	<tr>   <td><u>Finance </u></td>    <td style="text-align:center"><b class="rouge">-||||</b><b class="orange">||</b><b class="vert">-</b></td>   </tr>
		   </table><br />
		
	</div>
		
		<p class="deconnexion">
			<a href="#" onclick="deco(); return false" title="Deconnexion de Sms By YoTsumi"><img src="images/deco1.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/deco2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/deco1.png\';"></a><br />
			<a href="#" onclick="deco(); return false" title="Deconnexion de Sms By YoTsumi"><strong>Deconnexion</strong><br /><em>'.ucfirst($_SESSION['sess_pseudo']).'</em></a>
		</p>
 </div><div style="display:none;" id="timestamp">'.$key.'-'.$_SESSION['sess_id'].'</div>';

} else { /* PAGE SPECIAL DEMO */

	$sql1=mysql_query("SELECT * FROM stats");
	$d1=mysql_fetch_object($sql1);
	$sql2=mysql_query("SELECT jour, mois, total FROM membres WHERE id=".$_SESSION['sess_id']);
	$d2=mysql_fetch_object($sql2);
	
	if ($d2->jour==1) $onload="demoQuotat()";

  echo 'OK|:| Nifty("div.roundall", "smooth");Nifty("div.roundstat", "smooth");Nifty("div.roundpub", "smooth"); '.@$onload.'|:| 
  
  <h2>Envoyer des SMS gratuitement</h2><br /><br />
  
  <div style="height:430px !important; height:570px">
  
  	<div class="left">
	
	  <div class="roundall">
	  	<h3>Formulaire spécial Démo</h3>
		<form name="send" action="#" method="post">
			
			Numéro du destinataire<br/>
			<input type="text" name="num" id="num" style="width:110px" maxlength="10" onKeypress="return valid_mail(event);" onBlur="verifNum()" /><br/><br/>
			
			Message<br/>
			<textarea style="width:250px; height:85px" name="mess" id="mess" onKeyPress="return limit(event);";></textarea><br/>
			<div id="limit">0/160</div>
			
			<br/>
			
			<div id="envoyer" class="envoyer" style="width:130px"><a href="#" onclick="sendSmsDemo(); return false" class="envoyer">Envoyer le SMS</a></div>
			<div id="wait2"><img src="images/barre.gif"><br/><em style="color:#777">Traitement en cours</em><br /><br /></div>
		</form>
	  </div>	 
	</div>
	 
	  <div class="roundstat" >
		
		  <strong>Stats perso</strong> <br /><br />
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:90%;"><u>Sms total</u></td>   <td><b>'.$d2->total.'</b></td>   </tr>
		  	<tr>   <td><u>Sms aujourd\'hui </u></td>    <td><b>'.$d2->jour.'</b></td>   </tr>
		  	<tr>   <td><u>Sms ce mois </u></td>   <td><b>'.$d2->mois.'</b></td>   </tr>
		   </table><br />
		   
		  <strong>Stats générales</strong> <br /><br /> 
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:90%;"><u>Sms total</u></td>   <td><b>'.$d1->total.'</b></td>   </tr>
		  	<tr>   <td><u>Sms aujourd\'hui </u></td>    <td><b>'.$d1->jour.'</b></td>   </tr>
		  	<tr>   <td><u>Sms ce mois </u></td>   <td><b>'.$d1->mois.'</b></td>   </tr>
		   </table><br />
		   
		  <strong>Banque</strong> <br /><br /> 
		  <table style="width:130px; margin-left:10px" cellpadding="0" cellmargin="0">
		  	<tr>   <td style="width:75%;"><u>Stock</u></td>   <td><b>'.$d1->stock.'sms</b></td>   </tr>
		  	<tr>   <td><u>Finance </u></td>    <td style="text-align:center"><b class="rouge">-||||</b><b class="orange">||</b><b class="vert">-</b></td>   </tr>
		   </table><br />
		
	</div>
		
		<p class="deconnexion">
			<a href="#" onclick="deco(); return false" title="Deconnexion de Sms By YoTsumi"><img src="images/deco1.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/deco2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/deco1.png\';"></a><br />
			<a href="#" onclick="deco(); return false" title="Deconnexion de Sms By YoTsumi"><strong>Deconnexion</strong><br /><em>'.ucfirst($_SESSION['sess_pseudo']).'</em></a>
		</p>
 </div>';




}
break;
case "etape3":
	
// Protection : Pas envoyer 2 messages avec la même requête //
	$key=genKey(15); 	
	$pre=mysql_query("SELECT `key` FROM secure WHERE sess_id=".$_SESSION['sess_id']);
	$nb=mysql_num_rows($pre);
	if ($nb==0)
		$sql=mysql_query("INSERT INTO secure (`sess_id`, `key` ) VALUES ('".$_SESSION['sess_id']."','$key')") or die (mysql_error());
	else 
		$sql=mysql_query("UPDATE secure SET `key`='$key' WHERE sess_id=".$_SESSION['sess_id']);

	echo '<h3>Etape 3/3</h3>
		Une nouvelle fenêtre vient de s\'ouvrir, merci de <b>cliquer<br /> sur une des bannières publicitaires</b> qui s\'y trouve.<br /><br />
		<em>Si vous ne le faites pas, tampis pour vous, je ne remplirais<br /> plus le stock de sms si je suis dans le rouge</em>
		<br /><br /><br />
		<div id="envoyer" class="envoyer" style="width:130px"><a href="#" onclick="sendSms(); return false" class="envoyer">ENVOYER LE SMS</a></div>
		<div id="wait2"><img src="images/barre.gif"><br/><em style="color:#777">Traitement en cours</em><br /><br /></div>
		<div id="date" style="display:none">'.$key.'</div><br /><br />';

break;
case "smsok":

if ($_GET['fraude']==1) { 
	$sql=mysql_query("SELECT fraude FROM membres WHERE id=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	$addJs="messFraude('".$d->fraude."');";
}
  echo 'OK|:| Nifty("div.roundok", "smooth"); '.@$addJs.'|:| 
  
  <h2>Envoyer des SMS gratuitement</h2><br /><br />
  <div style="height:220px">
	  <div class="roundok">
		<br />Votre SMS vers le numéro '.$_SESSION['sess_num']." a été envoyé <br/>avec succés !<br/></br><br />
		<em>Vous pouvez envoyer d'autres SMS gratuitement mais n'en abusez pas non plus !<br/><br />
		Merci</em><br/><br/><br />
		»  <b><a href='?home' title='Envoyer des SMS gratuits avec YoTsumi'>Envoyer un nouveau message</a></b>  «<br/><br />
	</div>";

break;
}
 

?>