{include file="messagerie_header.tpl"}

<div id="messagerie">

	<div class="titreMessagerie">Lire un message</div>
	
		<table class="table_ecrire">
			<tr>
				<td style="width:150px; text-align:center" id="first"><a href="membre-{$mess.id_membre}-{$mess.pseudo}.htm" class="naviguer_membre" rel="{$mess.id_membre}">{$mess.pseudo|capitalize}</a></td>
				<td style="height:15px;font-family:verdana; font-size:11px; color:#FFF; border-bottom:1px dotted #666; padding-bottom:2px"> &nbsp; <img src="images/boutons/email_open.png" /> &nbsp; {$mess.sujet|escape}</td>
			</tr>
			
			<tr>
				<td style="vertical-align:top; padding-top:11px; text-align:center"><img src="{if empty($mess.avatar)}images/no_avatar.png{else}upload/avatars/{$mess.avatar}{/if}" class="avatar" alt="Avatar de {$mess.pseudo}"/></td>
				<td style="vertical-align:top; padding-top:11px" class="message">{$mess.message|escape|nl2br}</td>
			</tr>
			<tr>
				<td></td>
				<td style="color:#AAA; text-align:right; height:15px; vertical-align:bottom; font-size:10px">{$mess.date|date_format_pretty}</td>
			</tr>
            {if $type=="Inbox"}
            <tr>
            	<td colspan="2">
                	<a href="messagerie-supprimer-{$mess.id}.htm" class="naviguer_messagerie" rel="supprimer-{$mess.id}" title="Supprimer le message" ><img src="images/messagerie/email_delete.png" style="vertical-align:middle"> Supprimer</a> &nbsp; &nbsp; &nbsp;
					<a href="messagerie-ecrire-{$mess.id}.htm" class="naviguer_messagerie" rel="ecrire-{$mess.id}"title="Répondre à ce message"><img src="images/messagerie/auto.png" style="vertical-align:middle"> R&eacute;pondre</a>
				</td>
           </tr>
           {/if}
		</table>
		
		<div style="margin-top:7px;">
		</div>
		
</div>