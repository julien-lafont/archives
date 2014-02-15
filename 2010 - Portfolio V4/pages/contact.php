<?php

switch(@$_GET['act']) {

default:

	// Page affichant le formulaire de contact
	if (!$_POST) { 
		$m->design->template("_actions/contact");
		$m->design->assign('titrePage', "Contacter l'equipe du blog");
	
	// Evalusation de sdonnées
	} else {
	
		$donnees=$_POST;
		
		// Vérification captcha
		if ($_SESSION['captcha-control']!=$donnees['contact_captcha']) 
			$erreur_type="erreur_captcha";
		
		// Vérification champs nécessaires
		if (empty($donnees['contact_email']) || empty($donnees['contact_sujet']) || empty($donnees['contact_message'])) 
			$erreur_type="erreur_form";

			
		// Gestion des erreurs
		if (isset($erreur_type)) {
			if (defined('AJAX'))   die($erreur_type);
			else {
				$m->design->template("erreur");
				$m->design->assign("nomErreur", utf8_decode("Votre message n'a pas pu être envoyé"));
				$m->design->assign("descErreur", utf8_decode("Merci de remplir correctement le formulaire<br />Tous les champs doivent être renseignés."));
			}
		} else {
	
			
		// Tout est OK, mise en forme de l'email :
		$membre="invité";
			
			 
		$sujet=">> Contact Folio IUT >> ".$donnees['contact_sujet'];
		$message="
			<h3>Contact reçu via mon Folio IUT</h3>
			
			<strong>Sujet</strong> : ".$donnees['contact_sujet']."<br />
			<strong>Email</strong> : ".$donnees['contact_email']."<br />
			<strong>Infos sur le membre</strong> : ".$membre."<br /><br />
			
			<strong>Message</strong><br />
			".nl2br($donnees['contact_message']);
			
		@fonctions::email( EMAIL, $sujet, fonctions::recupBdd($message), 'Bot_'.NOM.'' );
	
		if (defined('AJAX'))   die("ok");
		else 	header('location: contact-confirmation.htm');
			
	  }
	}
	
break;

case "confirmation":
				
	$m->design->template("_actions/contact_confirmation");
	$m->design->assign("titrePage", "Formulaire envoye avec succes !");

break;
}
	
?>