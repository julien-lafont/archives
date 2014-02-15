<?php

	$m->design->assign('nomSite', NOM);
	$m->design->assign('baseUrl', URL);
	$m->design->assign('footer', FOOTER);
	$m->design->assign('infos_mbre', $m->mbre->infos());


	//-- Passage de variable --//
	/* Connecté ? */  $m->design->assign('est_connecte', $m->mbre->est_log());
	/* Admin ? */     $m->design->assign('est_admin', $m->mbre->est_admin());
	
?>