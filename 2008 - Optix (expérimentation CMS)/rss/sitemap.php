<?php

			   
$liste=array();

// Sélection du titre de tous les billets
$sql=mysql_query("SELECT id_billet, titre FROM ".PREFIX."billets ORDER BY date ASC");
while ($d=mysql_fetch_object($sql)) {
	$liste[]='billets-'.$d->id_billet.'-'.fonctions::recode($d->titre).'.htm';
}

// Sélection de la liste des membres
$sql2=mysql_query("SELECT id_membre, pseudo FROM ".PREFIX."membres");
while ($mm=mysql_fetch_object($sql2)) {
	$liste[]='membre-'.$mm->id_membre.'-'.fonctions::recode($mm->pseudo).'.htm';
}

// Sélection de la liste des catégories
$sql3=mysql_query("SELECT id_cat, cat_url, cat FROM ".PREFIX."categories");
while ($c=mysql_fetch_object($sql3)) {
	$liste[]='categorie-'.$c->id_cat.'-'.fonctions::recode(empty($c->cat_url)? $c->cat : $c->cat_url).'.htm';
}

// Sélection des jours ayants des billets
$sql4=mysql_query("SELECT DAY(date) as jour, MONTH(date) as mois, YEAR(date) as annee FROM ".PREFIX."billets ORDER BY date ASC");
while ($f=mysql_fetch_object($sql4)) {
	$liste[]='calendrier-'.$f->jour.'_'.$f->mois.'_'.$f->annee.'.htm';
}

// Sélection des tags
$bb=new billets($m);
$tags=$bb->recuperer_tags();
foreach($tags as $tag=>$pts) {
	$liste[]='billets-tag-'.fonctions::recode(strtolower($tag)).'.htm';
}



	// -------------------------[ Sélection du template ]---------------------------------------//
	$m->design->assign('liens', $liste);
	$m->design->assign('URL', URL);
	$m->design->template('sitemap');	

?>
