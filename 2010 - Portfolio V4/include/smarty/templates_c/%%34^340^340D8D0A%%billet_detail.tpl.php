<?php /* Smarty version 2.6.18, created on 2008-02-06 14:49:53
         compiled from billet_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'billet_detail.tpl', 4, false),array('modifier', 'recode', 'billet_detail.tpl', 8, false),array('modifier', 'escape', 'billet_detail.tpl', 8, false),array('modifier', 'lower', 'billet_detail.tpl', 31, false),)), $this); ?>
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
" title="Afficher en d&eacute;tail le billet : <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 ainsi que les r&eacute;actions des membres">
    		<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

         </a>
    </h2>
    <br class="clear" />
    
    <div class="infos">
    	<span class="heure"><?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</span>  
        <span class="cat"><a href="categorie-<?php echo $this->_tpl_vars['billet']['id_cat']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['cat_url'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_categorie" rel="<?php echo $this->_tpl_vars['billet']['id_cat']; ?>
"><?php echo $this->_tpl_vars['billet']['cat']; ?>
</a></span> 
        <span class="auteur"><a href="membre-<?php echo $this->_tpl_vars['billet']['id_auteur']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['pseudo'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" title="Afficher le profil du membre <?php echo $this->_tpl_vars['billet']['pseudo']; ?>
" class="naviguer_membre" rel="<?php echo $this->_tpl_vars['billet']['id_auteur']; ?>
"><?php echo $this->_tpl_vars['billet']['pseudo']; ?>
</a></span>
    	<span class="points" id="span_pts_<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
"><?php echo $this->_tpl_vars['billet']['points']; ?>
 <a href="javascript:void()" class="ajouter_point" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
">+1</a></span>
    </div>
	
    <div class="coms">
        <a href="billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_billet_detail" rel="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
" title="Afficher les commentaires du billet <?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" ><?php echo $this->_tpl_vars['billet']['nb_com']; ?>
 commentaire<?php if ($this->_tpl_vars['billet']['nb_com'] > 1): ?>s<?php endif; ?></a>
    </div>
    <br class="clear" />
    
    <div class="message">
    	<?php echo $this->_tpl_vars['billet']['contenu']; ?>

        
        <div class="tags">
            <?php $_from = $this->_tpl_vars['billet']['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
                <a href="billets-tag-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tag'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
.htm" class="naviguer_tag" rel="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tag'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
" title="Afficher les articles en rapport avec le tag <?php echo $this->_tpl_vars['tag']; ?>
"><strong><?php echo $this->_tpl_vars['tag']; ?>
</strong></a> 
            <?php endforeach; endif; unset($_from); ?>
        </div>
        <div class="trackball">
        	<a href="<?php echo $this->_tpl_vars['baseUrl']; ?>
billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm"><?php echo $this->_tpl_vars['baseUrl']; ?>
billet-<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['billet']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm</a>
        </div>
    </div>
    
</div>


<?php if ($this->_tpl_vars['billet']['com_statut'] != 'ferme'): ?>
	<?php if ($this->_tpl_vars['billet']['nb_com'] == 0): ?>
		<div style="text-align:center; margin-bottom:15px"><a href="#poster_commentaire" class="lien_poster_commentaire">Soyez le premier &agrave; poster un commentaire</a></div>
	<?php endif; ?>
	
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "commentaires.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
  
<div id="poster_commentaire">

	<!--<?php if (( $this->_tpl_vars['billet']['com_statut'] == 'membres_only' && $this->_tpl_vars['est_connecte'] ) || $this->_tpl_vars['billet']['com_statut'] == 'ouvert'): ?>		
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "poster_commentaire.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php elseif ($this->_tpl_vars['billet']['com_statut'] == 'membres_only'): ?>
		<div class="message_erreur">
			Seuls les membres connect&eacute;s peuvent poster des commentaires sur ce sujet.
		</div>
	<?php else: ?>
		<div class="message_erreur">
			Les commentaires ont &eacute;t&eacute; d&eacute;sactiv&eacute;s sur ce billet.
		</div>
	<?php endif; ?>-->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "poster_commentaire.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>