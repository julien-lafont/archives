<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';

security();
$etat="ok";

if ($_SESSION['sess_pseudo']!="demo") {

	// On gère les variables en POST
		$_SESSION['sess_num']=$_POST['num'];
	if(preg_match('`^0[6][0-9]{8}$`',$_POST['num'])) $tel="+33".substr($_POST['num'],1,9);
	else exit("ERREUR : Le numéro doit être celui d'un portable !");
	$message=urlencode(trim($_POST['mess']));
	$messagesql=addslashes(trim($_POST['mess']));
	$key=$_POST['date'];
	
	// Vérifications
		//:: Il reste des SMS ?
	$isstock=mysql_query("SELECT stock FROM stats");
	$stock=mysql_fetch_object($isstock);
	if ($stock->stock==0) {
		@mail("email de l'admin@gmail.fr","=> Plus de SMS en stock <=", "Et oui, sa part vite !!!!!");
		exit("Désolé, nous n'avons plus de SMS en stock ! Je vais en acheter de nouveaux le plus rapidement possible !");
	}
		//:: Vérification si banni
	$isban=mysql_query("SELECT `ban` FROM membres WHERE `id`=".$_SESSION['sess_id']);
	$is=mysql_fetch_object($isban);
	if ($is->ban==1) exit("Vous êtes banni, vous ne pouvez pas envoyé de sms !");
	
		//:: Vérification par la Key unique
	$one=mysql_query("SELECT `key` FROM secure WHERE `sess_id`=".$_SESSION['sess_id']);
	$d1=mysql_fetch_object($one);
	if ($key!=$d1->key) exit("C'est pas bien d'essayer de tricher !");
	
		//:: Vérification du click via key_click et sess_id
	$two=mysql_query("SELECT `click` FROM secure WHERE `sess_id`=".$_SESSION['sess_id']);
	$d3=mysql_fetch_object($two); /* je c les noms des variables sa part en live ! */
	if ($d3->click!=1) {
			// Si il n'a pas clické, on ajoute 1 au compte FRAUDE mais on envoie le SMS quand même si fraude<3
		$etat="fraude";
		$sqlfraude=mysql_query("UPDATE membres SET fraude=fraude+1 WHERE id=".$_SESSION['sess_id']);
			// Si supérieur à 5 fraude, on BAN 
		$sqlfraude2=mysql_query("SELECT fraude FROM membres WHERE id=".$_SESSION['sess_id']);
		$fraude=mysql_fetch_object($sqlfraude2);
		if (($fraude->fraude>5) && ($_SESSION['sess_ban']!=9)) { 
			$sqlban=mysql_query("UPDATE membres SET ban=1  WHERE id=".$_SESSION['sess_id']);
			$sql4=mysql_query("DELETE FROM secure WHERE `sess_id`=".$_SESSION['sess_id']);
			exit("Vous avez envoyé 5sms sans clické sur la pub, votre compte vient d'être banni.");
		}
	} else {
		$sqladdclick=mysql_query("UPDATE membres SET click=click+1 WHERE id=".$_SESSION['sess_id']);
	}
	
		//:: Vérification pas plus de 7 sms
	$verif2=mysql_query("SELECT jour FROM membres WHERE id=".$_SESSION['sess_id']);
	$d2=mysql_fetch_object($verif2);
	if ($d2->jour>=7) exit("Vous avez déjà envoyé 7 SMS aujourd'hui. Il faut savoir rester raisonnable :)");
	
	$time=time();
	$ip=ip();
	$auteur=$_SESSION['sess_pseudo'];
	
	// On supprime l'enregistrement de la Key unique
	$sql4=mysql_query("DELETE FROM secure WHERE `sess_id`=".$_SESSION['sess_id']);
	
	// On incrémente les compteur
	$sql2=mysql_query("UPDATE membres SET jour=jour+1, mois=mois+1, total=total+1 WHERE id=".$_SESSION['sess_id']);
	$sql3=mysql_query("UPDATE stats SET total=total+1, jour=jour+1, mois=mois+1");
	
	// On envoie le SMS
	$result=tm4b("type=broadcast&username=yotsumi&password=xxxxxxxx&msg=$message&to=$tel&from=YotsumiSMS&route=business");
	
	// On met à jour le nombre de SMS restants
	$credits=tm4b("type=check_balance&username=yotsumi&password=xxxxxx");
	$sms=round($credits/5.4);
	$sql4=mysql_query("UPDATE stats SET stock=$sms");
	
	// On affiche un message
	echo $etat;

##########################################################################################################""
##########################################################################################################""
} else { /* Spécial compte DEMO */

	// On gère les variables en POST
		$_SESSION['sess_num']=$_POST['num'];
	if(preg_match('`^0[6][0-9]{8}$`',$_POST['num'])) $tel="+33".substr($_POST['num'],1,9);
	else exit("ERREUR : Le numéro doit être celui d'un portable !");
	$message=urlencode(trim($_POST['mess']));
	$messagesql=addslashes(trim($_POST['mess']));
	
	// Vérifications
		//:: Il reste des SMS ?
	$isstock=mysql_query("SELECT stock FROM stats");
	$stock=mysql_fetch_object($isstock);
	if ($stock->stock==0) {
		mail("yotsumi.fx@gmail.com","=> Plus de SMS en stock <=", "Et oui, sa part vite !!!!!");
		exit("Désolé, nous n'avons plus de SMS en stock ! Je vais en acheter de nouveaux le plus rapidement possible !");
	}
			
		//:: Vérification pas plus de 7 sms
	$verif2=mysql_query("SELECT jour FROM membres WHERE id=".$_SESSION['sess_id']);
	$d2=mysql_fetch_object($verif2);
	if ($d2->jour>=1) exit("Le quota du compte démo est dépassé ( 1 sms/jour )");
	
	// On enregistre le SMS dans la base de donné
	$time=time();
	$ip=ip();
	$auteur=$_SESSION['sess_pseudo'];
		
	// On incrémente les compteur
	$sql2=mysql_query("UPDATE membres SET jour=jour+1, mois=mois+1, total=total+1 WHERE id=".$_SESSION['sess_id']);
	$sql3=mysql_query("UPDATE stats SET total=total+1, jour=jour+1, mois=mois+1");
	
	// On envoie le SMS
	$result=tm4b("type=broadcast&username=yotsumi&password=xxxxx&msg=$message&to=$tel&from=YotsumiSMS&route=business");
	
	// On met à jour le nombre de SMS restants
	$credits=tm4b("type=check_balance&username=yotsumi&password=xxxxxxxx");
	$sms=round($credits/5.4);
	$sql4=mysql_query("UPDATE stats SET stock=$sms");
	
	// On affiche un message
	echo $etat;
}
?>