<style>
	.com-counts { display: none }
	.com-nb:after { content:")"}
	.com-nb:before { content:"("}
</style>

<?php foreach($articles as $article):?>
  <li>
    <a href="<?php echo url_for('article', $article); ?>" class="tip" title="Lire l'article [strong]<?php echo $article?>[/strong] sur le blog technique Studio-dev.fr"><?php echo $article?></a> <a href="<?php echo url_for('article', $article); ?>#disqus_thread" data-disqus-identifier="blog-<?php echo $article->getId() ?>" class="com-nb">0</a>
  </li>
<?php endforeach;?>
