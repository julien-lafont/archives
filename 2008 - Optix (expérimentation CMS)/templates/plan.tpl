<h1>Plan du site Optix</h1>

<h2>Général</h2>
<ul class="plan">
	<li>
		&rsaquo; <a href="accueil.htm" title="Retour à la apge d'accueil">Page d'accueil</a>
	</li>
	<li>
		&rsaquo; <a href="contact.htm" title="Contacter l'entreprise">Contact</a>
	</li>
	<li>
		&rsaquo; <a href="#" title="Flux RSS d'actualité">Flux RSS</a>
	</li>
</ul>


<h2>Articles</h2>
{foreach from=$menu item=cat}
	<h3 style="margin-bottom:7px">{$cat.nom}</h3>
	<ul class="plan" style="margin-left:70px">
		{foreach from=$cat.contenu item=page}
		<li>&rsaquo; <a href="article-{$cat.url}-{$page.url}.htm" title="Accéder à l'article {$page.titre} de la catégorie {$cat.nom}">{$page.titre}</a></li>
		{/foreach}
	</ul>
{/foreach}


<h2>Actualités</h2>
<ul class="plan">
{foreach from=$actus item=actu}
	<li>&rsaquo; <a href="actualite-{$actu.id_news}-{$actu.titre|recode}.htm" title="Lire la news : {$actu.titre}">{$actu.titre}</a></li>
{/foreach}
</ul>