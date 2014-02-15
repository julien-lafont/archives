<?php

switch(@$_GET['act']) {

default:

	// Page affichant le formulaire de contact
	if (!$_POST) { 
		$m->design->template("_general/contact");
		$m->design->assign('titrePage', "Contacter l'équipe nixtee");
		
		$ajax_titre = "Contacter l'equipe du blog";
		$ajax_hash  = "#contact";
	
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
				$m->design->assign("nomErreur", "Votre message n'a pas pu être envoyé");
				$m->design->assign("descErreur", "Merci de remplir correctement le formulaire<br />Tous les champs doivent être renseignés.");
			}
		} else {
	
			
		// Tout est OK, mise en forme de l'email :
			if ($m->mbre->est_log()) {
			  $infos=$m->mbre->infos();
			  $membre='<a href="'.URL.'membre-'.$infos['id_membre'].'-'.fonctions::recode($infos['pseudo']).'.htm">'.ucfirst($infos['pseudo']).'</a>';
			} else {
			  $membre="<i>Invit&eacute;</i>";
			}
			
			 
		$sujet=">> Contact blog >> ".$donnees['contact_sujet'];
		$message="
			<h3>Contact reçu via le blog ".NOM."</h3>
			
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
				
	$m->design->template("_general/contact_confirmation");
	$m->design->assign("titrePage", "Formulaire envoyé avec succes !");
	
	$ajax_titre="Formulaire envoye avec succes !";
	$ajax_hash="#contact-confirmation";

break;
}
	
?>