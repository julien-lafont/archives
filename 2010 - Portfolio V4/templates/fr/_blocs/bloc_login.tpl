{if !$est_connecte }
    <form name="connexion" class="connexion" action="#" method="post" onsubmit="bloc_connexion_top(); return false;">
        <input type="text" value="Nom d'utilisateur" onfocus="this.value=''" id="bloc_top_login" />  
        <input type="password" value="******" onfocus="this.value=''" id="bloc_top_pass" /><br />
        <input type="submit" class="submit" value="Connexion" /><noscript><span style="font-size:10px">Javascript n&eacute;cessaire</span></noscript>
    </form>
    <div><a href="inscription.htm" class="naviguer_inscription" rel="formulaire"><strong>Inscription</strong></a><br />
         <a href="mot_pass_perdu.htm" class="naviguer_pass_perdu" rel="formulaire">Mot de passe ?</a>
    </div>
{else}
    <div style="background-color:#131313; border:1px solid #000; padding:5px; color:#FFF">
    <strong>Espace membre</strong><br /><br />
    <img src="templates/images/user.png" alt="MC" /> &nbsp;<a href="mon-compte.htm" class="naviguer_moncompte">Mon compte</a><br />
    <img src="templates/images/logout.png" alt="MC" /> &nbsp;<a href="deconnexion.htm" title="Déconnexion" class="naviguer_deco">Deconnexion</a><br />
    
	{if est_admin}<img src="templates/images/admin_icone.png" alt="MC" /> &nbsp;<a href="admin.php">Admin</a><br />{/if}
    </div>
 {/if}