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
		@$relations.="<tr><td class='a' style='color:#0066FF'>".$d->id."</td><td>".ucfirst($d->pseudo)."</td></tr>";
	}
		?>
			<style media="all" type="text/css">
				#fenetreInn { text-align:center}
				#fenetreInn h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				#fenetreInn strong  { font-weight:normal;color:#FF9900; }	
				#fenetreInn input 			{ background-color:#FFFFFF; border:1px solid #CCC; padding:2px 1px 2px 1px; text-align:center; margin-bottom:6px; font-size:12px; font-family:Verdana; color:#333333; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../../images/fond_input1.jpg) }
				#fenetreInn input:focus		{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }
				#fenetreInn #submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#fenetreInn #submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
				#fenetreInn table { border:1px solid #ccc; padding:2x; font-size:11px; width:170px}
				#fenetreInn td { }
				#fenetreInn .a { width:30px; text-align:center; height:18px }
			</style>
			
			<div id="fenetreInn">	
			<div class="titreMessagerie" style="margin:10px auto 20px 80px">Relation Id<>Pseudo</div>
			
			Utilisez cette page pour sélectionner l'Id correspondant au pseudo du membre.<br /><br />
			<table align="center" style="margin:0 auto">
				<td class='a'><b>ID</b></td><td><b>Pseudo</b></td>
				<?php echo $relations ?>
			</table>
			</div>
		<?php

break;
}
?>