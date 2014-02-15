<?php
session_start();

	function middle_security_admin($secure) { // Vérification admin Sécurité moyenne ( Validcode/Session - IP )
		$secure=addslashes($secure);
		if (!isset($_SESSION['sess_pseudo'])|| $_SESSION['sess_admin']!=1 || !isset($_SESSION['sess_secure']) || $_SESSION['sess_secure']!=$secure) {
			echo " Ta rien à foutre ici !";
			exit;
		} 
	}
	middle_security_admin($_POST['secure']);
	
include '../../include/config.inc.php';
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");


$galerie=$_POST['galerie'];
$garder=$_POST['garder'];
$jetter=$_POST['jetter'];


  $garder2 = ereg_replace('<br></div><div>', '|', $garder);
  $garder2 = ereg_replace('<div>', '', $garder2);
  $garder2 = ereg_replace('<br></div>', '', $garder2);
  $garder3=explode("|", $garder2);
  
  $jetter2 = ereg_replace('<br></div><div>', '|', $jetter);
  $jetter2 = ereg_replace('<div>', '', $jetter2);
  $jetter2 = ereg_replace('<br></div>', '', $jetter2);
  $jetter3=explode("|", $jetter2);

	if (empty($galerie)) { /* Si validations des photos principales */

		$query1="UPDATE members SET `img_valid`=1 WHERE ";
		foreach($garder3 as $cle=>$valeur)
		{
		$query1.="`username`='".trim(strtolower($valeur))."' OR";
		} 
		$sql1=substr($query1, 0, (strlen($query1)-3));
		$sql=mysql_query($sql1) or die(mysql_error());
		
	
		$query2="UPDATE members SET `img_valid`=2 WHERE ";
		foreach($jetter3 as $cle=>$valeur)
		{
		$query2.="`username`='".trim(strtolower($valeur))."' OR";
		} 
		$sql2=substr($query2, 0, (strlen($query2)-3));
		$sql=mysql_query($sql2) or die(mysql_error());
	
		echo "ok";
	} 
	else /* Validations des photos de la galerie */
	{ 
		$query1="UPDATE photos SET `valid`=1 WHERE ";
		foreach($garder3 as $cle=>$valeur)
		{
		$query1.="`img`='".trim(strtolower($valeur))."' OR";
		} 
		$sql1=substr($query1, 0, (strlen($query1)-3));
		$sql=mysql_query($sql1) or die(mysql_error());
		
	
		$query2="UPDATE photos SET `valid`=2 WHERE ";
		foreach($jetter3 as $cle=>$valeur)
		{
		$query2.="`img`='".trim(strtolower($valeur))."' OR";
			$sqll=mysql_query("SELECT dir_galerie FROM members LEFT JOIN photos ON members.id_membre=photos.id_membre WHERE photos.img='".trim(strtolower($valeur))."'" ) or die('Erreur de selection '.mysql_error());
			$d=mysql_fetch_object($sqll);
			@unlink("../../upload/galerie/".$d->dir_galerie."/".trim(strtolower($valeur)) );
			@unlink("../../upload/galerie/".$d->dir_galerie."/_min_".trim(strtolower($valeur)) );
		} 
		$sql2=substr($query2, 0, (strlen($query2)-3));
		$sql=mysql_query($sql2) or die(mysql_error());
	
		echo "ok";
	}
mysql_close();
?>