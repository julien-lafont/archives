
<br /><h1 class="style">Mot de passe perdu ?</h1>

<div class="message_erreur" style="width:520px; margin-top:30px">
	{if $type_erreur=="email"}
    	<p>D&eacute;sol&eacute;, mais aucun compte n'est enregistr&eacute; avec cette adresse email !</p><br />
    	<p><a href="mot_passe_perdu.htm" class="naviguer_pass_perdu lien" title="Changer de mot de passe">Nouvelle tentative</a></p>
    {elseif $type_erreur=="cle"}
    	<p>La cl&eacute; indiqu&eacute;e ne correspond pas &agrave; la cl&eacute; de v&eacute;rification de ce membre.</p>
    {/if}
</div>
