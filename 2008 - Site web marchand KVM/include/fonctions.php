<?php

/* 
 * KVM E-commerce : fonctions.php
 *
 * Liste des fonctions usuelles utilisés dans le site et l'administration
 * + présence du menu membre ( invité/membre ) pour pouvoir y accéder en ajax
 */
 
// Inclusions des fichiers indispensables
include_once 'config.php';
include_once 'template.php';
initialiser();
//unregister_globals();

// Initialise la connexion au serveur SQL et récupères les variables de configuration
function initialiser() {

	//:: Connexion Mysql :://
	$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
	mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");

	$sql_config=mysql_query("SELECT cle, valeur FROM ".PREFIX."config");
	while($conf=mysql_fetch_array($sql_config, MYSQL_ASSOC))
	{
		define($conf['cle'], $conf['valeur']);
	}
}

function unregister_globals()
{
	$register_globals = @ini_get('register_globals');
	if ($register_globals === "" || $register_globals === "0" || strtolower($register_globals === "off"))
		return;

	// Prevent script.php?GLOBALS[foo]=bar
	if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS']))
		exit('Ta seule richesse c\'est ton sentiment qui te pousse vers l\'avant.');
	
	// Variables that shouldn't be unset
	$no_unset = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');

	// Remove elements in $GLOBALS that are present in any of the superglobals
	$input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
	foreach ($input as $k => $v)
	{
		if (!in_array($k, $no_unset) && isset($GLOBALS[$k]))
		{
			unset($GLOBALS[$k]);
			unset($GLOBALS[$k]);	// Double unset to circumvent the zend_hash_del_key_or_index hole in PHP <4.4.3 and <5.1.4
		}
	}
}


// Initialisation et gestion des sessions ( invités ou membres ) liés au panier de l'utilisateur 
function gestion_panier() {
	
	// Si la personne est connecté, on récup son panier enregistré
	if (is_log()) {
		$sqlPanier=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE id_membre=".$_SESSION['sess_id']);
		$panier=mysql_fetch_object($sqlPanier);
		$liste_panier=$panier->liste_produits_s;
	}
	else
	{
		// On détecte une session
		if (!empty($_COOKIE['sess_invite_id'])) {
			
			// La session invité est-elle valide ?
			$idInvite=(int)$_COOKIE['sess_invite_id'];
			$sqlVerif=mysql_query("SELECT ip, cle, last_activitee FROM ".PREFIX."session_invites WHERE id_session=$idInvite");
			$verif=mysql_fetch_object($sqlVerif);
			
			if ( $verif->ip==ip() && $verif->cle==$_COOKIE['sess_invite_cle'] && $verif->last_activitee>(time()-(3600*24)*7) ) {
				// Session valide : on récupère le panier
				$sqlPanier=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE id_sess_invite=".$idInvite);
				$panier=mysql_fetch_object($sqlPanier);
				$liste_panier=$panier->liste_produits_s;
			}
			else
			{
				// Session invalide : On suppr les cookies et on en cré une autre
				unset($_COOKIE['sess_invite_id'], $_COOKIE['sess_invite_cle']);

				// On cré une session invitée
				$cle=genKey(50);
				$ip=ip();
				$act=time();
				$sqlCreer=mysql_query("INSERT INTO ".PREFIX."session_invites (`ip`,`cle`,`last_activitee`) VALUES ('$ip', '$cle', '$act')");
					setcookie('sess_invite_id', mysql_insert_id()+' dfds', (time() + (3600*24)*7 ), '/../') or die('Erreur cookies 1<br />');
					setcookie('sess_invite_cle', $cle, (time() + (3600*24)*7 ),'../') or die ('Erreur cookies 2<br />'.headers_sent());			$liste_panier=NULL;
				
			}
				
		}
		
		// Pas connecté et pas de session invitée
		else
		{
		
			$cle=genKey(50);
			$ip=ip();
			$act=time();
			$sqlCreer=mysql_query("INSERT INTO ".PREFIX."session_invites (`ip`,`cle`,`last_activitee`) VALUES ('$ip', '$cle', '$act')");
					setcookie('sess_invite_id', mysql_insert_id(), (time() + (3600*24)*7 ),'../');
					setcookie('sess_invite_cle', $cle, (time() + (3600*24)*7 ),'/../');

			$liste_panier=NULL;
		
		}
	
	}
	
	return $liste_panier;

}

// Met en forme le contenu du panier dans une mini-liste ( comme sur le bloc menu )
function lister_panier($liste_s) {

	if (!empty($liste_s) || is_array($liste_s) ) {
		(is_array($liste_s)) ? $liste=$liste_s : $liste=unserialize($liste_s);
		$total=0;
		foreach($liste as $arrayId=>$arrayInfos) {
			list($idProduit, $nbProduit)=$arrayInfos;
			
			// Infos sur le produit :
			$sql=mysql_query("SELECT nom, prix FROM ".PREFIX."produits WHERE id_produit=$idProduit");
				@extract(recupBdd(mysql_fetch_array($sql)));
				
			$menu_panier.="<li>$nbProduit x <strong>".tronquerChaine($nom,15)."</strong> <span>".round($prix*$nbProduit*TAXE,2)." &euro;</span></li>";
			$total+=$prix*$nbProduit*TAXE;
		}
		$menu_panier.="<li class='total'>TOTAL TTC : <span>".round($total,2)." &euro;</span></li>
					   <li class='finaliser'><img src='images/boutons/cart_go.png' /> &nbsp;<a href='mon-panier.htm'>Détail de ma commande</a></li>";
	} else $menu_panier.="<li>Votre panier est vide</li>";
	
	return $menu_panier;

}



// Affiche des menus, et particulièrement le menu membre ( accessible de ce fait en ajax )
function menu($menu)
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
				$txt='<form id="form_connexion" action="#" method="post" onsubmit="connexion(); return false" class="nomargin">
						<fieldset style="margin:0">
							
							<h4> &nbsp; Connexion  son espace privé</h4>
							<table style="border:0; width:100%; padding-left:20px">
								<tr>
									<td style="width:140px"><label for="log_pseudo"><strong>Pseudo</strong></label></td>
									<td><input type="text" name="log_pseudo" id="log_pseudo" style="width:100px" tabindex="1" class="log" /></td>
								</tr>
								<tr>
									<td><label for="log_pass"><strong>Pass</strong></label></td>
									<td><input type="password" name="log_pass" id="log_pass" style="width:100px" tabindex="2" class="log"  /></td>
								</tr>
								<tr>
									<td colspan="2" id="log_submit"><input type="submit" value="Connexion" class="f-submit" tabindex="3" /></td>	
								</tr>
								<tr>
									<td colspan="2" id="log_statut" style="display:none"><img src="images/indicator2.gif" style="vertical-align:middle" /> Connexion en cours</td>
								</tr>					
							</table>
				
						</fieldset>
					 </form>
				
				<div style="margin:7px 0 0 27px">
					<img src="images/boutons/user.png" alt="Inscription" />&nbsp; <a href="inscription.htm">Inscription</a><br />
					<img src="images/boutons/key.png" alt="Mdp perdu" />&nbsp; <a href="mot-de-passe-perdu.htm">Mot de passe perdu </a><br />
				</div>';
				
			}
			else 
			{	

				
				// Menu membre
				$txt='<h5>Mon espace perso</h5>
						<img src="images/boutons/user.png" />&nbsp; <a href="mon-compte.htm">Gérer mon compte</a><br />
						<img src="images/boutons/door_out.png" />&nbsp; <a href="deconnexion.htm">Déconnexion</a><br />';
				
				if (is_admin()) $txt.='<img src="images/boutons/monitor.png" />&nbsp; <a href="index.php?admin-accueil">Administration</a>';

				/*// Sélection des différentes devises :
					//	 Devise choisie :
					if (is_numeric($_SESSION['sess_id_devise']) && $_SESSION['sess_id_devise']!=0) $deviseSelect=$_SESSION['sess_id_devise'];
					else $deviseSelect=DEVISE_DEFAUT;
					
				$sqlDevises=mysql_query("SELECT nom, id_devise FROM ".PREFIX."devises"); $liste_devises='';
				while($devises=mysql_fetch_object($sqlDevises)) {
						if ($devises->id_devise==$deviseSelect) $s='selected';
						else $s='';
					$liste_devises.='<option value="'.$devises->id_devise.'" '.$s.'>'.recupBdd($devises->nom).'</option>';
				}
				
				$txt.='	<!-- Changer la devise -->
						<form name="devise" method="post" action="changer_devise.htm" class="f-wrap-1" style="margin:15px 0 0 7px">
						<fieldset style="margin:2px; padding-left:7px">
							<strong>Changer la devise :</strong><br />
							<select name="id_devise" style="width:120px; padding-left:5px">
								'.$liste_devises.'
							</select>
							<input type="submit" value="OK" class="f-submit" />
						</fieldset>
						</form>';*/
			}
	
		break;
	}
		
	return $txt;
}


// Connecte un utilisateur en vérifiant son login/pass, gère les droits d'admin, la devise choisie, et gère le panier ( panier invité prioritaire sur panier membre )
function connexion($login, $pass) {

	$ip = ip();
	$sql = mysql_query("SELECT id_membre, pseudo, pass, email, cle, groupe  FROM ".PREFIX."membres WHERE pseudo='$login' AND groupe>=1 AND groupe!=".GROUPE_BAN) or die(mysql_error());
	$result = mysql_fetch_object($sql);
	
			if ( $result->pass==$pass AND $result->id_membre!=0 ) 
			{
						//#### On récupère les données générales du membre ####//
						$_SESSION['sess_id']= $result->id_membre;
						$_SESSION['sess_pseudo'] = $login;
						$_SESSION['sess_level']= $result->groupe;
						$_SESSION['sess_last_activity']=time();
						
						/*// Gestion de la devise
						$sqlInfosSup=mysql_query("SELECT id_devise FROM ".PREFIX."membres_config WHERE id_membre=".$result->id_membre);
						$infos=mysql_fetch_object($sqlInfosSup);
							$_SESSION['sess_id_devise']=$infos->id_devise;*/
										
							
						//#### Gestion du panier ####//  //> Si l'invité a un panier Invité, on le transforme en panier membre <//						
						$idInvite=(int)$_COOKIE['sess_invite_id'];
						$sqlVerif=mysql_query("SELECT ip, cle, last_activitee FROM ".PREFIX."session_invites WHERE id_session=$idInvite");
							$verif=mysql_fetch_object($sqlVerif);
						
							// Session Invité valide ?
							if ( $verif->ip==ip() && $verif->cle==$_COOKIE['sess_invite_cle'] && $verif->last_activitee>(time()-(3600*24)*7) ) 
							{

								// Oui -> Y-a-t-il un panier invité ?
								$sqlPanInv=mysql_query("SELECT liste_produits_s FROM ".PREFIX."paniers_membres WHERE id_sess_invite=$idInvite");
								$panInv=mysql_fetch_object($sqlPanInv);
								
									// Oui -> On transformme le panier invité en panier membre -> FIN
									if (mysql_num_rows($sqlPanInv)==1) 
									{
										// Suppprime déjà les paniers existants :
										$sqlSuppr=mysql_query("DELETE FROM ".PREFIX."paniers_membres WHERE id_membre=".$_SESSION['sess_id']);
										
										$sqlTrans=mysql_query("UPDATE ".PREFIX."paniers_membres SET id_membre=".$_SESSION['sess_id'].", id_sess_invite='' WHERE id_sess_invite=$idInvite");						
										unset($_COOKIE['sess_invite_id'], $_COOKIE['sess_invite_cle']);
										
									} 
							} 
							
							
						//#### Gestion des droits admins ####//
						if($result->groupe>=GROUPE_ADMIN) { 
							
							$sqlAdmin=mysql_query("SELECT * FROM ".PREFIX."admins_droits WHERE id_admin=".$result->id_membre);
							$a=mysql_fetch_object($sqlAdmin);
							
							// Gestion des droits de l'admin
							$_SESSION['sess_admin']=true; 
							$_SESSION['sess_secure']=$result->cle;
							if ($a->droit_membres==1) $_SESSION['admin_droits']['membres']=true;
							if ($a->droit_editorial==1) $_SESSION['admin_droits']['editorial']=true;
							if ($a->droit_gestion_commandes==1) $_SESSION['admin_droits']['commandes']=true;
							if ($a->droit_config==1) $_SESSION['admin_droits']['config']=true;
						}
									
						// Maj des données ( activitée )
						$sqlMaj = mysql_query('UPDATE '.PREFIX.'membres SET last_ip="'.$ip.'", last_activity="'.time().'" WHERE pseudo="'.$login.'" ');
						return true;									
			} else {	
						return false;										
			}
}


// Est connecté ? retourne true ou false
function is_log() {
	if (isset($_SESSION['sess_id']) && $_SESSION['sess_id']!=0) return true;
	else return false;
}
// Est admin ? retourne true ou false ( pas vraiment sécurisé )
function is_admin() {
	if ( !isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure']) )
		return false;
	else
		return true;
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

/* Vérification de sécurité administrateur avec gestion des droits
	 $droits : Liste des droits nécessaires, syntaxe : "membres editorial commandes config" */
function securite_admin($droits=null, $ajax=false) {

	// Vérifie si le membre est admin
    if (!isset($_SESSION['sess_pseudo']) || $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure'])) {
		if ($ajax) die("Erreur : accés interdit !");
		bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
			Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
    } 

	// Protection anti vol de sessions
    $sql = mysql_query("SELECT last_ip, cle FROM ".PREFIX."membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "' AND groupe>=".GROUPE_ADMIN." AND groupe!=".GROUPE_BAN);
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != ip() || $result->cle != $_SESSION['sess_secure']) {
		deconnexion();
		if ($ajax) die("Erreur : accés interdit ! Problème avec votre IP");
		bloquerAcces("Nous avons détecté un changement d'adresse IP<br />Par sécurité, merci de vous reconnecter.");
    } 
     
    // Vérifications des droits spécifiques
   if ($droits) {  
		$droitsA=explode(' ', $droits);
	    foreach($droitsA as  $droit) {
			if ($_SESSION['admin_droits'][$droit]!==true) {
				if ($ajax) die("Erreur : accés interdit !");
				bloquerAcces("Vous n'êtes pas autorisé à afficher cette page : Vous n'avez pas les droits nécessires pour accédr à cette page");
			}
		}
		
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

// Fonction plus que basique : envoyer un mail en HTML ^^
function email( $dest, $sujet, $message, $from )
{

	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: ".$from."\n";

	return mail( $dest, $sujet, $message, $headers );

}


/* ****************************************************************************************
   *			FONCTIONS POUR LA GESTION ET LA PROTECTION DES DONNEES SQL                *
   **************************************************************************************** */

// Sécurisation de l'insertion BDD ( addslashe + protection HTML )
function addBdd($txt)
{
	return htmlentities(trim($txt), ENT_QUOTES);
}
	// Idem pour un tableau
	function addslashes_array($a, $htmlentities=false ){
	        if(is_array($a)){
	            foreach($a as $n=>$v){
					if ($htmlentities)  $b[$n]=htmlentities(trim($v), ENT_QUOTES);
	                else				$b[$n]=addslashes_array($v);
	            }
	            return $b;
	        }else{
				if ($htmlentities)  return htmlentities(trim($a), ENT_QUOTES);
	            else				return addslashes($a);
	        }
	}
// Sécurisation de la sélection BDD ( array ou donnée simple )
function recupBdd($txt)
{
	if (is_array($txt)) {
		foreach($txt as $cle=>$val) {
			$txt[$cle]=stripslashes($val);
		}
		return $txt;
	}
	else 
		return stripslashes($txt);
}

// Automatisation verification sql
function verif_champs_requis($redir_erreur, $donnees, $requis){
	
	$etat=true;
	foreach($requis as $cle) {
		if (empty($donnees[$cle])) $etat=false;
	}

	if (!$etat) { header('location: '.$redir_erreur); die(); }
	else return true;
	
}

// Automatisation ajout sql | $protection : array avec la liste des clé à enregister ( facultatif )
function insererBdd($table, $donnees, $protection=false) {
	
	$sql="INSERT INTO ".$table." SET ";
	
	foreach($donnees as $cle=>$val) {
		// Si protection activée, n'insère que les champs inscrits
		if (($protection && in_array($cle, $protection)) || !$protection) {
			$val=mysql_real_escape_string($val);
			$sql.="`$cle` = '$val', ";		
		}	
	}
	
	$sql=substr($sql, 0, -2);
	
	$query=mysql_query($sql);
	return $query;
}

// Automatisation modification sql
function majBdd($table, $where, $donnees, $protection=false) {
	
	$sql="UPDATE ".$table." SET ";
	
	foreach($donnees as $cle=>$val) {
		// Si protection activée, n'insère que les champs inscrits
		if (($protection && in_array($cle, $protection)) || !$protection) {
			$val=mysql_real_escape_string($val);
			$sql.="`$cle` = '$val', ";		
		}	
	}
	
	$sql=substr($sql, 0, -2);
	$sql.=' WHERE '.$where;
	
	$query=mysql_query($sql);
	
	return $query;
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


// Met en forme un texte suivant différents styles prédéfinis
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
		case "bad":
			return '<p class="error"><img src="images/boutons/exclamation.png" /> '.$texte.'</p>';
		break;
		case "ok":
			return '<p class="success">'.$texte.'</p>';
		break;
		default:
			return $texte;
		break;
	}
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

?>