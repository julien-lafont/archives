<?php



	$rea=new Folio($m);
	
	switch(@$_GET['act']) {
		default:
			$liste['sites']=$rea->liste_rea("sites");
			$liste['designs']=$rea->liste_rea("designs");
			//$liste['autres']=$rea->liste_rea("autres");
			
			$m->design->assign("liste", $liste);
			
			// Optimisation ref
			$m->design->assign('titrePage', 'Mes dernières réalisations: sites web et logiciels');
			$m->design->assign('description', 'Découvrez mes dernières développements : réalisations de sites web 2.0 ou programmation de logiciels en Java/Ada');
			
			$m->design->template("_rea/accueil");
		break;
		
		case "site_detail":
		
			$m->design->assign('site', $rea->detail("sites", $_GET['prefix']));
			$m->design->template("_rea/sites_detail");
				
		break;
	}	


?>