<?php /* Smarty version 2.6.18, created on 2008-11-07 13:30:52
         compiled from _blocs/login.tpl */ ?>
<?php if (! $this->_tpl_vars['est_connecte']): ?>
<form method="post" action="connexion.php" onsubmit="procedure_connexion(); return false;">
    <fieldset>
    	<span>Connexion à l'intranet</span> &raquo; &nbsp;
        <input type="text" name="pseudo" id="con1_pseudo" value="Pseudo" onfocus="if (this.value=='Pseudo') this.value='';"/> 
        <input type="password" name="pass" id="con1_pass" value="*****" onfocus="if (this.value=='*****') this.value='';"/> 
        <input type="submit" value="Ok" />
    </fieldset>
</form>

<?php else: ?>
	 <div class="center" style="padding-top:10px">
        	Bonjour <strong><?php echo $this->_tpl_vars['infos_mbre']['pseudo']; ?>
</strong> /
			<a href="admin.php" title="Accéder à l'adminsitration">Administration</a> / 
			<a href="deconnexion.htm" title="Me déconnecter">Déconnexion</a>
	</div>
<?php endif; ?>