<?php /* Smarty version 2.6.18, created on 2008-02-04 13:31:10
         compiled from poster_commentaire.tpl */ ?>
<form class="style" action="#" method="post" onsubmit="verifier_form_com(); return false">
    <fieldset>
    	<h3>Poster un commentaire</h3>
        
        <div class="erreur" id="erreur_com">
        	<strong>Une erreur est survenue durant l'envoie du formulaire</strong><br />
        	Merci de vérifier que le formulaire soit correctement remplis.<br />
            Si le problème persiste, n'hésitez pas à nous contacter.
            <div id="erreur_detail"></div>
        </div>

    <?php if (! $this->_tpl_vars['est_log']): ?>
		<fieldset id="info_user">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" tabindex="1" onblur="verif_pseudo('pseudo');" /> <span id="statut_pseudo"></span><br /><br />
    
            <div id="pass_hide">
                <label for="pass">Mot de passe</label>
                <input type="password" id="pass" name="pass" onblur="verif_pass_com('pseudo', 'pass');" /> <span id="statut_pass"></span><br /><br />
            </div>
            
            <label for="email">Email</label>
            <input type="text" id="email" name="email" tabindex="2" onblur="verif_email('email');"/> <span id="statut_email"></span><br /><br />
            
            <label for="site">Site Internet</label>
            <input type="text" id="site" name="site" tabindex="3" onblur="verif_site('site');"/><br /><br />
        </fieldset>
    <?php else: ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "poster_commentaire_login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
        
        <fieldset>
            <label for="message">Message</label>
            <textarea id="message" name="message" tabindex="4" cols="20" rows="10" onblur="verif_message('message');" ></textarea><br /><br />
            
            <label for="captcha">Code anti-spam</label>
            <input type="text" id="captcha" name="captcha" tabindex="5" style="text-transform:uppercase"/> <img src="classes/img_captcha.php" id="img_captcha" alt="Code de s&eacute;curit&eacute;"/> <a href="#" title="Changer d'image Captcha" class="refresh_captcha"><img src="images/arrow_refresh_small.png" alt="Refresh" /></a><br /><br /><br />
       		
            <label for="submit_com">&nbsp;</label> <input type="image" src="templates/images/submit.png" class="image" id="submit_com"/>  
            <input type="hidden" name="id_billet" id="id_billet" value="<?php echo $this->_tpl_vars['billet']['id_billet']; ?>
" />              

        </fieldset>
        
    </fieldset>
</form>