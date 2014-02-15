<?php
session_start();
include '../ixteam.php';
is_membre();

switch (@$_GET['action']) {

case "RedimAvatar":
		// ------------------------------------------------------------------------- //
		// Auteur: NobodX                                                            //
		// Email:  icecube@fr.fm                                                     //
		// Web:    http://icecube.fr.fm/                                             //
		// ------------------------------------------------------------------------- //
		function RatioResizeImg( $image, $newWidth, $newHeight){
		global $ixteam;
		
		// détéction du type de l'image
		eregi("(...)$",$image,$regs); $type = strtolower($regs[1]);
		switch($type){
		case "gif": $srcImage = @imagecreatefromgif( $image ); break;
		case "jpg": $srcImage = @imagecreatefromjpeg( $image ); break;
		case "png": $srcImage = @imagecreatefrompng( $image ); break;
		default : unset($type); break;}
		
		if($srcImage){
		
		// hauteurs/largeurs
		$srcWidth = imagesx( $srcImage );
		$srcHeight = imagesy( $srcImage );
		$ratioWidth = $srcWidth/$newWidth;
		$ratioHeight = $srcHeight/$newHeight;
		
		// taille maximale dépassée ?
		if (($ratioWidth > 1) || ($ratioHeight > 1)) {
		if( $ratioWidth < $ratioHeight){
		$destWidth = $srcWidth/$ratioHeight;
		$destHeight = $newHeight;
		}else{
		$destWidth = $newWidth;
		$destHeight = $srcHeight/$ratioWidth;}
		}else {$destWidth = $srcWidth;  $destHeight = $srcHeight;}
		
		// resize
		$destImage = imagecreate( $destWidth, $destHeight);
		imagecopyresized( $destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight,
															 $srcWidth, $srcHeight );
		
		// nom du fichier
		$dest_file  = random($dest_file,$type);
		while (file_exists("$dest_file"))
		{$dest_file  = random($dest_file,$type);}
		
		// création et sauvegarde de l'image finale
		/* Ici on peut éditer le chemin de sauvegarde ($dest_file) */
		switch($type){
		case "gif": @imagegif($destImage, $dest_file); break;
		case "jpg": @imagejpeg($destImage, $dest_file); break;
		case "png": @imagepng($destImage, $dest_file); break;}
		
		// libère la mémoire
		imagedestroy( $srcImage );
		imagedestroy( $destImage );
		
		// renvoit l'URL de l'image
		return $dest_file;}
		
		// erreur
		else {echo "Image inexistante ou aucun support ";
				if ($type){echo "pour le format $type";}
				else {echo "pour ce format de fichier";}
		exit;}}
		
		
		// nom de fichier suivant la date + nb aléatoire
		function random($dest_file,$type){
		srand ((double) microtime() * 1000);
		$dest_file = date("dhis");
		$dest_file .= rand();
		$dest_file .= ".$type";
		return $dest_file;
		}
		
		// Et c'est parti !
		$urlimage = $ixteam['url']."upload/".$_SESSION['nomfichier'];
		$imgurl = RatioResizeImg($urlimage,100,100);
		
		$urlfinale = $ixteam['url']."upload/".$imgurl; $id = $_SESSION['sess_id'];
		$sql = mysql_query("UPDATE ix_membres_detail SET avatar='$urlfinale' WHERE id_mbre='$id'");
		
		$ip = $_SERVER['REMOTE_ADDR']; $date= date("Y-m-d") ; $pseudo= $_SESSION['sess_pseudo']; $nomfichier=$_SESSION['nomfichier'];
		$sql2 = mysql_query("INSERT INTO `ix_upload` ( `nomfichier` , `nomoriginal` , `membre` , `ip` , `date`) VALUES ( '$imgurl', '$nomfichier','$pseudo','$ip','$date')") or die ("erreur sql " . mysql_error());

		//$sql2 = mysql_query("INSERT ix_upload 
		unset($_SESSION['nomfichier']); $_SESSION['AvatarOk']=1;
		rediriger("../?page=upload&action=RedimAvatarOk");
break;
}
?>