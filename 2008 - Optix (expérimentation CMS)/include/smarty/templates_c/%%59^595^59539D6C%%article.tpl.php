<?php /* Smarty version 2.6.18, created on 2008-11-07 13:39:15
         compiled from _general/article.tpl */ ?>
<div class="article">

	<div class="ariane"><strong><?php echo $this->_tpl_vars['article']['nom']; ?>
</strong> / <a href="article-<?php echo $this->_tpl_vars['article']['urlCat']; ?>
-<?php echo $this->_tpl_vars['article']['urlPage']; ?>
.htm"><?php echo $this->_tpl_vars['article']['titre']; ?>
</a></div>
	
	<h1><?php echo $this->_tpl_vars['article']['titre']; ?>
</h1>
	
	<?php echo $this->_tpl_vars['article']['contenu']; ?>



</div>