{* Si le membre n'est pas connecté, on affiche le formulaire de connexion *}
{if !$est_connecte}
<form method="post" action="connexion.php" onsubmit="procedure_connexion(); return false;">
    <fieldset>
    	<span>Connexion à l'intranet</span> &raquo; &nbsp;
        <input type="text" name="pseudo" id="con1_pseudo" value="Pseudo" onfocus="if (this.value=='Pseudo') this.value='';"/> 
        <input type="password" name="pass" id="con1_pass" value="*****" onfocus="if (this.value=='*****') this.value='';"/> 
        <input type="submit" value="Ok" />
    </fieldset>
</form>

{* Si le membre est connecté, on affiche les actions à sa disposition *}
{else}
	 <div class="center" style="padding-top:10px">
        	Bonjour <strong>{$infos_mbre.pseudo}</strong> /
			<a href="admin.php" title="Accéder à l'adminsitration">Administration</a> / 
			<a href="deconnexion.htm" title="Me déconnecter">Déconnexion</a>
	</div>
{/if}