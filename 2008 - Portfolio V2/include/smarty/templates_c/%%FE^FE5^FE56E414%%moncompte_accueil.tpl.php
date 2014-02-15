<?php /* Smarty version 2.6.18, created on 2008-01-24 20:11:39
         compiled from moncompte_accueil.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', 'moncompte_accueil.tpl', 15, false),)), $this); ?>
<div class="centre">
    <h2><?php echo $this->_tpl_vars['pseudo']; ?>
, bienvenue sur votre espace personnel</h2><br /><br />
    
    <span class="txt11">Cette zone vous permet de modifier les informations de votre profil, de contacter un autre membre via notre messagerie internet et surtout de contribuer au site en soumettant du contenu.</span>
    <table style="width:80%; margin:30px auto" id="liste_lien_moncompte">
        <tr>
            <td style="width:50%; text-align:center"><a href="mon-compte-infos.htm" class="naviguer_moncompte" rel="infos"><strong>Mon profil</strong></a></td>
            <td style="width:50%; text-align:center"><a href="ma-messagerie.htm" class="naviguer_messagerie" rel="accueil"><strong>Messagerie interne</strong></a></td>
        </tr>
        <tr>
            <td style="text-align:center"><a href="mon-compte-infos.htm" class="naviguer_moncompte" rel="infos"><img src="images/membre/Login_Manager.png" alt="Profil" /></a></td>
            <td style="text-align:center"><a href="ma-messagerie.htm" class="naviguer_messagerie" rel="accueil"><img src="images/membre/chat.png" alt="Messagerie" /></a></td>
        </tr>
     	<tr>
        	<td style="text-align:center"><a href="membre-<?php echo $this->_tpl_vars['infos']['id_membre']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['pseudo'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" title="" class="naviguer_membre lien" rel="<?php echo $this->_tpl_vars['infos']['id_membre']; ?>
">&rsaquo; Voir ma fiche &lsaquo;</a></td>
            <td></td>
        </tr>
    </table>
</div>