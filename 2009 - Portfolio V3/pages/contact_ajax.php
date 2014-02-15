<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


	// On parse vite fait et on envoie un mail
	
	$type=ucfirst($_POST['type']);
	$sujet="Studio-Dev::Contact - $type - ".$_POST['email']."";
	
	$mess="<html><body>
			<h2>Contact le ".date("Y-m-d H:m:s")." par ".$_POST['email']."</h2>
			<h4>Type : ".$type."</h4>
			<h4>Ip : ".ip()."</h4>
			
			<br><br>
			<table style='width:90%; border:2px solid #0099FF; padding:3px;  margin:0 auto' border='0'>
				<tr>
					<td width='120px'><b>Nom</b></td>
					<td><b>Valeur</b></td>
				</tr>";
	
	foreach($_POST as $key=>$value) {
		if ($key!="undefined") {
			$mess.="<tr>
						<td><b>".ucfirst($key)."</b></td>
						<td>".stripslashes(nl2br($value))."</td>
					</tr>";
		}
	}
	$mess.="</table>
			</body></html>";
	
	
	
	if (@email( "yotsumi.fx@gmail.com", $sujet, $mess, "auto@studio-dev.fr" )) echo "ok";
	else echo "bad";

	
?>