<?php
// Mode WAP ?
if ($_SERVER['SERVER_NAME']=='wap.d4team.info') $wap=true;

include_once 'config.php';
include_once 'template.php';
include_once 'menus.php';

//:: Fonctions de Mise en Forme :://
function miseEnForme($type, $texte)
{
	switch($type)
	{
		case "message":
			return '<div style="text-align:center">
						<div style="width:80%; text-align:center; margin-top:50px; margin-bottom:50px; margin-left:auto; margin-right:auto">
							'.$texte.'
						</div>
					</div>';
		break;
		case "erreur":
			return '<div style="width:100%; min-height:450px;text-align:center; margin-top:50px; margin-bottom:50px;">
						<u style="color:#ec5994; font-weight:bold;">Erreur détectée : </u><br /><br />
						<div style="font-family:courier">'.$texte.'</div><br /><br />
						<i>Si le problème persiste, veuillez contacter un administrateur.<br />
						Merci de votre compréhension.</i><br /><br />
						<a href="http://www.d4team.com" title="Accueil du site Dimension4">Accueil de D4team.com</a>
					</div>';
		break;
		default:
			return $texte;
		break;
	}
}

// Trouve le path pour afficher les images malgré l'url rewriting
function path()
{	
	$path="";
	if ($_SERVER['REQUEST_URI']!=URL_REL) {
		$path=str_replace(URL_REL, "", $_SERVER['REQUEST_URI']);
		
		$path=substr($path, 1);
		$nbRep=substr_count($path, '/');	
		$path="";	
		for ($i=0; $i<$nbRep; $i++) {
			$path .= "../";
		}
	}
	return $path;
}

// Connecte un utilisateur en vérifiant son login/pass
function connexion($login, $pass) {

	$ip = ip();
	$sql = mysql_query("SELECT id, pseudo, mdp, cle, groupe, nb_gb_lu FROM ".PREFIX."membres WHERE pseudo='$login' AND groupe>=1 AND groupe!=".GROUPE_BAN) or die(mysql_error());
	$result = mysql_fetch_object($sql);
	
			if ( $result->mdp==$pass AND $result->id!=0 ) 
			{
						$_SESSION['sess_id']= $result->id;
						$_SESSION['sess_pseudo'] = $login;
						$_SESSION['sess_level']= $result->groupe;
						$_SESSION['sess_last_activity']=time();
						if($result->groupe>=GROUPE_ADMIN) { $_SESSION['sess_admin']=true; $_SESSION['sess_secure']=$result->cle; }
						
						// Nouveaux messages ?
						$sqlMess = mysql_query("SELECT count(id) as nbMess FROM ".PREFIX."messagerie WHERE id_dest=".$result->id." AND etat!='lu'");
						$mess = mysql_fetch_object($sqlMess);
						if ($mess->nbMess>0) $_SESSION['nouveau_message']=$mess->nbMess;
						
						// Nombres messages lues guestbook ?
						$_SESSION['sess_gb_lu'] = $result->nb_gb_lu;
						
						// Maj des données
						$sqlMaj = mysql_query('UPDATE '.PREFIX.'membres SET last_ip="'.$ip.'", last_activity="'.time().'" WHERE pseudo="'.$login.'" ');
						return true;									
			} else {	
						return false;										
			}
}

// Fonction gérant l'activité des membres : online ou non
function manage_activity() {
	$now=time();
	if ($now >= ($_SESSION['sess_last_activity']+60*5) ) {
		$sql_maj = mysql_query('UPDATE '.PREFIX.'membres SET last_activity="'.time().'" WHERE id='.$_SESSION['sess_id'] );
		$_SESSION['sess_last_activity']=time();
	}
}

// Affiche une image en fonction du sexe/de la connexion
function imgOnline($sexe, $activite)
{
	if ( time()>=$activite && time()<=($activite+5*60) ) { 
		if ($sexe=="f")	$img="ico_femme.gif";
		else 			$img="ico_homme.gif";
	} else { 
		if ($sexe=="f")	$img="ico_femme_off.gif";
		else 			$img="ico_homme_off.gif";
	}
	return $img;
}

// Est connecté ? retourne true ou false
function is_log() {
	if (isset($_SESSION['sess_id'])) return true;
	else return false;
}
// Est admin ? retourne true ou false
function is_admin() {
	if ( !isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure']) )
		return false;
	else
		return true;
}

// Vérifie l'accés des membres en vérifiant si leur numéro de groupe est autorisé
// Utiliser le signe '+' pour indiquer 'et supérieurs', ex : '5+' -> '5,6,7,8' ( 9 = banni )
// OU alors définir explicitement : "1-2-3-5-8"
function securite_groupes($groupes, $ip=true) {

	// On part avec une valeur positive
	$good=true;
	
	// Si banni
 	if ($_SESSION['sess_level']==GROUPE_BAN) $good=false;
	
	// Appartient aux groupes ? ( syntaxe avec + puis syntaxe détaillée
	if (strpos($groupes, "+"))
	{	
		if ($_SESSION['sess_level']<$groupes{0}) $good=false;
	}
	else 
	{
		$nb=explode("-", $groupes);
		foreach($nb as $value)
		{
			if ($_SESSION['sess_level']==$value && $good) $tempgood=true;
		}
		if (!$tempgood) $good=false;
	}
	
	// Vérification supplémentaire du pseudo
	if (!isset($_SESSION['sess_pseudo'])) $good=false;

	// Vérification de l'IP si il le faut
	if (ip && $good)
	{
		$sql = mysql_query("SELECT last_ip FROM ".PREFIX."membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "'");
		$result = mysql_fetch_object($sql);
		if ($result->last_ip != ip()) {
			$good=false;
		} 
	}
	
	// Conclusions
	if ($good)
	{
		return true;
	} 
	else 
	{
		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
			Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
    } 

}


// Vérifie de façon sécurisée que l'utilisateur est loggué en tant que membre
function securite_membre($ajax=false) { 

    if (!isset($_SESSION['sess_pseudo'])) {
		if ($ajax) die("Erreur : accés interdit !");
		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
			Veuillez vous connecter à votre compte.");
    } 

    $sql = mysql_query("SELECT last_ip FROM ".PREFIX."membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "' AND groupe>=1 AND groupe!=".GROUPE_BAN);
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != ip()) {
		deconnexion();
		if ($ajax) die("Erreur : accés interdit ! Problème avec votre IP");
		bloquerAcces("Pbm Ip");
    } 
    
}

// Vérification admin Sécurité normal ( sans validcode )
function securite_admin($ajax=false) {

    if (!isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure'])) {
		if ($ajax) die("Erreur : accés interdit !");
		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
			Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
    } 

   $sql = mysql_query("SELECT last_ip, cle FROM ".PREFIX."membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "' AND groupe>=".GROUPE_ADMIN." AND groupe!=".GROUPE_BAN);
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != ip() || $result->cle != $_SESSION['sess_secure']) {
		deconnexion();
		if ($ajax) die("Erreur : accés interdit ! Problème avec votre IP");
		bloquerAcces("Pbm Ip");
    } 
}



function bloquerAcces($txt)
{
	global $design;
	$design->template('simple');
	$design->zone('contenu', miseEnForme("erreur",$txt));
	$design->zone('titre', 'Accés bloqués !');
	$design->zone('titrePage', 'Erreur 403');
	$design->afficher();
	die();

}

// Déconnecte un membre ou un admin
function deconnexion() { 

	$lastActivity=$_SESSION['sess_last_activity']-(60*5)-1;
	$sql_deco=mysql_query("UPDATE ".PREFIX."membres SET last_ip='0', last_activity='$lastActivity' WHERE id=".$_SESSION['sess_id']);
	session_unset();
	session_destroy();

}

function envoyerMp($destId, $sujet, $message, $etat='nouveau')
{
	$exped=$_SESSION['sess_id'];
	$ip=ip();
	$sql=mysql_query("	INSERT INTO ".PREFIX."messagerie
							(`id_exped`, `id_dest`, `sujet`, `message`, `etat`, `date`, `ip`)
						VALUES
							('$exped', '$destId', '$sujet', '$message', '$etat', NOW(), '$ip' )
						") or die("Erreur envoie MP : ".mysql_error());
	
	/* Amélioration : envoyer un mail ?? */
	
	if ($sql) return true;
	else	  return false;

}

function email( $dest, $sujet, $message, $from )
{

	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: ".$from."\n";

	return mail( $dest, $sujet, $message, $headers );

}

function creerMiniature( $imageb, $newWidth, $newHeight, $nom)
{
	
	eregi("(...)$",$imageb,$regs); $type = strtolower($regs[1]);
	
	switch($type)
	{
		case "gif": $image = imagecreatefromgif( $imageb ); break;
		case "jpg": $image = imagecreatefromjpeg( $imageb); break;
		case "png": $image = imagecreatefrompng( $imageb ); break;
		default : unset($type); break;
	}
		
	if($image)
	{
	
		$srcWidth = imagesx( $image );
		$srcHeight = imagesy( $image );
		$ratioWidth = $srcWidth/$newWidth;
		$ratioHeight = $srcHeight/$newHeight;
	
		if (($ratioWidth > 1) || ($ratioHeight > 1))
		{
			if( $ratioWidth < $ratioHeight) {
				$destWidth = $srcWidth/$ratioHeight;
				$destHeight = $newHeight;
			} else {
				$destWidth = $newWidth;
				$destHeight = $srcHeight/$ratioWidth;
			}
		} else {
			$destWidth = $srcWidth;  $destHeight = $srcHeight;
		}
		
		$image_p = imagecreatetruecolor ( $destWidth, $destHeight );
		imagecopyresampled ( $image_p, $image, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight );
		
	// création et sauvegarde de l'image finale
	switch($type)
	{
		case "gif": imagegif ( $image_p, $nom ); break;
		case "jpg": imagejpeg( $image_p, $nom, 100); break;
		case "png": imagepng ( $image_p, $nom ); break;
	}
	
	// libère la mémoire
	imagedestroy( $image_p );
	imagedestroy( $image );
	
	// renvoit l'URL de l'image
	return $nom;
	
	}
	else 
	{ 
		return false;
		exit;
	}
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

function addBdd($txt)
{
	return htmlentities(trim($txt), ENT_QUOTES);
}

function recupBdd($txt)
{
	return stripslashes($txt);
}

function rediriger($url) {
	header('location: '.$url);
	die('Redirection');
}

function tronquerChaine($chaine, $max=100)
{
	if(strlen($chaine)>=$max){
	   $chaine=substr($chaine,0,$max); 
	   $chaine.=" ..."; 
	}  
	return $chaine;
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
	} 
    if ($style == 4) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(-)
		$madate=substr($madate,0,10);
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j-$m-$a";
	} 
    if ($style == 5) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(-) COMPLET avec <BR>
		$madate1=substr($madate,0,10);
		$madate2=substr($madate,11,8);
        list($a, $m, $j) = explode("-", $madate1);
        list($h, $mn, $s) = explode(":", $madate2);
        $newdate = "$j/$m/$a <br />$h:$mn:$s";
	} 
    if ($style == 6) { // Idem 5 SANS <BR>
		$madate1=substr($madate,0,10);
		$madate2=substr($madate,11,8);
        list($a, $m, $j) = explode("-", $madate1);
        list($h, $mn, $s) = explode(":", $madate2);
        $newdate = $j.'/'.$m.'/'.$a.' à '.$h.'h'.$mn;
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
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$str .= $string[mt_rand() % strlen($string)];
    } 
    return $str;
} 


function recode($txt, $supprEsp=true){ // Pour URL Rewriting
	 $new = preg_replace('#\[#', '-', $txt);
	 $new = preg_replace('#\]#', '-', $new);
	 $new = preg_replace("#[\\\'?!:,;|*=+°)(}{\#~&%$£<>./\"\$]#", "-", $new);
	 if ($supprEsp) $new = preg_replace("#[ ]#", "-", $new);
	 $new = preg_replace("#[-_]+#", "-", $new); /* Si plusieurs -- ou ___ on en met qu'un seul */
	 $new = preg_replace("#[-_]$#", "", $new); /* Vire le - ou _ final */
	 $new= strtr($new,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	return $new;
}

function bbcode($text)
{	
	$smy1 = array("8-:" , "^:" , ":cool:" , ":pet:" , ":evil:" , ":D" , ":bad:" , ":good:" , ":lang:" , ":rah:" , ":??:" , ":)" , ":scotch:" , ":intello:" , ":whaou:" , ":!:" , ":zzz:" , ":bye:" , ":yeux:" , ":rrah:" , ":coool:" , ":hein:" , ":locked:" , ":censored:" , ":spam:");
	$smy2 = array("blink.gif" , "CADQ0UD5.png" , "cool.gif" , "cool40.gif" , "evil.gif" , "06.gif" , "128.gif" , "ok.gif" , "130.gif" , "32.gif" , "91.gif" , "original.gif" , "shutup.gif" , "smartass.gif" , "w00t.gif" , "sign56.gif" , "61.gif" , "sign05.gif" , "unsure.gif" , "basic_15.png" , "basic_13.png" , "basic_2.png" , "sign52.gif" , "sign53.gif" , "sign54.gif");

    $text = preg_replace("#\[img\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", "'<img src=\\1' . str_replace(' ', '%20', '\\3') . '>'", $text);
    $text = preg_replace("#\[url\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/url\]#sie", "'<a href=\"\\1' . str_replace(' ', '%20', '\\3') . '\" target=blank>\\1\\3</a>'", $text);
    $text = preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/", "<a href=$1 target=blank>$2</a>", $text);

    $text = preg_replace("/\[b\](.+?)\[\/b\]/", "<b>$1</b>", $text);
    $text = preg_replace("/\[i\](.+?)\[\/i\]/", "<i>$1</i>", $text);
    $text = preg_replace("/\[u\](.+?)\[\/u\]/", "<u>$1</u>", $text);

    $text = preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/", "<font color=\"$1\">$2</font>", $text);
	
	$text = preg_replace("/\[\/\-(.+?)\]/", "</div>", $text);
    $text = preg_replace("/\[\-(.+?)\]/", "<div align=\"$1\">", $text);
	
	for ($i=0;$i<=count($smy1);$i++) {
		$text = str_replace($smy1[$i],'<img src="images/smileys/'.$smy2[$i].'" style="border:0"/>',$text); 
	}
		
    return $text;
} 

function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}

function printr($array)
{
   static $indentation = '';
   static $array_key = '';
   $cst_indentation = '&nbsp;&nbsp;&nbsp;&nbsp;';

   echo "<div style='font-size:10px; text-align:left; background-color:#FFF; margin:5px; padding:5px; width:100%'>";
   echo $indentation . $array_key . '<b>array(</b><br />';
   reset($array);
   while (list($k, $v) = each($array))
   {
      if (is_array($v))
      {
         $indentation .= $cst_indentation;
         $array_key = '\'<i style="color: #334499 ;">' . addslashes(htmlspecialchars($k)) . '</i>\' => ';
         printr($v);
         $indentation = substr($indentation, 0, strlen($indentation) - strlen($cst_indentation));
      }
      else
      {
         echo $indentation . $cst_indentation . '\'<i style="color: #334499 ;">' . 
 		 addslashes(htmlspecialchars($k)) . '</i>\' => \'' . addslashes(htmlspecialchars($v)) . '\',<br />';
      }
   }
   echo $indentation . '<b>)</b>' . (($indentation === '') ? ';' : ',') . '<br /></div>';
}
?>