<section>
  <header>
    <h5>Articles préférés</h5>
  </header>
  
  <ul>
  <?php foreach ($tops as $article):?>
    <?php $current = $sf_request->getParameter('module') == 'blog' && $sf_request->getParameter('action') == 'show' && $sf_request->getParameter('slug')==$article->getSlug(); ?>
    
    <li><a href="<?php echo url_for('article', $article)?>" title="<?php echo $article->getTitre()?>" class="tip <?php if ($current) echo 'current'?>"><span><?php echo $article->getTitre()?></span></a></li>
  <?php endforeach;?>
  </ul>

</section><br />