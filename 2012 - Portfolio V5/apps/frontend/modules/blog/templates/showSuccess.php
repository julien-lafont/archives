
  <!-- Article détaillé -->
  <?php include_partial('blog/article_detail', array('article'=>$article))?>


 
	<div class="niceline" id="commentaires"></div>
	
	<h4>Discussions autours de l'article</h4>
	<div id="disqus_thread"></div>
	
	<script type="text/javascript">
		var disqus_shortname = 'blogstudiodevv2'; 
		var disqus_identifier = "blog-<?php echo $article->getId() ?>";
		
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
		
		(function () {
			var s = document.createElement('script'); s.async = true;
			s.type = 'text/javascript';
			s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
			(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		}());
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	
					
<?php /*
  <!--  Commentaires V1 -->
  <?php $commentaires = $article->getCommentaires(); $nbComs = count($commentaires); ?>
  <?php if ($nbComs==0):?>
    <h4>Discussion : Soyez le premier à donner votre avis</h4>
  <?php else: ?>
    <h4>Discussion : <?php echo $nbComs ?> commentaire<?php echo ($nbComs<=1)?'':'s'?></h4>
  <?php endif;?>
  
  <?php foreach ($commentaires as $commentaire):?>
    <?php include_partial('blog/commentaire', array('commentaire'=>$commentaire));?>
  <?php endforeach;?>
 
  <!-- Poster un commentaire -->
  <h3 id="poster">Poster un commentaire</h3>
  
  <?php include_partial('blog/posterCommentaire', array('article'=>$article, 'form'=>$form))?>

*/
?>