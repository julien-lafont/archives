<?php

	$cat=$_GET['cat'];
	$page=$_GET['page'];
	
	$p = new Page($m);
	$contenu = $p->info_page($cat, $page);
	
	$m->design->assign('article', $contenu);
	$m->design->template('_general/article');
	
?>