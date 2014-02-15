<form class="style field" action="mon-compte-maj.htm" method="post" >

	{if $modif_ok}<div class="good">
    	{$modif_ok}
    </div>{/if}
    
	<fieldset><legend>Mon compte</legend><br />
    
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" value="{$infos.pseudo}" disabled="disabled" style="font-style:italic"/><br /><br />
    
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="{$infos.email}" tabindex="1" /><br /><br />
    
        <label for="pseudo">Mot de passe</label>
         <a href="javascript:void(0)" onclick="afficher_changer_pass();"  class="lien">&raquo; Modifier mon mot de passe</a><br /><br />

        <label for="pseudo">Avatar</label>
         <a href="javascript:void(0)" onclick="afficher_changer_avatar();" class="lien">&raquo; Modifier mon avatar</a> &nbsp;&nbsp;&nbsp; <img src="{if empty($infos.avatar)}images/no_avatar.png{else}upload/avatars/{$infos.avatar}{/if}" class="avatar " alt="Avatar de {$com.pseudo}" style="border:1px solid #AAA; vertical-align:top"/><br /><br />
        
         
    </fieldset>
    
	<fieldset><legend>Communaut&eacute;</legend><br />
    
        <label for="site">Site internet</label>
        <input type="text" id="site" name="site" value="{$infos.site}" tabindex="2" /><br /><br />
    
        <label for="msn">Adresse MSN</label>
        <input type="text" id="msn" name="msn" value="{$infos.msn}" tabindex="3" /><br /><br />

        <label for="skype">Adresse Skype</label>
        <input type="text" id="skype" name="skype" value="{$infos.skype}" tabindex="4" /><br /><br />

        <label for="skype">Fiche réseau social</label>
        <input type="text" id="facebook" name="facebook" value="{$infos.facebook}" tabindex="5" /><br /><br />
        
    </fieldset>
    
    <fieldset><legend>Informations persos</legend><br />
        <label for="prenom">Pr&eacute;nom</label>
        <input type="text" id="prenom" name="prenom" value="{$infos.prenom}" tabindex="6" /><br /><br />

        <label for="date_naiss">Date de naissance</label>
        <input type="text" id="date_naiss" name="date_naiss" value="{$infos.date_naiss}" tabindex="7" /><br /><br />
    
        <label for="metier">M&eacute;tier</label>
        <input type="text" id="metier" name="metier" value="{$infos.metier}" tabindex="8" /><br /><br />
    
        <label for="ville">Ville</label>
        <input type="text" id="ville" name="ville" value="{$infos.ville}" tabindex="9" /><br /><br />
    </fieldset>
    
    <fieldset><legend>My life</legend><br />
        <label for="signature">Petit message</label>
        <textarea id="signature" name="signature" tabindex="10" cols="20" rows="10">{$infos.signature}</textarea><br /><br />
    </fieldset>
    
    <label for="submit_com"></label> 
    <input type="image" src="templates/images/submit.png" tabindex="11" class="image" id="submit_com"/>  
    <!--<input type="submit" value="Envoyer" style="display:none" />-->
    
</form>
