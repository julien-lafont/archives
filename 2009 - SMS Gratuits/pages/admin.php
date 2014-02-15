<?php
if ($_SESSION['sess_level']!=5) exit("Accés interdit");

switch(@$_GET['act']) {
default:
$design['contenu']='<h2>Ajouter un membre</h2><br/><br/>
<form action="?admin&act=add" method="POST" name="form1">
	<input type="text" name="pseudo" value="Pseudo" onClick="this.value=\'\'" style="margin:2px" /><br/>
	<input type="text" name="pass" value="Pass" onClick="this.value=\'\'"  style="margin:2px"/><br/>
	<input type="text" name="email" value="Email" onClick="this.value=\'\'"  style="margin:2px"/><br/>
	<input type="text" name="com" value="Commentaire" onClick="this.value=\'\'"  style="margin:2px"/><br/>
	<input type="submit" value="ajouter"  style="margin:2px"/>
</form><br><br><a href="?admin&act=raz"><span style="color:#0099FF">RAZ des stats journalières</span></a><br>
<a href="?admin&act=raz2"><span style="color:#0099FF">RAZ des stats mensuelles (19/07)</span></a><br><br>';
break;
######################################################################################
######################################################################################
case "add":

$pseudo=strtolower(htmlspecialchars($_POST['pseudo']));
$pass=strtolower(htmlspecialchars($_POST['pass']));
$email=strtolower($_POST['email']);
$com=addslashes($_POST['com']);

$sql=mysql_query("INSERT INTO membres (`pseudo`,`pass`,`email`,`com`) VALUES ('$pseudo','$pass','$email','$com')")or die("Erreur : ".mysql_error());
$design['contenu']='<center><b>Membre ajouté avec succés </b><br><br><br><a href="?admin"><span style="color:#0099FF">- Retour -</span></a><br><br><br>';

break;
######################################################################################
######################################################################################
case "raz":

$sql1=mysql_query("UPDATE membres SET jour=0");
$sql2=mysql_query("UPDATE stats SET jour=0");
$design['contenu']='<center><b>RAZ des stats effectuée </b><br><br><br><a href="?admin"><span style="color:#0099FF">- Retour -</span></a><br><br><br>';
break;
######################################################################################
######################################################################################
case "raz2":

$sql1=mysql_query("UPDATE membres SET jour=0, mois=0");
$sql2=mysql_query("UPDATE stats SET jour=0, mois=0");
$design['contenu']='<center><b>RAZ des stats effectuée </b><br><br><br><a href="?admin"><span style="color:#0099FF">- Retour -</span></a><br><br><br>';
break;

}
?>
