<?php
	
	include_once('pages/forum_class.php');
	$forum = new Forum();
	
switch(@$_GET['act']) {
default:

	$contenu=$forum->recuperer_liste_categories();
	$titre="Forums et discussions";
	
break;

case "liste_sujets":

		$id=(int)$_GET['id'];
		$page=(int)$_GET['page'];
	$cat=$forum->recuperer_infos_categorie($id);

	$contenu=$forum->recuperer_listes_sujets($id, $page);
	$titre="Discussions sur le thème : ".recode($cat['nom']);
	
	$design->zone('img_titre', '<!--  rien -->');
	
break;

case "afficher_message":

	
		$id=(int)$_GET['id'];
		$page=(int)$_GET['page'];
	$contenu=$forum->afficher_message($id, $page);
	
	$ref=$forum->recuperer_meta($id);
	metatag($ref[0], $ref[1]);

	$mess=$forum->recuperer_infos_sujet($id);
	$titre=$mess['titre'];
	
	$design->zone('img_titre', '<!--  rien -->');
break;
}

	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Forum : '.$titre);
	
	$design->zone('header', '<script type="text/javascript" src="javascript/-forum.js"></script>
							 <script type="text/javascript" src="javascript/-profil.js"></script>
							 <script type="text/javascript" src="javascript/librairies/jquery.inplace.js"></script>');
	$design->zone('body', 'onload="h = new  historique(); document.h = h; return h.init(\'h\'); "');
?>