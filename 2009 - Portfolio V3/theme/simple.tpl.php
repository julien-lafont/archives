<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Studio-dev.fr - {::titrePage::}</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="{::meta_description::}" />
	<meta name="Keywords" content="studio-web, studio, yotsumi, julien, lafont, orange, développeur, ajax,  php, web, création, site, portfolio, blog, services, designer, graphiste, programmeur, freelance" />
	<meta name="author" content="Julien LAFONT alias YoTsumi on freelance@studio-dev.fr">
	<meta name="robots" content="all">
	<link rel="shortcut icon" href="/favicon.ico" />
	<base href="{::baseUrl::}" />
	
	<link rel="stylesheet" href="theme/pink.css" type="text/css" />	
	<script type="text/javascript" src="include/js/librairies/jquery.js"></script>
	<script type="text/javascript" src="include/js/general.js"></script>
	<script type="text/javascript" src="include/js/bulle_infos.js"></script>
	{::header::}{::jvs-admin::}

</head>
<body>

	<div id="curseur" class="infobulle"></div>
	
	
	<div id="couleurs">
		<ul>
			<li id="lien_header"></li>
			<li id="liMin1"><a href="javascript:void(0);" title="Changer le thème graphique"><img src="theme/images/min_bg5.jpg" id="bg1" alt="" /></a></li>
			<li id="liMin2"><a href="javascript:void(0);" title="Changer le thème graphique"><img src="theme/images/min_bg9.jpg" id="bg2" class="active" alt="" /></a></li>
			<li id="liMin3"><a href="javascript:void(0);" title="Changer le thème graphique"><img src="theme/images/min_bg7.jpg" id="bg3" alt="" /></a></li>
		</ul>
	</div>
	
	<div id="badge">
		<img src="theme/images/badge_love_design_b.png" alt="Création de sites internet" height="130" width="130" />
	</div>
	
	<div id="header">
	  <div class="inside"> 		
			<h1><a href="http://www.studio-dev.fr" title="Accueil Studio-dev.fr - Développement internet 2.0">Studio-dev.fr</a></h1>
		  <h2>Développement d'applications web <strong>2.0</strong></h2> <br />
		  <h2>Sites internet perso, associatif ou marchand</h2><br />
	  </div>
	</div>
	
	<div id="menu">
		<div class="inside">
			<a class="nav" href="contact.htm" title="Me contacter pour toutes demandes, demis, questions" style="margin-left:5px" >&nbsp;Contact&nbsp;</a>
			<a class="nav" href="cv-julien-lafont.htm" title="Curriculum vitae de Julien LAFONT alias Yotsumi, développeur web 2.0 sur Montpellier" style="margin-left:5px">&nbsp;&nbsp;&nbsp; CV &nbsp;&nbsp;&nbsp;</a>
			<a class="nav" href="portfolio.htm" title="Mes dernières réalisations : développement, design, ajax" style="margin-left:5px" >Portfolio</a>
            <a class="nav" id="navigationOuvrir" href="javascript:void(0);" title="Afficher le menu de navigation">Navigation</a> 
			<a class="nav" id="navigationFermer" href="javascript:void(0);" title="Cacher le menu de navigation" style="display: none;">Fermer nav</a>		
		</div>
	</div>

	<div class="clear"></div>
	
	
	
	<!-- Panneau dynamique -->
	<div id="utils" style="display: none;">
		<div class="ancillary">
			<div class="inside">
			
				<div class="block first">
					<h2>Actu &rsaquo; Catégories</h2>
					<ul class="counts">
						{::menu_categories::}
					</ul>
				</div>
				
				<div class="block">
                	<h2>Nuage de tag 2.0</h2>
                    <i>Bientôt disponible</i>
                    

				</div>				
				<div class="block">
					<h2>Bookmarks</h2>
					<ul class="counts">
                    	<li><a href="http://www.di4art.net/" title="Blog graphique Di4art : tendances graphiques" target="_blank">Blog sur les tendances graphiques <strong>di4art</strong></a></li>
                        <li><a href="http://www.fizzystudio.com/" title="Voir les dernières créations du graphiste webdesigner Fizzy">Portfolio de mon ami graphiste <strong>FizzyStudio</strong></a></li>
						<li><a href="http://www.jpnp.org" title="Association de jeunes développeurs jPnP">Association de développeurs : <strong>jPnP</strong></a></li>
						<li><a href="http://www.webrankinfo.com" title="WebRankInfo : Tout savoir sur le référencement">Référencement google : <strong>WebRankInfo</strong></a></li>
						<li><a href="http://blogmarks.net/search/ajax%2Bweb2.0" title="BlogMarks" target="_blank">BlogMarks <strong>Ajax-Web2.0</strong></a></li>
					</ul>
				</div>
			
				<div class="clear"></div>
			</div>
		</div>
	</div>

	
	
	
	<div id="primary" class="onecol-stories" style="background-image:url({::urlTheme::});">
	
		<div class="inside" id="primary_effect">
		  
		  <div class="story first">
			
			<h3>{::titre::}</h3>			
			<div id="contenu">{::contenu::}</div>
			
		  </div>
		</div>	
							
			<div class="clear"></div>
</div>
	
	
 	<div class="ancillary">
		<div class="inside">
		
			<div class="block first">
				<h2>Qui suis-je ? </h2>
				<p>Salut ! <br />
				Mon nom est Julien LAFONT. Je suis actuellement étudiant mais pendant mon temps libre je deviens Développeur web 2.0 / Web designer. </p>
                <p>&nbsp;</p>
				<p>Je suis ouvert à tout travail en freelance ou en collaboration.  <span style="border-bottom:1px solid #00A8FF">Offrez vous mes services ! </span></p>
				<p>&nbsp;</p>
				<p>Pour me contacter, rendez vous sur <a href="contact.htm" title="Contacter Julien LAFONT : développeur web 2.0">cette page</a> ou sinon envoyez un petit mail à <br /> <img src="images/email_black.png" class="noborder"/></p>
		  		<p class="img_no_border" style="margin:10px 0 0 10px"><img src="images/doc.png" style="vertical-align:middle; border:0" /> &nbsp;<a href="cv-julien-lafont.htm" title="Voir le CV de Julien Lafont alias Yotsumi, développeur web 2.0" style="border-bottom:1px solid #f06; text-decoration:none">Afficher mon CV</a></p>
			</div>

			
			<div class="block">	
				<h2>Portfolio</h2>
					<ul id="thumbs">
						{::portfolio::}
					</ul>
				<div class="clear"></div>
				
				<h2>Nos designs </h2>
					<ul id="thumbs2">
						{::designs::}
					</ul>
				<div class="clear"></div>
		  	</div>
			
			<div class="block">	
				<h2>Actualité</h2>
				<ul class="dates">
					{::dernieres_news::}
				</ul>
			</div>
			
			<div class="clear"></div>
		</div>
	</div>

<hr class="hide" />
	<div id="footer">
		<div class="inside">
			<div class="foot-notes">
				<p>Développement <strong>php</strong> et <strong>ajax</strong> par <strong>Julien LAFONT</strong> alias Yotsumi, design par Jek2k. <br />
				Contenus sous license  <a href="http://creativecommons.org/licenses/by-nc/2.0/fr/">Creative Commons</a>  | Valide <a href="http://validator.w3.org/check?uri=referer">XHTML</a> et <a href="http://jigsaw.w3.org/css-validator/validator?uri=#/wp/wp-content/themes/hemingway/style.css">CSS</a> (si tout va bien) </p>
				<p class="copyright">Développé à l'aide de <a href="http://ui.jquery.com/">Jquery UI</a> et <a href="http://jquery.com/demo/thickbox/">thickbox</a></p>
				<div style="border-top:1px solid #6B6B6B; margin-top:10px; color:#CACACA; font-size:10px"><br />Numéro SIRET : {::siret::} - Déclaré en tant qu'auteur souscrivant au régime de l'AGESSA<br /><br /></div>
			</div>
			<p class="attributes"><a href="plan-du-site-studio-dev.htm" title="SiteMap studio-dev.fr">Plan du site</a> // <a href="rss.htm" title="flux RSS">Flux RSS</a></p>
		</div>
	</div>


<div id="connexion">

	<h3 id="move">Connexion</h3>
	<div id="closeConnexion"></div>
	
	<div id="con_contenu" style="text-align:center">
		{::zone_connexion::}
	</div>
	
</div>

<div class="hide"><div id="id_news_courante">{::news_id::}</div><img src="images/loading.gif" /></div>

</body>
</html>