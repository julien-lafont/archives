<?php /* Smarty version 2.6.18, created on 2008-12-27 02:05:54
         compiled from fr/_actions/contact.tpl */ ?>
﻿<br /><br />



<div class="contact_l">
	<div class="center"><img src="images/T_MeContacter.png" alt="" /></div><br /><br />
	
	<img src="images/moi_min1.jpg" alt="" width="95" height="123" class="img_left" />
	<img src="images/user.png" alt="Moi:"/> <strong>Julien LAFONT</strong><br /><br />
	29 rue Jean Froissart,<br />
	Bat F Appt 8023<br />
	34090, Montpellier<br />
	France<br /><br /><br />
	
	<p style="line-height:25px">
		<img src="images/phone.png" alt="Tel:"/> 06 76 <i>Zéro Un</i> 58 12<br />
		<img src="images/email.png" alt="@:"/> <i>freelance (at) studio-dev (dot) fr</i><br />
		<img src="images/skype.png" alt="Skype:" /> <i>studio-dev</i><br />
		<img src="images/world.png" alt="Site:"/> <a href="http://www.studio-dev.fr" title="Studio-dev : Réalisations de sites web 2.0">Studio-Dev.fr</a><br />

	</p>
	
</div>

<div class="contact_d">
	<div class="center" id="web"><img src="images/T_FormContact.png" alt="" /></div><br />

	<form class="style" action="#" onsubmit="this.action='me-contacter.htm'" method="post" style="margin-left:30px">
	
		<p style="margin-left:30px"><span>Utilisez ce formulaire pour toutes demandes, questions, etc ...</span></p>
		<fieldset>
		
		    <label for="contact_email">Email</label>
		   	<input type="text" id="contact_email" name="contact_email" tabindex="1" /><br /><br />
		
		    <label for="contact_sujet">Sujet</label>
		    <input type="text" id="contact_sujet" name="contact_sujet" tabindex="2" /><br /><br />
		    
		    <label for="contact_message">Message</label>
		    <textarea id="contact_message" name="contact_message" tabindex="3" cols="20" rows="10"></textarea><br /><br /><br />
		    
		    <label for="contact_captcha">Code anti-spam</label>
		    <input type="text" id="contact_captcha" name="contact_captcha" tabindex="4" style="text-transform:uppercase; width:50px" maxlength="5"/> <img src="classes/img_captcha.php" id="img_captcha" alt="Code de s&eacute;curit&eacute;"/> <a href="#" title="Changer d'image Captcha" class="refresh_captcha"><img src="images/arrow_refresh_small.png" alt="Refresh" /></a><br /><br />
		
		    <label for="submit_com">&nbsp;</label> <input type="submit" class="submit" id="submit_com" tabindex="5" />  
		</fieldset>
	</form>
</div>


    	