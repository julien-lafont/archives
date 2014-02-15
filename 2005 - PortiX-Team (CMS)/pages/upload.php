<?php
is_membre();
$NbMaxUpload=3;

switch (@$_GET['action']) {
default:

$texte='<div class="titreBS">Centre d\'upload :</div>';
	if ($ixteam['up_allow']==1) {
		$texte.='<b>Bienvenue sur le centre d\'upload</b><br><br>
		A partir de cet espace, vous pouvez uploadé sur le site votre propre avatar</b><br>
		<blockquote>- <span class="txt2"> Taille maximale autorisée : </span>'.$ixteam['upmbre_max'].' ko<br>
		- <span class="txt2"> Format autorisé : </span> Jpg - Png - Gif<br>
		- <span class="txt2"> Dimension conseillée : </span> 100 * 100<br><br>
		<form name="formulaire_envoi_fichier" enctype="multipart/form-data" method="post" action="?page=upload&action=2">
		<input type="file" name="fichier_choisi"  size="35"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="bouton_submit" value="Uploader" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">
		</form></blockquote>
		<br><br><br>Si vous êtes admin ou modo du site, suivez ce lien pour avoir accés à plus d\'option pour l\'upload de fichiers : <a href="?page=admin/upload">- Centre d\'upload Admin -</a><br><br>';
	} else {
		$texte.='<center><span class="txt2">Module désactivé.</span><br>Pour plus de renseignements, veuillez contacter un admin du site.<br><br></center>';
	}
	
break;
###################################################################################################
###################################################################################################
case "2":

	if(!empty($_FILES["fichier_choisi"]["name"]))
	{
			// Infos sur le fichier envoyé
			$nomFichier    = $_FILES["fichier_choisi"]["name"] ;
			$nomTemporaire = $_FILES["fichier_choisi"]["tmp_name"] ;
			$typeFichier   = $_FILES["fichier_choisi"]["type"] ;
			$poidsFichier  = round($_FILES["fichier_choisi"]["size"]/1024) ;
			$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
			
			// on vérifie qu'un fichier ayant le même nom n'existe pas déjà utilisé 
				$newnom = GenPass(15).".".$extension;
				$sql = mysql_query('SELECT id FROM ix_upload WHERE nomfichier="'.$newnom.'"') or die; 
				$nb=mysql_num_rows($sql);
				if(!$nb==0) $newnom = GenPass(16).".".$extension;
			
			// on vérifie que la taille du fichier 
				if ($poidsFichier>=$ixteam['upmbre_max']) { 
					message_redir("------------- ERREUR -------------\\nLe fichier envoyé est trop gros.\\nLa taille maximale autorisée est : ".$ixteam['upmbre_max']." ko.","?page=upload");
					}
					
			// on vérifie l'extention du fichier
				if ($extension!="jpg" && $extension!="png" && $extension!="gif" && $extension!="jpeg") {
					message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions autorisés sont jpg, png et gif .","?page=upload");
					}
			
			// Protection Anti Flood 
				$ip = $_SERVER['REMOTE_ADDR']; $date= date("Y-m-d") ; $pseudo= $_SESSION['sess_pseudo'];
				$sql3 = mysql_query('SELECT id FROM ix_upload WHERE (ip="'.$ip.'" || membre="'.$pseudo.'") AND date="'.$date.'" AND cat!="1"') or die ("erreur sql " . mysql_error());
				$nb2=mysql_num_rows($sql3); 
				if($nb2>=$NbMaxUpload) {
					message_redir("------------- ERREUR -------------\\nUn membre ne peut uploadé que ".$NbMaxUpload." avatars par jour.","?page=upload");
					}
					
			$chemin = ("upload/");

			if(copy($nomTemporaire, $chemin.$newnom)) {
				$sql2 = mysql_query("INSERT INTO `ix_upload` ( `nomfichier` , `nomoriginal` , `membre` , `ip` , `date`) VALUES ( '$newnom', '$nomFichier','$pseudo','$ip','$date')") or die ("erreur sql " . mysql_error());
				$_SESSION['nomfichier'] = $newnom; $_SESSION['nbavatar']=($nb2+1); $_SESSION['etape2ok']=1; 
				rediriger("?page=upload&action=3"); }
			else {
					message_redir("------------- ERREUR -------------\\nUne erreur est survenue durant l'upload.","?page=upload");
					}
	}
	else
	{
		rediriger("?page=upload"); }	

###################################################################################################
###################################################################################################
case "3":

	if ( $_SESSION['etape2ok']!=1 ) rediriger("?page=upload");
		$texte='<div class="titreBS">Centre d\'upload :</div>
		<center><b>Votre avatar a été envoyé avec succés.</b> <br>
		Tu peux encore effectuer <b>'.($NbMaxUpload-$_SESSION['nbavatar']).'</b> uploads aujourd\'hui</center><br><br>
		Voici le lien pour afficher ton avatar : <span class="txt2"><br>'.$ixteam['url'].'upload/'.$_SESSION['nomfichier'].'</span>
		<br><br> Apercu de l\'avatar :<br>
		<img src="'.$ixteam['url'].'upload/'.$_SESSION['nomfichier'].'">
		<br><br>Actions possible :<br>
		- <a href="upload/imagegd.php?action=RedimAvatar">Faire de cette image mon avatar EN adaptant au mieux la taille</a> [conseillé]<br>
		- <a href="?page=upload&action=AvatarNoRedim">Faire de cette image mon avatar SANS modification de la taille</a><br><br>
		- <a href="?page=membre">Retour à mon compte</a>';
		unset($_SESSION['etape2ok']);
		unset($_SESSION['nbavatar']);
break;

###################################################################################################
###################################################################################################
case "AvatarNoRedim":

	if (empty($_SESSION['nomfichier'])) rediriger("?page=upload");
		$urlimage = $ixteam['url']."upload/".$_SESSION['nomfichier'];
		$id = $_SESSION['sess_id'];
		
		$sql = mysql_query("UPDATE ix_membres_detail SET avatar='$urlimage' WHERE id_mbre='$id'");
		unset($_SESSION['nomfichier']); $_SESSION['AvatarOk']=1;
		rediriger("?page=upload&action=RedimAvatarOk");


break;

###################################################################################################
###################################################################################################
case "RedimAvatarOk":

	if ($_SESSION['AvatarOk']!=1)  rediriger("?page=upload"); 
	
	$texte='<center><br><b>Votre nouvel avatar a été enregistré avec succés !</b><br><br>
			Pour consulter votre Profil, cliquez <a href="?page=profil&id='.$_SESSION['sess_id'].'">ici</a><br><br>';
	unset($_SESSION['AvatarOk']);
	
break;
}

	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin matchs");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>