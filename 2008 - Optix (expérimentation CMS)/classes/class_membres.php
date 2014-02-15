<?php

class membres
{
	// Configuration des variables
	private $NOM_COOKIE ;
	
	// Liaison Mysql ( table / champs )
	private $tbl="membres";
	private $chp = array('id'=>'id_membre', 'identifiant'=>'pseudo', 'pass'=>'pass', 'email'=>'email', 'cle'=>'cle', 'droit'=>'groupe', 'ip'=>'last_ip', 'activite'=>'last_activity');
	
	private $main;
	private $sql;
	private $design;
	
	public function __construct($main) {
		$this->main = $main;
		$this->sql = $main->sql;
		$this->design = $main->design;
		
		$this->NOM_COOKIE = fonctions::recode(NOM)."_";
		$this->tbl = PREFIX.$this->tbl;
	}

	private function valider_login($u)
	{
		return (!ereg ("[^A-Za-z,-_,0-9]", $u) && strlen($u) >= 3 && strlen($u) <= 20);
	}
	
	// Retourne VRAI si le pseudo n'est pas déjà utilisé
    public function verif_login($login)
    {
    	$username=$this->formatter_login($login);

    	$q = "SELECT ".$this->chp['identifiant']." FROM ".$this->tbl." WHERE ".$this->chp['identifiant']." = '$username'";
		return ($this->sql->nb($q, true) == 0);
    }


    public function valider_email($address)
    {
    	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";

    	if (strstr($address, '@') && strstr($address, '.')) {
    		if (preg_match($chars, $address))
                return true;
    		else
                return false;
    	} else
            return false;

    }    
	public function verif_email($email)
	{
    	$q = "SELECT ".$this->chp['email']." FROM ".$this->tbl." WHERE ".$this->chp['email']." = '$email'";
    	return ($this->sql->nb($q, true) == 0);
    }   
    
	private function valider_pass($p1, $p2)
	{
		return (strlen($p1) >= 4 && strlen($p1) <= 20 && ($p2===false || $p1==$p2));
	}
	
    public function ajouter_membre($username, $pass1, $pass2=false, $email, $validation=true, $chps_supplementaires)
    {
		
		
		// IP déjà enregistré ?
		$v1= "SELECT ".$this->chp['id']." FROM ".$this->tbl." WHERE ".$this->chp['ip']."='".fonctions::ip()."'";
		if ($this->sql->nb($v1, true)) return "erreur_ip";
		
		// Pseudo incorrect ?
		if (!$this->valider_login($username)) return "erreur_pseudo";
		
		// Pseudo déjà utilisé ?
		if (!$this->verif_login($username)) return "erreur_pseudo_utilise";
		
		// Email incorrect ?
		if (!$this->valider_email($email)) return "erreur_email";
		
		// Email déjà utilisé  ?
		if (!$this->verif_email($email)) return "erreur_email_utilise";
		
		// Passes corrects et identiques
		if (!$this->valider_pass($pass1, $pass2)) return "erreur_pass";
		
		
		//-- Données correctes, on prépare l'enregistrement :
		$user=$this->formatter_login($username);
		$pwd=$this->crypter_pass($pass1);
		$cle=fonctions::GenKey();
		
		$groupe=(int)(boolean)!$validation;
		
		// Gestion des champs supplémentaires
		$chp_suppl=""; $val_suppl="";
		foreach($chps_supplementaires as $chp=>$val) {
			$chp_suppl.=', `'.$chp.'` ';
			$val_suppl.=", '".fonctions::addBdd($val)."' ";
		}
			
		$q="INSERT INTO ".$this->tbl."
				(`".$this->chp['identifiant']."`, `".$this->chp['pass']."`, `".$this->chp['email']."`, `".$this->chp['ip']."`, `".$this->chp['activite']."`, `".$this->chp['cle']."`, `".$this->chp['droit']."` ".$chp_suppl.") 
			VALUES 
				('$user', '$pwd', '$email', '".fonctions::ip()."', '".time()."', '$cle', '$groupe' ".$val_suppl.")";
		if (!$this->sql->query($q)) return "erreur_sql";
		
		if($validation) {
			
			$id=$this->sql->last_id();
			
			// Prévoir d'utiliser une classe email et un template
			$m_message = "
				<html>
				<body>
					Bonjour,<br />
					<br />Vous venez de vous inscrire sur le site ".NOM.", pour confirmer votre inscription, veuillez suivre le lien ci-dessous.						
					<br /><br />
					Vos identifiants de connexion sont :<br />
					Login: $username<br />
					Password: $pass1<br />
					<br />
					<b>Activer mon compte :</b><br/>
					<a href='".URL."valider-compte-$id-$cle.htm'>".URL."valider-compte-$id-$cle.htm</a><br />
					<br />
					Nous vous souhaitons une bonne journée sur ".NOM." !
					<br />Le staff
				</body>
				</html>";
			
			// Envoie du mail
			$m_sujet = "Finalisation de l'inscription au site ".NOM;

			//if (!fonctions::email( $email, $m_sujet, $m_message, '"Inscription '.NOM.'" <robot@'.recode(NOM).'.com>' )) return "erreur_email";
		}
		
    	return TRUE;
    }
    
    
    public function verif_identifiants($login, $pass, $pass_deja_crypter=false)
    {
		
    	$login=$this->formatter_login($login);
		if (!$pass_deja_crypter) $pass=$this->crypter_pass($pass);
		$ip = fonctions::ip();
		
		$q="SELECT ".$this->chp['id']." as id, ".$this->chp['pass']." as mdp 
			FROM ".$this->tbl."
			WHERE ".$this->chp['identifiant']."='$login' AND ".$this->chp['droit'].">=1 AND ".$this->chp['droit']."!=".GROUPE_BAN;
		$sql=$this->sql->query($q);
		$r=$this->sql->getObject($sql);

		if (!($r->mdp==$pass && $r->id!=0 && $this->sql->nb($q, true)>0)) {
			unset($_SESSION['sess_pseudo'], $_SESSION['sess_pass'], $_SESSION['sess_id']);
			setcookie($this->NOM_COOKIE.'login', false, time()-10 , '/');
			setcookie($this->NOM_COOKIE.'pass', false, time()-10 , '/');
			return false;
		} else {
			return true;
		}

    }
    
    public function connexion($login, $pass, $pass_deja_crypter=false) 
	{
		// Identifiants incorrects : on aborde la tentative de connexion
		if (!$this->verif_identifiants($login, $pass, $pass_deja_crypter)) return false;

    	$login=$this->formatter_login($login);
		if (!$pass_deja_crypter) $pwd=$this->crypter_pass($pass);
		else					 $pwd=$pass;

		$s="SELECT ".$this->chp['id']." as id, ".$this->chp['droit']." as droit, ".$this->chp['email']." as email 
			FROM ".$this->tbl." 
			WHERE ".$this->chp['identifiant']."='".$login."' AND ".$this->chp['pass']."='".$pwd."'";
		$sql=$this->sql->query($s);
		$d=$this->sql->getObject($sql);

		$upd="	UPDATE ".$this->tbl." 
				SET ".$this->chp['ip']."='".fonctions::ip()."', ".$this->chp['activite']."='".time()."'
				WHERE ".$this->chp['id']."=".$d->id;
		$this->sql->query($upd);
					
			$_SESSION["sess_pseudo"]=$login;
			$_SESSION["sess_groupe"]=$d->droit;
			$_SESSION["sess_email"]=$d->email;
			$_SESSION["sess_id"]=$d->id;
			$_SESSION["sess_pass"]=$pwd;
			
			setcookie($this->NOM_COOKIE.'login', $login, time() + 60 * 60 * 24 * 100, "/");
			setcookie($this->NOM_COOKIE."pass", $this->crypter_cookie($pwd), time() + 60 * 60 * 24 * 100, "/");

		return true;
	}
    
    public function connexion_cookies()
    {
		if (!$this->est_log()) {
			
			if (isset($_COOKIE[$this->NOM_COOKIE.'login']) && isset($_COOKIE[$this->NOM_COOKIE.'pass'])) {
				$_SESSION['sess_pseudo'] = $_COOKIE[$this->NOM_COOKIE.'login'];
				$_SESSION['sess_pass'] = $this->decrypter_cookie($_COOKIE[$this->NOM_COOKIE.'pass']);
			}
	
			if (isset($_SESSION['sess_pseudo']) && isset($_SESSION['sess_pass'])) {
				if ($this->verif_identifiants($_SESSION['sess_pseudo'], $_SESSION['sess_pass'], true)!==true) {
					unset($_SESSION['sess_pseudo'], $_SESSION['sess_pass'], $_SESSION['sess_id']);
					setcookie($this->NOM_COOKIE.'login', false, time()-10, '/');
					setcookie($this->NOM_COOKIE.'pass', false, time()-10, '/');
					return false;
				}
				else
				{
					$this->connexion($_SESSION['sess_pseudo'], $_SESSION['sess_pass'], true);
					return true;
				}
			}
	
			return false;
		}
    }
    
	
	public function est_log() 
	{
		return isset($_SESSION['sess_id']) && $_SESSION['sess_id']!=0;
		
	}
	
	public function est_admin()
	{
		return isset($_SESSION['sess_id']) && $_SESSION['sess_id']!=0 && $_SESSION['sess_droits']>=GROUPE_ADMIN;
	}
	
	// Vérifie l'accés des membres en vérifiant si leur numéro de groupe est autorisé
	// Utiliser le signe '+' pour indiquer 'et supérieurs', ex : '5+' -> '5,6,7,8' ( 9 = banni )
	// OU alors définir explicitement : "1-2-3-5-8"
	/*public function protection_groupe ($groupes, $ip=true, $bloquer=false) {
	
		// On part avec une valeur positive
		$good=true;
		
		// Si banni
		if ($_SESSION['sess_groupe']==GROUPE_BAN) $good=false;
		
		// Appartient aux groupes ? ( syntaxe avec + puis syntaxe détaillée )
		if (strpos($groupes, "+"))
		{	
			if ($_SESSION['sess_groupe']<$groupes{0}) $good=false;
		}
		else 
		{
			$nb=explode("-", $groupes);
			foreach($nb as $value)
			{
				if ($_SESSION['sess_groupe']==$value && $good) $tempgood=true;
			}
			if (!$tempgood) $good=false;
		}
		
		// Vérification supplémentaire du pseudo
		if (!isset($_SESSION[PREFIX_SESS.'sess_pseudo'])) $good=false;
	
		// Vérification de l'IP si il le faut
		if (ip && $good)
		{
			$v1 = "SELECT ".$this->chp['id']." FROM ".$this->tbl." WHERE ".$this->chp['identifiant']."='" . $_SESSION['sess_pseudo'] . "'";
			$result = mysql_fetch_object(mysql_q($v1));
			if ($result->last_ip != fonctions::ip()) {
				$good=false;
			} 
		}
		
		// Conclusions
		if ($good)
		{
			return true;
		} 
		else 
		{
			if ($bloquer)  return false;
			else		$this->bloquerAcces("Vous n'êtes pas autorisé à afficher cette page.<br />
											 Soit vous n'avez pas les droits suffisants, soit vous n'êtes pas connectés à votre compte.");
		} 
	
	}*/
    
    
/* Vérification de sécurité administrateur avec gestion des droits
	 $droits : Liste des droits nécessaires, syntaxe : "membres billets_redaction billets_edition commentaires configuration" */
public function securite_admin($droits=null) {

	// Vérifie si le membre est admin
    if (!isset($_SESSION['sess_pseudo']) || $_SESSION['sess_groupe']<GROUPE_ADMIN) {
		$this->design->display("_admin/403.tpl"); die();
    } 

	// Protection anti vol de sessions
    $sql = $this->sql->query("SELECT ".$this->chp['ip']." as ip FROM ".$this->tbl." WHERE `".$this->chp['identifiant']."`='" . $_SESSION['sess_pseudo'] . "' AND `".$this->chp['droit']."`>=".GROUPE_ADMIN." AND `".$this->chp['droit']."`!=".GROUPE_BAN);
    $result = $this->sql->getObject($sql);
    if ($result->ip != fonctions::ip() and mysql_num_rows($sql)>0) {
		$this->deconnexion();
		$this->design->display("_admin/403.tpl"); die();
    } 
     

}

    
    public function deconnexion()
    {	
		setcookie($this->NOM_COOKIE.'login', false, time()-10, '/');
		setcookie($this->NOM_COOKIE.'pass', false, time()-10, '/');
		unset($_SESSION); unset($_COOKIE);
		session_destroy();
		return true;

    }
	
   public function activer_compte($id, $cle) {

		if (empty($id) || empty($cle))
		{
			$this->design->assign('nomErreur', "Activation impossible");
			$this->design->assign('descErreur', "Erreur de r&eacute;cup&eacute;ration. $id - $cle");
			$this->design->template("erreur");
		}
		else
		{
		
			$q = "SELECT count(".$this->chp['id'].") as nb FROM ".$this->tbl."  WHERE `".$this->chp['id']."`='".$id."' AND `".$this->chp['cle']."`='".$cle."' AND `".$this->chp['droit']."`='0'";
			$sql=$this->sql->query($q);
			$d=$this->sql->getObject($sql);
			
			if ($d->nb == 1)
				{
					$maj = $this->sql->query("UPDATE ".$this->tbl." SET ".$this->chp['droit']."='1' WHERE `".$this->chp['id']."`='".$id."'");
					
					header("location: accueil.html");
				}
			else
				{
					$this->design->assign('nomErreur', "Activation impossible");
					$this->design->assign('descErreur', "Erreur de correspondance avec la cl&eacute;");
					$this->design->template("erreur");
				}
		}
		
   }
    
   public function infos($id=false) 
   {
 		// Si aucun id n'est définis, on met par défaut l'id du membre connecté
		if ($id===false) $id=$_SESSION['sess_id'];
   		$id=(int)$id;  
		
		$q="SELECT * FROM ".$this->tbl." WHERE ".$this->chp['id']."=".$id;
		$sql=$this->sql->query($q);   // bof bof le *
		return $this->sql->getRowAssoc($sql);
   }
   
   public function infos_par_email($email) 
   {
		$q="SELECT * FROM ".$this->tbl." WHERE ".$this->chp['email']."='".$email."'"; 
		$sql=$m->sql->query($q);  
		return $this->sql->GetAllArray($sql);
   }
   
   	public function maj_infos ($champs, $donnees, $id=false) 
	{
		// Si aucun id n'est définis, on met par défaut l'id du membre connecté
		if ($id===false) $id=$_SESSION['sess_id'];
   		$id=(int)$id;
		
   		$sql="UPDATE ".$this->tbl." SET ";
		foreach($champs as $chp) {
			$sql.="`$chp`='".fonctions::addBdd($donnees[$chp])."', ";
		}
		$sql=substr($sql, 0, -2);
		$sql.=" WHERE id_membre=".$id;	

		return $m->sql->query($sql);  
   }
   
   public function maj_mdp($newPass, $id=false) {

		// Si aucun id n'est définis, on met par défaut l'id du membre connecté
		if ($id===false) $id=$_SESSION['sess_id'];
   		$id=(int)$id;
		   
   		$pass=$this->crypter_pass($newPass);
   		$sql="UPDATE ".$this->tbl." SET `".$this->chp['pass']."`='$pass' WHERE `".$this->chp['id']."`=".$id;
		return $m->sql->query($sql);  
   }
   
   public function supprimer_avatar($id=false) {
   		if ($id===false) $id=$_SESSION['sess_id'];
		$id=(int)$id;
		
		$infos=$this->infos($id);
		$avatar=$infos['avatar'];
		if (!empty($avatar)) {
			@unlink($chemin."/".$avatar);
			$this->maj_infos(array("avatar"), array("avatar", ""), $id);
		}	
		return true;
   }
   
   public function liste_membres() {
   		// A faire si besoin est
   }
    
   private function formatter_login($username)
	{
		return $username=strtolower(trim(fonctions::escape($username)));
	}
	
   public function crypter_pass($pass)
    {
		return crypt(md5($pass), CLE);
	}
   private function crypter_cookie($pass_crypt)
    {
		return 	base64_encode($pass_crypt.fonctions::GenKey(5));
	}
   private function decrypter_cookie($pass) 
    {
		return substr(base64_decode($pass), 0, -5);
	}
	
	public function bloquerAcces($message) {
		$this->design->template("erreur");
		$this->design->assign("nomErreur", "Accés refusé");
		$this->design->assign("descErreur", $message);
		if (defined("AJAX")) {
			Fonctions::echoAjax("Erreur|:|#erreur|:|");
			$this->design->displayAjax('erreur.tpl');
		} else {
			$this->design->display('index.tpl');
		}	
	}
}

?>