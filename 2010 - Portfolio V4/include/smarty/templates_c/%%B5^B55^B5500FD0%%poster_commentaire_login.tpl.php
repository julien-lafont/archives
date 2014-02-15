<?php /* Smarty version 2.6.18, created on 2008-02-01 14:01:21
         compiled from poster_commentaire_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'poster_commentaire_login.tpl', 7, false),)), $this); ?>
    	<input type="hidden" name="pseudo" id="pseudo" value="log" />
        <input type="hidden" name="pass" id="pass" value="log" />
        <input type="hidden" name="email" id="email" value="log" />
        <input type="hidden" name="site" id="site" value="log" />

<div class="infos_mbres">
    Bonjour <?php echo ((is_array($_tmp=$this->_tpl_vars['infos_mbre']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
, <br />
    <img src="templates/images/user.png" alt=""/>&nbsp; <a href="mon-compte.htm" class="naviguer_moncompte">Mon compte</a> &nbsp;&nbsp;&nbsp; 
    <img src="templates/images/logout.png" alt=""/>&nbsp; <a href="deconnexion.htm" title="Déconnexion" class="naviguer_deco">D&eacute;connexion</a>
</div>