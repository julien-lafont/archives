<?php

switch($_GET['action']) {

#########################################################################################################################
// Page d'inscription par défaut //
#########################################################################################################################
default:

		// Nbre d'inscrits
		$sql_nb=mysql_query("SELECT count(id_membre) as nbid FROM members");
		$datanb=mysql_fetch_object($sql_nb);
		$nb_members=$datanb->nbid;

		$add='<script src="include/inscription.js"></script>';

head($add);

echo '<center>Rejoignez sans plus attendre les <b>'.$nb_members.'</b> utilisateurs de Mon-Look.com !</center><br>';
	
	// Si on a une erreur à afficher.
	if (isset($_SESSION['erreur'])) {
		echo '<div style="width:380px; padding:5px; margin-left:auto; margin-right:auto; background-color:#FFFFFF; border:1px solid #FF0000">
			 <span style="color:#3366FF">Une erreur est survenue dans la vérification du formulaire :</span><br><br>'.$_SESSION['erreur'].'</div>';
		unset($_SESSION['erreur']);
	}

echo'	<form name="myform" action="?p=inscription&action=verif" method="post" onsubmit="return checkifvalid();">
<table id="inscription" >
		<tr>
			<td colspan="3"><h3> » Vos identifiants :</h3></td>
		</tr>
		<tr>
			<td style="width:160px">Pseudo</td>
			<td style="width:300px"><input type="text" name="pseudo" style="background-image:url(images/formulaires/pseudo.png);" maxlength="50" onKeypress="return block(event,3);"> <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td>Adresse Email</td>
			<td><input type="text" name="email" style="background-image:url(images/formulaires/email.png);"  maxlength="255" onKeypress="return block(event,5);"> <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td>Mot de Passe</td>
			<td><input type="password" name="pass1" style="background-image:url(images/formulaires/pass.png);" maxlength="50" onKeypress="return block(event,3);"> <span style="color:#F00">*</span> </td>
		</tr>
		<tr>
			<td>Confimer Mdp</td>
			<td><input type="password" name="pass2" style="background-image:url(images/formulaires/pass.png);" maxlength="255" onKeypress="return block(event,3);"> <span style="color:#F00">*</span> </td>
		</tr>
		<tr>
			<td colspan="3"><br><h3> » Vous :</h3></td>
		</tr>
		<tr>
			<td style="width:160px">Prénom </td>
			<td style="width:165px"><input type="text" name="prenom" class="input_inscript"  maxlength="50" style="background-image:url(images/formulaires/nom.png);  onKeypress="return block(event);""> <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td style="width:160px">Nom </td>
			<td style="width:160px"><input type="text" name="nom" class="input_inscript" style="background-image:url(images/formulaires/nom.png); " maxlength="50" onKeypress="return block(event);"> <span style="font-size:10px">( privé )</span></td>
		</tr>
		<tr>
			<td style="width:160px">Pays </td>
			<td style="width:165px"><select name="country">
					  <option value="Canada">Canada</option>
					  <option value="France">France</option>
					  <option value="Belgique">Belgique</option>
					  <option value="U.S.A">U.S.A</option>
					  <option value="Autre">Autre</option>
					</select>  <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td style="width:160px">Age </td> 
			<td style="width:200px"><input type="text" name="age" style="width:60px" class="input_date" maxlength="2"  onKeypress="return block(event,4);"> <span style="color:#F00">*</span> <b style="color:#09F">! 13 ans minimum !</b></td>
		</tr>
		<tr>
			<td style="width:160px">Sexe </td>
			<td style="width:165px"><select name="gender">
				  <option value="h">Homme</option>
				  <option value="f">Femme</option>
				</select>  <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td style="width:160px; vertical-align:top; padding-top:4px">Tel Mobile </td>
			<td style="width:160px"><input type="text" name="tel" class="input_inscript" style="background-image:url(images/profil/mobile.png); " maxlength="50" onKeypress="return block(event,4);">
				<div id="help_port2" style="display:inline"> 
					&nbsp; <a href="#" onCLick="document.getElementById(\'help_port\').style.display=\'block\'; document.getElementById(\'help_port2\').style.display=\'none\'; return false"><img src="images/formulaires/lampe.png"> <i>Confidentiel</i></a>
				</div>
				<div id="help_port" style="width:200px; background-color:#FFFFFF; border:1px dotted #0099FF; color:#555; padding:2px; margin-top:7px; overflow:auto; display:none; ">Nous vous invitons à entrer votre num de mobile pour que les autres membres de M-L puissent vous envoyer des message <b style="color:#F33">via le site</b>, c\'est à dire <span style="color:#06F">sans avoir un <b>accés direct</b> à votre numéro</span> !<br></div></td>
		</tr>
		<tr>
			<td colspan="3"><br><h3> » Motivations :</h3></td>
		</tr>
		<tr>
			<td style="width:160px">Je recherche</td>
			<td style="width:165px"><select name="cherche">
				  <option value="h">un homme</option>
				  <option value="f">une femme</option>
				  <option value="hf">un homme ou une femme</option>
				  <option value="p">personne</option>
				</select> <span style="color:#F00">*</span></td>
		</tr>
		<tr>
			<td style="width:160px">Type de relation</td>
			<td style="width:160px"><br>
			 	<input name="amitie" type="checkbox" value="1" style="width:20px" style="border:0px; background-color:#B4E4E6"> Développer une amitié<br>
				<input name="activites" type="checkbox" value="1" style="width:20px"style="border:0px; background-color:#B4E4E6"> Partenaires d\'activités<br>
				<input name="court" type="checkbox" value="1" style="width:20px"style="border:0px; background-color:#B4E4E6"> Une courte relation<br>
				<input name="long" type="checkbox" value="1" style="width:20px"style="border:0px; background-color:#B4E4E6"> Une longue relation<br>
				<input name="amusement" type="checkbox" value="1" style="width:20px"style="border:0px; background-color:#B4E4E6"> L\'amusement<br>
				<input name="sexe" type="checkbox" value="1" style="width:20px"style="border:0px; background-color:#B4E4E6"> Relation sexuelle<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" ><br><br>
			<div style="width:320px; padding:5px; margin-left:auto; margin-right:auto; background-color:#FFFFFF; border:1px solid #999999; border-left:5px solid #999999">
<font color="#FF0000">Règlement :</font><br>
- Vous devez etre agé de plus de 13 ans<br>
- Aucune photo vulgaire<br>
- Le spam est interdit<br>
- Vous devez mettre une photo de vous seulement</div>
<input type="checkbox" name="regagree" id="agree" value="valeur" onClick="ChangeStatut(this.form)" style="width:20px; margin-left:20px; border:0px; background-color:#B4E4E6""/> J\'accepte le reglement
			</td>
		</tr>
		<tr>
			<td></td>
			<td><br><div class="envoyer" id="send" style="width:135px; display:none" OnClick="verif();">Terminer l\'inscription</div></td>
		</tr>


	</table>
</form>';
foot();

break;
#######################################################################################################################
// Page vérifant les infos donnés + Insertion MYSQL + Envoie mail confirmation
#######################################################################################################################
case "verif":

	$pseudo=strtolower(htmlspecialchars($_POST['pseudo']));
	$email=strtolower(htmlspecialchars($_POST['email']));
	$pass1=strtolower(htmlspecialchars($_POST['pass1']));
	$pass2=strtolower(htmlspecialchars($_POST['pass2']));
	$prenom=strtolower(htmlspecialchars($_POST['prenom']));
	$nom=strtolower(htmlspecialchars($_POST['nom']));
	$age=strtolower(htmlspecialchars($_POST['age']));
	$gender=strtolower(htmlspecialchars($_POST['gender']));
	$cherche=strtolower(htmlspecialchars($_POST['cherche']));
	$amitie=strtolower(htmlspecialchars($_POST['amitie']));
	$activites=strtolower(htmlspecialchars($_POST['activites']));
	$court=strtolower(htmlspecialchars($_POST['court']));
	$long=strtolower(htmlspecialchars($_POST['long']));
	$amusement=strtolower(htmlspecialchars($_POST['amusement']));
	$sexe=strtolower(htmlspecialchars($_POST['sexe']));
	$tel=strtolower(htmlspecialchars($_POST['tel']));
	$country=strtolower(htmlspecialchars($_POST['country']));
	$password_encrypt = crypt( md5($pass1) , CLE );
	$key=GenKey();
	
	
	$sql1=mysql_query("SELECT count(id_membre) as nbpseudo FROM members WHERE username='$pseudo'");
	$data1=mysql_fetch_object($sql1);
	if ($data1->nbpseudo!=0) $err="- Le pseudo choisi est déjà utilisé.<br>";
	
	/* ON tri les pseudo bannis */ 
	if ($pseudo==base64_decode('a2lyaWtpcmk4NA==')) $ban=1;
	else $ban=0;
	
	/* On gère le num de téléphone international */
	$newtel="";
	
	if ($country=="france") { if (strlen($tel)==10) $newtel="+33".substr($tel,1,9); }
	if ($country=="canada" || $country=="u.s.a") $newtel="+3".$tel;
	if ($country=="belgique") $newtel="+32".$tel;
	
	$sql2=mysql_query("SELECT count(id_membre) as nbemail FROM members WHERE email='$email'");
	$data2=mysql_fetch_object($sql2);
	if ($data2->nbemail!=0) @$err.="- Nous n'autorisons qu'une seule inscription par adresse email.<br>";
	
	if (!empty($err)) { 
		$_SESSION['erreur']=$err;
		rediriger('?p=inscription');
	}
	
	$sql=mysql_query("INSERT INTO `members` ( `username` , `password` , `email` , `age` , `country`, `portable` ,`gender` , `joindate`,`active` , `fname` , `lname` , `ip` , `validcode` , `cherche` , `amitie` , `activites` , `relationct` , `relationlt` , `amusement` , `sexe`, `admin` )
					VALUES ('$pseudo', '$password_encrypt', '$email', '$age', '$country', '$newtel', '$gender', NOW( ), '0' , '$prenom', '$nom', '".ip()."', '$key' , '$cherche', '$amitie' , '$activites' , '$court' , '$long' , '$amusement' , '$sexe', '$ban')") or die(mysql_error());
					
			$mail_body = "
			<html>
			<body>
				Bonjour,<br />
				<br />Vous venez de vous inscrire sur Mon-Look.com, pour confirmer votre inscription, vous n'avez qu'à utiliser les informations inscrites ci-dessous.						
				<br />
				Vos identifiants de connexion sont :<br />
				Login: $pseudo<br />
				Password: $pass1<br />
				<br />
				Vous devez maintenant valider votre inscription en cliquant sur le lien ci-dessous :)<br/>
				<a href='".URL."?p=inscription&action=valid&c=".$key."&l=".$pseudo."'>".URL."?p=inscription&action=valid&c=".$key."&l=".$pseudo."</a><br />
				<br />
				Nous vous souhaitons de bonnes rencontres sur Mon-Look !
			</body>
			</html>
		";
		$mail_object = "Finalisation de l'inscription à Mon-Look.com";
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

		@mail( $email, $mail_object, $mail_body, $headers );
		
	head();
	echo "<br><center><b>Votre inscription s'est déroulée avec succés.</b><br><br><br>
	    Vous devez impérativement finaliser votre inscription en cliquant sur le lien présent dans le mail que nous venons de vous envoyer.<br>
		<i>L'équipe de Mon-Look.com</i><br><img src='img/px.gif' height='200' width='1'>";
	foot();

break;
#######################################################################################################################
// Vérification du code d'activation du compte //
#######################################################################################################################
case "valid":

	$code=htmlspecialchars(addslashes($_GET['c']));
	$pseudo=htmlspecialchars(addslashes($_GET['l']));
	
	$sql=mysql_query("SELECT id_membre, validcode FROM members WHERE username='$pseudo' AND active='0'");
	$data=mysql_fetch_object($sql);
	if ($data->validcode==$code) { 
		$sql2=mysql_query("UPDATE members SET active='1' WHERE username='$pseudo'");
		head();
		echo "<br><center><b>Merci d'avoir activé votre compte.</b><br><br><br>
			  Vous pouvez maintenant vous connecter à Mon-Look.com et faire de nombreuses rencontres.<br>
			  Bon surf<br><br><br>";
		echo '<form name="identification2" method="post" action="?p=fonctions/identification">
				<div style="margin-left:20px">
					<input type="text" name="pseudo" style="background-image:url(images/formulaires/pseudo.png);" maxlength="50" class="input_log" value="Login" onclick="this.value=\'\'"><br>
					<input type="password" name="pass" style="background-image:url(images/formulaires/pass.png); margin-top:10px" maxlength="50" class="input_log" value="password"  onclick="this.value=\'\'"><br>
					<div class="envoyer" style="width:115px; margin-top:5px" OnClick="document.identification2.submit()">Se connecter</div>
				</div>
			</form>
			<img src="img/px.gif" height="100" width="1">';

		foot();
	} else {
		head();
		echo "<br><center><b>Erreur : Code Incorrect</b><br><br><br>
			  Une erreur est survenue durant l'activations.<br>
			  Si le problème persiste, veuillez contacter l'<a href='mailto:".EMAIL_BUG."'>administrateur<a/><br>
			  <img src='img/px.gif' height='200' width='1'>";
		foot();
	}
	
break;
}
?>