<?php

	$m->design->template(Fonctions::addBdd($_GET['tpl']));

	// On définit des titres pour les pages
	switch($_GET['tpl']) {
		case "_quisuisje/accueil":
			$m->design->assign("titrePage", "Qui suis-je ? Programmeur autodidacte et passioné du web");
		break;
		
		case "_cv/accueil":
			$m->design->assign("titrePage", "Découvres mon CV et mes différentes compétences");
		break;
		
		case "_general/plan":
			$m->design->assign("titrePage", "Plan de mon portfolio, Accés rapide aux différentes rubriques.");
		break;		
	}	
?>