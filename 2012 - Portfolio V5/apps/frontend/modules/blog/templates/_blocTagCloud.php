<section>
  <header>
    <h5>Nuage de tags</h5>
  </header>
  
  <ol class="nuage_tag">
  <?php foreach( $tags as $nom=>$poids):?>
  	<?php if (empty($nom)) continue; ?>
  	
    <li class="tag_<?php echo $poids?>"><a href="<?php echo url_for('@blog_tag?tag='.$nom)?>"  class="tip" title="Voir tous les articles attachés au tag [strong]<?php  echo ucfirst($nom)  ?>[/strong]"><?php echo ucfirst($nom) ?></a></li>
  <?php endforeach; ?>
  </ol>

</section>