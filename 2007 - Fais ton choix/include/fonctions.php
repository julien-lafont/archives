<?php
/*  ---------------------------------------------------------------------------------------------------------------
	  Mes fonctions perso
    --------------------------------------------------------------------------------------------------------------- */

// On inclus le fichier de configuration et le système de template
include_once 'config.php';
include_once 'template.php';

// Echo spécial compressant le texte ( suppression saut à la lignes, espaces redondants ... ).
// Indispensable en jvs !
function echo2($txt)
{
	$txt = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $txt);
	echo $txt;

}

// Version spécial de echo2() permettant une compabilité avec la syntaxe JSON
function json($txt) 
{
	// Recode pour mettre entre deux \' \' en Json nottament
	$txt = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $txt);
	$txt = preg_replace ('#\'#', '\\\'', $txt);
	return $txt;
}


// Connecte un utilisateur en vérifiant son login/pass
function connexion($login, $pass) {

	$ip = ip();
	$sql = mysql_query("SELECT id, pseudo, pass, groupe FROM ".PREFIX."admin WHERE pseudo='$login' AND groupe>=1 AND groupe!=".GROUPE_BAN) or die(mysql_error());
	$result = mysql_fetch_object($sql);

			if ( $result->pass==$pass AND $result->id!=0 ) 
			{
				
				$_SESSION['sess_id']= $result->id;
				$_SESSION['sess_pseudo'] = $login;
				$_SESSION['sess_level']= $result->groupe;
				$_SESSION['sess_last_activity']=time();
				if($result->groupe>=GROUPE_ANIM) { $_SESSION['sess_admin']=true;  }
				
				// Maj des données
				$sqlMaj = mysql_query('UPDATE '.PREFIX.'admin SET last_ip="'.$ip.'", nb_connexion=nb_connexion+1 WHERE pseudo="'.$login.'" ');
				return true;
													
			} else {	
				return false;										
			}
}

// Vérifie l'accés des membres en vérifiant si leur numéro de groupe est autorisé
// Utiliser le signe '+' pour indiquer 'et supérieurs', ex : '5+' -> '5,6,7,8' ( 9 = banni )
// OU alors définir explicitement : "1-2-3-5-8"
function securite($groupes, $if=false, $ip=true ) {
global $design;

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
	if ($ip && $good)
	{
		$sql = mysql_query("SELECT last_ip FROM ".PREFIX."admin WHERE pseudo='" . $_SESSION['sess_pseudo'] . "'");
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
		if ($if) 	return false;
		else		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
						Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
    } 

}

// Vérifie l'accés aux pages admin
function securite_admin($ajax=false) {

    if (!isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 ) {
		if ($ajax) die("Erreur : accés interdit !");
		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
			Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
    } 

   $sql = mysql_query("SELECT last_ip FROM ".PREFIX."admin WHERE pseudo='" . $_SESSION['sess_pseudo'] . "' AND groupe>=".GROUPE_ADMIN." AND groupe!=".GROUPE_BAN);
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != ip()) {
		deconnexion();
		if ($ajax) die("Erreur : accés interdit ! Problème avec votre IP");
		bloquerAcces("Pbm Ip");
    } 
}

// Bloque l'accés avec message d'erreur
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

	session_unset();
	session_destroy();

}

// Met à jour le flux rss
function maj_rss() {

	$xml = '<?xml version="1.0" encoding="iso-8859-1"?><rss version="2.0">';
	$xml .= '<channel>'; 
	$xml .= '<title>Fais ton choix .fr</title>';
	$xml .= '<link>'.URL.'</link>';
	$xml .= '<description>Duels de photos en ligne - Décide qui sera le vainqueyr</description>';
	$xml .= '<copyright>© Faistonchoix.fr 2007</copyright>';
	$xml .= '<language>fr</language>';
	
	$res=mysql_query("SELECT * FROM ".PREFIX."duels ORDER BY id DESC LIMIT 0, 10");
	while($d=mysql_fetch_object($res)){   
			$titre=$d->nom1." vs ".$d->nom2;
			$adresse=URL.'duel-'.recode(recupBdd($d->nom1)).'_ou_'.recode(recupBdd($d->nom2)).'-'.$d->id.'.htm';
			$contenu='Accéder au duel';
					
			$madate=$d->timestamp;
			$datephp=date("D, d M Y H:i:s +0100", strtotime($madate));
	
				$xml .= '<item>';
				$xml .= '<title>'.$titre.'</title>';
				$xml .= '<link>'.$adresse.'</link>';
				$xml .= '<guid isPermaLink="True">'.$adresse.'</guid>';
				$xml .= '<pubDate>'.$datephp.'</pubDate>'; 
				$xml .= '<description>'.$contenu.'</description>';
				$xml .= '</item>';	
		}
	
	$xml .= '</channel>';
	$xml .= '</rss>';
		   
	$fp = fopen("rss.xml", 'w+');
	fputs($fp, $xml);
	fclose($fp);

	
}

// Ajouter-Récupérer des infos sql
function addBdd($txt)
{
	return htmlentities(trim($txt), ENT_QUOTES);
}
function recupBdd($txt)
{
	return stripslashes($txt);
}


// Tronque une chaine de caractère
function tronquerChaine($chaine, $max=100)
{
	if(strlen($chaine)>=$max){
	   $chaine=substr($chaine,0,$max); 
	   $chaine.=" ..."; 
	}  
	return $chaine;
}


// Calcule la différence entre 2 dates
function difference_date($time) {
	$now=time();
	$diff=$now-$time;
	if ($diff<=60) $r=$diff."s";
	if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
	if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
	if ($diff>86400) $r=round(($diff/86400))."j";
	return $r;
}

// Génération automatique de clé
function GenKey($nbcaract = 8)
{
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$str .= $string[mt_rand() % strlen($string)];
    } 
    return $str;
} 

// Permet de rendre une url compatible avec l'url rewriting
function recode($txt, $supprEsp=true){ 
	 $new= strtr($new,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	 $new = preg_replace('#\[#', '-', $txt);
	 $new = preg_replace('#\]#', '-', $new);
	 $new = preg_replace("#[\\\'?!:,;|*=+°)(}{\#~&%$£<>./\"\$]#", "-", $new);
	 if ($supprEsp) $new = preg_replace("#[ ]#", "-", $new);
	 $new = preg_replace("#[-_]+#", "-", $new); /* Si plusieurs -- ou ___ on en met qu'un seul */
	 $new = preg_replace("#[-_]$#", "", $new); /* Vire le - ou _ final */
	return $new;
}

// Retourne l'ip réelle
function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}

//:: Fonctions de Mise en Forme :://
function miseEnForme($type, $texte)
{
	switch($type)
	{
		case "message":
			return '<div style="text-align:center">
						<div style="width:80%; text-align:center; margin-top:50px; margin-bottom:50px; margin-left:auto; margin-right:auto">
							'.$texte.'
							<br /><br /><a href="'.URL.'" title="Accueil du site Faistonchoix.fr">Accueil Faistonchoix</a>
						</div>
					</div>';
		break;
		case "erreur":
			return '<div style="width:100%; text-align:center; margin-top:50px; margin-bottom:50px;">
						<u style="color:#ec5994; font-weight:bold;">Erreur détectée : </u><br /><br />
						<div style="font-family:courier">'.$texte.'</div><br /><br />
						<i>Si le problème persiste, veuillez contacter un administrateur.<br />
						Merci de votre compréhension.</i><br /><br />
						<a href="'.URL.'" title="Accueil du site Faistonchoix.fr">Accueil Faistonchoix</a>
					</div>';
		break;
		default:
			return $texte;
		break;
	}
}

/*
// Est admin ? retourne true ou false ( vérification rapide )
function is_admin() {
	if ( !isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure']) )
		return false;
	else
		return true;
}


// Message + redirection javascript
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
    if ($style == 4) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(.)
		$madate=substr($madate,0,10);
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j.$m.$a";
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
}*/


?>