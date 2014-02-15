{foreach from=$menu item=cat}
<h4><a href="#" title="" style="cursor:default">{$cat.nom}</a></h4>
<ul>
	{foreach from=$cat.contenu item=page}
	<li><a href="article-{$cat.url}-{$page.url}.htm" title="Accéder à l'article {$page.titre} de la catégorie {$cat.nom}"><strong>{$page.titre}</strong></a></li>
	{/foreach}
</ul>
{/foreach}