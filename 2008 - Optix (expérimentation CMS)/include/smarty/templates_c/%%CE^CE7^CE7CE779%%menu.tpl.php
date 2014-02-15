<?php /* Smarty version 2.6.18, created on 2008-11-07 11:32:24
         compiled from _blocs/menu.tpl */ ?>
<?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
<h4><a href="#" title="" style="cursor:default"><?php echo $this->_tpl_vars['cat']['nom']; ?>
</a></h4>
<ul>
	<?php $_from = $this->_tpl_vars['cat']['contenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
	<li><a href="article-<?php echo $this->_tpl_vars['cat']['url']; ?>
-<?php echo $this->_tpl_vars['page']['url']; ?>
.htm" title="Accéder à l'article <?php echo $this->_tpl_vars['page']['titre']; ?>
 de la catégorie <?php echo $this->_tpl_vars['cat']['nom']; ?>
"><strong><?php echo $this->_tpl_vars['page']['titre']; ?>
</strong></a></li>
	<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endforeach; endif; unset($_from); ?>