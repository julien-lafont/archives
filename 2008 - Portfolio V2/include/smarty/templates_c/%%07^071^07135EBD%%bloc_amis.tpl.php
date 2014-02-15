<?php /* Smarty version 2.6.18, created on 2008-02-17 19:06:10
         compiled from bloc_amis.tpl */ ?>
<?php $_from = $this->_tpl_vars['bloc_ami']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ami']):
?>
  <li><a href="<?php echo $this->_tpl_vars['ami']['url']; ?>
" 
  		 rel="blank" 
		 title="<?php echo $this->_tpl_vars['ami']['description']; ?>
">
		      <?php echo $this->_tpl_vars['ami']['nom']; ?>

	   </a>
  </li>
<?php endforeach; endif; unset($_from); ?>