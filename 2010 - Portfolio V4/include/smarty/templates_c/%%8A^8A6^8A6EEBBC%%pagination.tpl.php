<?php /* Smarty version 2.6.18, created on 2008-01-20 22:49:21
         compiled from pagination.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', 'pagination.tpl', 12, false),array('modifier', 'escape', 'pagination.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['nb_pages'] > 1): ?>
<div class="pagination"><p>
	<?php $_from = $this->_tpl_vars['pagination']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
    
    	<?php if ($this->_tpl_vars['page'][2] === true): ?>
        	<span><strong><?php echo $this->_tpl_vars['page'][0]; ?>
</strong></span>
        <?php elseif ($this->_tpl_vars['page'][2] == 'espace'): ?>
        	&nbsp;&nbsp;
        <?php else: ?>
        	
            	
        	<strong><a href="billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
<?php if ($this->_tpl_vars['page'][1] != 1): ?>-<?php echo $this->_tpl_vars['page'][1]; ?>
<?php endif; ?>-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo $this->_tpl_vars['page'][1]; ?>
" class="naviguer_billet_detail" title="Afficher en détail le billet : <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 page <?php echo $this->_tpl_vars['page'][1]; ?>
"><?php echo $this->_tpl_vars['page'][0]; ?>
</a></strong>
        <?php endif; ?>
    
    <?php endforeach; endif; unset($_from); ?></p>
    <h4>Page <?php echo $this->_tpl_vars['page_courante']; ?>
/<?php echo $this->_tpl_vars['nb_pages']; ?>
</h4>
</div>
<?php endif; ?>