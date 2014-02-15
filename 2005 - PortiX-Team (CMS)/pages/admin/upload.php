<?php
is_admin();

// Fonction pour savoir la taille d'un fichier
function filesize_remote($url, $timeout=2)
{
   $url = parse_url($url);
   if ($fp = @fsockopen($url['host'], ($url['port'] ? $url['port'] : 80), $errno, $errstr, $timeout)){
       fwrite($fp, 'HEAD '.$url['path'].$url['query']." HTTP/1.0\r\nHost: ".$url['host']."\r\n\r\n");
       stream_set_timeout($fp, $timeout);
       while (!feof($fp))
       { $size = fgets($fp, 4096);
           if (stristr($size, 'Content-Length') !== false){ $size = trim(substr($size, 16));break;}
       } fclose ($fp);}
   return is_numeric($size) ? intval($size) : false;
} 

switch (@$_GET['action']) {

default:
$texte="<div class=\"titreBS\">Centre d'upload Admin :</div>

<ul class='menu-spe'>
	<li><a href='?page=admin/upload&action=upload1'>Upload Admin</a></li>
	<li><a href='?page=admin/upload&action=nettoyage'>Nettoyage Auto</a></li>
	<li><a href='?page=admin/upload&action=listeup1'>Nettoyage Manuel</a></li>
	<li><a href='?page=admin/upload&action=configuration'>Configuration</a></li>
</ul>
</div>";

		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

$texte .= "Cette zone d'administration est consacrée aux <b>Uploads</b>. <br><br>Sur cette page, tu peux uploader des fichiers pour le site ( screenshots de match, HLTV ...), mais si tu veux uploadé un Avatar, rends-toi sur la page 'Mon Compte'<br><br>
<div class='textexplicatifadmin'>- L'onglet <span class=\"txt2\">Upload Admin</span> permet d'envoyer sur le serveur des fichiers.<br>
- L'onglet <span class=\"txt2\">Nettoyage Auto</span> supprime toutes les images qui ne sont plus utilisées.<br>
- L'onglet <span class=\"txt2\">Nettoyage Manuel</span> affiche la liste de tous les fichiers uploadés.<br>
- Enfin,l'onglet <span class=\"txt2\">Configuration</span> permet de définir les restrictions d'upload.</div><br>";
	
break;

####################################################################################################
####################################################################################################
case "nettoyage":

$nberreur=0; $nbsuppr=0;
$texte="<div class=\"titreBS\">Nettoyage des uploads :</div>
		<u>Rapport des fichiers inutilisés : </u><blockquote>";
		
		$dossier = opendir ("upload/");
		while ($fichier = readdir ($dossier)) {
			if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db" && $fichier != "imagegd.php"  && $fichier != "admin") {	
				
				// On vérifie que le fichier est bien enregistré dans la table Ix_Upload
				$sql1 = mysql_query("SELECT id,nomfichier FROM ix_upload WHERE nomfichier='".$fichier."'");
				$data1=mysql_fetch_object($sql1); $nbfichiers++;
				
					if ($data1==FALSE) { $texte.= "- ".$fichier;
										if (unlink ("upload/".$fichier))  { $texte.=" -> Supprimé avec succés !<br>";  $nbsuppr++; }
										else { $texte.=" -> Erreur !<br>";   $nberreur++; }
									  }
					else { 
					
				// Puis on vérifie si le fichier est utilisé par un membre
				$sql2 = mysql_query("SELECT id_mbre FROM ix_membres_detail WHERE avatar LIKE '%".$fichier."%'"); 
				$data2 = mysql_fetch_object($sql2); 
				
				if ($data2==FALSE) { $texte.= "- ".$fichier; 
										$sql = mysql_query("DELETE FROM ix_upload WHERE nomfichier='$fichier'") or die('Erreur SQL : '.mysql_error());
										if (unlink ("upload/".$fichier))  { $texte.=" -> Supprimé avec succés !<br>";  $nbsuppr++; }
										else { $texte.=" -> Erreur !<br>";   $nberreur++; }
									  }
						}
			} 
		} 
		closedir ($dossier);
		
		if ($nbsuppr==0 && $nberreur==0 ) $texte.= "Aucun fichier inutilisé<br>";
		
	$texte.="</blockquote><u>Rapports des avatars :</u><br><blockquote>
		Nombre d'avatar total : $nbfichiers<br>
		Nombre d'avatar supprimés : $nbsuppr<br>
		Nombre d'erreur : $nberreur<br><br>
		Nombre d'avatar restants : ".($nbfichiers-$nbsuppr)."</blockquote>";
break;

####################################################################################################
####################################################################################################
case "configuration":

($ixteam['up_allow']==1) ? $checked1="checked" : $checked2="checked";

$texte="<div class=\"titreBS\">Configuration :</div>";
$texte.='<FORM name="configuration" method="post" action="?page=admin/upload&action=configuration2">
			<table>
			<tr>
			  <td width="250px">- Autorisé l\'upload pour les membres</td>
			  <td><input name="up_allow" type="radio" value="1" '.$checked1.'> OUI &nbsp;&nbsp;&nbsp;<input name="up_allow" type="radio" value="0" '.$checked2.'> NON</td>
		  </tr>
		  <tr>
		  		<td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
		  	<td>- Taille Max des fichiers pour un Membre</td>
			<td><input name="upmbre" type="text" size="7" maxlength="7" class="case_inscript" value="'.$ixteam['upmbre_max'].'" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"> ko</td>
		  </tr>
		  <tr>
		  	<td>- Taille Max des fichiers pour un Admin</td>
			<td><input name="upadmin" type="text" size="7" maxlength="7" class="case_inscript" value="'.$ixteam['upadmin_max'].'"onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"> ko</td>
		  </tr>
		  </table>
		   <br><input type="submit" name="Submit" value="Go !" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/></FORM><br>';

break;

####################################################################################################
####################################################################################################
case "configuration2":

	$up_allow=$_POST['up_allow'];
	$up_mbre=$_POST['upmbre'];
	$up_admin=$_POST['upadmin'];
	
	$sql = mysql_query("UPDATE ix_config SET valeur=$up_allow WHERE nom='up_allow'");
	$sql2 = mysql_query("UPDATE ix_config SET valeur=$up_mbre WHERE nom='upmbre_max'");
	$sql3 = mysql_query("UPDATE ix_config SET valeur=$up_admin WHERE nom='upadmin_max'");
	
	rediriger("?page=admin/upload");
break;	

####################################################################################################
####################################################################################################
case "upload1":

$texte.='<b>Bienvenue sur le centre d\'upload</b><br><br>
		Ce module d\'upload sert à envoyé vos Screenshots de matchs, Vidéos HLTV ou autres sur le Serveur.</b><br>
		<blockquote>- <span class="txt2"> Taille maximale autorisée : </span>'.$ixteam['upadmin_max'].' ko<br>
		- <span class="txt2"> Format autorisé : </span> Tous sauf php [ Protection ]<br><br>
		<form name="formulaire_envoi_fichier" enctype="multipart/form-data" method="post" action="?page=admin/upload&action=upload2">
		<input type="file" name="fichier_choisi"  size="35"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="bouton_submit" value="Uploader" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">
		</form></blockquote>
		<br>';

break;

####################################################################################################
####################################################################################################
case "upload2":

	if(!empty($_FILES["fichier_choisi"]["name"]))
	{
			// Infos sur le fichier envoyé
			$nomFichier    = $_FILES["fichier_choisi"]["name"] ;
			$nomTemporaire = $_FILES["fichier_choisi"]["tmp_name"] ;
			$typeFichier   = $_FILES["fichier_choisi"]["type"] ;
			$poidsFichier  = round($_FILES["fichier_choisi"]["size"]/1024) ;
			$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
			$nom2 			= explode(".", $nomFichier);
			
			// on vérifie qu'un fichier ayant le même nom n'existe pas déjà utilisé 
				$sql = mysql_query('SELECT id FROM ix_upload WHERE nomfichier="'.$nomFichier.'"') or die; 
				$nb=mysql_num_rows($sql);
				if(!$nb==0) { $nomFichier = $nom2['0']."_".GenPass(2).".".$extension; }

	
			
			// on vérifie que la taille du fichier 
				if ($poidsFichier>=$ixteam['upadmin_max']) { 
					message_redir("------------- ERREUR -------------\\nLe fichier envoyé est trop gros.\\nLa taille maximale autorisée est : ".$ixteam['upadmin_max']." ko.","?page=admin/upload");
					}
				
			// on vérifie l'extention du fichier
				if ($extension=="php" || $extension=="bat") {
					message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions bannient sont PHP et BAT.","?page=admin/upload");
					}
								
			$chemin = ("upload/admin/");
			
			if(copy($nomTemporaire, $chemin.$nomFichier)) {
				$cat = "1"; $ip = $_SERVER['REMOTE_ADDR']; $date= date("Y-m-d") ; $pseudo= $_SESSION['sess_pseudo'];
				$sql2 = mysql_query("INSERT INTO `ix_upload` ( `nomfichier` , `nomoriginal` , `cat` ,`membre` , `ip` , `date`) VALUES ( '$nomFichier', '$nomFichier', '$cat' ,'$pseudo','$ip','$date')") or die ("erreur sql " . mysql_error());
				$_SESSION['nomfichier'] = $nomFichier;  $_SESSION['etape2ok']=1 ;
				rediriger("?page=admin/upload&action=upload3"); }
			else {
					message_redir("------------- ERREUR -------------\\nUne erreur est survenue durant l'upload.","?page=admin/upload");
					}
	} else {
	rediriger("?page=admin/upload"); 
	}
				
break;

####################################################################################################
####################################################################################################
case "upload3":

	if ( $_SESSION['etape2ok']!=1 ) rediriger("?page=admin/upload");
		$texte='<div class="titreBS">Centre d\'upload :</div>
		<center><b>Votre fichier a été envoyé avec succés.</b></center> <br><br>
		Voici le lien pour récupérer le fichier : <span class="txt2"><br>'.$ixteam['url'].'upload/admin/'.$_SESSION['nomfichier'].'</span>
		<br><br>';
		unset($_SESSION['etape2ok']);
		unset($_SESSION['nomfichier']);
break;

####################################################################################################
####################################################################################################
case "listeup1":

		$texte='<div class="titreBS">Listes des fichiers uploadés:</div>';
		
		$texte.='<center><span class="txt2" style="font-size:13px">Voici la liste des avatars uploadés par les membres du site.</span><br>
		- <span class="txt2">Pour accéder aux fichiers uploadés par les <b>admins</b>, <a href="?page=admin/upload&action=listeup2">cliquez ici</a> </span>-</center> <br><br>';
		
		$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px" width="70%">Nom du Fichier</td>
				<td class="liste_titre" style="font-size:10px" width="20%">Taille</td>
				<td class="liste_titre" style="font-size:10px" width="10%">Suppr</td>
			  </tr>';
			  
	$dossier = opendir ("upload/");
	while ($fichier = readdir ($dossier)) {
		if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db" && $fichier != "imagegd.php"  && $fichier != "admin") {	
			$taille = round(filesize_remote($ixteam['url']."upload/".$fichier)/1024);
			@$t_total += $taille; @$nb_fichier++;
			$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'><a href='".$ixteam['url']."upload/$fichier' target='_blank'>$fichier</td>
					<td class='liste_txt' style='font-size:10px'>$taille ko</td>
					<td class='liste_txt' style='font-size:10px'><a href='?page=admin/upload&action=suppr_mbre&nom=$fichier'><img src=\"images/suppr.jpg\"  border=0></td>
					</tr>";
		} 
	} 
	closedir ($dossier);
	$texte.="</table><br>
			Nombre de fichiers : <span class=\"txt2\">$nb_fichier</span>
			<br>Taille totale : <span class=\"txt2\">$t_total ko</span><br>";
break;

####################################################################################################
####################################################################################################
case "suppr_mbre":

	$nom = $_GET['nom'];
	if (!unlink ("upload/".$nom)) { message_redir("Erreur durant la suppression du ficher","?page=admin/upload"); }
	$req = mysql_query("DELETE FROM ix_upload WHERE nomfichier='".$nom."'");
	rediriger("?page=admin/upload&action=listeup1");
	
break;

####################################################################################################
####################################################################################################
case "listeup2":

		$texte='<div class="titreBS">Listes des fichiers uploadés:</div>';
		
		$texte.='<center><span class="txt2" style="font-size:13px">Voici la liste des fichiers uploadés par les <b>Admins</b>.</span><br>
		- <span class="txt2">Pour accéder aux fichiers uploadés par les membres, <a href="?page=admin/upload&action=listeup1">cliquez ici</a> </span>-</center> <br><br>';
		
		$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px" width="70%">Nom du Fichier</td>
				<td class="liste_titre" style="font-size:10px" width="20%">Taille</td>
				<td class="liste_titre" style="font-size:10px" width="10%">Suppr</td>
			  </tr>';
			  
	$dossier = opendir ("upload/admin/");
	while ($fichier = readdir ($dossier)) {
		if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db") {	
			$taille = round(filesize_remote($ixteam['url']."upload/admin/".$fichier)/1024);
			@$t_total += $taille; @$nb_fichier++;
			$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'><a href='".$ixteam['url']."upload/admin/$fichier' target='_blank'>$fichier</td>
					<td class='liste_txt' style='font-size:10px'>$taille ko</td>
					<td class='liste_txt' style='font-size:10px'><a href='?page=admin/upload&action=suppr_admin&nom=$fichier'><img src=\"images/suppr.jpg\"  border=0></td>
					</tr>";
		} 
	} 
	closedir ($dossier);
	$texte.="</table><br>
			Nombre de fichiers : <span class=\"txt2\">$nb_fichier</span>
			<br>Taille totale : <span class=\"txt2\">$t_total ko</span><br>";
break;

####################################################################################################
####################################################################################################
case "suppr_admin":

	$nom = $_GET['nom'];
	if (!unlink ("upload/admin/".$nom)) { message_redir("Erreur durant la suppression du ficher","?page=admin/upload");  }
	$req = mysql_query("DELETE FROM ix_upload WHERE nomfichier='".$nom."'");
	rediriger("?page=admin/upload&action=listeup2");
	
break;


}

	(empty($_GET['action'])) ? $texte.="" : $texte.='<br><a href="?page=admin/upload"><center>- Retour à l\'admin du Centre d\'Upload -</center></a><br>';

    $afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin Centre d'Upload");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>