<?php
/*  ---------------------------------------------------------------------------------------------------------------
	   Actions ajax en rapport avec la gestion des membres
	     -> Connexion
	     -> Déconnexion
	     -> Mise à jour des pts
	     -> Afficher le classement
    --------------------------------------------------------------------------------------------------------------- */

header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


switch(@$_GET['act'])
{
case "connexion": 
	
	$email=addBdd($_GET['email']);
	
	// Déjà un compte ?
	$sql=mysql_query("SELECT * FROM ".PREFIX."membres WHERE email='".$email."'");
	$d=mysql_fetch_object($sql);
	$nb=mysql_num_rows($sql);
	
	if ($nb==0) { // si non :
	
		// On ajoute le membre dans la bdd
		$sqlAdd=mysql_query("INSERT INTO ".PREFIX."membres (`email`,`first_connexion`,`points`) VALUES ('".$email."', NOW(), 0)");
		$id=mysql_insert_id();
		
		$_SESSION['log_email']=$email;
		$_SESSION['log_id']=$id;
		$_SESSION['log_vote']=array();
		setcookie('log_email', $_GET['email'], (time() + 604800), URL_REL); /* 7j */
		echo "ok|:|0";
	
	} else { #### !!! COPIE DANS MENUS.PHP POUR CONNEXION VIA LES COOKIES !!! ####
	
		// Sélectionne la position dans le classement :
		$sqlPos=mysql_query("SELECT count(id) as position FROM ".PREFIX."membres WHERE points>".$d->points);
		$pos=mysql_fetch_object($sqlPos);
		
		// Sélection les duels déjà votés:
		$sqlVote=mysql_query("SELECT id_duel FROM ".PREFIX."verifduel WHERE ip='".ip()."' OR email='".$email."'");
		while ($vote=mysql_fetch_object($sqlVote)) {
			$_SESSION['log_vote'][$vote->id_duel]=true;
		}
		
		$_SESSION['log_email']=$email;
		setcookie('log_email', $_GET['email'], (time() + 604800), URL_REL); /* 7j */
		$_SESSION['log_id']=$d->id;
		echo "ok|:|".$d->points."|:|".($pos->position+1);
	}


break;
####################################################################################################################
####################################################################################################################
case "deconnexion":

	session_unset();
	session_destroy();
	setcookie('log_email', '', 0, URL_REL);
	echo "ok";

break;
####################################################################################################################
####################################################################################################################
case "refresh":

	if ($_SESSION['log_id']) {
		$sqlScore=mysql_query("SELECT * FROM ".PREFIX."membres WHERE id=".$_SESSION['log_id']." AND email='".$_SESSION['log_email']."'");
		$score=mysql_fetch_object($sqlScore);
		
		$sqlPos=mysql_query("SELECT count(*) as pos FROM ".PREFIX."membres WHERE points>".$score->points);
		$pos=mysql_fetch_object($sqlPos);
		
		echo $score->points.'|:|'.($pos->pos+1);
	} 
	else exit('byebye');
	

break;
####################################################################################################################
####################################################################################################################
case "classement":

	// Combien de jours avant la fin du mois ?
	$now=time();
	$diff=mktime(0, 0, 0, date("m")+1, 1, date("Y"))-$now;
	if ($diff<=60) $r=$diff."s";
	if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
	if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
	if ($diff>86400) $r=round(($diff/86400))."j";
	
	
	$sql=mysql_query("SELECT email, points FROM ".PREFIX."membres ORDER BY points DESC LIMIT 0,10");
	$c="<table style='border:0; padding:0; width:100%; text-align:left'>
			<tr>
			  <td colspan='2' style='text-align:center'><br />
			  <span style='font-size:13px; color:#FF6600'>Les 10 membres les plus actifs</span><br />
			  Prochain tirage au sort dans ".$r."<br /><br />
			  </td>
			</tr></table>
			<div style=' margin-left:35px; height:150px; overflow:auto; border:1px solid #ccc; border-left:0; border-right:0'>
			<table style='border:0; padding:0;width:100%; text-align:left;'>";
			
	while ($d=mysql_fetch_object($sql)) {
		$temp=explode('@', $d->email);
		if ($d->points>PT_MEMBRE_PLATINIUM) $bonus=' <img src="images/level4.png" style="vertical-align:middle"/>';
		elseif ($d->points>PT_MEMBRE_OR) $bonus=' <img src="images/level3.png" />';
		elseif ($d->points>PT_MEMBRE_ARGENT) $bonus=' <img src="images/level2.png" />';
		elseif ($d->points>PT_MEMBRE_BRONZE) $bonus=' <img src="images/level1.png" />';
		else $bonus='';
		
		$c.="<tr><td style='width:50%; text-align:left; border-left:2px solid #00A8FF; padding-left:5px'> ".$bonus." <b>".tronquerChaine($temp[0],20)."</b></td><td style='text-align:left'>".$d->points." points</td></tr>";
	}
	
	$c.='</table></div>';
	
	echo2($c);

break;
default:
	exit("Accés interdit");
break;
}

?>