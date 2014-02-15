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

	switch(@$_GET['act']) 
	{
	
	// Page principale du membre
	default:
	
		$b=new BuddyList($m);
		$m->design->assign('liste', $b->recup_tous());
		
		$m->design->template("_moncompte/buddylist");
	
	break;
	
	
	// Appel AJAX : Ajouter un ami	
	case "ajouter":
	
		$standalone=true;
		
		$nom=$_POST["nom"];
		$email=$_POST["email"];
		$groupe=$_POST["groupe"];
		
		$b=new BuddyList($m);
		fonctions::echoAjax($b->ajouter($nom, $email, $groupe));
		 
	break;
	
	
	// Appel AJAX : Retirer un ami
	case "supprimer":
	
		$standalone=true;

		$email=$_POST["email"];
		$groupe=$_POST["groupe"];
		
		$b=new BuddyList($m);
		fonctions::echoAjax($b->supprimer($email, $groupe));	
	
	break;
	}
}

	$m->design->assign('titrePage', "Buddy-List");
?>