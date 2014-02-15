<?php /* Smarty version 2.6.18, created on 2010-08-06 20:47:45
         compiled from fr/_rea/sites.tpl */ ?>
<div id="siteweb" class="min_rea">

	<div class="center" id="web"><img src="images/T_devWeb.png" alt="" /></div>
		
	<div class="detail"></div>

	<ul class="gen">
		<?php $_from = $this->_tpl_vars['liste']['sites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rea']):
?>
			<li><a href="#" class="info_rea" rel="<?php echo $this->_tpl_vars['rea']['prefix']; ?>
" title ="<?php echo $this->_tpl_vars['rea']['titre']; ?>
 (<?php echo $this->_tpl_vars['rea']['annee']; ?>
)|<?php echo $this->_tpl_vars['rea']['bulle_desc']; ?>
" ><img src="images/realisations/min_sites/<?php echo $this->_tpl_vars['rea']['min_rea']; ?>
" alt="<?php echo $this->_tpl_vars['rea']['titre']; ?>
" /></a></li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
	
	<br class="clear" />
	<div class="help"><img src="images/help_moyen.png" alt="? " /> Cliquez sur une miniature pour avoir plus de détail</div>
	

</div>

<div class="retour_site"><a href="#" title="Développements webs|Retourner à la liste de mes réalisations">Retour à la liste</a></div>
	