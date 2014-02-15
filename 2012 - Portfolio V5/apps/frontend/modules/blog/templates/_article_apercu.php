<?php use_helper('Date'); ?>

<!-- Blog entry -->
<article class="blog_entry">

  <header>
    <h3><a href="<?php echo url_for('article', $article)?>"><?php echo $article->getTitre() ?></a></h3>
  </header>

  <footer>
   <p>Rédigé par <strong>Julien Lafont</strong> le <?php echo format_datetime($article->getDate(), 'dd/MM/yyyy') ?> / 
   <a href="<?php echo url_for("blog_categorie", $article->getCategorie()) ?>"><?php echo $article->getCategorie()->getTitre() ?></a> / 
   <a href="<?php echo url_for('article', $article)?>#disqus_thread" data-disqus-identifier="blog-<?php echo $article->getId() ?>">0 commentaire</a> &nbsp; &nbsp;</p>
  </footer>

  <section>
  	<?php echo $article->getChapeau(ESC_RAW) ?>
  </section>
  
  <p class="right"><a href="<?php echo url_for('article', $article)?>" class="button"><span>Accéder à l'article</span> </a></p>
  <br class="clear" />

</article>
<!-- /Blog entry -->