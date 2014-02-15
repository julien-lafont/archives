<?php

class News {

	private $main;
	private $sql;
	private $design;
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->sql;
		$this->design = $main->design;
	}	
	
	
	/**
		Retourne un tableau contenant les différentes informations des $nb dernières news
    */
	public function lister_news_bloc($nb=5) {
	
		$nb=(int)$nb;
		
		$q="SELECT id_news, titre, identite
			FROM ".PREFIX."news n
			LEFT JOIN ".PREFIX."membres m
			ON m.id_membre=n.id_auteur
			WHERE n.billet_statut='en ligne'
			ORDER BY n.date DESC
			LIMIT 0,$nb";
			
		$r=$this->sql->query($q);
	
		return $this->sql->GetAllArray($r);
	}
	
	/**
	 * 	Retourne un tableau contenant les infos complète d'une news précise
	 */
	 public function info_news($id) {
	 	$id=(int)$id;
	 	
	 	$q="SELECT id_news, titre, contenu, identite, date 
		 	FROM ".PREFIX."news n
			LEFT JOIN ".PREFIX."membres m
			ON m.id_membre=n.id_auteur
			WHERE n.id_news=".$id;
			
		$r=$this->sql->query($q);
		
		$news=$this->sql->getRowAssoc($r);
		
		// Si aucune news à cet id, retourne faux
		if ($this->sql->nb($r)==0) return false;
		
		return $news;
			
	 }
	
}