<div id="liste-articles">	
	<?php foreach($pager->getResults() as $article):?>
		<?php include_partial('blog/article_apercu', array('article'=>$article))?>
	<?php endforeach; ?>
</div>


         
<?php if ($pager->haveToPaginate()): ?>                
<div id="paginate">
    <div class="pagination">
        <?php if ($pager->getPreviousPage()!=$pager->getPage()):?>
          <span><a href="<?php echo url_for('blog', array('page' => $pager->getPreviousPage()))?>">&laquo;</a></span>
        <?php endif;?>
        
        <?php foreach ($pager->getLinks() as $page): ?>
          <?php if ($page == $pager->getPage()): ?>
            <span class="courante"><?php echo $page ?></span>
          <?php else: ?>
           <a href="<?php echo url_for('blog', array('page' =>$page))?>"><?php echo $page ?></a>
          <?php endif; ?>
        <?php endforeach; ?>
        
        <?php if ($pager->getNextPage()!=$pager->getPage()):?>
          <span><a href="<?php echo url_for('blog', array('page' =>$pager->getNextPage()))?>">&raquo;</a></span>
        <?php endif;?>
    </div>
</div>
<?php endif; ?>
           

<?php slot('menu_gauche')?>
  <?php include_component('blog', 'blocListeCategories');?>
  <?php include_component('blog', 'blocTopArticles');?>
  <?php include_component('blog', 'blocTagCloud');?>
<?php end_slot() ?>