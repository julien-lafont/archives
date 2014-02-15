<?php


	
	// -------------------------[ Configuration du flux RSS ]---------------------------------------//
	$rss=array("nom"  => NOM,
			   "url"  => URL,
			   "desc" => DESCRIPTION
			   );
			   
			   
	// -------------------------[ Selection des infos ]---------------------------------------//
	$sql="	SELECT id_billet, titre, resume, contenu, date
			FROM ".PREFIX."billets
			GROUP BY date DESC
			LIMIT 0,20";
	
	$q=mysql_q($sql);
	
	// -------------------------[ Création du tableau RSS ]---------------------------------------//
	$r=array();
	while ($d=mysql_fetch_array($q)) {
		extract(fonctions::recupBdd($d));
		$r[]=array("title" => utf8_encode($titre),
				   "url_title" => fonctions::recode(utf8_encode($titre)),
				   "url_id" => $id_billet,
				   "description" => (empty($resume)) ? fonctions::tronquerChaine(utf8_encode($contenu), 150) : utf8_encode($resume),
				   "created_on" => $date
				   );
	}
	
	// -------------------------[ Sélection du template ]---------------------------------------//
 	$m->design->assign('rss', $rss);
	$m->design->assign('articles', $r);
	$m->design->template('rss');	

?>