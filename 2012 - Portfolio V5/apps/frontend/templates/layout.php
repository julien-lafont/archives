<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
		
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    
    <link rel="shortcut icon" href="/images/favicon.ico" >
    <link rel="icon" type="image/gif" href="/images/animated_favicon1.gif" >
    
    <?php if (!Toolbox::isIE6()):?>
      <?php include_javascripts_by_position('first') ?>
      <?php include_javascripts_by_position('') ?>
      <?php include_stylesheets() ?>
    <?php endif; ?>  

    <link rel="alternate" type="application/rss+xml" title="Le blog technique Studio-Dev.fr &raquo; Flux" href="http://www.studio-dev.fr/blog/rss" />
    
    <!--[if IE 7]><link rel="stylesheet" href="css/ie/ie7.css" type="text/css" media="screen"><![endif]-->

    <script type="text/javascript">
        Cufon.replace('h2, hgroup h3, aside h3, aside h5',{ hover: true });  
    </script>
   
</head>
<body class="innerpage">

    <!--[if lte IE 6]><script src="/js/warning.js"></script><script>window.onload=function(){e("/images/antiie/")}</script><![endif]-->

    <header>
    
        <div class="content">
        
            <div id="logo" role="banner">
                <h1><a href="http://www.studio-dev.fr" class="tip" title="Blog et Portfolio [strong]Julien Lafont[/strong] - Ingénieur étude et développement à [strong]Montpellier[/strong]"><span class="inv">Studio-Dev.fr - Julien Lafont</span></a></h1>
            </div>
           
             <ul class="social_slider">
                <li class="rss"><a href="http://www.studio-dev.fr/blog/rss" target="_blank" class="tip" title="Abonnez-vous au [strong]flux RSS[/strong] du Blog Studio-Dev.fr">&nbsp;</a></li>
                <li class="twitter"><a href="<?php echo sfConfig::get('app_liens_twitter')?>" target="_blank" class="tip" title="Suivez-moi sur le réseau social [strong]Twitter[/strong]">&nbsp;</a></li>
                <li class="linkedin"><a href="<?php echo sfConfig::get('app_liens_linkedin')?>" target="_blank" class="tip" title="Consultez mon profil sur le réseau social [strong]LinkedIn[/strong]">&nbsp;</a></li>
                <li class="viadeo"><a href="<?php echo sfConfig::get('app_liens_viadeo')?>" target="_blank" class="tip" title="Consultez mon profil sur le réseau social [strong]Viadeo[/strong]">&nbsp;</a></li>
             </ul> 
    
            <?php include_component("design", "menuPrincipal")?>
        
        </div>
        
    </header>
    
    <?php include_partial('design/titre'); ?>
    
    <section id="main">
    
        <div class="content innerpage_main_bg">
        
            <div class="design">
            
                <?php if ($sf_response->getFullwidth()): ?>
                
                  <div id="fullwidth" role="main">
                  
                     <?php include_partial('design/flash') ?>
                    
                     <?php echo $sf_content ?>
                      
                  </div>
                
                <?php else: ?>

                  <aside id="sidebar">
                     <div class="top"></div>
                     <div class="middle">
                     
                          <?php include_slot('menu_gauche'); ?>
                          
                     </div>
                     <div class="bottom"></div>
                  </aside>       
              
                  <div id="right"  role="main">
                  
                    <?php include_partial('design/flash') ?>
                  
                 
                    <?php echo $sf_content ?>
   
                  </div>
               
                <?php endif; ?>
                
            <br class="clear" />
            </div>
        
        </div>
        
    </section>
    
    <footer>
    
        <div class="content">
   
          <?php include_component("design", "menuFooter")?>
            
          <div class="copy">
            Copyright 2010-2011 &copy; All rights reserved - Development by <a href="http://www.studio-dev.fr"><strong>Studio-Dev.fr</strong></a> 
            
            <div class="validation">
            <a href="http://validator.w3.org/check/referer" target="blank" class="tip" title="* Valid HTML 5 draft"><img src="/images/html5-valide.png" alt="HTML 5" /></a> 
            <a href="http://jigsaw.w3.org/css-validator/check/referer/" target="blank" class="tip" title="* Might become valid with CSS3 validator"><img src="/images/css3-valide.png" alt="CSS 3" /></a>
            <a href="http://www.symfony-project.org" target="blank" class="tip" title="* Propulsed by Symfony 1.4"><img src="/images/symfo-valide.png" alt="Symfony 1.4" /></a>
            </div>
         </div>    

    	</div>
        
    </footer>
    
    <?php include_javascripts_by_position('last') ?>
    
    <script type="text/javascript">
    
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-316708-2']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = 'http://www.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
    
		var disqus_shortname = 'blogstudiodevv2'; 
		
		(function () {
			var s = document.createElement('script'); s.async = true;
			s.type = 'text/javascript';
			s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
			(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		}());
    </script>
    

</body>
</html>
