<?php 

class Folio {
	
	private $main;
	private $design;
	
	public function __construct($main) {
		$this->main = $main;
		$this->design = $main->design;
	}	
	
	
	public function liste_rea($type) {
		if (!preg_match('#^(sites|designs|autres)$#', $type)) $type="sites";
		
		$sql="SELECT prefix, titre, annee, bulle_desc, min_rea FROM ".PREFIX."rea_".$type." ORDER BY ordre ASC";
		return mysql_tab($sql);
	}
	
	public function detail($type, $prefix) {
		if (!preg_match('#^(sites|designs|autres)$#', $type)) $type="sites";
		$prefix=Fonctions::addBdd($prefix);
		
		$sql="SELECT * FROM ".PREFIX."rea_".$type." WHERE prefix='$prefix'";
		return mysql_tab($sql);
	}
	
}


?>