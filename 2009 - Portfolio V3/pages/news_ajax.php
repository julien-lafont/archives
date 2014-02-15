<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


switch(@$_GET['act'])
{
case "recup_apercu":

	// On récupère les données
	if (isset($_GET['idCurrent'])) { //-> News suivante-Précédente
		
		$idCurrent=$_GET['idCurrent'];
	
		if ($_GET['dir']=='suivante') $id=$idCurrent+1;
		else if ($_GET['dir']=='precedente') $id=$idCurrent-1;
		else die('error');
	} 
	else //-> News précise
	{
		$id=$_GET['idAff'];
	}
	
	
	$news=0;
	while (empty($news->idNews)) {
		$sql=mysql_query("	SELECT *, n.id as idNews, n.url as urlNews, nc.url as urlCat
							FROM ".PREFIX."news n
							LEFT JOIN ".PREFIX."news_cat nc
							ON nc.id=n.idcat
							WHERE n.id=".$id);
		$news=mysql_fetch_object($sql);
		
		// On gère l'existance de la news demandée
		if (empty($news->idNews)) {
			if ($_GET['dir']=='suivante') $id=$id+1;
			if ($_GET['dir']=='precedente') $id=$id-1;
		}
	}
	
	// News suivante - News précédente ?
	$sqlpre=mysql_query("SELECT id FROM ".PREFIX."news WHERE id<$id");
		$pre=mysql_num_rows($sqlpre);
		if ($pre>=1) $pre=1;
	$sqlsuiv=mysql_query("SELECT id FROM ".PREFIX."news WHERE id>$id");
		$suiv=mysql_num_rows($sqlsuiv);
		if ($suiv>=1) $suiv=1;
		
	// On les met en forme
	$titre='<a href="?actu-'.$news->idNews.'/'.$news->urlNews.'" title="'.$news->titre.'">'.$news->titre.'</a>';
	
	$date=inverser_date($news->date, 6);
	
	if (@$_GET['obj']=="detail") {
		$contenu=$news->contenu;
	} else {
		if (empty($news->apercu)) {
			$contenu=$news->contenu;
		} else {
			$contenu=$news->apercu.'
				<p>
					<span class="read-on"><a href="?actu-'.$news->idNews.'/'.$news->urlNews.'" title="Lire cet article en entier">Lire la suite</a></span>
				</p>';
		}
	}

	$cat='<a href="?actu/categorie/'.$news->urlCat.'" title="Voir les articles de la catégorie '.$news->nom.'">'.$news->nom.'</a>';

	// On affiche la requête Json
	echo2 ('var infosNews = { 
			  "id": \''.$id.'\',
			  "titre": \''.json($titre).'\', 
			  "date": \''.$date.'\', 
			  "contenu": \''.json($contenu).'\',
			  "cat": \''.json($cat).'\',
			  "suivant": \''.$suiv.'\',
			  "precedent": \''.$pre.'\'
			} ');


break;
}

?>