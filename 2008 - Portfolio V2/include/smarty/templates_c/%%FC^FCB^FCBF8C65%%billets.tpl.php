<?php /* Smarty version 2.6.18, created on 2008-02-12 13:33:58
         compiled from billets.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'billets.tpl', 5, false),array('modifier', 'recode', 'billets.tpl', 9, false),array('modifier', 'escape', 'billets.tpl', 9, false),array('modifier', 'capitalize', 'billets.tpl', 18, false),array('modifier', 'truncate', 'billets.tpl', 29, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['billets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['billet']):
?>
<div class="billets">

    <div class="date">
    	<h5><?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e") : smarty_modifier_date_format($_tmp, "%e")); ?>
</h5> 
        <h6><?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%b") : smarty_modifier_date_format($_tmp, "%b")); ?>
</h6>
    </div> 
    
  	<h2><a href="billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_billet_detail" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
" title="Afficher en détail le billet : <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 ainsi que les reactions des membres">
    		<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

         </a>
    </h2>
    <br class="clear" />
    
    <div class="infos">
    	<span class="heure"><?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</span>  
        <span class="cat"><a href="categorie-<?php echo $this->_tpl_vars['billet']['id_cat']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['cat'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_categorie" rel="<?php echo $this->_tpl_vars['billet']['id_cat']; ?>
"><?php echo $this->_tpl_vars['billet']['cat']; ?>
</a></span> 
        <span class="auteur"><a href="membre-<?php echo $this->_tpl_vars['billet']['id_auteur']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['pseudo'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" title="Afficher le profil du membre <?php echo $this->_tpl_vars['billet']['pseudo']; ?>
" class="naviguer_membre" rel="<?php echo $this->_tpl_vars['billet']['id_auteur']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></span>
    	<span class="points" id="span_pts_<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
"><?php echo $this->_tpl_vars['billet']['points']; ?>
 <a href="javascript:void(0)" class="ajouter_point" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
">+1</a></span>
    </div>
	
    <div class="coms">
        <a href="billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_billet_detail" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
" title="Afficher les commentaires du billet <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['billet']['nb_com']; ?>
 commentaire<?php if ($this->_tpl_vars['billet']['nb_com'] > 1): ?>s<?php endif; ?></a>
    </div>
    <br class="clear" />
    
    <div class="message">
    	<?php if (empty ( $this->_tpl_vars['billet']['resume'] )): ?>
    		<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['contenu'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 150) : smarty_modifier_truncate($_tmp, 150)); ?>

       <?php else: ?>
       		<?php echo $this->_tpl_vars['billet']['resume']; ?>

        <?php endif; ?>
    </div>
    
    <?php if (isset ( $this->_tpl_vars['billet']['resume'] ) && strlen ( $this->_tpl_vars['billet']['contenu'] ) > 150): ?>
    <div class="lire_suite">
    	<a href="billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_billet_detail" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
" title="Afficher les commentaires du billet <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">&nbsp;</a>
    </div>
    <br class="clear" />
    <?php endif; ?>
    
</div>
<?php endforeach; else: ?>

	Rien !
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "erreur.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    
<?php endif; unset($_from); ?>


<?php if (isset ( $this->_tpl_vars['suivprec']['prec']['href'] ) || isset ( $this->_tpl_vars['suivprec']['suiv']['href'] )): ?>
<table class="page_suiv_prec">
	<tr>
    	<td class="prec"><?php if (isset ( $this->_tpl_vars['suivprec']['prec']['href'] )): ?><img src="templates/images/pagination_fl_g.png" alt="Prec" /> <a href="<?php echo $this->_tpl_vars['suivprec']['prec']['href']; ?>
" rel="<?php echo $this->_tpl_vars['suivprec']['prec']['rel']; ?>
" title="<?php echo $this->_tpl_vars['suivprec']['prec']['title']; ?>
" class="<?php echo $this->_tpl_vars['suivprec']['prec']['class']; ?>
">Billets précédents</a><?php endif; ?></td>
        <td class="suiv"><?php if (isset ( $this->_tpl_vars['suivprec']['suiv']['href'] )): ?><a href="<?php echo $this->_tpl_vars['suivprec']['suiv']['href']; ?>
" rel="<?php echo $this->_tpl_vars['suivprec']['suiv']['rel']; ?>
" title="<?php echo $this->_tpl_vars['suivprec']['suiv']['title']; ?>
" class="<?php echo $this->_tpl_vars['suivprec']['suiv']['class']; ?>
">Billets suivants</a> <img src="templates/images/pagination_fl_d.png" alt="Suiv" /><?php endif; ?></td>
    </tr>
</table>
<?php endif; ?>