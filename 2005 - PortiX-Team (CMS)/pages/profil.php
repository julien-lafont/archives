<?php

if (empty($_GET['id']) && empty($_GET['action'])) {
	
	$texte='<div class="titreBS">Listes des membres :</div>
	<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
  <tr>   
  	<td class="liste_titre" width=10%>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td class="liste_titre" width=30%>Pseudo</td>
    <td class="liste_titre" width=12%>PM</td>
	<td class="liste_titre" width=12%>MSN</td>
	<td class="liste_titre" width=12%>Site Web</td>
	<td class="liste_titre" width=19%>Inscrit le</td>
  </tr>
';

	// Systeme de page 
	$NombreDeMessagesParPage = 15; // nb de membres à afficher 
	$sql1 = mysql_query('SELECT COUNT(id) AS nb_messages FROM ix_membres'); // requete pour compter
	$donnees = mysql_fetch_array($sql1); $TotalDesMessages = $donnees['nb_messages'];
	$NombreDePages = ceil($TotalDesMessages / $NombreDeMessagesParPage); // Calcul nb pages
	(isset($_GET['p'])) ? $p = intval($_GET['p']) : $p=1 ; // On regarde si une page a déjà été entrée ( URL )
	$PremierMessageAafficher = ($p - 1) * $NombreDeMessagesParPage; // Calcul du LIMIT pour Mysql

	$sql = mysql_query('SELECT id, pseudo, inscript FROM ix_membres  LIMIT ' . $PremierMessageAafficher . ', ' . $NombreDeMessagesParPage);	
	while($data = mysql_fetch_object($sql)) {
		
			$sql_d = mysql_query("SELECT site, msn, avatar FROM ix_membres_detail WHERE id_mbre=".$data->id);
			while($data_d = mysql_fetch_object($sql_d)) {			
			$url=$data_d->site;
			$msn=$data_d->msn;
			$avatar=$data_d->avatar; }
			
		/* AVATAR */ if ($avatar=="none.jpg") { $avatar2=$ixteam['url']."images/pas_avatar.jpg"; }
					 else { if (!empty($avatar)) $avatar2=$avatar;
					 		else $avatar2=$ixteam['url']."images/pas_avatar.jpg"; 
					 }
		/* URL */ 	 (empty($url)) ? $url2="" : $url2="<a href=\"$url\" targer=\"_blank\"><img src=\"images/icon_www.gif\" border=0 ></a>";
		/* MSN */ 	 (empty($msn)) ? $msn2="" : $msn2="<a href=\"?page=profil&id=".$data->id."\"><img src=\"images/icon_msn.gif\" border=0 ></a>";
		/* MP */ 	 $mp="<a href=\"?page=mp&dest=".$data->id."\"><img src=\"images/icon_pm.gif\" border=0 ></a>";
		/* PSEUDO */ $pseudo="<a href=\"?page=profil&id=".$data->id."\">".ucfirst($data->pseudo)."</a>";
		/* DATE */   $date=inverser_date($data->inscript);


			$texte.="  <tr>
						<td class='liste_txt'><img src=\"$avatar2\" width=20 height=20 border=0 style=\"border:1px solid #FFFFFF;\" OnMouseOver=\"this.style.border='1px inset #108AFB'\" OnMouseOut=\"this.style.border='1px solid #FFFFFF'\"></td>
						<td class='liste_txt'>$pseudo</td>
						<td class='liste_txt'>$mp</td>
						<td class='liste_txt'>$msn2</td>
						<td class='liste_txt'>$url2</td>
						<td class='liste_txt'>$date</td>
					  </tr>";	
		 }
		 $texte.="</table><br>";
		 
	// Suite systeme page :
	$texte.= '<center> Pages : ';
	if ($p>=2) $texte.= '<a href="?page=profil&p=' . ($p-1) . '"> « </a> '; // Bouton Précédent
	for ($i = 1; $i <= $NombreDePages; $i++) { // Numéro des pages
		($i==$p) ? $texte.= $i . ' ' : $texte.= '<a href="?page=profil&p=' . $i . '">' . $i . '</a> '; 
	}
	if ($p!=$NombreDePages) $texte.= '<a href="?page=profil&p=' . ($p+1) . '"> » </a> '; // Bouton Suivant
	$texte.= '</center>';		
	
		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Liste des membres :");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");
}
elseif (!empty($_GET['id'])) 
{

$id=$_GET['id'];
	
	$sql = mysql_query("SELECT * FROM ix_membres WHERE id=$id");
	$sql_d = mysql_query("SELECT * FROM ix_membres_detail WHERE id_mbre=$id");
	
	while ($data=mysql_fetch_object($sql)) {
		$pseudo=ucfirst($data->pseudo);
		$mail=$data->mail;
		$inscript=inverser_date($data->inscript);
		if ($data->niveau==0) $niveau="Membre"; 
			if ($data->niveau==1) $niveau="Modérateur"; 
			if ($data->niveau==2) $niveau="Administrateur";
	}
	
	while ($data_d=mysql_fetch_object($sql_d)) {
		(!empty($data_d->prenom)) ? $prenom=ucfirst($data_d->prenom) : $prenom=" / ";
		(!empty($data_d->ville)) ? $ville=$data_d->ville : $ville=" / ";
		(!empty($data_d->pays)) ? $pays=$data_d->pays : $pays=" / ";
		(!empty($data_d->age)) ? $age=$data_d->age : $age=" / ";
		(!empty($data_d->jeux_pref)) ? $jeux_pref=$data_d->jeux_pref : $jeux_pref=" / ";
		(!empty($data_d->niveau)) ? $skill=$data_d->niveau : $skill=" / ";
		(!empty($data_d->configuration)) ? $configuration=$data_d->configuration : $configuration=" / ";
		(!empty($data_d->site)) ? $site=$data_d->site : $site=" / ";
		(!empty($data_d->msn)) ? $msn=$data_d->msn : $msn=" / ";
		(!empty($data_d->signature)) ? $signature=$data_d->signature : $signature=" / ";
		(!empty($data_d->chan)) ? $chan=$data_d->chan : $chan=" / ";
		(!empty($data_d->job)) ? $job=$data_d->job : $job=" / ";
		(eregi("http://", $data_d->avatar)==1) ? $avatar=$data_d->avatar : $avatar=$ixteam['url']."images/avatar/".$data_d->avatar ;
		(eregi("http://", $site)==1) ? $site="<a href=\"$site\" target=\"_blank\">$site</a>" : $site=$site;
		if (!empty($data_d->sexe)) { ($data_d->sexe=="homme") ? $sexe='<img src="images/ico_homme.gif">' : $sexe='<img src="images/ico_femme.gif">'; }
		else $sexe=" / ";
	}


	
$texte = '<br><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH=100% height=50 >
			<PARAM NAME=movie VALUE="images/title.swf?text='.$pseudo.'">
			<PARAM NAME=quality VALUE=high> <PARAM NAME=wmode VALUE=transparent> <PARAM NAME=menu VALUE=true>
			<EMBED src="images/title.swf?text='.$pseudo.'" quality=high wmode=transparent bgcolor=#00CCFF WIDTH=100% height=50 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" menu="false"></EMBED>
		   </OBJECT><br><br>
		   		   
		   <table width="100%"  border="0" cellspacing="0" cellpadding="1">
			<tr>
			<td width="80%" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt2"><b>» Infos sur le membre :</span></b><br><br></td>
			<td rowspan="10" width="20px" align="center" valign="top">		   
					<table width="120" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #000000">
					<tr bgcolor="#000000">
					  <td><div align="center"><font color="#FFFFFF">Avatar<b></b></font></div></td>
					</tr>
					<tr bgcolor="#000000">
					  <td><center><img src="'.$avatar.'"></center></td>
					</tr>
					<tr bgcolor="#000000">
					  <td><div align="center"><font color="#FFFFFF"><b>'.$niveau.'</b></font></div></td>
					</tr>

				   </table></td>
			</tr>
			<tr>
			<td width="20%">. <span class="txt2">Prénom :</span></td>
			<td width="40%">'.$prenom.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Sexe :</span></td>
			<td>'.$sexe.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Localisation :</span></td>
			<td>'.$ville.' - '.$pays.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Age :</span></td>
			<td>'.$age.' ans</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Job / Etudes :</span></td>
			<td>'.$job.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Inscrit le :</span></td>
			<td>'.$inscript.'</td>
			</tr>
			<tr>
			<td colspan="2"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt2"><b>» '.$pseudo.' sur le Net :</span></b><br><br></td>
			</tr>
			<tr>
			<td>. <span class="txt2">Email :</span></td>
			<td>'.$mail.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">MSN :</span></td>
			<td>'.$msn.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Site :</span></td>
			<td>'.$site.'</td>
			</tr>
			<tr>
			<td>. <span class="txt2">Chan IRC :</span></td>
			<td>'.$chan.'</td>
			</tr>
			<tr>
			<td colspan="2"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt2"><b>» Infos de Gamer\'z :</span></b><br><br></td>
			</tr>
			<tr>
			<td>. <span class="txt2">Niveau :</span></td>
			<td>'.$skill.'</td>
			</tr>
			<tr>
			<td  valign="top">. <span class="txt2">Jeux Préférés :</span></td>
			<td>'.$jeux_pref.'</td>
			</tr>
			<tr>
			<td  valign="top">. <span class="txt2">Configuration :</span></td>
			<td>'.$configuration.'</td>
			</tr>
			<tr>
			<td  valign="top">. <span class="txt2">Signature :</span></td>
			<td>'.$signature.'</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</table>
';

		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Liste des membres :");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");
}
elseif (!empty($_GET['action'])) {

switch (@$_GET['action']) {
case "editer":
is_membre();

	$id=$_SESSION['sess_id'];

	$sql= mysql_query("SELECT * FROM ix_membres WHERE id=$id");	$data=mysql_fetch_object($sql);
	$sql_d = mysql_query("SELECT * FROM ix_membres_detail WHERE id_mbre=$id");	$data_d=mysql_fetch_object($sql_d);
	
	($data_d->sexe=="homme") ? $sexe='<input type="radio" name="sexe" value="homme" checked><img src="images/ico_homme.gif">&nbsp;&nbsp;&nbsp;<input type="radio" name="sexe" value="femme"><img src="images/ico_femme.gif">' : $sexe='<input type="radio" name="sexe" value="homme"><img src="images/ico_homme.gif">&nbsp;&nbsp;&nbsp;<input type="radio" name="sexe" value="femme"  checked><img src="images/ico_femme.gif">';
	(eregi("http://", $data_d->avatar)==1) ? $avatar=$data_d->avatar : $avatar=$ixteam['url']."images/avatar/".$data_d->avatar ;
	($ixteam['up_allow']==1) ? $upload="ou uploader votre avatar via le <a href=\"?page=upload\" target=\"_blank\"><b class=\"txt2\">Centre d'upload</b></a>" : $upload="" ;
 	//	ou uploader votre avatar via le <b>Centre d\'upload</b>.
		$texte='<div class="titreBS">Editer un membre :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmbre" id="formmbre" method="post" action="?page=profil&action=editer2">
		   <p><span class="soulignpoint" style="margin-left:10px">Infos sur le compte :</span></p>
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tr>
			   <td width="200px">Pseudo</td>
			   <td colspan="2"><input name="pseudo" class="case_inscript" size="25" maxlength="100"  type="text" value="'.$data->pseudo.'" readonly>
			   </td>
			 </tr>
			 <tr>
			   <td>E-mail</td>
			   <td colspan="2"><input name="mail" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->mail . '"></td>
			 </tr>
			 <tr>
			   <td valign="top">Mot de Passe<br> </td>
			   <td><input name="pass" class="case_inscript" size="25" maxlength="15" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" ><br>
			   <span style="font-size:10px">A ne remplir que si vous voulez modifier le mdp</span></td>
			  </tr>
			 </table>
			 
		   <p><span class="soulignpoint" style="margin-left:10px">Profil du membre :</span></p>
			<table style="margin-left: 25px;" border="0" width="95%">
			 <tr>
			   <td width="200px">Prénom</td>
			   <td colspan="2"><input name="prenom" class="case_inscript" size="25" maxlength="100" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->prenom . '"></td>
			 </tr>
			 <tr>
			   <td>Age</td>
			   <td colspan="2"><input name="age" class="case_inscript" size="5" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->age . '"/></td>
			 </tr>
			  <tr>
			   <td>Sexe :</td>
			   <td colspan="2">'.$sexe.'</td>
			 </tr>
			 <tr>
			 	<td>Ville</td>
				<td colspan="2"><input name="ville" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->ville . '"></td>
			 </tr>
			 <tr>
			 	<td>Pays</td>
				<td colspan="2"><input name="pays" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->pays . '"></td>
			 </tr>
			 <tr>
			 	<td>Job / Etude</td>
				<td colspan="2"><input name="job" class="case_inscript" size="25" maxlength="100" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->job . '"></td>
			 </tr>
			 <tr>
				<td colspan="3">&nbsp;</td>
			 </tr>
			 <tr>
               <td>Niveau (skill) :</td>
			   <td colspan="2"><input name="niveau" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->niveau . '"></td>
			   </tr>
			 <tr>
			 <tr>
			   <td>Site Web</td>
			   <td colspan="2"><input name="site" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->site . '"></td>
			 </tr>
			 <tr>
			   <td>MSN / AIM / ICQ</td>
			   <td  colspan="2"><input name="msn" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->msn . '"></td>
			 </tr>
			 <tr>
			   <td>Chan IRC :</td>
			   <td colspan="2"><input name="irc" class="case_inscript" size="25" maxlength="200" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data_d->chan . '"></td>
			  </tr>
			 <tr>
				<td colspan="3">&nbsp;</td>
			 </tr>
			 <tr>
               <td>Jeux favoris :</td>
			   <td colspan="2"><textarea name="jeux_pref" cols="35" rows="1" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. $data_d->jeux_pref . '</textarea></td>
			 </tr>
			 <tr>
               <td>Configuration :</td>
			   <td colspan="2"><textarea name="config" cols="35" rows="2" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. $data_d->configuration . '</textarea></td>
			 </tr>
			 <tr>
               <td>Signature :</td>
			   <td colspan="2"><textarea name="sign" cols="35" rows="2" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. $data_d->signature . '</textarea></td>
			 </tr>
			 <tr>
			   <td>Avatar</td>
			   <td colspan="2"><input name="avatar" class="case_inscript" size="35" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' .$data_d->avatar. '"/>&nbsp;&nbsp;<a href="'.$avatar.'" target="_blank">voir</a><br>
			   Vous pouvez entrez une addresse exerne'.$upload.'.</td>
			   </tr>
		   </table>
		   <p align="center">
		     <input type="hidden" name="oldpass" value="'.$data->pass.'">
			 <input name="Submit" value="Modifier" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
		   </p>';
		   
	$texte.='<br><a href="?page=membre"><center>- Retour à Mon Compte -</center></a><br>';

		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Editer mon profil :");
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");
break;

case "editer2":
is_membre();

	// on récupère toutes les variables et on les protèges :
	$_mail=htmlspecialchars(trim($_POST['mail']));			
	$_pass=htmlspecialchars(trim($_POST['pass']));
	$_prenom=htmlspecialchars(trim($_POST['prenom']));		
	$_age=htmlspecialchars(trim(intval($_POST['age'])));			
	$_sexe=htmlspecialchars(trim($_POST['sexe']));
	$_ville=htmlspecialchars(trim($_POST['ville']));		
	$_pays=htmlspecialchars(trim($_POST['pays']));			
	$_niveau=htmlspecialchars(trim($_POST['niveau']));
	$_site=htmlspecialchars(trim($_POST['site']));			
	$_msn=htmlspecialchars(trim($_POST['msn']));			
	$_jeux_pref=htmlspecialchars(trim($_POST['jeux_pref']));
	$_config=htmlspecialchars(trim($_POST['config']));		
	$_sign=htmlspecialchars(trim($_POST['sign']));			
	$_avatar=htmlspecialchars(trim($_POST['avatar']));
	$_oldpass=htmlspecialchars(trim($_POST['oldpass']));	
	$_chan=htmlspecialchars(trim($_POST['irc']));
	$_job=htmlspecialchars(trim($_POST['job']));
	$_id=$_SESSION['sess_id'];
	if (!ereg('^http://', $_site)) $_site="http://".$_site;
	
	// on fait toutes les vérifications :
	if (empty($_mail)) {
		$_SESSION['message'] .= ">> Les champs E-Mail doit obligatoirement être remplis.<br>";
		$erreur++;
	} 

	if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $_mail)) {
		$_SESSION['message'] .= ">> Adresse E-mail invalide<br>";
		$erreur++;
	} 
	
	if ((!ereg('.jpg$', $_avatar)) && (!ereg('.png$', $_avatar)) && (!ereg('.gif$', $_avatar))) {
		$_SESSION['message'] .= ">> Format de votre Avatar interdit. Fichier autorisés : .jpg, .png, .gif <br>";
		$erreur++;
	}

		// Si il faut  changer le mot de passe.
		(empty($_pass)) ? $newpass=$_oldpass : $newpass=md5($_pass);
		
	        if (@$erreur != 0) { // Si il ya eu des problèmes :
            
			// On met les champs déjà inscrits en sessions, pour éviter de les retapper 
			// --------- NON UTILISE ----------
			
           /* $_SESSION['pseudo'] = $_SESSION['sess_pseudo'];
            $_SESSION['mail'] = $_mail; $_SESSION['prenom'] = $_prenom; $_SESSION['age'] = $_age;
			$_SESSION['sexe'] = $_sexe; $_SESSION['ville'] = $_ville; $_SESSION['pays'] = $_pays;
			$_SESSION['niveau'] = $_niveau; $_SESSION['site'] = $_site; $_SESSION['msn'] = $_msn;
			$_SESSION['jeux_pref'] = $_jeux_pref; $_SESSION['config'] = $_config; $_SESSION['sign'] = $_sign;
			$_SESSION['avatar'] = $_avatar; $_SESSION['chan'] = $_chan; $_SESSION['job'] = $_job;*/
            rediriger("?page=profil&action=editer");
			
		} else {
		
					
				$sql = mysql_query("UPDATE ix_membres SET  mail='$_mail', pass='$newpass'  WHERE id='$_id'");
				$sql_d = mysql_query("UPDATE ix_membres_detail SET prenom='$_prenom', sexe='$_sexe', ville='$_ville', pays='$_pays', age='$_age', jeux_pref='$_jeux_pref', niveau='$_niveau', configuration='$_config', site='$_site', msn='$_msn', avatar='$_avatar', signature='$_sign', job='$_job', chan='$_chan' WHERE id_mbre='$_id'");
				rediriger("?page=membre");
		}
	break;
}
}
?>