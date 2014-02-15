{include file="messagerie_header.tpl"}

<div id="messagerie">

    <div class="titreMessagerie">{$titre}</div>
    <div class="centre">{$info}</div>
    
    <table class="liste_mess" cellpadding=0 cellspacing=0>
        <tr>
            <td class="top" width="28"></td>
            <td class="top" style="text-align:left;" width="200">{$champs.1}</td>
            <td class="top" width="75" style="text-align:center">{$champs.2}</td>
            <td class="top" width="75" style="text-align:center">{$champs.3}</td>
            <td class="top" width="30"></td>
        </tr>
        
        {foreach item=mess from=$messages}
            <tr id="tr{$mess.id}">
                <td><img src="images/messagerie/{$mess.etat}.png"></td>
                <td style="text-align:left"><a href="messagerie-lire{$type}-{$mess.id}.htm" class="naviguer_messagerie" rel="lire{$type}-{$mess.id}">{$mess.sujet|escape}</a></td>
                <td><a href="membre-{$mess.id_membre}-{$mess.pseudo}.htm" class="naviguer_membre" rel="{$mess.id_membre}">{$mess.pseudo|capitalize}</a></td>
                <td><span style="font-size:10px; color:#AAA">{$mess.date|date_format:"%d/%m/%y"}</span></td>
                <td><a href="messagerie-supprimer-{$mess.id}.htm" class="naviguer_messagerie" rel="supprimer-{$mess.id}" ><img src="images/messagerie/email_delete.png"></a></td>
            </tr>
        {foreachelse}
			<tr>
            	<td colspan="5" style="text-align:center">Vous n'avez aucun message !</td>
            </tr>
        {/foreach}
                    
    </table>
    
    <div class="infos_bas">
        <img src="images/messagerie/nouveau.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
        <img src="images/messagerie/lu.png" style="vertical-align:middle"> D&eacute;j&agrave; lu &nbsp;&nbsp;
        <img src="images/messagerie/important.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
        <img src="images/messagerie/auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
    </div>
        
</div>