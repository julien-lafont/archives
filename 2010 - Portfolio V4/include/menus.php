<?php

	$m->design->assign('nomSite', NOM);
	$m->design->assign('baseUrl', URL);
	$m->design->assign('footer', FOOTER);
	
	$m->design->assign("titrePage", TITRE_PAGE);
	$m->design->assign("description", DESCRIPTION);
	$m->design->assign("keywords", KEYWORDS);



	$tags=array(
			array("societe", "Societe", 10),
			array("web", "Web 2.0", 18),
			array("geek", "Geek", 15),
			array("msn", "Msn", 8),
			array("friends", "Friends", 7),
			array("dev", "Studio-Dev", 22),
			array("musique", "Musique", 9),
			array("ajax", "Ajax", 10),
			array("internet", "Internet", 18),
			array("design", "Design", 14),
			array("comic", "Web Comic", 7),
			array("serigraphie", "Serigraphie", 7),
			array("open", "Open Source", 7),
			array("firefox", "Firefox", 13),
			array("partage", "Partage", 9),
			array("mario", "Mario", 5),
			array("series", "Series TV", 9),
			array("mangas", "Mangas", 8),
			array("entrepreneur", "Entrepreneur", 10),
			array("ada", "Ada", 9),
			array("netvibes", "Netvibes", 13),
			array("twitter", "Twitter", 12),
			array("google", "Google", 15),
			array("IUT", "IUT", 7),
			array("programmation", "Programmation", 12)
			
		);
		
	shuffle($tags);
	
	$vars="";
	foreach ($tags as $tag) {
		$vars.='<a href="javascript:info_tag(\''.$tag[0].'\');" style="font-size:'.$tag[2].'pt">'.$tag[1].'</a>
';
	}
	
	$m->design->assign('tags', urlencode("<tags>".$vars."</tags>"));

	
?>