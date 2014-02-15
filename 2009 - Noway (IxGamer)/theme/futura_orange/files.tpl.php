<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Team {::nom::} - {::titrePage::}</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="{::description::}" />
	<meta name="Keywords" content="{::keywords::}" />
	<base href="{::baseUrl::}">
	
	<!-- Inclusion pour le script -->
	<script type="text/javascript">var _URL = "{::baseUrl::}";</script>
	<script type="text/javascript" src="javascript/librairies/jquery.js"></script>
	<script type="text/javascript" src="javascript/-general.js"></script>

    <!-- Inclusions pour le thème -->
	<link rel="stylesheet" href="theme/{::design::}/style.css" type="text/css" />	
    <script type="text/javascript" src="theme/{::design::}/script.js"></script>
	
	<!-- Inclusions dynamiques si nécessaire -->
	{::header::}{::jvs-admin::}
			
</head>
<body {::body::}>

	<div id="tooltip"></div>
	<div id="global"></div>
    
<div id="page">
    <div id="menu_top">
    	<ul class="links">
        	<li><a href="actualite/" title=""><img src="theme/{::design::}/images/top_accueil.png" alt="" class="hover" /></a></li>
        	<li><a href="team/" title=""><img src="theme/{::design::}/images/top_team.png" alt="" class="hover" /></a></li>
        	<li><a href="results/" title=""><img src="theme/{::design::}/images/top_results.png" alt="" class="hover" /></a></li>
        	<li><a href="awards/" title=""><img src="theme/{::design::}/images/top_awards.png" alt="" class="hover" /></a></li>
        	<li><a href="coverage/" title=""><img src="theme/{::design::}/images/top_coverage.png" alt="" class="hover" /></a></li>
        	<li><a href="galerie-officielle/" title=""><img src="theme/{::design::}/images/top_galerie.png" alt="" class="hover" /></a></li>
        	<li><a href="files/" title=""><img src="theme/{::design::}/images/top_files.png" alt="" class="hover" /></a></li>
        	<li><a href="forum/" title=""><img src="theme/{::design::}/images/top_forum.png" alt="" class="hover" /></a></li>
        	<li><a href="nos-sponsors/" title=""><img src="theme/{::design::}/images/top_sponsor.png" alt="" class="hover" /></a></li>
        	<li><a href="contact/" title=""><img src="theme/{::design::}/images/top_contact.png" alt="" class="hover" /></a></li>
        </ul>
        
		<div id="menu_log">{::Menu_Log::}</div>

    </div>
    
    <div id="header">
    	<h1>{::titre::}</h1>
    </div>
    
    <div id="corps">
    	<div id="gauche">
        	<div class="in">
        		<img src="theme/{::design::}/images/menuG_titre_menu.png" alt="" />
                <ul class="puce">
                	<li><a href="actualite/">Accueil</a></li>
                	<li><a href="actualite/archives/">Archive des news</a></li>                	
                    <li><a href="coverage/">Coverage</a></li>                    
                	<li><a href="awards/">Récompenses</a></li>
                	<li><a href="results/">Résultats</a></li>
                	<li><a href="forum/">FORUM</a></li>                	
                </ul>
         		<img src="theme/{::design::}/images/menuG_titre_files.png" alt="" />
                <ul>
					{::last_medias::}
                </ul>       		
         		<img src="theme/{::design::}/images/menuG_titre_forum.png" alt="" />
                <ul>
					{::last_topics::}
                </ul>  
                <img src="theme/{::design::}/images/menuG_titre_pub.png" alt="" />
                <p class="centre">
					{::pub::}
                </p>
        	</div>
        </div>
        
    	<div id="centre">

					<div style="text-align:center; margin-top:5px" o>
						<a href="files/movies/" onmouseover="afficher_nom('Gaming movies')" ><img src="images/files/videos.png" width="78" height="85" alt=""></a>
						<a href="files/demos/" onmouseover="afficher_nom('Demos In-Eyes & HLTV');" ><img src="images/files/demos.png" width="81" height="85" alt=""></a>
						<a href="files/files/" onmouseover="afficher_nom('Software & files');" ><img src="images/files/logiciels.png" width="83" height="85" alt=""></a>
						<a href="files/others/" onmouseover="afficher_nom('The Others');" ><img src="images/files/autres.png" width="79" height="85" alt=""></a>
						<div id="fond_last" style="display:none; margin:0 auto"></div>
					</div>
             
                
			<div class="content">
				<p class="in">{::contenu::}</p>
			</div>
						
				
       </div>
         	
  <div id="droite">
        	<div class="in">
            
            	<img src="theme/{::design::}/images/menuD_titre_sponsor.png" alt="" />
            	<ul>
					{::head_sponsor::}
                </ul>
                <img src="theme/{::design::}/images/menuD_titre_aboutus.png" alt="" />
            	<p>
                	{::what_is::}                
                </p>
                <img src="theme/{::design::}/images/menuD_titre_coverage.png" alt="" />         
            	<ul class="big">
                	{::coverage::}
                </ul>
                
            </div>
        </div>
        <br class="clear" />
	</div>
    
    <div id="footer">
    	<p><a href="contact/">Contact</a> - <a href="forum/">Forum</a> - <a href="news.xml">Flux Xml</a><br /><br />
           <span class="copyright">Propuls&eacute; par <a href="http://www.ix-gamer.net" title="Portail de gestion de team esport Web 2.0">Ix'Gamer</a> by <a href="http://www.studio-dev.fr" title="Agence de développement web 2.0">Studio-dev</a></span></p>
    </div>

</div>

<!-- Préchargement -->
<div class="hide">
    <img src="theme/{::design::}/images/top_accueil_h.png" alt="" />
	<img src="theme/{::design::}/images/top_team_h.png" alt="" />
    <img src="theme/{::design::}/images/top_results_h.png" alt="" />
    <img src="theme/{::design::}/images/top_awards_h.png" alt="" />
    <img src="theme/{::design::}/images/top_coverage_h.png" alt="" />
    <img src="theme/{::design::}/images/top_galerie_h.png" alt="" />
    <img src="theme/{::design::}/images/top_files_h.png" alt="" />
    <img src="theme/{::design::}/images/top_forum_h.png" alt="" />
    <img src="theme/{::design::}/images/top_sponsor_h.png" alt="" />
    <img src="theme/{::design::}/images/top_contact_h.png" alt="" />
    <img src="images/indicator2.gif" alt="" />
</div>

		<div id="ajax_path" class="hide"></div>
								
		<div id="window">
			<div id="windowTop">
				<div id="windowTopContent">{::nom::} featuring</div>
				<img src="theme/images/window_min.jpg" id="windowMin" />
				<img src="theme/images/window_max.jpg" id="windowMax" />
				<img src="theme/images/window_close.jpg" id="windowClose" />
			</div>
			<div id="windowBottom"><div id="windowBottomContent">&nbsp;</div></div>
			<div id="windowContent"></div>
			<img src="theme/images/window_resize.gif" id="windowResize" />
		</div>

	
</body>
</html>