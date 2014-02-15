<?php

// On bloque l'accés aux personnes déjà connectées
if (is_log()) bloquerAcces("Vous êtes déjà connecté, vous ne pouvez pas accéder à cette page");

	$design->zone('titre', "Mot de passe perdu ?");
	$design->zone('titrePage', "Demander un nouveau mot de passe");	

switch(@$_GET['action'])
{

default:

	$contenu = '
			<form action="nouveau-pass2/" method="post" name="formPass1">
			<fieldset id="form" style="text-align:center; margin:20px auto 20px auto;">

				<div style="width:80%; background-color:#FFFFFF; text-align:center; margin:0 auto;">
					<div style="margin:5px; color:#555; font-size:11px; line-height:18px; text-align:center">
						Si vous avez perdu votre mot de passe, entrez votre <u>adresse email</u> dans ce formulaire pour en recevoir un nouveau.<br><br>
							<input type="text" name="newemail" MAXLENGTH="50" onKeypress="return block(event,5);" style="text-align:center" /><br />
							<input type="submit" value="nouveau mdp" class="submit" />
					</div>
				</div>
				
			</fieldset>
			</form>';
	
	$design->template('simple');
	$design->zone('contenu', $contenu );
	$design->zone('titre', "Mot de passe perdu ?");
	$design->zone('titrePage', "Demander un nouveau mot de passe");	

break;
case "passPerdu2":

	$email=addslashes(htmlspecialchars($_POST['newemail']));
	$sql=mysql_query("SELECT id, cle FROM ".PREFIX."membres WHERE email='$email'") or die( mysql_error());
	$d=mysql_fetch_object($sql);
	if ($d->id!=0) {
	
	$mail_body = "<html>
					<body>
						Bonjour,<br />
						<br />Vous venez de demander sur D4team.com une réinitialisation de vos identifiants de connexion.						
						<br />
						Si vous confirmer ce choix, veuillez suivre ce lien, sinon effacez ce message.<br />
						<a href='".URL."nouveau-pass/".$d->id."-".$d->cle."/'>Nouveau mot de passe</a><br><br>
						En cas de problème, copier cette adresse dans votre navigateur : <br>'".URL."nouveau-pass/".$d->id."-".$d->cle."/'<br><br>
						Merci<br>
						Staff D4team.com
					</body>
				</html>";
				
			$mail_object = "Réinitialisation Mot de Passe D4team.com";
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: \"Staff D4team.com\" <robot@d4team.com>\n";

		@mail( $email, $mail_object, $mail_body, $headers );
		
		$design->zone('contenu', miseenforme('message',"Un Email vient de vous être envoyé avec la démarche à suivre !") );
		
	} else {
		$design->zone('contenu', miseenforme('erreur', "Désolé, mais aucun compte n'est enregistré avec cette adresse Email !") );
	}
	
break;
case "newPass":

// On récuère les infos
$infos=explode('-',$_GET['key']);
	$id=addBdd($infos[0]);
	$cle=addBdd($infos[1]);

	$sql=mysql_query("SELECT count(id) as nb FROM ".PREFIX."membres WHERE `id`='$id' AND `cle`='$cle'") or die(mysql_error());
	$d=mysql_fetch_object($sql);
	
	if ($d->nb==1) {
		$newpass=genKey();
		$newpasscrypt=crypt( md5($newpass) , CLE );
		$sql2=mysql_query("UPDATE ".PREFIX."membres set `mdp`='$newpasscrypt' WHERE id=$id") or die(mysql_error());
		
		$design->zone('contenu', miseenforme('message', "Votre nouveau mot de passe est : <b>$newpass</b> <br><br>Ne le perdez pas :)") );
	} else {
		$design->zone('contenu', miseenforme('erreur', "Code de vérifications incorrects") );
	}
	
break;
}
?>