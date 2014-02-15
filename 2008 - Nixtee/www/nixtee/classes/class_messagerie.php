<?php

class messagerie 
{

	private $main;
	private $sql;
	private $mbre;
	private $design;

	// Liaison Mysql ( table / champs )
	private $tbl="messagerie";
	private $chp = array('id'=>'id', 'exped'=>'id_exped', 'dest'=>'id_dest', 'sujet'=>'sujet', 'message'=>'message', 'etat'=>'etat', 'date'=>'date', 'ip'=>'ip');
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->design;
		$this->mbre = $main->mbre;
		$this->design = $main->design;
	}
		
	public function lister_messages() {
	
	}
	
	public function nb_messages($id_mbre=$_SESSION['sess_id']) {
		$sql="SELECT ".$this->chp['id']." FROM ".PREFIX.$this->tbl." WHERE ".$this->chp['id_dest']."=".$id_mbre;
		return mysql_nb($sql);
	}
	
	public function nb_nouveaux_messages($id_mbre=$_SESSION['sess_id']) {
		$sql="SELECT ".$this->chp['id']." FROM ".PREFIX.$this->tbl." WHERE ".$this->chp['id_dest']."=".$id_mbre." AND ".$this->chp['etat']."='nouveau'";
		return mysql_nb($sql);
	}
	
	public function detail_message() {
		// Inbox
		// Historique
		// Récupérer infos pour répondre
	
	}
	
	public function definir_lu() {
	
	}
	
	public function supprimer() {
	
	}
	
	public function envoyer_message() {
	
	}
	
}

?>