<?php

//------------------------------------------------------------------------------------
// Appel normal : Affiche la dernière news dans le template accueil.tpl
// Appel 'détail' : Affiche le détail d'une news dans le template accueil_detail.tpl
// ------------------------------------------------------------------------------------

switch(@$_GET['act']) { /* Suivant l'appel */
default :

	// Sélectionner la dernière news //
	
	$sql=mysql_query("	SELECT *, n.id as idNews, n.url as urlNews, nc.url as urlCat, n.idcat
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."news_cat nc
						ON nc.id=n.idcat
						ORDER BY n.id DESC
						LIMIT 0,1");
	$news=mysql_fetch_object($sql);
	
			
		// Mise en page de la news
		$titre='<a href="actualite-'.$news->idNews.'-'.recode($news->urlNews).'.htm" title="Billet : '.recupBdd($news->titre).'">'.recupBdd($news->titre).'</a>';
		
		$date=inverser_date($news->date, 6);
		
		if (empty($news->apercu)) {
			$contenu=recupBdd($news->contenu);
		} else {
			$contenu=recupBdd($news->apercu).'
				<p>
					<span class="read-on"><a href="actualite-'.$news->idNews.'-'.recode($news->urlNews).'.htm" title="Lire cet article en entier" onclick="news_detail(); return false;">Lire la suite</a></span>
				</p>';
		}
	
		$cat='<a href="categorie-'.$news->idcat.'-'.recode($news->urlCat).'.htm" title="Voir les articles de la catégorie '.recupBdd($news->nom).'">'.recupBdd($news->nom).'</a>';
		
		// Insertion dans le design
		$design->zone('news_titre', $titre);
		$design->zone('news_date', $date);
		$design->zone('news_contenu', $contenu);
		$design->zone('news_cat', $cat);
		$design->zone('news_id', $news->idNews);
	

		
	$design->zone('titrePage', 'Le web 2.0 dans sa démesure, par Julien LAFONT alias YoTsumi');

break;
###########################################################################################################"
###########################################################################################################"
case "detail";

	// Sélection des donneés
	$id=$_GET['id'];
	$sql=mysql_query("	SELECT *, n.id as idNews, n.url as urlNews, nc.url as urlCat, n.idcat
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."news_cat nc
						ON nc.id=n.idcat
						WHERE n.id=".$id);
	$news=mysql_fetch_object($sql);
	
	// Mise en forme
	$titre='<a href="actualite-'.$news->idNews.'-'.recode($news->urlNews).'.htm" title="'.recupBdd($news->titre).'">'.recupBdd($news->titre).'</a>';
	$date=inverser_date($news->date, 6);
	$contenu=recupBdd($news->contenu);
	$cat='<a href="categorie-'.$news->idcat.'-'.recode($news->urlCat).'.htm" title="Voir les articles de la catégorie '.recupBdd($news->nom).'">'.recupBdd($news->nom).'</a>';

		
	// Insertion dans le template
	$design->template('news-detail');
	
	$design->zone('news_titre', $titre);
	$design->zone('news_date', $date);
	$design->zone('news_contenu', $contenu);
	$design->zone('news_cat', $cat);
	$design->zone('news_id', $news->idNews);
	$design->zone('titrePage', recupBdd($news->titre));

break;
}

?>