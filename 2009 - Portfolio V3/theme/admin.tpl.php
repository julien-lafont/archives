<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Studio-dev.fr - ADMINISTRATION {::titrePage::}</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="Studio-dev.fr : D&eacute;veloppements web 2.0 et design par Yotsumi - Portfolio, blog et tutoriaux" />
	<meta name="Keywords" content="studio-web, studio, yotsumi, julien, lafont, orange, d&eacute;veloppeur, ajax,  php, web, cr&eacute;ation, site, portfolio, blog, services, designer, graphiste, programmeur, freelance" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<base href="{::baseUrl::}" />
	
	<link rel="stylesheet" href="theme/pink.css" type="text/css" />	
	<script type="text/javascript" src="include/js/librairies/prototype.js"></script>
	<script type="text/javascript" src="include/js/general.js"></script>
	{::header::}

</head>
<body>

	<div id="curseur" class="infobulle"></div>
	
	
	<div id="couleurs">
		<ul>
			<li id="lien_header"></li>
			<li id="liMin1"><a href="javascript:void(0);" title="Changer le th&egrave;me graphique"><img src="theme/images/min_bg5.jpg" id="bg1" alt="" /></a></li>
			<li id="liMin2"><a href="javascript:void(0);" title="Changer le th&egrave;me graphique"><img src="theme/images/min_bg9.jpg" id="bg2" class="active" alt="" /></a></li>
			<li id="liMin3"><a href="javascript:void(0);" title="Changer le th&egrave;me graphique"><img src="theme/images/min_bg7.jpg" id="bg3" alt="" /></a></li>
		</ul>
	</div>
	
	<div id="badge">
		<img src="theme/images/badge_love_design_b.png" alt="Studio-dev : Cr&eacute;ation de sites internet" height="130" width="130" />
	</div>
	
	<div id="header">
	  <div class="inside"> 		
			<h1><a href="http://www.studio-dev.fr" title="Accueil Studio-dev.fr - D&eacute;veloppement internet">Studio-dev.fr</a></h1>
		  <h2>Développement applications web <strong>2.0</strong></h2> <br />
		  <h2>Sites internet perso, associatif ou marchand</h2><br />
	  </div>
	</div>
	
	<div id="menu">
		<div class="inside">
			<a class="nav" href="?contact" title="Me contacter" style="margin-left:5px" >Contact</a>
			<a class="nav" href="?mes-creations" title="Mes derni&egrave;res cr&eacute;ations" style="margin-left:5px" >Mes créations</a>
			<a class="nav" id="navigationOuvrir" href="javascript:void(0);" title="Afficher le menu de navigation">Navigation</a> 
			<a class="nav" id="navigationFermer" href="javascript:void(0);" title="Cacher le menu de navigation" style="display: none;">Fermer nav</a>		</div>
	</div>

	<div class="clear"></div>
	
	
	
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
					<h2>Rechercher</h2>
					<p>Ecrivez votre recherche et validez par Entrée</p>
					<div id="search">
						
					</div>
				</div>
				
				<div class="block">
					<h2>Bookmarks</h2>
					<ul class="counts">
						<li><a href="http://www.arsys.fr" title="H&eacute;bergement internet" target="_blank">Hébergement par <strong>Arsys</strong></a></li>
						<li><a href="http://www.jpnp.org" title="Association de jeunes d&eacute;veloppeurs jPnP">Association de développeurs : <strong>jPnP</strong></a></li>
						<li><a href="http://groups.google.fr/group/web_2-0_et_ajax" title="groupe google" target="_blank">Google Groupe : <strong>Web 2.0  &amp; Ajax</strong></a></li>
						<li><a href="#" title="projets">Avancement de mes <strong>Projets</strong></a></li>
						<li><a href="http://blogmarks.net/search/ajax%2Bweb2.0" title="BlogMarks" target="_blank">BlogMarks <strong>Ajax-Web2.0</strong></a></li>
					</ul>
				</div>
			
				<div class="clear"></div>
			</div>
		</div>
</div>

	
	
	
	<div id="primary" style="background-image:url({::urlTheme::});">
	
		<div class="inside" id="primary_effect">
		  
		  <div class="story first">
			
			<h3><a href="#">Administration Studio-dev.fr</a></h3>			
			<div id="contenu">
			
				<table id="img_no_border">
					<tr>
					<td style="vertical-align:top">
							<div id="menu_admin">
							<ul>
								<li><a href="?admin/news">Gérer les news</a></li>
								<li><a href="http://www.studio-dev.fr/robotstats/">Stats</a></li>
							</ul>
						</div>
					</td>
					<td style="vertical-align:top">
						<div id="admin_contenu">
							{::contenu::}
						</div>
					</td>
					</tr>
				</table>
			
			</div>
			
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
				<p>Je suis ouvert à tout travail en freelance ou en colaboration.  <span style="border-bottom:1px solid #00A8FF">Offrez vous mes services ! </span></p>
				<p>&nbsp;</p>
				<p>Pour me contacter, rendez vous sur cette page ou sinon envoyez un un petit mail à <br /> <a href="mailto:freelance@studio-dev.fr" title="Contactez moi (pas de spam svp)">freelance@studio-dev.fr</a></p>
		  		<p class="img_no_border" style="margin:10px 0 0 10px"><img src="images/doc.png" style="vertical-align:middle; border:0" /> &nbsp;<a href="?cv" title="Voir le CV de Julien Lafont alias Yotsumi"  style="border-bottom:1px solid #f06; text-decoration:none">Afficher mon CV</a></p>
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
				<p>Développement <strong>php</strong> et <strong>ajax</strong> par Julien alias <strong>Yotsumi</strong>, design par Jek2k. <br />
				Contenus sous license  <a href="http://creativecommons.org/licenses/by-nc/2.0/fr/">Creative Commons</a>  | Valide <a href="http://validator.w3.org/check?uri=referer">XHTML</a> et <a href="http://jigsaw.w3.org/css-validator/validator?uri=#/wp/wp-content/themes/hemingway/style.css">CSS</a> (si tout va bien) </p>
				<p class="copyright">Développé à l'aide de <a href="http://www.script.aculo.us/">Scriptaculous </a> et <a href="http://www.huddletogether.com/projects/lightbox2/">LightBox v2 </a> | <img src="theme/images/apple_logo.png" alt="Apple Logo" height="12" width="12" /> Made on a Pc ( mais avec l'esprit <a href="http://www.apple.com/getamac/">Mac</a> ! ) </p>
			</div>
			<p class="attributes"><a href="?plan/plan-du-site-studio-dev" title="SiteMap studio-dev.fr">Plan du site</a> // <a href="rss.htm" title="flux RSS">Flux RSS</a></p>
		</div>
</div>



    <div id="connexion">

	<h3 id="move">Connexion</h3>
	<div id="closeConnexion"></div>
	
	<div id="con_contenu" style="text-align:center">
		{::zone_connexion::}
	</div>
	
</div>


    <div class="hide"><div id="id_news_courante">{::news_id::}</div></div>

</body>
</html>