<?php

switch($_GET['code']) {
	case "01":
		$erreur="Vous n'êtes pas enregistré ! <br><br>Veuillez vous connecter pour accéder à votre espace personnel";
	break;
	case "02":
		$erreur="L'adresse Ip utilisé lors de votre connexion n'est plus la même que celle avec laquelle vous tentez d'accéder à cette page.<br><br><b>Par mesure de sécurité, vous avez été déconnecté</b><br><br>Merci de bien vouloir vous reconnecter avec vos indentifiants.";
	break;
	case "03":
		$erreur="Vous n'êtes pas autorisé à afficher cette page directement..";
	break;
	case "04":
		$erreur="Erreur lors de l'authentification !";
	break;
	case "05":
		$erreur="L'utilisateur indiqué n'existe pas !";
	break;
	case "06":
		$erreur="Aucun membre n'entre dans les critères de sélection de cette catégorie/recherche.";
	break;
	case "07":
		$erreur="Recherche incorrecte !";
	break;
	case "08":
		$erreur="<u>Erreur</u> : correspondance introuvable dans le champs `search_secure` ";
	break;
	case "09":
		$erreur="Vous ne pouvez pas visionner ce profil, le compte n'a pas encore été activé ! ";
	break;
	case "10":
		$erreur="Ce membre a décidé de cloturer son compte sur Mon-Look";
	break;
}

	head();
	echo '<br><br>
	<div class="erreur">
		'.$erreur.'</div><img src="images/px.gif" height="150" width="1">';
	foot();

?>
