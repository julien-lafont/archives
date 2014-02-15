<?php
/**
 * Module "Mot de passe perdu"
 * Permet de générer un nouveau mot de passe
 *
 * Url : mot-de-passe-perdu.htm
 */

// On bloque l'accés aux personnes déjà connectées
if (is_log()) bloquerAcces("Vous êtes déjà connecté, vous ne pouvez pas accéder à cette page");

	$design->zone('titre', "Mot de passe perdu ?");

switch(@$_GET['action'])
{

default:

	$contenu = '
			<form action="mot-de-passe-perdu2.htm" method="post" name="formPass1">
			<fieldset id="form" style="text-align:center; margin:20px auto 20px auto;">

				<div style="width:80%; background-color:#FFFFFF; text-align:center; margin:0 auto;">
					<div style="margin:5px; color:#555; font-size:11px; line-height:18px; text-align:center">
						Si vous avez perdu votre mot de passe, entrez votre <u>adresse email</u> dans ce formulaire pour en recevoir un nouveau.<br><br>
							<input type="text" name="newemail" MAXLENGTH="50" onKeypress="return block(event,5);" style="text-align:center" /><br />
							<input type="submit" value="Nouveau mdp" class="f-submit" />
					</div>
				</div>
				
			</fieldset>
			</form>';
	
	$design->template('simple');
	$design->zone('contenu', $contenu );
	$design->zone('titre', "Mot de passe perdu ?");

break;
case "passPerdu2":

	$email=addBdd($_POST['newemail']);
	$sql=mysql_query("SELECT id_membre, cle FROM ".PREFIX."membres WHERE email='$email'") or die( mysql_error());
	$d=mysql_fetch_object($sql);
	if ($d->id_membre!=0) {
	
	$mail_body = "<html>
					<body>
						Bonjour,<br />
						<br />Vous venez de demander sur le site ".NOM." une réinitialisation de vos identifiants de connexion.						
						<br />
						Si vous confirmer ce choix, veuillez suivre ce lien, sinon effacez ce message.<br />
						<a href='".URL."nouveau-pass-".$d->id_membre."-".$d->cle.".htm'>Nouveau mot de passe</a><br><br>
						En cas de problème, copier cette adresse dans votre navigateur : <br>'".URL."nouveau-pass-".$d->id_membre."-".$d->cle.".htm'<br><br>
						Merci<br>
						Staff ".NOM."
					</body>
				</html>";
				
			$mail_object = "Réinitialisation Mot de Passe ".NOM;
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: \"Staff ".NOM."\" <robot@".NOM.".com>\n";

		@mail( $email, $mail_object, $mail_body, $headers );
		
		$design->zone('contenu', miseenforme('message',"Un Email vient de vous être envoyé avec la démarche à suivre !".$mail_body) );
		
	} else {
		$design->zone('contenu', miseenforme('erreur', "Désolé, mais aucun compte n'est enregistré avec cette adresse Email !") );
	}
	
break;
case "newPass":

// On récuère les infos
	$id=addBdd($_GET['id']);
	$cle=addBdd($_GET['cle']);

	$sql=mysql_query("SELECT count(id_membre) as nb FROM ".PREFIX."membres WHERE `id_membre`='$id' AND `cle`='$cle'") or die(mysql_error());
	$d=mysql_fetch_object($sql);
	
	if ($d->nb==1) {
		$newpass=genKey();
		$newpasscrypt=crypt( md5($newpass) , CLE );
		$sql2=mysql_query("UPDATE ".PREFIX."membres set `pass`='$newpasscrypt' WHERE id_membre=$id") or die(mysql_error());
		
		$design->zone('contenu', miseenforme('message', "Votre nouveau mot de passe est : <b>$newpass</b> <br><br>Vous pourrez par la suite modifier ce mot de passe dans votre espace personnel") );
	} else {
		$design->zone('contenu', miseenforme('erreur', "Code de vérifications incorrects") );
	}
	
break;
}
?>