<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
//security();

if (empty($_POST['time']) AND empty($_GET['time'])) exit('not');

if (empty($_POST['time'])) $time=$_GET['time'];
else $time=$_POST['time'];

$data=explode('-',htmlspecialchars(addslashes($time)));
$key_click=$data[0];
$sess_id=$data[1];

$sql=mysql_query("SELECT key_click FROM secure WHERE `sess_id`=".$sess_id)or die (mysql_error());
$d=mysql_fetch_object($sql);

if (($key_click==$d->key_click) && (strlen($key_click)==10)) {
	$sql2=mysql_query("UPDATE secure SET click='1' WHERE `sess_id`=".$sess_id);
	/*debug */ echo $sql2;
}


?>