<?php /* Smarty version 2.6.18, created on 2008-04-14 12:49:39
         compiled from contact.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>CONTACTER LE STAFF NIXTEE.COM</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<div class="ok">Utilisez ce formulaire pour toutes demandes, questions, etc ...</div><br />

	<form class="style" action="contact.htm" method="post" onsubmit="procedure_contact(); return false" style="margin-left:15px">
	<fieldset>
	    <label for="contact_email">Email</label>
	   	 <input type="text" id="contact_email" name="contact_email" tabindex="1" style="width:250px" /><br /><br />
	
	    <label for="contact_sujet">Sujet</label>
	    <input type="text" id="contact_sujet" name="contact_sujet" tabindex="2" style="width:250px" /><br /><br />
	    
	    <label for="contact_message">Message</label>
	    <textarea id="contact_message" class="contact_message" tabindex="3" cols="20" rows="10" style="width:350px" ></textarea><br /><br />
	    
	    <label for="contact_captcha">Code anti-spam</label>
	    <input type="text" id="contact_captcha" name="contact_captcha" tabindex="4" style="text-transform:uppercase; width:60px "/> &nbsp; &nbsp; <img src="classes/img_captcha.php" id="img_captcha" alt="Code de sécurité"/> &nbsp; &nbsp; <a href="#" title="Changer d'image Captcha" class="refresh_captcha"><img src="images/arrow_refresh_small.png" alt="Refresh" /></a><br /><br />
	
	    <label for="submit_com">&nbsp;</label> <input type="submit" value="Envoyer" class="submit" tabindex="5" />  
	</fieldset>
</form>
	
</div>
<div class="b"></div>