{if !$est_connecte}
	<h4>connexion</h4>
	<form action="#" method="post" onsubmit="bloc_connexion_top(); return false">
    	<label for="con1_login">Nom d'utilisateur</label><input type="text" name="con1_login" id="con1_login" value="" /><br />
		<label for="con1_pass">Mot de passe</label><input type="password" name="con1_pass" id="con1_pass" value="" /><br />
        <input type="submit" value="" class="submit"/>
        
    </form>
 {else}
 	<h4>Bienvenu {$infos_mbre.pseudo}</h4>
 	<ul>
 		<li>Questionnaires : <strong>9</strong></li>
 		<li>Avis reçus : <strong>92</strong></li>
 		<li>Note : <strong>9.32/10</strong></li>
		<li style="text-align:right; font-weight:bold"><a href="deconnexion.htm" title="Me déconnecter">Déconnexion</a></li>
	</ul>
	
{/if}