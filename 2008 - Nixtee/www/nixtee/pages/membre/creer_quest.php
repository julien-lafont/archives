<?php

if (!$m->mbre->est_log()) {

	$m->design->assign("nomErreur", "Accés interdit");
	$m->design->assign("descErreur", "Vous devez être connecté pour accéder à cette section");
	$m->design->template("erreur");
	
	$ajax_titre="Acces interdit !";
	$ajax_hash="#erreur";
}	
else
{
	
	$q=new Questionnaires($m);
	
	switch(@$_GET['act']) {
		
	// Liste des différents formulaires types 	
	default:	
		$apercus=$q->apercu();
		$m->design->assign("apercus", $apercus);
		$m->design->template("_questionnaires/form_types");
	break;
	
	
	case "infos":
		$id=(int)$_GET['id'];
		$apercu=$q->apercu($id, false);
		$m->design->assign('form', $apercu);
		$m->design->template("_questionnaires/form_infos");
	break;
	
	
	case "enregistrer":
		$id=(int)$_GET['id'];
		
		// Cas d'un questionnaire type NON-personnalisé
		if (@$_POST['personnaliser']!="oui") {
			
			$r=$q->ajouter_form_membre_noperso($id, $_POST);
			if ($r)  $m->design->template("_questionnaires/form_confirmation");

		}
		else
		{
			
		}
		
	break;
	}
	
	
	$m->design->assign("titrePage", "Création d'un questionnaire");
}

?>