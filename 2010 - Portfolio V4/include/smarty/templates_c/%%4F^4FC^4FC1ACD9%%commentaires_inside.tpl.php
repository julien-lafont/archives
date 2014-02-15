<?php /* Smarty version 2.6.18, created on 2008-02-15 09:29:32
         compiled from commentaires_inside.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', 'commentaires_inside.tpl', 7, false),array('modifier', 'capitalize', 'commentaires_inside.tpl', 7, false),array('modifier', 'nl2br', 'commentaires_inside.tpl', 19, false),array('modifier', 'date_format_pretty', 'commentaires_inside.tpl', 21, false),)), $this); ?>
<div class="com" <?php echo $this->_tpl_vars['action_speciale']; ?>
>
    <div class="infos">
        
        <img src="<?php if (empty ( $this->_tpl_vars['com']['avatar'] )): ?>images/no_avatar.png<?php else: ?>upload/avatars/<?php echo $this->_tpl_vars['com']['avatar']; ?>
<?php endif; ?>" class="avatar" alt="Avatar de <?php echo $this->_tpl_vars['com']['pseudo']; ?>
"/>
        <div class="auteur">
        	<?php if ($this->_tpl_vars['com']['id_membre'] != 0): ?>
				<a href="membre-<?php echo $this->_tpl_vars['com']['id_membre']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['com']['pseudo'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_membre" rel="<?php echo $this->_tpl_vars['com']['id_membre']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['com']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a> 
			<?php else: ?>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['com']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

			<?php endif; ?> 
			
			<?php if (! empty ( $this->_tpl_vars['com']['site'] )): ?>
				<a href="<?php echo $this->_tpl_vars['com']['site']; ?>
" rel="blank" title="Visiter le site internet de <?php echo $this->_tpl_vars['com']['pseudo']; ?>
"><img src="images/link.png" alt="lien site" class="vmiddle"/></a>
			<?php endif; ?>
        </div> 
    </div>
    
    <div class="message">
        <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['message'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
    
    </div>
    <div class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['com']['date'])) ? $this->_run_mod_handler('date_format_pretty', true, $_tmp) : smarty_modifier_date_format_pretty($_tmp)); ?>
</div>   
</div>

<br class="clear" />