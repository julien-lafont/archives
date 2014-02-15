<div class="titre">
	<div class="g"></div>
	<h2>LES QUESTIONNAIRES TYPES A PERSONNALISER</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Etape 1/3 : Choix le questionnaire type</h1>
	
	<p>Choisissez dans la liste ci-dessous le questionnaires que vous trouvez le plus proche de vos envies.<br />
	Vous pourrez dans l'étape suivante le personnaliser si vous le désirer.</p>
	
	<div class="info">
		<div class="img"></div>
		<p>Dans quelques jours, vous aurez la possibilité de créer vos questionnaires de A à Z !</p>
		<!--TODO:Bulle sous IE6/EI7 ? -->
	</div>
	
	
	<ul class="liste_form">
	{foreach item=form from=$apercus}
		<li><h2>{$form.nom}</h2>
		    <p>{$form.description}</p>

			<div class="apercu" id="apercu_{$form.id_form_type}">
				{$form.html}
			</div>
			
		    <div class="bouton" style="margin-left:400px"><a href="#" title="Apercu du questionnaire" class="ouvrir_apercu" rel="{$form.id_form_type}">Aperçu des questions</a></div>
		    <div class="bouton"><a href="questionnaire-choix-{$form.id_form_type}.htm" title="">Choisir ce questionnaire</a></div>
		    <br class="clear" />
		    
		</li>
	{/foreach}
	</ul>
	<br /><br />
</div>