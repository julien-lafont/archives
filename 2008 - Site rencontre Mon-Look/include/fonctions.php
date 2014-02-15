<?php
include 'include/config.inc.php';
include 'include/blocs.php';
include 'include/headandfoot.php';

$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");

function rediriger($url)
{
	header ("location: $url");
	exit;
} 

function connexion($login,$pass) {

	if (@$_SESSION['tentative']>=5) { return 0; exit; }
	
	$ip = ip();
	$sql = mysql_query("SELECT id_membre, password, gender, email, ban, fname, lname, admin, validcode, dir_galerie FROM members WHERE username='$login' AND ban!='1'");
	$result = mysql_fetch_object($sql);
	
			if ( $result->password==$pass) 
			{
						@$_SESSION['tentative']=0;
						$_SESSION['sess_id']= $result->id_membre;
						$_SESSION['sess_pseudo'] = $login;
						$_SESSION['sess_dir'] = $result->dir_galerie;
						$_SESSION['sess_gender']= ucfirst($result->gender);
						if($result->admin==1) { $_SESSION['sess_admin']=1; $_SESSION['sess_secure']=$result->validcode; }
						$sql_maj = mysql_query('UPDATE members SET ip="'.$ip.'", online="1", lastdate="'.time().'" WHERE username="'.$login.'" ');
						return 1;									
			} else {	
						$_SESSION['tentative']++;
						return 0;										
			}
}

function mini_fiche($sql, $i=1) {
	
	if (!mysql_fetch_object($sql)) rediriger("?p=erreur&code=6");
	else mysql_data_seek($sql,0);
	
	while ($data=mysql_fetch_object($sql)) {
	
		if ($data->gender=="h") $gender="Homme";
		if ($data->gender=="f") $gender="Femme";
	    if ($data->cherche=="f") $ch="une <span style='color:#FF00FF; font-family:georgia''>femme</span>";
		if ($data->cherche=="h") $ch="un <span style='color:#0066FF; font-family:georgia''>homme</span>";
	  	if ($data->cherche=="hf") $ch="une <span style='color:#FF00FF; font-family:georgia'>femme</span> ou un <span style='color:#0066FF; font-family:georgia'>homme</span>";
		if ($data->cherche=="p") $ch="<span style='font-family:georgia'>personne :)</span>";
		if ($data->cherche=="") $ch="non-spécifié";
		if (isset($data->img_principale) AND ($data->img_valid==1) ) $photo="upload/principal/$data->img_principale";
		else $photo="images/profil/nophoto_little.png";
		
		echo '<div style="width:95%; padding:2px; margin-bottom:8px;" class="round">
				<table style="width:100%; line-height:15px">
				<tr>
					<td style="width:10px; vertical-align:top; background-color:#3399FF; font-weight:bold; color:#FFFFFF; text-align:center; height:100%" class="roundblue" >'.$i.'</td>
					<td align="center" width=120><a href="?p=infos&pseudo='.$data->username.'"><img src="'.$photo.'" id="img3"></a></td>
					<td><b>Pseudo</b> : <a href="?p=infos&pseudo='.$data->username.'">'.ucfirst($data->username).'</a><br>
						<b>Sexe</b> : '.$gender.'<br>
						<b>Age</b> : '.$data->age.' ans<br>
						<b>Ville</b> : '.ucfirst($data->city).'<br>
						<b>Cherche</b> : '.$ch.'<br>
						<b>Inscrit le</b> : '.inverser_date($data->joindate,4).'<br>
						<b>Dernière connexion </b> : '.difference_date($data->lastdate).' </td>
					<td align="center"><b>Note</b><br><br><span style="color:#FF6633">'.round($data->note,1).' / 10</span><br>'.round($data->coeff_note).' votes</td>
				</tr>
			   </table></div>';
		$i++;
	}
}

function is_log() {
	// Vérification rapide de la connexion !! Aucune Protection !!
	if (isset($_SESSION['sess_pseudo'])) return 1;
	else return 0;
}


function securite_membre() { // Vérifie de façon sécurisée que l'utilisateur est loggué en tant que membre

    if (!isset($_SESSION['sess_pseudo'])) {
		rediriger('?p=erreur&code=01');
    } 

    $sql = mysql_query("SELECT ip FROM members WHERE username='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->ip != ip()) {
		rediriger('?p=erreur&code=02');
    } 
    
}

function high_security_admin($secure) { // Vérification admin Sécurité élevé ( Ip/Session/ValidCodex2 )

	$secure=addslashes($secure);
    if (!isset($_SESSION['sess_pseudo'])|| $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure'])) {
		rediriger('?p=erreur&code=01');
    } 

    $sql = mysql_query("SELECT ip, validcode FROM members WHERE username='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->ip != ip() || $result->validcode!=$secure) {
		deconnexion();
		rediriger('?p=erreur&code=04');
    } 
}

function security_admin() { // Vérification admin Sécurité normal ( sans validcode )

	
    if (!isset($_SESSION['sess_pseudo'])|| $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure'])) {
		rediriger('?p=erreur&code=01');
    } 

    $sql = mysql_query("SELECT ip FROM members WHERE username='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->ip != ip() ) {
		deconnexion();
		rediriger('?p=erreur&code=04');
    } 
}

function envoyerMp($idfrom, $iddest, $sujet, $message ) {
		
	$sql=mysql_query("INSERT INTO mp ( `id_exped` , `id_dest` , `sujet` , `message` , `date`, `etat`  )  
								VALUES ('$idfrom' , '$iddest', '$sujet' , '$message', NOW( ), 'auto' )");
	return $sql;

}
function deconnexion() { 

	// On passe le champs Online à 0
	$sql=mysql_query("UPDATE members SET online='0' WHERE username='".$_SESSION['sess_pseudo']."'");
	// Et on détruit les sessions
	session_unset();
	session_destroy();
}

function message_redir($msg,$url)
{
    echo'<html><head><script language="javascript" type="text/javascript">
		<!-- 
		alert("' . $msg . '"); 
		-->
		</script></head>';
		
	echo "<body bgcolor=\"#F7F7F7\" alink=\"#0066FF\" vlink=\"#0066FF\"><br><br><br><br><br><br><br><br><center><div style=\"font-face:Verdana; font-size:14px; color=#222222; border:1px solid #000000; width:80%; background-color:#FFFFFF\"><br>Redirection en cours à l'adresse : <a href='".URL."/".$url."'> ".URL."/".$url."</a><br><br><br>La redirection ne s'effectuent pas automatiquement si le <font color=\"#FF0000\">javascript</font> n'est pas activé dans les options de votre navigateur.<br>Il est fortement conseillé de l'activer. [ <a href=\"http://www.ixteam.free.fr/javascript.htm\">AIDE ICI</a> ]<br><br></div></center></body></html>";
	echo'<script language="javascript" type="text/javascript">
	<!--
	window.location.replace("' . $url . '");
	-->
	</script>';
	exit;

} 



function inverser_date($madate, $style = 1)
{
    if ($style == 1) { // Mysql  =>  Normal(.)
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j.$m.$a";
    } 
    if ($style == 2) { // Normal(-)  =>  Mysql
        list($j, $m, $a) = explode("-", $madate);
        $newdate = "$a-$m-$j";
    } 
    if ($style == 3) { // Mysql  =>  Normal(-)
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j-$m-$a";
	} // 2006-04-17 15:05:26 //
    if ($style == 4) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(-)
		$madate=substr($madate,0,10);
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j-$m-$a";
	} 
	
    return $newdate;
} 

function difference_date($time) {
	$now=time();
	$diff=$now-$time;
	if ($diff<=60) $r=$diff."s";
	if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
	if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
	if ($diff>86400) $r=round(($diff/86400))."j";
	return $r;
}

function GenKey($nbcaract = 8)
{
    $string = "abcdefghijklmnopqrstuvwxyz0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$pass .= $string[mt_rand() % strlen($string)];
    } 
    return $pass;
} 


function RatioResizeImg( $imageb, $newWidth, $newHeight, $destination, $action=0, $nom=""){
	
	eregi("(...)$",$imageb,$regs); $type = strtolower($regs[1]);
	switch($type){
	case "gif": $image =  @imagecreatefromgif( $imageb ); break;
	case "jpg": $image = @imagecreatefromjpeg( $imageb); break;
	case "png": $image =  @imagecreatefrompng( $imageb ); break;
	default : unset($type); break;}
		
	if($image){
	
	$srcWidth = imagesx( $image );
	$srcHeight = imagesy( $image );
	$ratioWidth = $srcWidth/$newWidth;
	$ratioHeight = $srcHeight/$newHeight;
	
	if (($ratioWidth > 1) || ($ratioHeight > 1)) {
	if( $ratioWidth < $ratioHeight){
	$destWidth = $srcWidth/$ratioHeight;
	$destHeight = $newHeight;
	}else{
	$destWidth = $newWidth;
	$destHeight = $srcHeight/$ratioWidth;}
	}else {$destWidth = $srcWidth;  $destHeight = $srcHeight;}
	
	$image_p = imagecreatetruecolor($destWidth, $destHeight);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
	
	switch($action) {
		case 0:
			$dest_file  = recode($_SESSION['sess_pseudo'])."___".GenKey(5).".".$type;
			while (file_exists("$dest_file"))
			{$dest_file  = recode($_SESSION['sess_pseudo'])."___".GenKey(5).".".$type; }		
		break;
		case 1:
			$dest_file  = $nom;
		break;
		case 2:
			$dest_file  = "_min_".$nom;
		break;
	}
	
	// création et sauvegarde de l'image finale
	switch($type){
	case "gif": @imagegif($image_p, $destination.$dest_file); break;
	case "jpg": @imagejpeg($image_p, $destination.$dest_file,100); break;
	case "png": @imagepng($image_p, $destination.$dest_file); break;}
	
	// libère la mémoire
	imagedestroy( $image_p );
	imagedestroy( $image );
	
	// renvoit l'URL de l'image
	return $dest_file;}
	
	// erreur
	else {echo "Image inexistante ou aucun support ";
			if ($type){echo "pour le format $type";}
			else {echo "pour ce format de fichier";}
	exit;}
}

function recode($txt){ // Pour URL Rewriting
	 $new = ereg_replace("['?!:./, ]", "_", $txt);
	 $new= strtr($new,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	return $new;
}

function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}



?>
