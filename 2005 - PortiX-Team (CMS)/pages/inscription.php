<?php

if (!empty($_SESSION['sess_id'])) { rediriger("?page=news"); }// Si l'utilisateur est déjà logué 

switch (@$_GET['action']) {
    default:

        $texte = '<div class="titreBS ">Formulaire d\'inscription :</div><br>'; 
        // Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

        $texte .= '	   <p><span class="soulignpoint" style="margin-left:10px">Champs obligatoires :</span></p>
		   <form name="form1" id="form1" method="post" action="?page=inscription&action=verifier" >
		   <table width="95%" border="0" style="margin-left:25px">
			 <tr>
			   <td width="200">Pseudo</td>
			   <td><input name="pseudo2" type="text" class="case_inscript" size="25" maxlength="25" value="' . @$_SESSION['pseudo2'] . '"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/>
			   </td>
			 </tr>
			 <tr>
			   <td>Mot de passe </td>
			   <td><input name="pass1" type="password" class="case_inscript" size="25" maxlength="15"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			 </tr>
			 <tr>
			   <td>Confirmer le
				 mot de passe
			   <br /> </td>
			   <td><input name="pass2" type="password" class="case_inscript" size="25" maxlength="15"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			  </tr>
			 <tr>
			   <td>E-mail </td>
			   <td><input name="email" type="text" class="case_inscript" size="25" maxlength="100"  value="' . @$_SESSION['mail'] . '" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			 </tr>
		   </table><br /><br />
			<div id="barresouligner"></div><br />
			<p><span class="soulignpoint" style="margin-left:10px">
			 Champs facultatifs : </span></p>
			<table width="95%" border="0" style="margin-left:25px">
			  <tr>
				<td width="200">MSN</td>
				<td><input name="msn" type="text" class="case_inscript" size="25" maxlength="100"  value="' . @$_SESSION['msn'] . '"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			  </tr>
			  <tr>
				<td>Site Web </td>
				<td><input name="site" type="text" class="case_inscript" size="25" maxlength="100"  value="' . @$_SESSION['site'] . '"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			  </tr>
			  <tr>
				<td>Chan IRC </td>
				<td><input name="chan" type="text" class="case_inscript" size="25" maxlength="100"  value="' . @$_SESSION['chan'] . '"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"/></td>
			  </tr>
			   <tr>
               <td>Niveau (skill) :</td>
			   <td><input name="skill" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['skill'] . '"></td>
			   </tr>
			 <tr>
			 <tr>
               <td>Jeux favoris :</td>
			   <td><textarea name="jeux_pref" cols="35" rows="1" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. @$_SESSION['jeux_pref'] . '</textarea></td>
			 </tr>
			  <tr>
				<td>Signature </td>
				<td><textarea name="signature" cols="35" rows="2" wrap="VIRTUAL" class="case_inscript"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'">' . @$_SESSION['signature'] . '</textarea></td>
			  </tr>
			   <tr>
				<td>Avatar </td>
				<td><select class="formnews2" name="predef" onChange="showimage()" style="width:160px"  >
				<option value="none.jpg">--------- Avatar ---------</option>

				  ';

        $dossier = opendir ("images/avatar/");

        while ($fichier = readdir ($dossier)) {
            if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db") {
                $fichier2 = ereg_replace(".jpg", "", $fichier);
                $fichier2 = ereg_replace(".png", "", $fichier);
                $texte .= '<option value="' . $fichier . '">' . $fichier2 . '</option>';
            } 
        } 
        closedir ($dossier);

        $texte .= '</select> &nbsp;&nbsp;&nbsp;<img src="images/avatar/-vide.png" name="predef_name" width="118" height="100" alt="avatar" align="absmiddle" style="border:1px solid #000000"></td>
                 </tr>
                </table>
			    <p align="center">
			      <input type="submit" name="Submit" value="Insription !" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
			    </p>
				</form>';
				
        $afficher->AddSession($handle, "contenu");
        $afficher->setVar($handle, "contenu.module_titre", "Inscription");
        $afficher->setVar($handle, "contenu.module_texte", $texte);
        $afficher->CloseSession($handle, "contenu"); 
       
	    // On efface les varaibles session
        unset($_SESSION['pseudo2']);
        unset($_SESSION['mail']);
        unset($_SESSION['site']);
        unset($_SESSION['signature']);
        unset($_SESSION['msn']);
		unset($_SESSION['chan']);
		unset($_SESSION['skill']);
		unset($_SESSION['jeux_pref']);

        break;

    case "verifier":

        $pseudo2 = strtolower(htmlspecialchars(trim($_POST['pseudo2'])));
        $pass1 = htmlspecialchars(trim($_POST['pass1']));
        $pass2 = htmlspecialchars(trim($_POST['pass2']));
        $email = htmlspecialchars(trim($_POST['email']));
        $msn = htmlspecialchars(trim($_POST['msn']));
        $site = htmlspecialchars(trim($_POST['site']));
        $signature = htmlspecialchars(trim($_POST['signature']));
        $avatar = $ixteam['url']."images/avatar/".htmlspecialchars(trim($_POST['predef']));
		$chan = htmlspecialchars(trim($_POST['chan']));
        $jeux_pref = htmlspecialchars(trim($_POST['jeux_pref']));
        $skill = htmlspecialchars(trim($_POST['skill']));


        if (empty($pseudo2) || empty($pass1) || empty($pass2) || empty($email)) {
            $_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de tous les remplir.<br>";
            $erreur++;
        } 

        if (strlen($pseudo2) < 4 || strlen($pass1) < 4) {
            $_SESSION['message'] .= ">> Le mot de passe et le pseudo doivent faire au minimum 4 caractères.<br>";
            $erreur++;
        } 

        if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) {
            $_SESSION['message'] .= ">> Adresse E-mail invalide<br>";
            $erreur++;
        } 

        if ($pass1 != $pass2) {
            $_SESSION['message'] .= ">> Les deux mot de passe ne correspondent pas !<br>";
            $erreur++;
        } 

        if (ereg ("[^A-Za-z, :-_,0-9]", $pseudo2)) {
            $_SESSION['message'] .= ">> Votre pseudo contient des caractères non autorisés.<br>";
            $erreur++;
        } 

        $sql = mysql_query('SELECT * FROM ix_membres WHERE pseudo="'.$pseudo2.'"') or die; 
		$nb_pseudo=mysql_num_rows($sql);
		if(!$nb_pseudo==0)
			{ $_SESSION['message'].=">> Le Pseudo ".$pseudo2." est déjà utilisé.<br>"; 
			   $erreur++; }

		$sql2 = mysql_query('SELECT * FROM ix_membres WHERE mail="'.$email.'"') or die; 
		$nb_pseudo2=mysql_num_rows($sql2);
		if(!$nb_pseudo2==0)
			{ $_SESSION['message'].=">> L'email ".$email." est déjà utilisé.<br>"; 
			  $erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            
			// On met les champs déjà inscrits en sessions, pour éviter de les retapper
            $_SESSION['pseudo2'] = $_POST['pseudo2'];
            $_SESSION['mail'] = $_POST['email'];
            $_SESSION['msn'] = $_POST['msn'];
            $_SESSION['site'] = $_POST['site'];
            $_SESSION['signature'] = $_POST['signature'];
			$_SESSION['jeux_pref'] = $_POST['jeux_pref'];
            $_SESSION['chan'] = $_POST['chan'];
            $_SESSION['skill'] = $_POST['skill'];

            rediriger("?page=inscription");
			
            exit;
			
        } else {
		
			// Insertion dans la base de donnée
            $passmd5 = md5($pass1);
            $date2 = date("Y-m-d");
			
           $req_membre = mysql_query("INSERT INTO `ix_membres` ( `pseudo` , `mail` , `pass` , `inscript`) VALUES ( '$pseudo2', '$email','$passmd5','$date2')") or die ("erreur sql " . mysql_error());
		   $newid = mysql_insert_id();
           $req_detail = mysql_query("INSERT INTO `ix_membres_detail` ( `id_mbre`, `jeux_pref`, `niveau`, `site` , `msn` , `avatar` , `signature` , `chan`) VALUES ( '$newid','$site', '$jeux_pref', '$skill', '$msn','$avatar', '$signature', '$chan')") or die ("erreur sql " . mysql_error());

			// Envoie du mail pour l'activation
			$mdp_cle = crypt($date2, "billonbenjam");
			$mail_message="<html><body>Bienvenue sur <b>$ixteam[site_nom]</b><br><br>
			Vous pouvez activer le compte <u>$pseudo2</u> en suivant le lien : <a href=\"$ixteam[url]?page=inscription&action=activer&pseudo=$pseudo2&cle=$mdp_cle\">-activer mon compte-</a><br><br>
			Si vous ne pouvez pas cliquer sur ce lien, copiez/collez l'adresse suivant dans votre navigateur internet :<br>
			$ixteam[url]?page=inscription&action=activer&pseudo=$pseudo2&cle=$mdp_cle <br><br>
			Ce compte sera effacé s'il n'est pas activé dans les 72 heures.<br><br>
			A bientôt<br><br>
			L'equipe $ixteam[site_nom]</body></html>";
			$mail_sujet="[-SITE-] Activation de votre inscription";
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			
			@mail( $email, $mail_sujet, $mail_message, $headers );
			
			// Préparation de la page à  afficher :
			
			$texte= "<br>Votre inscription a été enregistré. <br><br>"
			."Avant de pouvoir vous connecter, vous devez <b>activer votre compte</b> en cliquant sur le lien qui vous a été envoyé à l'adresse : <u>$email</u><br><br>"
			."Vous avez alors 48h pour activer votre compte. Si celui ci n'est pas activé sous ce délai, le compte est automatiquement supprimé.<br>&nbsp;";

			$afficher->AddSession($handle, "contenu");
       		$afficher->setVar($handle, "contenu.module_titre", "Inscription : Activation nécessaire");
			$afficher->setVar($handle, "contenu.module_texte", $texte);
            $afficher->CloseSession($handle, "contenu"); 


        } 
        break;

    case "activer":

        $rq = 'SELECT pseudo, inscript, active FROM `ix_membres` WHERE pseudo="'.$_GET['pseudo'].'"';
        $sql = mysql_query($rq);
        $infos = mysql_fetch_object($sql);

		$cle_base = crypt($infos->inscript, "billonbenjam");
		$cle=$_GET['cle'];
		
			$afficher->AddSession($handle, "contenu");

		if ($cle_base==$cle) {
		
			$rq = 'UPDATE ix_membres SET  active="1" WHERE pseudo="'.$_GET['pseudo'].'"';
			$sql = mysql_query($rq);
			
			$texte= "<br><b>Votre compte a été activé avec succés.</b><br><br>"
			."Vous pouvez maintenant vous connecter au compte <u>".$_GET['pseudo']."</u><br>&nbsp;";
       		$afficher->setVar($handle, "contenu.module_titre", "Inscription : Compte activé");
		 }
		 else {
		 
			$texte= "<br><b>Erreur lors de l'activation.</b><br><br>"
			."Veuillez vérifier le code qui vous a été envoyé par E-mail.<br>Si le problème persiste, veuillez contacter le Webmaster du site.<br>&nbsp;";
       		$afficher->setVar($handle, "contenu.module_titre", "Inscription : Erreur d'activation");
		}
		
			$afficher->setVar($handle, "contenu.module_texte", $texte);
            $afficher->CloseSession($handle, "contenu");  	

		
   break;

} 


?>