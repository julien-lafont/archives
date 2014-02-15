<?php use_helper('Date', 'Bitly'); ?>

<article id="article-detail" class="blog_entry">

	<div class="article">
		
		<!-- Fil d'ariane -->
		<div class="breadcrumb negatif center"><a href="http://www.studio-dev.fr/blog">Revenir au blog Studio-Dev</a>  <!--
		<a href="<?php echo url_for("blog_categorie", $article->getCategorie()) ?>">Catégorie <?php echo $article->getCategorie()->getTitre() ?></a> <!--&raquo;
		<?php echo $article->getTitre(); ?>-->
		</div>
								
  
		
		<header>
			<h3><a href="<?php echo url_for('article', $article)?>"><?php echo $article->getTitre() ?></a></h3>
		</header>

		<footer>
			<p class="infos_entry">Rédigé par <strong>Yotsumi</strong> le <?php echo format_datetime($article->getDate(), 'dd/MM/yyyy à HH:mm') ?> // 
			<a href="<?php echo url_for("blog_categorie", $article->getCategorie()) ?>"><?php echo $article->getCategorie()->getTitre() ?></a> // 
			<a href="<?php echo url_for('article', $article)?>#disqus_thread" data-disqus-identifier="blog-<?php echo $article->getId() ?>" class="smooth"><?php echo $article->getNbCommentairesS() ?></a></p>
		</footer>
  
  		<section>
  			
			<?php if ($article->getAfficherChapeau()==true):?>
			<div class="biglines chapeau"><?php echo $article->getChapeau(ESC_RAW) ?></div>
			<div class="niceline"></div>
			<?php endif;?>
  
  			<?php echo $article->getContenu(ESC_RAW) ?>
  			
  			
  			<div class="breadcrumb negatif center"><a href="http://www.studio-dev.fr/blog">Revenir au blog Studio-Dev</a></div>
  			
		
  			
  		</section>
 
		<!--<div>
				<?php if ($article->hasArticlePrecedent()):?><a href="<?php echo url_for('article', $article->getArticlePrecedent())?>" class="button float_left"><span>Article précédent</span></a><?php endif;?>
				<?php if ($article->hasArticleSuivant()):?><a href="<?php echo url_for('article', $article->getArticleSuivant())?>" class="button "><span>Article suivant</span></a><?php endif; ?>
				<br class="clear" />
			</div>
  
  			<?php $article->getArticleSuivant();?>
  			-->
  
		<div class="note">
		  	<p>
			  Ce blog est tenu par <strong>Julien Lafont</strong>, étudiant en <a href="http://www.epsi.fr/" target="blank">ingénierie Informatique</a> à Montpellier et développeur indépendant à ses heures perdues.
			</p>
			<p class="right">Web, Android & JavaEE enthousiast Developer, Agilist, Software Craftsman and Geek !</p>
		</div>
  

		<div class="col40">
 
		 	
			
			<?php $tags = $article->getTags(); if (count($tags)>0): ?>
			<h5>Tags : </h5>
			<ul class="nuage_tag">
			   <?php foreach ($tags as $tag): ?>
			      <li class="tag_2"><a href="<?php echo url_for('@blog_tag?tag='.$tag)?>"  class="tip" title="Voir tous les articles attachés au tag <?php  echo ucfirst($tag)  ?>"><strong><?php echo ucfirst($tag) ?></strong></a></li>
			    <?php endforeach; ?>
			</ul>
			<br class="clear" />
			<?php endif; ?>

		</div>
  
		<div class="col60">
			<h5 class="right">Vous aimez cet article ? Partagez le !</h5>
			<p class="right social">
				<a href="http://www.facebook.com/share.php?u=<?php echo urlencode($sf_request->getUri())?>" class="tip" title="Partager cet article sur [strong]Facebook[/strong]"><img src="/images/social/icontexto-inside-facebook.png" /> </a>
				<a href="http://twitter.com/home/?status=<?php echo urlencode("Blog Studio-dev.fr : ".$article->getTitre().' @ '.bitly($sf_request->getUri()).'') ?>" class="tip" title="Partager cet article sur [strong]Twitter[/strong]"><img src="/images/social/icontexto-inside-twitter.png" /> </a>
				<a href="http://digg.com/submit?phase=2&amp;url=<?php echo urlencode($sf_request->getUri())?>" class="tip" title="Partager cet article sur [strong]Digg[/strong]"><img src="/images/social/icontexto-inside-digg.png" /> </a>
				<a href="http://del.icio.us/post?url=<?php echo urlencode($sf_request->getUri())?>&amp;title=<?php echo urlencode($article->getTitre())?>"  class="tip" title="Partager cet article sur Del.icio.us"><img src="/images/social/icontexto-inside-delicious.png" /> </a> 
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($sf_request->getUri())?>&amp;title=<?php echo urlencode($article->getTitre())?>&amp;source=LinkedIn" class="tip" title="Partager cet article sur [strong]LinkedIn[/strong]"><img src="/images/social/icontexto-inside-linkedin.png" /> </a>
			</p>
		</div>
   
  		<?php if (count($article->getArticlesLies())>0):?>
		<h5>Articles traitant du même sujet</h5>
  
		<ul class="puce bullet-disc-orange">
  
			<?php foreach($article->getArticlesLies() as $articleLie):?>
		    	<li><a href="<?php echo url_for('article', $articleLie) ?>"><?php echo $articleLie->getTitre()?></a></li>
		    <?php endforeach;?>
		      
		</ul>
		<?php endif; ?>
		
	</div>

</article>