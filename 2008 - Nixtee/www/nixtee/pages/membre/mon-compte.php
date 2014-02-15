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

	// Zones communes
	$infos=$m->mbre->infos();
	$m->design->assign('infos', $infos);
	$m->design->assign('pseudo', ucfirst($_SESSION['sess_pseudo']));	


	switch(@$_GET['act']) 
	{
	
	// Page principale du membre
	default:
	
		$m->design->template("_moncompte/accueil");
	
		$ajax_titre="Mon compte";
		$ajax_hash="#mon_compte-accueil";

	break;
	
	// Modifier ses infos personelles
	case "infos":
		$m->design->assign('infos', $m->mbre->infos());
		$m->design->template("_moncompte/infos");
	
		$ajax_titre="Mon compte - Modifier mes infos personelles";
		$ajax_hash="#mon_compte-infos";

	break;
	
	
	// Mise à jour des données
	case "maj":
	
		if ($_POST) {
			$champs=array("email", "site", "msn", "skype", "facebook", "metier", "date_naiss", "prenom", "ville", "signature");
			
			$m->mbre->maj_infos($champs, $_POST);
			/* Nouvelles infos */ $infos=$m->mbre->infos();  $m->design->assign('infos', $infos);
			$m->design->assign('modif_ok', "Les modifications ont &eacute;t&eacute; effectu&eacute;es avec succ&eacute;s !");
		}
		$m->design->template("_moncompte/infos");
	
		$ajax_titre="Mon compte - Modifier mes infos personelles";
		$ajax_hash="#mon_compte-infos";
	
	break;
	
	// Changer mot de passe
	case "majmdp":
	
		if ($_POST) {
			$newPass=$_POST['lost_pass'];
			$m->mbre->maj_mdp($newPass);
			
			$m->design->assign('modif_ok', "Votre mot de passe a &eacute;t&eacute; mis &agrave; jours !");
		}
		$m->design->template("_moncompte/infos");
	
		$ajax_titre="Mon compte - Modifier mes infos personelles";
		$ajax_hash="#mon_compte-infos";
	break;
	
	// Mettre à jour mon avatar
	case "maj_avatar":
	
		// Configuration d'upload des avatars
		$chemin="upload/avatars";
		
		// Si le membre a déjà un avatar, on le supprime
		$m->mbre->supprimer_avatar();	
			
		// Upload et redimentionnement
		if ($_FILES) {
			$config = array('nom_champs'  => "fichier", 'destination' => $chemin, 'largeur' => 45, 'hauteur' => 45);
			$charger = new images($config);
			try {
				$charger->executer(); $nom=$charger->nom();
			} catch(Exception $e) {
				die("Erreur<br /><br />$e");
			}
			
			// Mise à jour de la base de donnée
			$m->mbre->maj_infos(array("avatar"), array("avatar"=>$nom));
			$m->design->assign('modif_ok', "Votre nouvel avatar a &eacute;t&eacute; enregistr&eacute; avec succ&eacute;s !");
			/* Nouvelles infos */ $infos=$m->mbre->infos();  $m->design->assign('infos', $infos);
		}
		
		$m->design->template("_moncompte/infos");
	
		$ajax_titre="Mon compte - Modifier mes infos personelles";
		$ajax_hash="#mon_compte-infos";	
	
	break;
	
	
	// Supprimer son avatar
	case "supprimer_avatar":
	
		$m->mbre->supprimer_avatar();	
		
		$m->design->assign('modif_ok', "Votre avatar a &eacute;t&eacute; supprim&eacute;.");
		$m->design->template("_moncompte/infos");
	
		$ajax_titre="Mon compte - Modifier mes infos personelles";
		$ajax_hash="#mon_compte-infos";	

	break; 
	}
	
}

	$m->design->assign('titrePage', "Mon compte");
?>