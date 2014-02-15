<?php

$login=strtolower($_POST['login']);
$pass_md5=md5($_POST['pass']);
$ip = $_SERVER['REMOTE_ADDR'];

if(empty($_POST['pass']) OR empty($_POST['login'])) rediriger("?page=news");

($_POST['page']=='fonc/identification') ? $redir_page="news" : $redir_page=$_POST['page'];
($_POST['page']=='') ? $redir_page="news" : $redir_page=$_POST['page'];

	$sql = mysql_query("SELECT * FROM ix_membres WHERE pseudo='".$login."' AND active=1");
	$result = mysql_fetch_object($sql);
	
	if ( $result->pass==$pass_md5) 
	{
				$_SESSION['sess_id']= $result->id;
				$_SESSION['sess_pseudo'] = $login;
				$_SESSION['sess_theme'] = $result->theme;
				$_SESSION['sess_niveau']= $result->niveau;
				$dateheure = date("Y-m-d H:m:s");
				$rq = 'UPDATE ix_membres  SET last_visite="'.$dateheure.'", last_ip="'.$ip.'", nb_con=nb_con+1 WHERE pseudo="'.$login.'" ';
				$sql = mysql_query($rq);
				
				rediriger("?page=$redir_page");
				
	} else {
	
			$texte="Une erreur lors de la connexion à votre compte est survenue.<br><br> 
					Veuillez vérifiez votre <b>Login</b> et votre <b>Mot de passe</b>.<br>
					Si vous n'avez pas encore activer votre compte via l'email, vous ne pouvez pas vous connecter.<br><br>";

			$afficher->AddSession($handle, "contenu");
       		$afficher->setVar($handle, "contenu.module_titre", "Erreur d'identification");
			$afficher->setVar($handle, "contenu.module_texte", $texte );
            $afficher->CloseSession($handle, "contenu"); 
				
	}


?>