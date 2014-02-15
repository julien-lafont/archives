<?php
	// Nifty Round
	$add='<link rel="stylesheet" type="text/css" href="include/effet/niftyCorners.css">
		<link rel="stylesheet" type="text/css" href="include/effet/niftyPrint.css" media="print">
		<script type="text/javascript" src="include/effet/nifty.js"></script>
		<script type="text/javascript" src="include/only_ajax.js"></script>
		
		<script type="text/javascript">
		function sendContact() {
			message=escape($(\'form_mess\').value);
			prenom=escape($(\'form_prenom\').value);
			email=escape($(\'form_email\').value);
			sujet=escape($(\'form_sujet\').value);
			if (prenom="" || email=="" || sujet=="" || message=="" ) { alert(\'Erreur : Tous les champs doivent être remplis !\');  }
			else {	
				$(\'wait\').style.display=\'block\';
				round();
				ajaxPostA(\'pages/contact.php?act=send\',\'prenom=\'+prenom+\'&email=\'+email+\'&sujet=\'+sujet+\'&message=\'+message,\'sendOK\');
			}
		}

			
		function sendContact2() {
			message=escape($(\'form_mess\').value);
			pseudo=escape($(\'form_pseudo\').innerHTML);
			email=escape($(\'form_email\').innerHTML);
			sujet=escape($(\'sujet\').value);
			if (pseudo=="" || email==\'\' || sujet==\'\' || message=="") { alert(\'Erreur : Tous les champs doivent être remplis !\');  }
			else {	
				$(\'wait\').style.display=\'block\';
				round();
				ajaxPostA(\'pages/contact.php?act=send\',\'prenom=\'+pseudo+\'&email=\'+email+\'&sujet=\'+sujet+\'&message=\'+message,\'sendOK\');
			}
		}

		function sendOK(result) {
			$(\'wait\').style.display=\'none\';
			$(\'principal\').innerHTML=\'<br><br><br><center><b style="color:#3366FF">Message envoyé avec succés !</b></center><br><br><br><br>\';
			round();
		}
		
		 
		</script>
			';
			

		
switch($_GET['act']) {
default:

if (is_log()==0) {
	 
	head($add);
	
	echo '<script type="text/javascript">
	window.onload=function(){
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");}
	function round() {
		if(!NiftyCheck())return;
		Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");
	}
	</script>';
	
		echo "<h3>Contact</h3><br>
		<center>N'hésitez pas à nous contacter si vous avez des interrogations ou des remarques à nous faire parvenir.</center><br><br>
		<center><div style='width:90%; background-color:#FFFFFF; margin-left:auto; margin-right:auto' class='round' id='principal'>
			<div id='wait' style='width:16px; height:16px; padding:1px; float:right; margin-right:5px; display:none'><img src='images/indicator2.gif'></div>
			<table width='100%' style='margin-left:20px'>
			  <tr>
			    <td style='width:50px;'><b style='color:#ffa500'>Votre Prénom</b></td>
				<td><input type='text' name='form_prenom' style='width:180px;' maxlength='50'></td>
			  </tr>
			  <tr>
			    <td><b style='color:#ffa500'>Adresse Email</b></td>
				<td><input type='text' name='form_email' style='width:180px;' maxlength='100'></td>
			  </tr>
			  <tr>
			    <td><br><b style='color:#ffa500'>Sujet du message</b></td>
				<td><br><input type='text' name='form_sujet' style='width:240px;' maxlength='200'></td>
			  </tr>
			  <tr>
			    <td><b style='color:#ffa500'>Message</b></td>
				<td><textarea rows='5' style='width:240px;border-color:#777 #DDD #EEE #777;' name='form_mess'></textarea></td>
			  </tr>
			  <tr>
			    <td></td>
				<td><div class='envoyer' id='send' style='width:135px;' onClick='sendContact()'>Envoyer</div></td>
			  </tr>
			 </table>
		</div></center>";
	
	foot();
  
  } else {
  
  	head($add);
	
	$sql=mysql_query("SELECT email FROM members WHERE id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	echo '<script type="text/javascript">
	window.onload=function(){
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");}
	function round() {
		if(!NiftyCheck())return;
		Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");
	}
	</script>';
	
		echo "<h3>Contact</h3><br>
		<center>N'hésitez pas à nous contacter si vous avez des interrogations ou des remarques à nous faire parvenir.</center><br><br>
		<center><div style='width:90%; background-color:#FFFFFF; margin-left:auto; margin-right:auto' class='round' id='principal'>
			<div id='wait' style='width:16px; height:16px; padding:1px; float:right; margin-right:5px; display:none'><img src='images/indicator2.gif'></div>
		<form name='myform' action='#' method='POST'>
			<table width='100%' style='margin-left:20px'>
			  <tr>
			    <td style='width:50px;'><b style='color:#ffa500'>Votre Pseudo :<br><br>Votre Email :</td>
				<td><span name='form_pseudo' style='color:#4395D8'>".ucfirst($_SESSION['sess_pseudo'])."</span><br><br><span name='form_email' style='color:#4395D8'>".$d->email."</span></td>
			  </tr>

			  <tr>
			    <td><br><b style='color:#ffa500'>Sujet du message</b></td>
				<td><br><input type='text' id='sujet' name='sujet' style='width:240px;' maxlength='200'></td>
			  </tr>
			  <tr>
			    <td><b style='color:#ffa500'>Message</b></td>
				<td><textarea rows='5' style='width:240px;border-color:#777 #DDD #EEE #777;' name='form_mess'></textarea></td>
			  </tr>
			  <tr>
			    <td></td>
				<td><div class='envoyer' id='send' style='width:135px;' onClick='sendContact2()'>Envoyer</div></td>
			  </tr>
			 </table>
		</form>
		</div></center>";
	
	foot();


  } 
break;
case "send":

	function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
	}

	$prenom=$_POST['prenom'];
	$email=$_POST['email'];
	$sujet=$_POST['sujet'];
	
	$date = date("Y-m-d");
	$ip=ip();
	
	$entete = 'Reply-to: '.$email."\r\n"// Adresse utilisée pour la réponse au mail
    .'From: Mon Look.com '."\r\n"// Adresse de l'expéditeur (format : Nom <adresse_mail>)
    .'Date: '.date('l j F Y, G:i')."\r\n"; // Date de l'envoie de l'E-Mail   
   $message = "Expéditeur : ".$email." ".$prenom."
Sujet : ".$sujet."
Date :  ".$date." IP : ".$ip."

Message
".stripslashes(nl2br($_POST['message']))."";
 
	
	 if (mail("yotsumi.fx@gmail.com","Contact Mon-Look.com",$message,$entete)) echo "ok";
	 else echo "bug";

break;
}

?>