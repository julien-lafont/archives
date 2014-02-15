<?php

class Questionnaires
{
	

	
	/* ----------------------- FONCTIONS PUBLIQUES ------------------------------- */
	

	
	public function apercu($id=false, $resume=true, $nb=100) {
		
		//> Un seul questionnaire
		if ($id) {
			$id=(int)$id;
			$q="SELECT * FROM ".PREFIX."form_type WHERE id_form_type='$id'";
			$d=$this->sql->getRowAssoc($this->sql->query($q));
		}
		
		//> Plusieurs questionnaires
		else
		{
			$q="SELECT * FROM ".PREFIX."form_type ORDER BY ordre ASC LIMIT 0,".$nb;
			$d=$this->sql->GetAllArray($this->sql->query($q));
		}
		
		//> Affichage résumé des questions
		if ($resume) {
			
			// Cas de plusieurs enregistrements
			if (!$id) {
				
				// On récupère dans le contenu sérializé le contenu des questions types
				foreach ($d as $cle_c=>$val_c) {
					$contenu=unserialize($val_c["contenu"]);
					
					foreach ($contenu as $cle=>$val) {
						if(is_int($val)) {
							$id=(int)$val;
							$q2="SELECT * FROM ".PREFIX."quest_type WHERE id_quest_type='$id'";
							$d[$cle_c]["contenu_complet"][$cle]=$this->sql->getRowAssoc($this->sql->query($q2));
						}
						else
						{
							$d[$cle_c]["contenu_complet"][$cle]=$val;
						}
					}
				}
				
				// On transforme les array du contenu complet en code HTML
				foreach ($d as $cle=>$vl_) {
					$d[$cle]["html"]=$this->array2Html($d[$cle]["contenu_complet"]);
				}
			
			}
			
			// Cas d'un seul enregistrement
			else {
			
				$contenu=unserialize($d["contenu"]);
				foreach ($contenu as $cle=>$val) {
					if(is_int($val)) {
						$id=(int)$val;
						$q2="SELECT * FROM ".PREFIX."quest_type WHERE id_quest_type='$id'";
						$d["contenu_complet"][$cle]=$this->sql->getRowAssoc($this->sql->query($q2));
					}
					else
					{
						$d["contenu_complet"][$cle]=$val;
					}
				}	
				$d["html"]=$this->array2Html($d["contenu_complet"]);
			}
		}
		return $d;
	}
	
	
	
	public function ajouter_form_membre_noperso($id_form_type, $donnees) {
		
		$donnees=fonctions::addBdd($donnees);
		
		$form=$this->apercu($id_form_type, true);
		$infos_form=serialize($form["contenu_complet"]);
		
		$q="INSERT INTO ".PREFIX."form_membre (`id_membre`,`contenu`,`description`,`nom`,`prive`) VALUES ('".$_SESSION["sess_id"]."', '".$infos_form."', '".$donnees['message']."', '".$donnees['nom']."', '".$donnees['prive']."')";
		$r=$this->sql->query($q);
		
		if (!$r) {
			$this->design->assign("nomErreur", "Erreur dans l'enregistrement du formulaire");
			$this->design->assign("descErreur", "Une erreur est survenue durant l'enregistrement de votre formulaire");
			$this->design->template("erreur");	
		}
		
		return $r;
	}
	
	
	
	public function mes_quest($id=false, $resume=true, $nb=100) {
		//> Un seul questionnaire
		if ($id) {
			$id=(int)$id;
			$q="SELECT * FROM ".PREFIX."form_membre WHERE id_form_membre='$id'";
			$d=$this->sql->getRowAssoc($this->sql->query($q));
		}
		
		//> Plusieurs questionnaires
		else
		{
			$q="SELECT * FROM ".PREFIX."form_membre LIMIT 0,".$nb;
			$d=$this->sql->GetAllArray($this->sql->query($q));
		}
		
		//> Affichage résumé des questions
		if ($resume) {
			
			// Cas de plusieurs enregistrements
			if (!$id) {
				
				// On récupère dans le contenu sérializé le contenu des questions types
				foreach ($d as $cle_c=>$val_c) {
					$contenu=unserialize($val_c["contenu"]);
					
					foreach ($contenu as $cle=>$val) {
						if(is_int($val)) {
							$id=(int)$val;
							$q2="SELECT * FROM ".PREFIX."quest_type WHERE id_quest_type='$id'";
							$d[$cle_c]["contenu_complet"][$cle]=$this->sql->getRowAssoc($this->sql->query($q2));
						}
						else
						{
							$d[$cle_c]["contenu_complet"][$cle]=$val;
						}
					}
				}
				
				// On transforme les array du contenu complet en code HTML
				foreach ($d as $cle=>$vl_) {
					$d[$cle]["html"]=$this->array2Html($d[$cle]["contenu_complet"]);
				}
			
			}
			
			// Cas d'un seul enregistrement
			else {
			
				$contenu=unserialize($d["contenu"]);
				foreach ($contenu as $cle=>$val) {
					if(is_int($val)) {
						$id=(int)$val;
						$q2="SELECT * FROM ".PREFIX."quest_type WHERE id_quest_type='$id'";
						$d["contenu_complet"][$cle]=$this->sql->getRowAssoc($this->sql->query($q2));
					}
					else
					{
						$d["contenu_complet"][$cle]=$val;
					}
				}	
				$d["html"]=$this->array2Html($d["contenu_complet"]);
			}
		}
		return $d;		
	}
	
	
	public function maj_form_membre($inconnu) {
		
	}
	
	public function suppr_form_membre($inconnu) {
		
	}
	
	public function possede_quest($id_quest, $id_mbre) {
		$q="SELECT count(id_form_membre) as nb FROM ".PREFIX."form_membre WHERE id_form_membre=".(int)$id_quest." AND id_membre=".(int)$id_mbre;
		$d=$this->sql->getObject($this->sql->q($q));
		return $d->nb>0;
	}
	
	
	public function diffuser ($id_quest, $mails, $message) {
		if (!$this->possede_quest($id_quest, $_SESSION['sess_id'])) return "hack_attempt";
		
	}
	
	
	/* ----------------------------- ADMIN ------------------------------------- */
	
	function ajouter_quest_type($inconnu) {
		
	}
	
	function ajouter_form_type($inconnu) {
		
	}
	
	function maj_quest_type($inconnu) {
		
	}
	
	function maj_form_type($inconnu) {
		
	}
	
	
	
	/* ----------------------- PRIVATE ----------------------- */
	
	private $main;
	private $sql;
	private $design;
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->sql;
		$this->design = $main->design;
		
	}	
	
	private function array2Form($array=false, $serialize=false) {
		
		if ($array===false && $serialize===false) return 0;
		else if ($array===false) {
			$array=unserialize($serialize);
		}
		$r="";
		
		foreach ($array as $key=>$val) {
			if (is_array($val)) {
		   		switch($val["type"]) {
				   case "input":
				     $r.='<label for="quest_'.$val["id"].'">
					 		<input type="text" id="quest_'.$val["id"].'" value="'.$val["valeur"].'" />
					      </label><br /><br />';
				   break;
				
				   case "textarea":
				   break;
				
				   case "multiple":
				   break;
				
				   case "ouinon":
				   break;
				 
				   case "note":
				   break;
				
				   case "slider":
				   break;
		   		}
		 	}
			else // is_string
			{
				$r.="<h3>$val</h3>";
			}
		}	
		
		return $r;
	}
	
	private function array2Html($array=false, $serialize=false) {
		
		// Utilisation de la fonction avec un array ou avec un serialize;
		if ($array===false && $serialize===false) return 0;
		else if ($array===false) {
			$array=unserialize($serialize);
		}
		$r="";
		
		foreach ($array as $key=>$val) {
			if (is_array($val)) {
				
				$r.='<strong>'.fonctions::recupBdd($val["intitule"]).'</strong>';
				
		   		switch($val["type"]) {
				   case "input":
				     $r.='<span>(réponse libre)</span><br />';
				   break;
				   case "textarea":
				     $r.='<span>(réponse sur plusieurs lignes)</span><br />';
				   break;
				
				   case "multiple":
				   	   $reps=unserialize($val["valeur"]); $rep_possibles="";
				   	   foreach ($reps as $rep ) {
							$rep_possibles.=$rep.", ";
						} 
						$rep_possibles=substr($rep_possibles, 0, -2);
				   	    $r.='<span>(réponses possibles : '.$rep_possibles.')</span><br />';	
				   break;
				
				   case "ouinon":
				   		$r.='<span>(oui/non avec commentaire possible)</span><br />';
				   break;
				 
				   case "note":
				   		$r.='<span>(Note entre 0 et 10)</span><br />';
				   break;
				
				   case "slider":
				   		$reps=unserialize($val["valeur"]);
				   		$r.='<span>(réponse avec un slider oscilant entre "'.$reps[0].'" et "'.$reps[1].'")</span><br />';
				   		//BUG:Penser à faire ce serialize
				   break;
		   		}
		 	}
			else // is_string
			{
				$r.="<h3>$val</h3>";
			}
		}	
		
		return $r;		
		
	}
	
	private function html2array($html) {
		
		function getAttribute($noeud, $name){
    		$attrs = $noeud->attributes();
    		return $attrs[$name];
		}

		$xml=simplexml_load_string($string);
		if ($xml===false) return error_xml;
		
		$r=array(); $id_quest=0;
		foreach ($xml as $noeud=>$val) {
		  if ($noeud=="t") $r[]=(string)$val;
		  else {
		   $id=(int)getAttribute($val, "id");
		   $q='SELECT * FROM '.PREFIX.'quest_type WHERE id_quest_type="'.$id.'"';
		   $d=$sql->getObject($sql->query($q)); //BUG:Requete sql à tester
		   $r[]=array("id"=>$id_quest++, "nom"=>(string)$val[0], "type"=>$d->type, "valeurs"=>(unserialize($d->valeurs)===false) ? $d->valeurs : unserialize($d->valeurs));
		  }
		}
		
		return serialize($r);
	}	
}

?>