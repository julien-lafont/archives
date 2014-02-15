<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_admin(true);

switch(@$_GET['act'])
{
case "affRelation":

	$sql=mysql_query("SELECT pseudo, id FROM ".PREFIX."membres ORDER BY pseudo ASC");
	while ($d=mysql_fetch_object($sql))
	{
		@$relations.="<tr><td class='a'><b>".$d->id."</b></td><td>".ucfirst($d->pseudo)."</td></tr>";
	}
		?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				strong  { font-weight:normal;color:#FF9900; }	
				input 			{ background-color:#FFFFFF; border:1px solid #CCC; padding:2px 1px 2px 1px; text-align:center; margin-bottom:6px; font-size:12px; font-family:Verdana; color:#333333; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../../images/fond_input1.jpg) }
				input:focus		{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }
				#submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
				table { border:1px solid #ccc; padding:2x; font-size:11px; width:170px}
				td { }
				.a { width:30px; text-align:center }
			</style>
		</head>
		<body>	
				
			<h1>Relation Id<->Pseudo</h1>
			Utilisez cette page pour sélectionner l'Id correspondant au Pseudo du membre.<br /><br />
			<table align="center">
				<td class='a' style='color:#00A8FF'><b>ID</b></td><td style='color:#00A8FF'>Pseudo</td>
				<?php echo $relations ?>
			</table>		
		</body>
		</html>
		<?php

break;
}
?>