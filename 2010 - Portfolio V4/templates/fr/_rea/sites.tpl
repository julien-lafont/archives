<div id="siteweb" class="min_rea">

	<div class="center" id="web"><img src="images/T_devWeb.png" alt="" /></div>
		
	<div class="detail"></div>

	<ul class="gen">
		{foreach from=$liste.sites item=rea}
			<li><a href="#" class="info_rea" rel="{$rea.prefix}" title ="{$rea.titre} ({$rea.annee})|{$rea.bulle_desc}" ><img src="images/realisations/min_sites/{$rea.min_rea}" alt="{$rea.titre}" /></a></li>
		{/foreach}
	</ul>
	
	<br class="clear" />
	<div class="help"><img src="images/help_moyen.png" alt="? " /> Cliquez sur une miniature pour avoir plus de détail</div>
	

</div>

<div class="retour_site"><a href="#" title="Développements webs|Retourner à la liste de mes réalisations">Retour à la liste</a></div>
	
