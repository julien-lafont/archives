{foreach item=billet from=$billets}
<div class="billets">

    <div class="date">
    	<h5>{$billet.date|date_format:"%e"}</h5> 
        <h6>{$billet.date|date_format:"%b"}</h6>
    </div> 
    
  	<h2><a href="billet-{$billet.id_billet}-{$billet.titre|recode}.htm" class="naviguer_billet_detail" rel="{$billet.id_billet}" title="Afficher en détail le billet : {$billet.titre|escape} ainsi que les reactions des membres">
    		{$billet.titre|escape}
         </a>
    </h2>
    <br class="clear" />
    
    <div class="infos">
    	<span class="heure">{$billet.date|date_format:"%H:%M"}</span>  
        <span class="cat"><a href="categorie-{$billet.id_cat}-{$billet.cat|recode}.htm" class="naviguer_categorie" rel="{$billet.id_cat}">{$billet.cat}</a></span> 
        <span class="auteur"><a href="membre-{$billet.id_auteur}-{$billet.pseudo|recode}.htm" title="Afficher le profil du membre {$billet.pseudo}" class="naviguer_membre" rel="{$billet.id_auteur}">{$billet.pseudo|capitalize}</a></span>
    	<span class="points" id="span_pts_{$billet.id_billet}">{$billet.points} <a href="javascript:void(0)" class="ajouter_point" rel="{$billet.id_billet}">+1</a></span>
    </div>
	
    <div class="coms">
        <a href="billet-{$billet.id_billet}-{$billet.titre|recode}.htm" class="naviguer_billet_detail" rel="{$billet.id_billet}" title="Afficher les commentaires du billet {$billet.titre|escape}">{$billet.nb_com} commentaire{if $billet.nb_com>1}s{/if}</a>
    </div>
    <br class="clear" />
    
    <div class="message">
    	{if empty($billet.resume)}
    		{$billet.contenu|truncate:150}
       {else}
       		{$billet.resume}
        {/if}
    </div>
    
    {if isset($billet.resume) AND  strlen($billet.contenu)>150 }
    <div class="lire_suite">
    	<a href="billet-{$billet.id_billet}-{$billet.titre|recode}.htm" class="naviguer_billet_detail" rel="{$billet.id_billet}" title="Afficher les commentaires du billet {$billet.titre|escape}">&nbsp;</a>
    </div>
    <br class="clear" />
    {/if}
    
</div>
{foreachelse}

	Rien !
	{include file="erreur.tpl"}
    
{/foreach}


{if isset($suivprec.prec.href) || isset($suivprec.suiv.href)}
<table class="page_suiv_prec">
	<tr>
    	<td class="prec">{if isset($suivprec.prec.href) }<img src="templates/images/pagination_fl_g.png" alt="Prec" /> <a href="{$suivprec.prec.href}" rel="{$suivprec.prec.rel}" title="{$suivprec.prec.title}" class="{$suivprec.prec.class}">Billets précédents</a>{/if}</td>
        <td class="suiv">{if isset($suivprec.suiv.href) }<a href="{$suivprec.suiv.href}" rel="{$suivprec.suiv.rel}" title="{$suivprec.suiv.title}" class="{$suivprec.suiv.class}">Billets suivants</a> <img src="templates/images/pagination_fl_d.png" alt="Suiv" />{/if}</td>
    </tr>
</table>
{/if}