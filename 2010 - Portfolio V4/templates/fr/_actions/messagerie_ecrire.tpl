{include file="messagerie_header.tpl"}

<div id="messagerie">

    <form action="#" method="post" class="style" style="margin-left:30px">
                
        <div class="titreMessagerie">R&eacute;diger un nouveau message</div>

        <label for="dest_id">Destinataire</label>
        {$destinataire}<br /><br />
   
        <label for="sujet">Sujet</label>
        <input type="text" name="sujet" id="sujet" maxlength="255"  tabindex="2" value="{$sujet}"><br /><br />
            
        <label for="mess">Message</label>
        <textarea id="mess" name="mess" tabindex="3" cols="20" rows="10"></textarea><br /><br />

		<label for="submit_com">&nbsp;</label> 
        <input type="image" src="templates/images/submit.png" class="image" id="submit_com" onclick="this.blur(); messagerie_envoyer(); return false"/>  <br /><br />

    </form>

</div>