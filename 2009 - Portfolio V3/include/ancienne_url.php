<?php

function redir301($url) {
	header("Status: 301 Moved Permanently", false, 301);
	header("Location: ".$url);
	exit();
}

if (!isset($_GET['noredir'])) {
	

// News
if (eregi('^actu-([0-9]*)', $page, $numActu)) { 
	$id=intval($numActu[1]);
	$sqlNews=mysql_query("SELECT url FROM ".PREFIX."new WHERE id=".$id);
	$d=mysql_fetch_object($sqlNews);
	redir301('actualite-'.$id.'-'.$d->url.'.htm');
}

// Plan
if (eregi('^plan', $page)) {
	redir301('plan-du-site-studio-dev.htm');
}


// Portfolio
if (eregi('^portfolio-([0-9]*)', $page, $numcrea)) { 
	$id=intval($numcrea[1]);
	$sqlPort=mysql_query("SELECT lien_perm FROM ".PREFIX."creations WHERE id=".$id);
	$d2=mysql_fetch_object($sqlPort);
	redir301('portfolio-'.$id.'-'.$d2->lien_perm.'.htm');
}

// Mon portfolio
if (eregi('^mes-creations', $page)) {
	redir301('portfolio.htm');
}

// Les catégories
if (eregi('^categorie-([0-9]*)/([a-zA-Z0-9_-]*)', $page, $numCat)) { 
	$id=intval($numCat[1]);
	$sqlCat=mysql_query("SELECT url FROM ".PREFIX."news_cat WHERE id=".$id);
	$d3=mysql_fetch_object($sqlCat);
	redir301('categorie-'.$id.'-'.$d3->url.'.htm');
}

}

