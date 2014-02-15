{if $nb_pages>1}
<div class="pagination"><p>
	{foreach item=page from=$pagination}
    
    	{if $page[2]===true}
        	<span><strong>{$page[0]}</strong></span>
        {elseif $page[2]=="espace"}
        	&nbsp;&nbsp;
        {else}
        	
            	
        	<strong><a href="billet-{$billet.id_billet}{if $page[1]!=1}-{$page[1]}{/if}-{$billet.titre|recode}.htm" rel="{$billet.id_billet}-{$page[1]}" class="naviguer_billet_detail" title="Afficher en détail le billet : {$billet.titre|escape} page {$page[1]}">{$page[0]}</a></strong>
        {/if}
    
    {/foreach}</p>
    <h4>Page {$page_courante}/{$nb_pages}</h4>
</div>
{/if}