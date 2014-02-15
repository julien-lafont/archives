<section id="topArticlesResume">
  
  <?php foreach ($tops as $article):?>

    <article rel="<?php echo url_for('article', $article) ?>">
      <h4><a href="<?php echo url_for('article', $article) ?>"><?php echo $article->getTitre()?></a></h4>
      <blockquote class="hoverblack"><?php echo $article->getChapeau();?></blockquote>
    </article> 

  <?php endforeach; ?>

  
</section>

<script type="text/javascript">
  $('#topArticlesResume').innerfade({
      animationtype: 'fade',
      speed: 750,
      timeout: 4000,
      type: 'sequence',
      containerheight: '200px'
    });
</script>