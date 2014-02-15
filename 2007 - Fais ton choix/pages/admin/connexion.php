<?php

	$pseudo=strtolower(addBdd($_POST['pseudo']));
	$pass=strtolower(addBdd($_POST['pass']));
	$passcrypt = crypt( md5($pass) , CLE );
	
	if (connexion($pseudo, $passcrypt)) 
		header('location: ?admin-accueil');
	else
		header('location: ?admin-accueil&error=1');
		
?>