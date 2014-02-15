<?php /* Smarty version 2.6.18, created on 2010-08-06 20:47:45
         compiled from fr/_rea/design.tpl */ ?>
<div id="design" class="min_rea">

	<div class="center"><img src="images/T_Infographie2.png" alt="" /></div>
		
	<div class="detail"></div>

	<ul class="gen">
		<?php $_from = $this->_tpl_vars['liste']['designs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rea']):
?>
			<li><a href="images/design/<?php echo $this->_tpl_vars['rea']['min_rea']; ?>
" rel="prettyOverlay[$rea.prefix]" title="<?php echo $this->_tpl_vars['rea']['titre']; ?>
|<?php echo $this->_tpl_vars['rea']['bulle_desc']; ?>
" ><img src="images/design/_<?php echo $this->_tpl_vars['rea']['min_rea']; ?>
" alt="<?php echo $this->_tpl_vars['rea']['titre']; ?>
" /></a></li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
	
	<br class="clear" />
	<div class="help"><img src="images/help_moyen.png" alt="? " /> Cliquez sur une miniature pour l'afficher en plein écran.</div>
		

</div>