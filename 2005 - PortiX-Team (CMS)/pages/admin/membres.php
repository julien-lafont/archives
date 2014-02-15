<?php
is_admin(); // Script de vérification Anti-Hack

switch (@$_GET['action']) {

default:
$texte="<div class=\"titreBS\">Administration des membres :</div>

<ul class='menu-spe'>
	<li><a href='?page=admin/membres&action=ajouter'>Ajouter</a></li>
	<li><a href='?page=admin/membres&action=gerer'>Gérer</a></li>
	<li><a href='?page=admin/membres&action=listead'>Liste Admins</a></li>
</ul>
</div>";

		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

$texte .= "Cette zone d'administration est consacrée aux <b>membres</b> et à leur <b>modération</b>.<br><br>
<div class='textexplicatifadmin'>- L'onglet <span class=\"txt2\">Ajouter</span> vous permet d'ajouter manuellement un nouveal utilisateur.<br>
- L'onglet <span class=\"txt2\">Gérer</span> vous donne accés à la liste de tous les membres, sur laquelle vous pourrez modifier, supprimer ou rendre admin un membre.<br>
- Enfin,l'onglet <span class=\"txt2\">Liste Admins</span> vous permet de voir quels membres sont admins ou modos..</div><br>";
	
break;

#########################################################################################################
#########################################################################################################
case "ajouter":

	$texte='<div class="titreBS" style="margin-bottom:17px">Ajouter un membre :</div>
	    	Les Membres ajoutés seront automatiquements activés.<br><br>';
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="form2" id="form2" method="post" action="?page=admin/membres&action=ajouter2">  
				<br>
				<table width="95%"  border="0">
                 <tr>
                   <td width="150">Pseudo</td>
                   <td>
                     <input name="pseudo" type="text" id="pseudo" size="22" maxlength="25" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
                   </td>
                 </tr>
                 <tr>
                   <td>Mot de passe </td>
                   <td><input name="pass1" type="text" id="pass" size="22" maxlength="15" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/></td>
                 </tr>
                 <tr>
                   <td>Niveau</td>
                   <td><select name="niveau" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">
                     <option value="0" selected="selected">Utilisateur</option>
                     <option value="1">Mod&eacute;rateur</option>
                     <option value="2">Administrateur</option>
                   </select></td>
                 </tr>
               </table>
			   
			      <input type="submit" name="Submit" value="Ajouter" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
			   
		</form>';
break;

#########################################################################################################
#########################################################################################################
case "ajouter2":

		/* VERIFIE LE LOGIN ET LE PASS :
				- Les champs sont ils remplis
				- Les champs utilisent-ils les bons caractères ( pas de %;:!, )<br />
				- les champs sont-ils assez long ( 3caract pour le login, 4 pour le pass ) */
				 
		if (empty($_POST['pseudo']) || empty($_POST['pass1'])) {
            @$_SESSION['message'] .= ">> Les champs Pseudo ou Pass n'ont pas été renseignés.<br>";
            @$erreur++; }
						
		if(strlen($_POST['pseudo'])<4 || strlen($_POST['pass1'])<4  ) {
            @$_SESSION['message'] .= ">> Les champs Pseudo et Pass doivent faire au moins 4 caractères.<br>";
            @$erreur++; }
		
		$sql = mysql_query('SELECT * FROM ix_membres WHERE pseudo="'.$_POST['pseudo'].'"') or die; 
		$nb_pseudo=mysql_num_rows($sql);
		if(!$nb_pseudo==0)
			{ $_SESSION['message'].=">> Le Pseudo ".$_POST['pseudo']." est déjà utilisé.<br>"; 
			   $erreur++; }
			   
		    
		if (@$erreur != 0) { // Si il ya eu des problèmes :
            rediriger("?page=admin/membres&action=ajouter"); } 
		else {
          	$passmd5 = md5($_POST['pass1']); $date2 = date("Y-m-d");
			$_pseudo=$_POST['pseudo']; $_niveau=$_POST['niveau'];

            $req = mysql_query("INSERT INTO `ix_membres` ( `pseudo` ,  `pass` , `inscript`, `niveau`, `active`) VALUES ('$_pseudo','$passmd5','$date2','$_niveau','1')");
			$newid = mysql_insert_id();
            $req_d = mysql_query("INSERT INTO `ix_membres_detail` ( `id_mbre` ) VALUES ('$newid')");
            $_SESSION['message']="Membre ajouté avec succés";
			rediriger("?page=admin/membres");
		}
break;

#########################################################################################################
#########################################################################################################
case "gerer":

	$texte="<div class=\"titreBS\">Administration des matchs :</div>
		<div style=\"background-color:#FFFFFF; border:1px solid #000000; color:#333333; padding-top:3px; padding-bottom:3px; width:90%; margin-left:auto; margin-right:auto\">&nbsp;&nbsp;<font color=\"#FF0000\">Actions</font> :  <img src='images/suppr.jpg' align=\"absmiddle\"> Supprimer le membre <img src='images/edit.jpg'  align=\"absmiddle\"> Editer le membre <img src='images/admin.jpg' align=\"absmiddle\"> Modifier les droits <br>
		&nbsp;&nbsp;<font color=\"#FF0000\">Niveaux</font> : <b>0</b> = Membre, <b>1</b> = Modérateur, <b>2</b> = Administrateur</div><br>";
	$query = "SELECT * FROM ix_membres ORDER BY id";
	$sql = mysql_query($query);		

		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\"><center>" . stripslashes($_SESSION['message']) . "</center></div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px">Pseudo</td>
				<td class="liste_titre" style="font-size:10px">Mail</td>
				<td class="liste_titre" style="font-size:10px">Inscription</td>
				<td class="liste_titre" style="font-size:10px">Niveau</td>
				<td class="liste_titre" style="font-size:10px">Admin</td>
			  </tr>';
			  
	while($data = mysql_fetch_object($sql)) {
		
		$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'><a href='?page=profil&id=".$data->id."'>".ucfirst($data->pseudo)."</a></td>
					<td class='liste_txt' style='font-size:10px'>$data->mail</td>
					<td class='liste_txt' style='font-size:10px'>".@inverser_date($data->inscript)."</td>
					<td class='liste_txt' style='font-size:10px'>$data->niveau</td>
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/membres&action=suppr&id=$data->id\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;<a href=\"?page=admin/membres&action=editer&id=$data->id\"><img src=\"images/edit.jpg\" border=0></a>&nbsp;<a href=\"?page=admin/membres&action=admin&id=$data->id\"><img src=\"images/admin.jpg\" border=0></a></td>
			    </tr>";	
	}
		 
	$texte.="</table>";
break;

#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_membres WHERE id=".$_GET['id']);
	$_SESSION['message']="Membre supprimé avec succés";
	rediriger("?page=admin/membres&action=gerer");
break;

#########################################################################################################
#########################################################################################################
case "admin":

		$rq="SELECT niveau, pseudo FROM ix_membres WHERE id='".$_GET['id']."'";		
		$sql = mysql_query($rq) or die; 
		$data = mysql_fetch_object($sql);
		
		if ($data->niveau==0) $niveau="Membre sans droit";
		if ($data->niveau==1) $niveau="Modérateur";
		if ($data->niveau==2) $niveau="Administrateur";
		
		$texte="<br><a href=\"?page=profil&pseudo=".$data->pseudo."\"><b>".ucfirst($data->pseudo)."</b></a> est un membre de niveau <b class=\"txt2\">".$data->niveau."</b>, c'est à dire : <b class=\"txt2\">".$niveau."</b><br /><br /><br /><br />
				  Changer le status de se membre en :<br /><br />";
		$texte.='<blockquote><form name="form" id="form" method="post" action="?page=admin/membres&action=admin2" > 
				   <select name="niveau" class="case_inscript" >
				   <option value="0" selected="selected">Utilisateur</option>
				   <option value="1">Mod&eacute;rateur</option>
				   <option value="2">Administrateur</option>
				   </select>
				   <input name="id" type="hidden" value="'.$_GET['id'].'">   
			       <input type="submit" name="Submit" value="Go !" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
			   	   </form></blockquote>';
break;

#########################################################################################################
#########################################################################################################
case "admin2":

		$req = mysql_query("UPDATE ix_membres SET niveau=".$_POST['niveau']." WHERE id=".$_POST['id']);
		$_SESSION['message']="Droits du membre modifiés avec succés";
		rediriger("?page=admin/membres&action=gerer");
break;

#########################################################################################################
#########################################################################################################
case "editer":

	$sql= mysql_query("SELECT * FROM ix_membres WHERE id=".$_GET['id']);					$data=mysql_fetch_object($sql);
	$sql_d = mysql_query("SELECT * FROM ix_membres_detail WHERE id_mbre=".$_GET['id']);	$data_d=mysql_fetch_object($sql_d);
	
	($data_d->sexe=="homme") ? $sexe='<input type="radio" name="sexe" value="homme" checked><img src="images/ico_homme.gif">&nbsp;&nbsp;&nbsp;<input type="radio" name="sexe" value="femme"><img src="images/ico_femme.gif">' : $sexe='<input type="radio" name="sexe" value="homme"><img src="images/ico_homme.gif">&nbsp;&nbsp;&nbsp;<input type="radio" name="sexe" value="femme"  checked><img src="images/ico_femme.gif">';
	(eregi("http://", $data_d->avatar)==1) ? $avatar=$data_d->avatar : $avatar=$ixteam['url']."images/avatar/".$data_d->avatar ;

		$texte='<div class="titreBS">Editer un membre :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmbre" id="formmatch" method="post" action="?page=admin/membres&action=editer2">
		   <p><span class="soulignpoint" style="margin-left:10px">Infos sur le compte :</span></p>
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tr>
			   <td width="200px">Pseudo</td>
			   <td colspan="2"><input name="pseudo" class="case_inscript" size="25" maxlength="100" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$data->pseudo.'">
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
			   <td  colspan="2"><input name="avatar" class="case_inscript" size="35" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' .$data_d->avatar. '"/>&nbsp;&nbsp;<a href="'.$avatar.'" target="_blank">voir</a></td>
			   </tr>
		   </table>
		   <p align="center">
		     <input type="hidden" name="oldpass" value="'.$data->pass.'"><input type="hidden" name="id" value="'.$data->id.'">
			 <input name="Submit" value="Envoyer" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
		   </p>';
		   
break;

#########################################################################################################
#########################################################################################################
case "editer2":

	// on récupère toutes les variables
	$_pseudo=$_POST['pseudo'];		$_mail=$_POST['mail'];			$_pass=$_POST['pass'];
	$_prenom=$_POST['prenom'];		$_age=$_POST['age'];			$_sexe=$_POST['sexe'];
	$_ville=$_POST['ville'];		$_pays=$_POST['pays'];			$_niveau=$_POST['niveau'];
	$_site=$_POST['site'];			$_msn=$_POST['msn'];			$_jeux_pref=$_POST['jeux_pref'];
	$_config=$_POST['config'];		$_sign=$_POST['sign'];			$_avatar=$_POST['avatar'];
	$_id=$_POST['id'];				$_oldpass=$_POST['oldpass'];	$_chan=$_POST['irc'];
	$_job=$_POST['job'];
	
		// Si il faut  changer le mot de passe.
		(empty($_pass)) ? $newpass=$_oldpass : $newpass=md5($_pass);
		
		// Si aucune ligne Détail n'existe pour le membre, on la crée : 
		$sqltest1=mysql_query("SELECT * from ix_membres_detail WHERE id_mbre='$_id'");
		$nb = mysql_num_rows($sqltest1);
		if ($nb==0 )
			{ 		$sqltest2=mysql_query("INSERT INTO `ix_membres_detail` ( `id_mbre` ) VALUES ( '$_id' )"); }
		
	$sql = mysql_query("UPDATE ix_membres SET pseudo='$_pseudo', mail='$_mail', pass='$newpass'  WHERE id='$_id'");
	$sql_d = mysql_query("UPDATE ix_membres_detail SET prenom='$_prenom', sexe='$_sexe', ville='$_ville', pays='$_pays', age='$_age', jeux_pref='$_jeux_pref', niveau='$_niveau', configuration='$_config', site='$_site', msn='$_msn', avatar='$_avatar', signature='$_sign', job='$_job', chan='$_chan' WHERE id_mbre='$_id'");
    $_SESSION['message']="Membre modifié avec succés";
	rediriger("?page=admin/membres");

break;

#########################################################################################################
#########################################################################################################
case "listead":

	$rq = mysql_query('SELECT id, pseudo, niveau FROM ix_membres WHERE niveau=2 ORDER BY id');
	$rq2 = mysql_query('SELECT id, pseudo, niveau FROM ix_membres WHERE niveau=1 ORDER BY id');
	
	$texte='<div class="titreBS">Liste des Modos & Admins :</div>
	<p><b><span class="soulignpoint">Listes des administrateurs :</span></u></b></p><blockquote>';
					
	while($data = mysql_fetch_object($rq)) {
		$texte.="<b>.</b> <a href=\"?page=profil&id=".$data->id."\">".ucfirst($data->pseudo)."</a><br />"; }
	
	$texte.='</blockquote><br><p><b><span class="soulignpoint">Listes des modérateurs :</span></u></b></p><blockquote>';
	
	while($data = mysql_fetch_object($rq2)) {
		$texte.="<b>.</b> <a href=\"?page=profil&id=".$data->id."\">".ucfirst($data->pseudo)."</a><br />"; }
	$texte.='</blockquote>';

break;
}
	(empty($_GET['action'])) ? $texte.="" : $texte.='<br><a href="?page=admin/membres"><center>- Retour à l\'admin des Membres -</center></a><br>';

    $afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin membres");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");


?>
