<section>
  <header>
    <h5>Catégories</h5>
  </header>
  
  <ul>
  <?php foreach ($categories as $categorie):?>
    <?php $current = $sf_request->getParameter('module') == 'blog' && $sf_request->getParameter('action') == 'categorie' && $sf_request->getParameter('slug')==$categorie->getSlug(); ?>
    
    <li><a href="<?php echo url_for('blog_categorie', $categorie)?>" title="" <?php if ($current) echo 'class="current"'?>><span><?php echo $categorie->getTitre()?></span></a></li>
  <?php endforeach;?>
  </ul>

</section><br />