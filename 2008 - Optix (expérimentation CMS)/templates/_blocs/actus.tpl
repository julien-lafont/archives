<h5>Dernières actualités</h5>
<ul>
	{foreach from=$actus item=actu}
    	<li><a href="actualite-{$actu.id_news}-{$actu.titre|recode}.htm" title="Lire la news : {$actu.titre}"><img src="templates/images/puce1.gif" alt="Puce" /> &nbsp;{$actu.titre}</a></li>
    {foreachelse}
    	<li><a href="#" title="">Aucune actualité</a></li>
    {/foreach}
</ul>