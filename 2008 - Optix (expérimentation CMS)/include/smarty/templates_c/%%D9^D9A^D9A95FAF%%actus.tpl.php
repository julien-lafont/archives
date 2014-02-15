<?php /* Smarty version 2.6.18, created on 2008-11-06 14:45:53
         compiled from _blocs/actus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', '_blocs/actus.tpl', 4, false),)), $this); ?>
<h5>Dernières actualités</h5>
<ul>
	<?php $_from = $this->_tpl_vars['actus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['actu']):
?>
    	<li><a href="actualite-<?php echo $this->_tpl_vars['actu']['id_news']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['actu']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" title="Lire la news : <?php echo $this->_tpl_vars['actu']['titre']; ?>
"><img src="templates/images/puce1.gif" alt="Puce" /> &nbsp;<?php echo $this->_tpl_vars['actu']['titre']; ?>
</a></li>
    <?php endforeach; else: ?>
    	<li><a href="#" title="">Aucune actualité</a></li>
    <?php endif; unset($_from); ?>
</ul>