<?php

//:: Fonction Design par YoTsumi :://
function design(){

	global $design;
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
			<title>Envoie de SMS gratuits avec YoTsumi - Service Web 2.0</title>
			<meta name="description" content="Service d\'envoie gratuit de SMS par YoTsumi développer en Web 2.0 : Ajax, Php et Javascript" />
			<meta name="keywords" content="yotsumi, webmaster, programmeur, sms, gratuit, site web, php, ajax, web 2.0, telephone, portable, mon-look , texto, free, gratos" />		
			
			<link rel="stylesheet" href="theme/feuille.css" type="text/css" />
			<script type="text/javascript" src="include/js/yotsumi.js"> </script> 
			
			<!-- Windows Class -->
			<script type="text/javascript" src="include/js/prototype.js"> </script> 
			<script type="text/javascript" src="include/js/effects.js"> </script>
			<script type="text/javascript" src="include/js/window.js"> </script>
			<link href="include/js/alphacube.css" rel="stylesheet" type="text/css" />
			<link href="include/js/default.css" rel="stylesheet" type="text/css" />
			
			<!-- Nifty Cube -->	
			<script type="text/javascript" src="include/js/niftycube.js"> </script> 
			<link href="include/js/niftyCorners.css" rel="stylesheet" type="text/css" />
			',@$design['header'],'
			
		</head>
		<body>
		',@$design['onload'],'
		<div id="referencement"><h1>Envoyer des <a href="http://fr.wikipedia.org/wiki/Short_message_service" title="le terme SMS par Wikipedia">SMS</a> gratuitement grâce à YoTsumi, réservé à mes potes ! Service Béta <a href="http://fr.wikipedia.org/wiki/AJAX" title="Service développer en Web 2.0 : Ajax, Prototype et Script Aculo Us">Web 2.0</a></h1></div>
		<div id="deco"></div>
		<div id="header"><a href="http://sms.yotsumi.info" title="Sms gratuits par Yotsumi en Web 2.0"><img src="theme/images/2.png" class="png" height="184" width="782" alt="Header Sms gratuits par Yotsumi" /></a></div>
		
		<div id="principal">
			<div id="contenu">
		  ',$design['contenu'],'
		  	</div>
		</div>
		
		<div id="barre_bas"></div>
		<div id="copyright" style="line-height:35px">
			
			<span class="txt"><a href="?stats">Stats</a></span>&nbsp;
			<a href="http://sms.yotsumi.info" title="Sms gratuits par Yotsumi en Web 2.0"><img src="theme/images/valid/ajax.png" alt="Ajax - Web2.0" style="margin-right:12px" /></a>
			<a href="#" onclick="yotsumi(); return false" title="Infos sur YoTsumi - Développeur Php/Xhtml/Ajax/Web 2.0"><img src="theme/images/valid/php-yotsumi.png" alt="By YoTsumi - Codeur php-ajax-web2.0" style="margin-right:12px" /></a>
			<a href="#" onclick="css(); return false" title="Certification Css"><img src="theme/images/valid/w3ccss2.jpg" alt="Valid Css2" style="margin-right:12px" /></a>
			<a href="#" onclick="xhtml(); return false" title="Certification Xhtml"><img src="theme/images/valid/w3cxhtml10.jpg" alt="Valid Xhtml"/></a>
			&nbsp;<span class="txt"><a href="?partenaire">Partenaires</a></span>
		</div>
		<div id="barre_bas2"></div>
		
		</body>
		</html>';
}

?>