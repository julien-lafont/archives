<?php

class Page {

	private $main;
	private $sql;
	private $design;
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->sql;
		$this->design = $main->design;
	}	
	
	
	/**
		Retourne un tableau contenant les différentes informations du menu ( catégories et sous catégories )
    */
	public function lister_menu() {
	
		$qCat="SELECT * FROM ".PREFIX."categories ORDER BY id ASC";
		$sqlCat=$this->sql->query($qCat);
		
		$r=array();
		while ($cat=$this->sql->getRowAssoc($sqlCat)){
			$r[]=$cat;
			
			$qPages = "SELECT * FROM ".PREFIX."pages WHERE id_cat='".$cat['id']."' ORDER BY id ASC ";
			$sqlPages = $this->sql->query($qPages);
			
			$r[count($r)-1]['contenu']=$this->sql->GetAllArray($sqlPages);
		}
		
		return $r;
	}
	
	public function info_page($cat, $page) {
		
		$cat=fonctions::addBdd($cat);
		$page=fonctions::addBdd($page);
		
		$q="SELECT p.id as idPage, c.id as idCat, p.url as urlPage, c.url as urlCat, p.titre, c.nom, p.contenu
		    FROM ".PREFIX."pages p
			LEFT JOIN ".PREFIX."categories c
			ON p.id_cat=c.id
			WHERE c.url='$cat' AND p.url='$page'";
			
		$sql=$this->sql->query($q);
		
		if ($this->sql->nb($sql) == 0) return false;
		else {
			return $this->sql->getRowAssoc($sql);
		}
	}
	
	

	
}