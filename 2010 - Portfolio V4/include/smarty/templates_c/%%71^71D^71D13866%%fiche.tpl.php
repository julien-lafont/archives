<?php /* Smarty version 2.6.18, created on 2008-02-06 14:01:38
         compiled from fiche.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'fiche.tpl', 7, false),array('modifier', 'nl2br', 'fiche.tpl', 48, false),array('modifier', 'date_format_pretty', 'fiche.tpl', 56, false),array('modifier', 'recode', 'fiche.tpl', 69, false),)), $this); ?>

<!--<div class="fiche_pseudo">
		<object type="application/x-shockwave-flash" data="images/FormatText.swf" width="590" height="80">
        <param name="movie" value="images/FormatText.swf" />
        <param name="quality" value="best" />
        <param name="pluginurl" value="http://www.macromedia.com/go/getflashplayer" />
        <param name="flashvars" value="&amp;txt=<?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
&amp;textColor1=0xEEEEEE&amp;textColor2=0xFFFFFF&amp;textColor3=0xEEEEEE&amp;textColor4=0xFFFFFF&amp;nbText=4" />
        <param name="scale" value="exactfit" />
        <param name="menu" value="false" />
        <param name="wmode" value="transparent" />
          </object>
         
</div>-->

 <h1 class="style centre" style="margin-left:45px">Fiche du membre <?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['pseudo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</h1>



<table class="fiche_table">
	<tr>
    	<td style="width:40%">
        
        	<div id="contenu_infos">
            
            	<h3 class="top">Communaut&eacute;</h3>
                <ul>
                    <li><span>Site/blog :</span> <?php if (! empty ( $this->_tpl_vars['infos']['site'] )): ?><a href="<?php echo $this->_tpl_vars['infos']['site']; ?>
" rel="blank" title="Visiter le site internet de <?php echo $this->_tpl_vars['infos']['pseudo']; ?>
"><img src="images/link.png" alt="lien site" class="vmiddle"/></a><?php endif; ?>
                    	<div class="fiche_avatar">
    						<img src="<?php if (empty ( $this->_tpl_vars['infos']['avatar'] )): ?>images/no_avatar.png<?php else: ?>upload/avatars/<?php echo $this->_tpl_vars['infos']['avatar']; ?>
<?php endif; ?>" class="avatar " alt="Avatar de <?php echo $this->_tpl_vars['com']['pseudo']; ?>
" style="border:1px solid #AAA;"/>
						</div>
                    </li>
                    <li><span>R&eacute;seau social :</span> <?php if (! empty ( $this->_tpl_vars['infos']['facebook'] )): ?><a href="<?php echo $this->_tpl_vars['infos']['facebook']; ?>
" rel="blank" title="Visiter la page 'reseau social' de <?php echo $this->_tpl_vars['infos']['pseudo']; ?>
"><img src="images/link.png" alt="lien facebook" class="vmiddle"/></a><?php endif; ?></li>
                    <li><span>Adresse MSN :</span></li><li class="b"><?php echo $this->_tpl_vars['infos']['msn']; ?>
</li>
                    <li><span>Adresse Skype :</span></li><li class="b"><?php echo $this->_tpl_vars['infos']['skype']; ?>
</li>
                </ul>
                        
            	<h3>Infos g&eacute;n&eacute;rales <img src="images/cursor.png" class="fiche_curseur" alt="Click"/></h3>
                <ul>
                    <li><span>Pr&eacute;nom :</span> <?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['prenom'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</li>
                    <li><span>Date de naissance :</span> <?php echo $this->_tpl_vars['infos']['date_naiss']; ?>
</li>
                    <li><span>Lieu :</span> <?php echo $this->_tpl_vars['infos']['ville']; ?>
</li>
                    <li><span>Job :</span> <?php echo $this->_tpl_vars['infos']['metier']; ?>
</li>
                </ul>
                
                
                <h3 >3615 MyLife <img src="images/cursor.png" class="fiche_curseur" alt="Click"/></h3>
                <ul>
                    <li class="txt"><?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['signature'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</li>
                 </ul>
                 
                <h3 class="bottom">@ctivité <img src="images/cursor.png" class="fiche_curseur" alt="Click"/></h3>
               	<ul>
                    <li><span>Nb Commentaires :</span> <?php echo $this->_tpl_vars['nb_com']; ?>
</li>
                    <li><span>Nb Billets :</span> <?php echo $this->_tpl_vars['nb_billets']; ?>
</li>
                    <li><span>Activité sur le blog :</span> <?php echo $this->_tpl_vars['activite']; ?>
%</li>
                    <li><span>Dernière connexion :</span></li><li class="b"><?php echo ((is_array($_tmp=$this->_tpl_vars['infos']['last_activity'])) ? $this->_run_mod_handler('date_format_pretty', true, $_tmp, true) : smarty_modifier_date_format_pretty($_tmp, true)); ?>
</li>
                 </ul>
                 
            </div>
        
        </td>
       	<td style="width:60%">
        	
            <div id="contenu_infos2">
            	<h3 class="top">Mes derniers commentaires</h3>
                
                <ul class="last_coms">
                <?php $_from = $this->_tpl_vars['coms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['com']):
?>
                	<li><h4><a href="billet-<?php echo $this->_tpl_vars['com']['id_billet']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['com']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" class="naviguer_billet_detail" rel="<?php echo $this->_tpl_vars['com']['id_billet']; ?>
" title="Afficher en détail le billet : <?php echo $this->_tpl_vars['com']['titre']; ?>
 ainsi que les reactions des membres"><?php echo $this->_tpl_vars['com']['titre']; ?>
</a></h4>
                    	<div><?php echo ((is_array($_tmp=$this->_tpl_vars['com']['message'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
                    </li>
                <?php endforeach; else: ?>
                	<li><i>Aucun commentaire</i></li>
                <?php endif; unset($_from); ?>
                </ul>
                
            </div>
        
        
        </td>
     </tr>
</table>