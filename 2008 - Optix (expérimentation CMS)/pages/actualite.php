<?php

	$id_news=(int)$_GET['id'];
	
	$n = new News($m);
	$news=$n->info_news($id_news);
	
	if ($news!=null)  {
		$m->design->assign('actualite', $news);
		$m->design->template('_general/actu_detail');	
	}
	else {
		//Erreur 404
		$m->design->template("erreur");
		$m->design->assign('nomErreur', 'Erreur 404 : page introuvable');
		$m->design->assign('descErreur', 'Impossible d\'afficher la news numéro <u>'.$id_news.'</u>.');

	}
	
	