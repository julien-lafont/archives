<?php /* Smarty version 2.6.18, created on 2008-02-06 14:52:35
         compiled from messagerie_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'messagerie_detail.tpl', 9, false),array('modifier', 'escape', 'messagerie_detail.tpl', 10, false),array('modifier', 'nl2br', 'messagerie_detail.tpl', 15, false),array('modifier', 'date_format_pretty', 'messagerie_detail.tpl', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messagerie_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="messagerie">

	<div class="titreMessagerie">Lire un message</div>
	
		<table class="table_ecrire">
			<tr>
				<td style="width:150px; text-align:center" id="first"><a href="membre-<?php echo $this->_tpl_vars['mess']['id_membre']; ?>
-<?php echo $this->_tpl_vars['mess']['pseudo']; ?>
.htm" class="naviguer_membre" rel="<?php echo $this->_tpl_vars['mess']['id_membre']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></td>
				<td style="height:15px;font-family:verdana; font-size:11px; color:#FFF; border-bottom:1px dotted #666; padding-bottom:2px"> &nbsp; <img src="images/boutons/email_open.png" /> &nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['sujet'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			</tr>
			
			<tr>
				<td style="vertical-align:top; padding-top:11px; text-align:center"><img src="<?php if (empty ( $this->_tpl_vars['mess']['avatar'] )): ?>images/no_avatar.png<?php else: ?>upload/avatars/<?php echo $this->_tpl_vars['mess']['avatar']; ?>
<?php endif; ?>" class="avatar" alt="Avatar de <?php echo $this->_tpl_vars['mess']['pseudo']; ?>
"/></td>
				<td style="vertical-align:top; padding-top:11px" class="message"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['mess']['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>
			</tr>
			<tr>
				<td></td>
				<td style="color:#AAA; text-align:right; height:15px; vertical-align:bottom; font-size:10px"><?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['date'])) ? $this->_run_mod_handler('date_format_pretty', true, $_tmp) : smarty_modifier_date_format_pretty($_tmp)); ?>
</td>
			</tr>
            <?php if ($this->_tpl_vars['type'] == 'Inbox'): ?>
            <tr>
            	<td colspan="2">
                	<a href="messagerie-supprimer-<?php echo $this->_tpl_vars['mess']['id']; ?>
.htm" class="naviguer_messagerie" rel="supprimer-<?php echo $this->_tpl_vars['mess']['id']; ?>
" title="Supprimer le message" ><img src="images/messagerie/email_delete.png" style="vertical-align:middle"> Supprimer</a> &nbsp; &nbsp; &nbsp;
					<a href="messagerie-ecrire-<?php echo $this->_tpl_vars['mess']['id']; ?>
.htm" class="naviguer_messagerie" rel="ecrire-<?php echo $this->_tpl_vars['mess']['id']; ?>
"title="Répondre à ce message"><img src="images/messagerie/auto.png" style="vertical-align:middle"> R&eacute;pondre</a>
				</td>
           </tr>
           <?php endif; ?>
		</table>
		
		<div style="margin-top:7px;">
		</div>
		
</div>