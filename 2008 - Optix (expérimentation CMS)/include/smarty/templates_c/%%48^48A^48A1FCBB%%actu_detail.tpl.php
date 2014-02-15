<?php /* Smarty version 2.6.18, created on 2008-11-07 13:38:44
         compiled from _general/actu_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '_general/actu_detail.tpl', 7, false),)), $this); ?>
<div class="actu">
	<h1><?php echo $this->_tpl_vars['actualite']['titre']; ?>
</h1>
	
		<?php echo $this->_tpl_vars['actualite']['contenu']; ?>

	
	
	<p style="text-align:right; font-weight:bold">Par <?php echo $this->_tpl_vars['actualite']['identite']; ?>
, posté <i><?php echo ((is_array($_tmp=$this->_tpl_vars['actualite']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</i></p>
</div>