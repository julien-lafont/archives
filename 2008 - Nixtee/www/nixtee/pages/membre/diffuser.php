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
	
	switch(@$_GET['act']) {
	
	// Affichage de la liste des différents questionnaires du membre
	default:
		
		$q=new Questionnaires($m);
		$liste_q=$q->mes_quest();

		$m->design->assign("liste", $liste_q);
		$m->design->template("_questionnaires/diffuser_accueil");
		
	break;
	
	// Page demandant à quel groupe envoyer le questionnaire
	case "choix":
	
		$id=$_GET['id'];
		$q=new Questionnaires($m);
		$mon_quest=$q->mes_quest($id, false);		
		
		$m->design->assign("quest", $mon_quest);
		$m->design->template("_questionnaires/diffuser_choix");
		
	break;
	
	// Envoie du questionnaire
	case "validation":
		
		$b=new BuddyList($m);
		
		$liste=array();
		
		// On récupère les emails des différents groupes;
		if ($_POST['buddy_h']) $liste[]=$b->recup_groupe("h");
		if ($_POST['buddy_f']) $liste[]=$b->recup_groupe("f");
		if ($_POST['buddy_p1']) $liste[]=$b->recup_groupe("p1");
		if ($_POST['buddy_p2']) $liste[]=$b->recup_groupe("p2");
		
		// Puis les autres emails, seulement si ils sont valides
		$liste_incorrect=array();
		foreach (preg_split("/[\s,]+/", $_POST['autre_emails']) as $email) {
			if ($m->mbre->valider_email($email))  $liste[]=$email;
			else								$liste_incorrect[]=$email;
		}
	
		$q=new Questionnaires($m);
		$q->diffuser($_POST['id_quest'], $liste, $_POST['mots']);
		


	break;
	}

	
	
}

?>