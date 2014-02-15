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
         		<img src="theme/{::design::}/images/menuG_titre_visitors.png" alt="" />
				<ul>
					{::li_visiteurs::}
				</ul>
          		<img src="theme/{::design::}/images/menuG_titre_friends.png" alt="" />
				<ul>
					{::li_amis::}
				</ul>
                <img src="theme/{::design::}/images/menuG_titre_pub.png" alt="" />
                <p class="centre">
					{::pub::}
                </p>
        	</div>
        </div>
        
    	<div id="centre">
			<div class="content">
            	
                <div class="titreMessagerie">Profil de {::pseudo::}</div>
                
				<table id="profil" style="width:560px; border:0; padding:0; margin:-5px 0; " cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="2">
						
								{::profil_top::}						
						</td>
					</tr>
					<tr>
						<td style="width:50%"><h2 class="demi">Infos générales</h2>
							<ul id="ulListe" >
								{::li_general::}
							</ul>
						</td>
						<td style="width:50%"><h2 class="demi">Galerie</h2>				
							
							<br /><br /><div id="mini_galerie" class="little">
								<div id="mini_galerie_in">
									<div id="mycarousel" style="width:185px;">
										  <ul>
											{::galerieP::}
										</ul> 
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td><h2 class="demi">Software</h2>
							<ul id="ulListe">
								{::li_software::}
							</ul>
						</td>
						<td><h2 class="demi">Hardware</h2>
							<ul id="ulListe">
								{::li_hardware::}
							</ul>
						</td>
					</tr>
					<tr>
						<td><h2 class="demi">Actions</h2><br />
							<div class="tdContact">{::actions::}</div>
						</td>
						<td><h2 class="demi">Contact</h2><br />
							<div class="tdContact">{::contact::}</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				</table>
						
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
                <img src="theme/{::design::}/images/menuD_titre_lineup.png" alt="" />         
            	<p class="centre">
                	{::team-perso::}
                </p>
                
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