<div id="design" class="min_rea">

	<div class="center"><img src="images/T_Infographie2.png" alt="" /></div>
		
	<div class="detail"></div>

	<ul class="gen">
		{foreach from=$liste.designs item=rea}
			<li><a href="images/design/{$rea.min_rea}" rel="prettyOverlay[$rea.prefix]" title="{$rea.titre}|{$rea.bulle_desc}" ><img src="images/design/_{$rea.min_rea}" alt="{$rea.titre}" /></a></li>
		{/foreach}
	</ul>
	
	<br class="clear" />
	<div class="help"><img src="images/help_moyen.png" alt="? " /> Cliquez sur une miniature pour l'afficher en plein écran.</div>
		

</div>