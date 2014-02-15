<?php
/**
 * Module Contact
 * Permet d'envoyer un message aux admins du site
 *
 * Url : /Contact/
 */

	$design->zone('titrePage', 'Contacter la team '.NOM.' : partenariats, propositions de matchs, bugs ...');
	$design->zone('titre', 'Formulaire de contact');
	metatag('Formulaire de contact');
	$design->zone('header', '<script type="text/javascript" src="javascript/-contact.js" ></script>');


switch(@$_GET['action'])
{

//:: Affiche le formulaire principal
default :
	
	// Formulaire de contact pour une personne connectée
	if (is_log())
	{
		$contenu = '
		<form id="contact" action="#" method="post" onsubmit="verifContactLog(); return false">
		
			<div class="titreMessagerie">Contactez la team '.NOM.'</div><br />

			<br /><fieldset id="form" style="margin-left:25px">
							
				<label for="_choix" style="font-weight:bold">» Pour quel raison souhaitez vous nous contacter</label><br /><br />
				<select name="choix" id="_choix" style="margin-left:25px !important; text-align:left; width:200px">
				  <option value="partenariat">Partenariat</option>
				  <option value="recrutement">Recrutement</option>
				  <option value="infos">Informations</option>
				  <option value="manager">Contact manager</option>
				  <option value="pbm">Probl&egrave;me technique sur le site</option>
				  <option value="autres">Autres</option>
				</select><br /><br /><br />
				
				<label for="_message" style="font-weight:bold">» Rédiger votre message</label><br /><br />
				<textarea id="_message" name="_message" class="size150" style="margin-left:25px !important; text-align:left;"></textarea><br /><br /><br />
				
				<input type="submit" class="submit" value="envoyer" style="margin-left:25px !important;"/><br /><br />
			</fieldset>
		</form>
		<div id="result" style="display:none"></div>';
	}
	else
	// Formulaire de contact pour une personne non-connectée
	{
	
		$contenu = '
		<form id="contact" action="#" method="post" onsubmit="verifContact(); return false">
		
			<div class="titreMessagerie">Contactez la team '.NOM.'</div><br />

			<fieldset id="form" style="margin-left:25px">
			
				<label for="_nom" style="font-weight:bold">» Inscrivez votre nom ou votre pseudo </label> <br /><br />
				<input type="text" name="nom" id="_nom" style="margin-left:25px !important; text-align:left;" /><br /><br />

				<label for="_email" style="font-weight:bold">» Indiquez votre adresse e-mail</label>  <br /><br />
				<input type="text" name="email" id="_email" style="margin-left:25px !important; text-align:left; " /><br /><br />

				<label for="_choix" style="font-weight:bold">» Pour quel raison souhaitez vous nous contacter</label><br /><br />
				<select name="choix" id="_choix" style="margin-left:25px !important; text-align:left; width:200px">
				  <option value="partenariat">Partenariat</option>
				  <option value="recrutement">Recrutement</option>
				  <option value="infos">Informations</option>
				  <option value="manager">Contact manager</option>
				  <option value="pbm">Probl&egrave;me technique sur le site</option>
				  <option value="autres">Autres</option>
				</select><br /><br /><br />
				
				<label for="_message" style="font-weight:bold">» Rédiger votre message</label><br /><br />
				<textarea id="_message" name="_message" class="size150" style="margin-left:25px !important; text-align:left;" wrap="nowrap"></textarea><br /><br /><br />
				
				<input type="submit" class="submit" value="envoyer" style="margin-left:25px !important;"/><br /><br />
			</fieldset>
		</form>
		<div id="result" style="display:none"></div>';

	}
	$design->zone('contenu', $contenu);
	
break;
}

?>