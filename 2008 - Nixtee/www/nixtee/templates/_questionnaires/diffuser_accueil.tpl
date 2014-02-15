<div class="titre">
	<div class="g"></div>
	<h2>CHOIX DU QUESTIONNAIRE A DIFFUSER</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Mes questionnaires prêts à l'envoie</h1>
	
	<p style="font-size:14px">Quel questionnaire désirez-vous diffuser à vos amis ?</p>
	
	<ul class="liste_quest">
	{foreach from=$liste item=quest}
		<li><h4><img src="images/puce1.gif" alt="." class="vmiddle"/>&nbsp; {$quest.nom} <span>Soumissions : <strong>{$quest.nb_soumis}</strong> - Avis : <strong>{$quest.nb_rep}</strong></span></span> </h4>
			
			<div class="bouton remontee" ><a href="diffuser-choix-{$quest.id_form_membre}.htm" title="#">Diffuser ce questionnaire</a></div><br />
			<div>{$quest.description}</div>
			
		</li>	
	{/foreach}
	<br />
</div>