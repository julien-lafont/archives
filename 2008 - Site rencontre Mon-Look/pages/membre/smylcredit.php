<?php
securite_membre();

	$smyl='<img src="images/smyl/petitsmyl2.png" style="vertical-align:middle">';
switch($_GET['act']) {
default:

	$add='<link rel="stylesheet" type="text/css" href="include/effet/niftyCorners.css">
		<link rel="stylesheet" type="text/css" href="include/effet/niftyPrint.css" media="print">
		<script type="text/javascript" src="include/effet/nifty.js"></script>';
		
head($add);
	
	echo '<script type="text/javascript">
	window.onload=function(){
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");}
	function round() {
		if(!NiftyCheck())return;
		Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");
	}
	</script>';

	echo '<h3>Smyl\'Center '.$smyl.'</h3><br><br>
	<table width="100%" border=0>
		<tr>
			<td width="20"></td>
			<td><div style="width:100%; background-color:#FFFFFF; margin-left:auto; margin-right:auto" class="round" >
					<div style="margin:5px; color:#666; font-size:11px; line-height:18px">
					 C\'est à partir de cet espace que vous pourrez dans quelques jours gérer vos <b>smyl\'crédits.</b><br><br>
					 
					 Le smyl\' '.$smyl.', correspond à la monaie d\'échange sur Mon-Look, c\'est comme des € ou des $ sauf que ça ne vous coute rien :)<br>
					 En effet, le point essentiel à retenir est que vous pouvez acquérir des '.$smyl.' <b>sans dépenser un seul centime !</b><br><br>
					 
					<u>Que faire avec mes '.$smyl.' ? </u><br>
					Dés l\'ouverture du Smyl\'Center, vous pourrez échanger vos '.$smyl.' contre des <span style="color:#F33">SMS</span> à envoyer aux autres membres de Mon-Look, participer à des <span style="color:#F33">tirages au sort</span>, agrandir votre espace personnel : <span style="color:#F33">BLOG</span>, vidéo, BuddyList ...<br><br>
					
					<u>Et comment acquérir ces '.$smyl.' ? </u><br>
					Plusieurs méthodes seront disponibles, gratuites pour la plupart. Par exemple, cliquer sur les <span style="color:#F33">pubs</span> de nos sponsors vous rapportera des point quotidiennent, répondre à des campagnes publicitaires, ou encore <span style="color:#F33">parrainer</span> de nouveaux membres. <br>De plus, nous mettrons aussi à votre disposition des moyens d\'acquérir des '.$smyl.' plus rapidement gràce aux systèmes Allopass et <span style="color:#F33">Paypal</span>.<br><br>
										
					Bien entendu, vous n\'avez ici qu\'un résumé des possibilités qui seront offertes par Mon-Look, vous en saurez plus quand le <b>Smyl\'Center</b> sera officiellement lancé !<br>
										</div>

			</div></td>
			<td width="20"></td>
		</tr>
	</table>';
	
foot();



break;
}