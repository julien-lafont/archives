<?php /* Smarty version 2.6.18, created on 2008-02-06 14:59:10
         compiled from messagerie_liste.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'messagerie_liste.tpl', 20, false),array('modifier', 'capitalize', 'messagerie_liste.tpl', 21, false),array('modifier', 'date_format', 'messagerie_liste.tpl', 22, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messagerie_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="messagerie">

    <div class="titreMessagerie"><?php echo $this->_tpl_vars['titre']; ?>
</div>
    <div class="centre"><?php echo $this->_tpl_vars['info']; ?>
</div>
    
    <table class="liste_mess" cellpadding=0 cellspacing=0>
        <tr>
            <td class="top" width="28"></td>
            <td class="top" style="text-align:left;" width="200"><?php echo $this->_tpl_vars['champs']['1']; ?>
</td>
            <td class="top" width="75" style="text-align:center"><?php echo $this->_tpl_vars['champs']['2']; ?>
</td>
            <td class="top" width="75" style="text-align:center"><?php echo $this->_tpl_vars['champs']['3']; ?>
</td>
            <td class="top" width="30"></td>
        </tr>
        
        <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mess']):
?>
            <tr id="tr<?php echo $this->_tpl_vars['mess']['id']; ?>
">
                <td><img src="images/messagerie/<?php echo $this->_tpl_vars['mess']['etat']; ?>
.png"></td>
                <td style="text-align:left"><a href="messagerie-lire<?php echo $this->_tpl_vars['type']; ?>
-<?php echo $this->_tpl_vars['mess']['id']; ?>
.htm" class="naviguer_messagerie" rel="lire<?php echo $this->_tpl_vars['type']; ?>
-<?php echo $this->_tpl_vars['mess']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['sujet'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
                <td><a href="membre-<?php echo $this->_tpl_vars['mess']['id_membre']; ?>
-<?php echo $this->_tpl_vars['mess']['pseudo']; ?>
.htm" class="naviguer_membre" rel="<?php echo $this->_tpl_vars['mess']['id_membre']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></td>
                <td><span style="font-size:10px; color:#AAA"><?php echo ((is_array($_tmp=$this->_tpl_vars['mess']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%y") : smarty_modifier_date_format($_tmp, "%d/%m/%y")); ?>
</span></td>
                <td><a href="messagerie-supprimer-<?php echo $this->_tpl_vars['mess']['id']; ?>
.htm" class="naviguer_messagerie" rel="supprimer-<?php echo $this->_tpl_vars['mess']['id']; ?>
" ><img src="images/messagerie/email_delete.png"></a></td>
            </tr>
        <?php endforeach; else: ?>
			<tr>
            	<td colspan="5" style="text-align:center">Vous n'avez aucun message !</td>
            </tr>
        <?php endif; unset($_from); ?>
                    
    </table>
    
    <div class="infos_bas">
        <img src="images/messagerie/nouveau.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
        <img src="images/messagerie/lu.png" style="vertical-align:middle"> D&eacute;j&agrave; lu &nbsp;&nbsp;
        <img src="images/messagerie/important.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
        <img src="images/messagerie/auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
    </div>
        
</div>