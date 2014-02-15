<div class="infos">

	<h3>{$site.titre} <i>({$site.annee})</i></h3>
	
	
	<p><span>&ldquo;</span>   
	    {$site.desc}
		<span>&rdquo;</span>
	</p>

	<ul>
		<li><strong>Technologies</strong> : {$site.techno}</li>
		<li><strong>Durée de réalisation</strong> : {$site.duree}</li>
		<li><strong>Client</strong> : {$site.client}</li>
		<li class="lien"><strong>Lien</strong> : <a href="{$site.href}" title="Ouvrir '{$site.titre}'|{$site.title}">{$site.lien}</a></li>
	</ul>
</div>

<div class="min">
	{if $site.prefix=="na"} 
		{assign var='ext' value='jpg'}
	{else}
		{assign var='ext' value='png'}
	{/if}
	
	<ul>
		<li><a href="images/realisations/_{$site.prefix}/1.{$ext}" title="Voir une capture du site" rel="prettyOverlay[{$site.prefix}]"><img src="images/realisations/_{$site.prefix}/_1.{$ext}" /></a></li>
		<li><a href="images/realisations/_{$site.prefix}/2.{$ext}" title="Voir une capture du site" rel="prettyOverlay[{$site.prefix}]"><img src="images/realisations/_{$site.prefix}/_2.{$ext}" /></a></li>
		<li><a href="images/realisations/_{$site.prefix}/3.{$ext}" title="Voir une capture du site" rel="prettyOverlay[{$site.prefix}]"><img src="images/realisations/_{$site.prefix}/_3.{$ext}" /></a></li>			
	</ul>
</div>
