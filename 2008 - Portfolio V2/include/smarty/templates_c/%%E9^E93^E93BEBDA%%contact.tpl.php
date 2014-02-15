<?php /* Smarty version 2.6.18, created on 2008-02-04 13:52:05
         compiled from contact.tpl */ ?>
<br /><br />

<h2 class="style">Contacter l'&eacute;quipe du blog</h2>

<div class="good">Utilisez ce formulaire pour toutes demandes, questions, etc ...</div><br />

<form class="style" action="contact.htm" method="post" onsubmit="procedure_contact(); return false" style="margin-left:15px">
<fieldset>
    <label for="contact_email">Email</label>
   	 <input type="text" id="contact_email" name="contact_email" tabindex="1" /><br /><br />

    <label for="contact_sujet">Sujet</label>
    <input type="text" id="contact_sujet" name="contact_sujet" tabindex="2" /><br /><br />
    
    <label for="contact_message">Message</label>
    <textarea id="contact_message" class="contact_message" tabindex="3" cols="20" rows="10"></textarea><br /><br /><br />
    
    <label for="contact_captcha">Code anti-spam</label>
    <input type="text" id="contact_captcha" name="contact_captcha" tabindex="4" style="text-transform:uppercase"/> <img src="classes/img_captcha.php" id="img_captcha" alt="Code de s&eacute;curit&eacute;"/> <a href="#" title="Changer d'image Captcha" class="refresh_captcha"><img src="images/arrow_refresh_small.png" alt="Refresh" /></a><br /><br />

    <label for="submit_com">&nbsp;</label> <input type="image" src="templates/images/submit.png" class="image" id="submit_com" tabindex="5" />  
</fieldset>
</form>
    	