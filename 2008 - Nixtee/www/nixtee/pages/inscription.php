<?php

// Est déjà connecté ?
if ($m->mbre->est_log()) {
	$m->design->template("erreur");
	$m->design->assign("nomErreur", "Inscription impossible");
	$m->design->assign("descErreur", "Nous avons détecté que vous êtes déjà connecté. Vous ne pouvez donc pas vous inscrire.");
}
else
{

switch(@$_GET['act']){

#######################################################################
######### Page affiché par défaut : Formualaire d'inscription #########
#######################################################################
default:
case "formulaire":

	$m->design->template("_general/inscription");
	$m->design->assign('titrePage', "Inscription aux services du blog");
	

	
break;
	
#######################################################################
############# Aprés post du formulaire : ajoute un membre #############
#######################################################################	
case "verif":
		
	$donnees=$_POST;
	$r=$m->mbre->ajouter_membre($donnees['pseudo'], $donnees['pass1'], $donnees['pass2'], $donnees['email'], true, array("site" => $donnees['site']));
	
	if ($r===true) {
		
		if (defined('AJAX')) {  header('location: ajax.php?inscription&act=confirmation'); }
		else				 {  header('location: inscription-confirmation.htm'); }
		
	} else {
		switch($r) {
		 case "erreur_ip": $mess="Nous avons détecté que vous avez déjà un compte sur ce site. Vous ne pouvez pas vous réinscrire."; break;
		 case "erreur_pseudo": $mess="Votre pseudo ne semble pas correspondre aux pré-requis."; break;
		 case "erreur_pseudo_utilise": $mess="Le pseudo que vous avez choisi est déjà utilisé par un membre."; break;
		 case "erreur_email": $mess="Votre adresse email ne semble pas valide."; break;
		 case "erreur_email_utilise": $mess="L'adresse email que vous avez entré est déjà enregistrée dans notre base de donnée."; break;
		 case "erreur_pass": $mess="Vous avez entré 2 mots de passe différents."; break;
		 case "erreur_sql": $mess="Une erreur inconnue est survenue durant l'enregistrement de votre compte."; break;
		 default: $mess="Erreur très inconnue !".$r; break;
		}
	   
	   if (defined('AJAX')) die ("erreur|:|".$mess);
	   else {
	   	$m->design->assign("erreur", $mess);
		$m->design->template("_general/inscription");
	   }

	}
		
break;

#######################################################################
####################### Message de confirmation #######################
#######################################################################	
case "confirmation":

	$m->design->template("_general/inscription_ok");
	$ajax_titre="Confirmation de votre inscription";
	$ajax_hash="#inscription-confirmation";
	
break;


#######################################################################
############### Active un compte avec son id et la clé  ###############
#######################################################################	
case "valider_compte":

	$m->mbre->activer_compte(fonctions::addBdd($_GET['id']), fonctions::addBdd($_GET['cle']));

break;
}

	$m->design->assign('titrePage', "Inscription au blog");
}
?>