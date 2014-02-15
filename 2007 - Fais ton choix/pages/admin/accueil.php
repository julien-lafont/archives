<?php

// Si le membre est déjà connecté
if (securite('4+', true)) {

	if ($_SESSION['sess_level']==4) $grade="animateur";
	if ($_SESSION['sess_level']==5) $grade="administrateur";
	
	$sqlBloc=mysql_query("SELECT blocnote FROM ".PREFIX."blocnote WHERE nom='admin'");
	$d=mysql_fetch_object($sqlBloc);
	
	$c="<h2>Accueil de l'administration</h2>
	
	<p style='margin-left:25px'>Bonjour <span>".ucfirst($_SESSION['sess_pseudo'])."</span>, vous avez le grade <span>$grade</span>.</p>
	<p style='margin-left:25px'>Pour commencer à gérer le site, utilisez le menu situé à droite.
	
	
	
	<br /><br /><h2>Bloc note</h2>
	
	<form id='form' name='form' action='?admin-blocnote' method='post'>
		<textarea name='blocnote' style='margin-left:25px'>".recupBdd($d->blocnote)."</textarea><br /><br />
		<input type='submit' value='&nbsp;&nbsp; modifier &nbsp;&nbsp;' class='submit' style='margin-left:25px'/>
	</form>";

	$design->zone('categorie', 'ACCUEIL');


// Sinon on affiche le formulaire de connexion
} else {

	$c="<h2>Connexion à l'administration</h2>";
	
	if (@$_GET['error']==1) $c.='<span style="color:#FF3300">Identifiants incorrects ! </span><br /><br />';
		
	$c.="<form id='form' action='?admin-connexion' method='post'>
		<table style='width:300px; border:0; margin-left:30px;'>
			<tr>
				<td ><label for='ps'>Pseudo</label></td>
				<td><input type='text' id='ps' name='pseudo' maxlength='255' /></td>
			</tr>
			<tr>
				<td><label for='mdp'>Mot de passe </label></td>
				<td><input type='password' name='pass' maxlength='255' /></td>
			</tr>
			<tr>
				<td colspan='2' style='text-align:center'><input type='submit' value='connexion' class='submit'/></td>
			</tr>
		
		</table>
	</form>";

	$design->zone('categorie', 'CONNEXION');
}
		
$design->template('admin');
$design->zone('contenu', $c);


?>