<h2>Mettre &agrave; jour mon avatar :</h2><br />

<table width="100%" border="0">
  <tr>
    <td style="width:100px"><strong><u>Avatar actuel</u></strong></td>
    <td><strong><u>Mise &agrave; jour</u></strong></td>
  </tr>
  <tr>
    <td style="vertical-align:top"><br /><img src="{if empty($infos.avatar)}images/no_avatar.png{else}upload/avatars/{$infos.avatar}{/if}" class="avatar " alt="Avatar de {$com.pseudo}" style="border:1px solid #AAA; "/><br /><br />
    <a href="mon-compte-supprimer_avatar.htm" class="lien" title="Supprimer cet avatar">Supprimer</a></td>
    <td><form action="mon-compte-maj_avatar.htm" method="post" enctype="multipart/form-data" class="style" style="margin-left:0">
    		<input type="file" name="fichier" id="fichier" /><br />
            <input type="image" src="templates/images/submit.png" tabindex="12" class="image" id="submit_com"/>  
    	</form><br />
        
        <div style="font-size:10px"><u>Conseils</u> :<br  />
        - Image carr&eacute;e. Taille id&eacute;ale : <span style="color:#FF9900;font-size:10px">45*45</span><br />
        - Formats autoris&eacute;s : <span style="color:#FF9900;font-size:10px">jpg, png, gif</span><br />
        - Taille max : <span style="color:#FF9900;font-size:10px">50 ko</span></div></td>
  </tr>
</table>

