<?php

if (isset($_GET['num'])) 
{
	
	$erreur[1]="<br><center>Vous n'avez pas les droits nécessaire pour accéder à cette page ou vous n'êtes pas connecté.</center><br>";
	$erreur[2]="<br><center>L'adresse Ip utilisé lors de votre connexion n'est plus la même que celle avec laquelle vous tentez d'accéder à cette page.<br><br><b>Par mesure de sécurité, vous avez été déconnecté</b><br><br>Merci de bien vouloir vous reconnecter avec vos indentifiants.</center><br><br>";
	
				$afficher->AddSession($handle, "contenu");
				$afficher->setVar($handle, "contenu.module_titre", "Erreur");
				$afficher->setVar($handle, "contenu.module_texte", $erreur[$_GET['num']]);
				$afficher->CloseSession($handle, "contenu"); 

}
?>

