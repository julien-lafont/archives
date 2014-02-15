<nav <?php if (isset($footer)) echo 'id="bottom_nav"';?> role="navigation">
	<ul>
		<li><a href="<?php echo url_for('@homepage'); ?>" class="navstyle"><span>Accueil</span></a></li>
		<li><a href="<?php echo url_for('@cv'); ?>" class="navstyle"><span>Mon CV</span></a></li>
		<li><a href="<?php echo url_for('@competences'); ?>" class="navstyle "><span>Domaines de compétences</span></a></li>
		<li><a href="<?php echo url_for('@folio'); ?>" class="navstyle "><span>Mes travaux</span></a></li>
		<li><a href="http://www.studio-dev.fr/blog" class="navstyle" onClick="_gaq.push(['_trackEvent', 'Navigation', 'Blog']);"><span>Blog</span></a>
		<?php if (isset($categories) && count($categories)>0): ?>
		<!--<ul>
			<?php foreach($categories as $cat): ?>
			<li><a href="<?php echo url_for('blog_categorie', $cat) ?>"><span><?php echo $cat->getTitre() ?> (<?php echo $cat->getNbArticles()?>)</span></a></li>
			<?php endforeach; ?>
		</ul>-->
		<?php endif; ?>
		</li>
		
		<?php if (isset($_GET['epsi'])):?>
			<li><a href="<?php echo url_for('@recommandations'); ?>" class="navstyle"><span>Recommandations</span></a></li>
		<?php endif; ?>
		
		<li><a href="<?php echo url_for('@contact');?>" class="navstyle "><span>Contact</span></a></li>
	</ul>
	
	<?php if (isset($footer)):?>
	    <div id="bottom_logo">
	         <a href="http://www.studio-dev.fr"><span class="inv">Studio-dev</span></a>
	    </div>
	    
	    <?php if (Toolbox::checkIp()):?>
	    <div id="bottom_login">
	      <a href="/backend.php"><span class="inv">Connexion</span></a>
	    </div>
	    <?php endif; ?>
    <?php endif; ?>
</nav>