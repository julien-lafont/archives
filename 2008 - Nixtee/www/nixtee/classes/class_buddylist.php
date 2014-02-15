<?php

class BuddyList
{
	

	
	/* ----------------------- FONCTIONS PUBLIQUES ------------------------------- */
	
	// Ajoute un contact ($nom, $email) dans le $groupe du membre $id_mbre. 
	// Si $id_mbre non définis, alors utilisateur courant
	public function ajouter($nom, $email, $groupe, $id_mbre=false){
		$id_mbre=($id_mbre===false) ? $_SESSION['sess_id'] : (int)$id_mbre;
		if (!preg_match('#^(f|h|p1|p2)$#', $groupe)) $groupe='p2';
		$nom=fonctions::addBdd($nom); $email=Fonctions::addBdd(strtolower($email));
		
		// Email valide ?
		if (!$this->mbre->valider_email($email)) return "email_invalide";
		
		$q="SELECT ".$groupe." as gp FROM ".PREFIX."buddylist WHERE id_membre=".$id_mbre;
		$sql=$this->sql->query($q);
		
		// Si le membre a déjà une liste
		if ($this->sql->nb($sql)>0) {
				
			$d=$this->sql->getRowAssoc($sql);
			$liste=@unserialize($d["gp"]);
			
				// Email déjà dans la liste ?
				if (!empty($d["gp"])) {
					foreach($liste as $key=>$val) {
						if ($val[1]==$email) {
							return "doublon";
						}
					}
				}
				
				// Ajout de l'amis
				$liste[]=array($nom, $email);
				$liste_s=serialize($liste);
				
			$q2="UPDATE ".PREFIX."buddylist SET `".$groupe."` = '".$liste_s."' WHERE id_membre=".$id_mbre;

		}
		else
		{
			
			$liste=array(array($nom, $email));
			$liste_s=serialize($liste);
			
			$q2="INSERT INTO ".PREFIX."buddylist (`id_membre`,`".$groupe."`) VALUES (".$id_mbre.", '".$liste_s."')";
		}
		return $this->sql->query($q2);
		
	}
	
	// Supprime le contact désigné par son adresse email dans un groupe définis.
	public function supprimer($email, $groupe, $id_mbre=false){
		
		$id_mbre=($id_mbre===false) ? $_SESSION['sess_id'] : (int)$id_mbre;
		if (!preg_match('#^(f|h|p1|p2)$#', $groupe)) $groupe='p2';		

		// Email valide ?
		if (!$this->mbre->valider_email($email)) return "email_invalide";
			
		$q="SELECT ".$groupe." as gp FROM ".PREFIX."buddylist WHERE id_membre=".$id_mbre;
		$sql=$this->sql->query($q);	
		
		if ($this->sql->nb($sql)>0) {
			$d=$this->sql->getRowAssoc($sql);
			$liste=unserialize($d["gp"]);
			
			if (count($liste)>0) {
				foreach($liste as $key=>$val) {
					if ($val[1]==Fonctions::addBdd(strtolower($email))) {
						unset($liste[$key]);
						
						$liste_s=serialize($liste);
						$q2="UPDATE ".PREFIX."buddylist SET `".$groupe."` = '".$liste_s."' WHERE id_membre=".$id_mbre;
						return $this->sql->query($q2);
					}
				}
			}
			
		}
		return false;
	}
	
	
	// Récupère la liste ( nom/email ) de tous les contacts d'un membre
	public function recup_tous($id_mbre=false) {
		
		$id_mbre=($id_mbre===false) ? $_SESSION['sess_id'] : (int)$id_mbre;
		
		$q="SELECT * FROM ".PREFIX."buddylist WHERE id_membre=".$id_mbre;
		$sql=$this->sql->query($q);	
		
		if ($this->sql->nb($sql)>0) {
			$d=$this->sql->getRowAssoc($sql);
			return array("h"=>unserialize($d["h"]), "f"=>unserialize($d["f"]), "p1"=>unserialize($d["p1"]), "p2"=>unserialize($d["p2"]));
		}
		
		return false;
	}
	
	// Récupère les emails d'un groupe spécifié
	public function recup_groupe($groupe, $id_mbre=false) {
		
		$id_mbre=($id_mbre===false) ? $_SESSION['sess_id'] : (int)$id_mbre;
		if (!preg_match('#^(f|h|p1|p2)$#', $groupe)) $groupe='p2';	
		
		$q="SELECT $groupe as gp FROM ".PREFIX."buddylist WHERE id_membre=".$id_mbre;
		$sql=$this->sql->query($q);
		
		if ($this->sql->nb($sql)>0) {
			$d=$this->sql->getObject($sql);
			$liste_temp=unserialize($d->gp);
			
			$liste=array();
			foreach ($liste_temp as $key=>$val) {
				$liste[]=$val[1];
			}
			
			return $liste;
		}
		return false;
	}
	
/*
	
	public function email_tous($id_mbre=false);
	public function email_groupe($groupe, $id_mbre=false);*/


	
	/* ----------------------- PRIVATE ----------------------- */
	
	private $main;
	private $sql;
	private $design;
	private $mbre;
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->sql;
		$this->design = $main->design;
		$this->mbre=$main->mbre;
		
	}	
	

}

?>