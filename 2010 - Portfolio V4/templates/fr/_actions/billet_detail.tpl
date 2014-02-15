	<div class="billets">

    <div class="date">
    	<h5>{$billet.date|date_format:"%e"}</h5> 
        <h6>{$billet.date|date_format:"%b"}</h6>
    </div> 
    
  	<h2><a href="billet-{$billet.id_billet}-{$billet.titre|recode}.htm" class="naviguer_billet_detail" rel="{$billet.id_billet}" title="Afficher en d&eacute;tail le billet : {$billet.titre|escape} ainsi que les r&eacute;actions des membres">
    		{$billet.titre|escape}
         </a>
    </h2>
    <br class="clear" />
    
    <div class="infos">
    	<span class="heure">{$billet.date|date_format:"%H:%M"}</span>  
        <span class="cat"><a href="categorie-{$billet.id_cat}-{$billet.cat_url|recode}.htm" class="naviguer_categorie" rel="{$billet.id_cat}">{$billet.cat}</a></span> 
        <span class="auteur"><a href="membre-{$billet.id_auteur}-{$billet.pseudo|recode}.htm" title="Afficher le profil du membre {$billet.pseudo}" class="naviguer_membre" rel="{$billet.id_auteur}">{$billet.pseudo}</a></span>
    	<span class="points" id="span_pts_{$billet.id_billet}">{$billet.points} <a href="javascript:void()" class="ajouter_point" rel="{$billet.id_billet}">+1</a></span>
    </div>
	
    <div class="coms">
        <a href="billet-{$billet.id_billet}-{$billet.titre|recode}.htm" class="naviguer_billet_detail" rel="{$billet.id_billet}" title="Afficher les commentaires du billet {$billet.titre|escape}" >{$billet.nb_com} commentaire{if $billet.nb_com>1}s{/if}</a>
    </div>
    <br class="clear" />
    
    <div class="message">
    	{$billet.contenu}
        
        <div class="tags">
            {foreach item=tag from=$billet.tags}
                <a href="billets-tag-{$tag|recode|lower}.htm" class="naviguer_tag" rel="{$tag|recode|lower}" title="Afficher les articles en rapport avec le tag {$tag}"><strong>{$tag}</strong></a> 
            {/foreach}
        </div>
        <div class="trackball">
        	<a href="{$baseUrl}billet-{$billet.id_billet}-{$billet.titre|recode}.htm">{$baseUrl}billet-{$billet.id_billet}-{$billet.titre|recode}.htm</a>
        </div>
    </div>
    
</div>


{if $billet.com_statut!="ferme"}
	{if $billet.nb_com==0}
		<div style="text-align:center; margin-bottom:15px"><a href="#poster_commentaire" class="lien_poster_commentaire">Soyez le premier &agrave; poster un commentaire</a></div>
	{/if}
	
	{include file="commentaires.tpl"}
{/if}
  
<div id="poster_commentaire">

	<!--{if ($billet.com_statut=="membres_only" AND $est_connecte) OR $billet.com_statut=="ouvert"}		
		{include file="poster_commentaire.tpl"}
	{elseif $billet.com_statut=="membres_only"}
		<div class="message_erreur">
			Seuls les membres connect&eacute;s peuvent poster des commentaires sur ce sujet.
		</div>
	{else}
		<div class="message_erreur">
			Les commentaires ont &eacute;t&eacute; d&eacute;sactiv&eacute;s sur ce billet.
		</div>
	{/if}-->
	{include file="poster_commentaire.tpl"}
</div>