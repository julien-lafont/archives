<?php /* Smarty version 2.6.18, created on 2008-04-09 23:17:52
         compiled from bloc_login2.tpl */ ?>
<?php if (! $this->_tpl_vars['est_connecte']): ?>
	<h4>connexion</h4>
	<form action="#" method="post" onsubmit="bloc_connexion_top(); return false">
    	<label for="con1_login">Nom d'utilisateur</label><input type="text" name="con1_login" id="con1_login" value="" /><br />
		<label for="con1_pass">Mot de passe</label><input type="password" name="con1_pass" id="con1_pass" value="" /><br />
        <input type="submit" value="" class="submit"/>
        
    </form>
 <?php else: ?>
 	<h4>éè !</h4>
 	
<?php endif; ?>