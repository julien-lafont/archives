<?php

$design->template('simple');
$design->zone('titre', '<a href="plan-du-site-studio-dev.htm" title="Plan du site Studio-dev.fr by Yotsumi">Plan du site</a>');
$design->zone('titrePage', 'Plan du site studio-dev.fr');

	$sql_news=mysql_query("	SELECT *, n.id as idNews, n.url as urlNews, nc.url as urlCat
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."news_cat nc
						ON nc.id=n.idcat
						ORDER BY nc.id");
	while ($news=mysql_fetch_object($sql_news)) {
		@$liste_news.='<li><strong>'.recupBdd($news->nom).'</strong> &rsaquo; <a href="actualite-'.$news->idNews.'-'.recode($news->urlNews).'.htm" title="'.recupBdd($news->titre).'">'.recupBdd($news->titre).'</a></li>';
	}
	
	$sql_crea=mysql_query("SELECT * FROM ".PREFIX."creations");
	while ($crea=mysql_fetch_object($sql_crea)) {
		@$liste_creations.='<li><a href="portfolio-'.$crea->id.'-'.recode($crea->lien_perm).'.htm" title="Création '.recupBdd($crea->nom).'"><strong>'.recupBdd($crea->nom).'</strong></a><br /><p style="margin-left:20px">'.recupBdd($crea->presentation).'</p></li>';
	}


$c='<div id="plan" class="img_no_border">
		<h4>Les actualités</h4>
		<ul>
			'.$liste_news.'
		</ul>
		
		<br /><h4>Mes créations</h4>
		<ul>
			'.$liste_creations.'
		</ul>
		
		<br /><h4>Mes projets</h4>
		<ul>
			'.@$liste_projets.'
		</ul>
	</div>';

$design->zone('contenu', $c);

?>