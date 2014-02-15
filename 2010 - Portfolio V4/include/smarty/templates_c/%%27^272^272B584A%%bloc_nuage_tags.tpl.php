<?php /* Smarty version 2.6.18, created on 2008-01-20 22:49:17
         compiled from bloc_nuage_tags.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'tag_cloud', 'bloc_nuage_tags.tpl', 2, false),)), $this); ?>
<div class="tag_cadre">
	<?php echo smarty_function_tag_cloud(array('tags' => $this->_tpl_vars['TagArray'],'av_url' => 'billets-tag-','ap_url' => '.htm','class' => 'naviguer_tag'), $this);?>

</div>