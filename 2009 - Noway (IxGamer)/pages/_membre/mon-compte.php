<?php

securite_membre();

$design->zone('titrePage', 'Editer les infos de mon compte');
$design->zone('titre', 'Mes infos');
$design->zone('header', '<script type="text/javascript" src="javascript/-inscription.js"></script>');

switch(@$_GET['action']) {

default:

	$sql=mysql_query("	SELECT * 
						FROM ".PREFIX."membres m
						LEFT JOIN ".PREFIX."membres_detail md
						ON m.id=md.id_membre
						WHERE m.id=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	// On prépare certaines infos //
	if ($d->gen_sexe=="h") 	$h="selected";
	else					$f="selected";
	
	if (file_exists(CHEMIN_PAYS.$d->gen_pays.'.gif')) $drapeau='<img src="'.CHEMIN_PAYS.$d->gen_pays.'.gif" style="vertical-align:middle" />';
	
	if (isset($_SESSION['sess_mess_profil'])) {
		$message="<span style='color:#FF6600'>Les informations de votre compte ont été modifiées avec succés !</span>";
		unset($_SESSION['sess_mess_profil']);
	} else {
		$message="<b>Utilisez ce formulaire pour modifier les informations publiques de votre compte.</b>";
	}
	
	$contenu='	<div id="infoInscription">
					'.$message.'<br /><br />
				</div>	
				
				<form id="mon-compte" name="modif_infos" method="post" enctype="multipart/form-data" action="membre/mon-compte/edit/">
				
				<fieldset id="form">
					<legend>Infos générales</legend>
				
						<table class="table_compte">
							<tr>
								<td class="left" style="width:150px"><b>Mot de passe</b></td>
								<td><img src="images/admin/cadenas.png" style="vertical-align:middle"/> <img src="images/puce1.gif" /> <em id="lienPass"><a href="#" onclick="affWindowsPass(); return false" class="lien_moncompte">Modifier mon mot de passe</a></em></td>
							</tr>
							<tr>
								<td class="left"><label for="nom">Nom</label></td>
								<td><input type="text" name="nom" id="nom" value="'.recupBdd($d->gen_nom).'" maxlength="50" /></td>
							</tr>
							<tr>
								<td class="left"><label for="prenom">Prénom</label></td>
								<td><input type="text" name="prenom" id="prenom" value="'.recupBdd($d->gen_prenom).'" maxlength="50" /></td>
							</tr>
							<tr>
								<td class="left"><label for="pays">Pays</label></td>
								<td><select name="pays" id="pays">
									<option value="" selected> &nbsp; &nbsp; /</option>
									'.liste_pays('nom', recupBdd($d->gen_pays)).'
									</select> '.@$drapeau.'</td>
							</tr>
							<tr>
								<td class="left"><label for="ville">Ville</label></td>
								<td><input type="text" name="ville" id="ville" value="'.recupBdd($d->gen_ville).'" maxlength="250" /></td>
							</tr>
							<tr>
								<td class="left"><label for="date_naiss">Date de naissance</label></td>
								<td><input type="text" name="date_naiss" id="date_naiss" value="'.recupBdd(inverser_date($d->gen_date_naiss, 2)).'" maxlength="50" /></td>
							</tr>
							<tr>
								<td class="left"><label for="sexe">Sexe</label></td>
								<td><select name="sexe" id="sexe">
									  <option value="h" '.@$h.'>Homme</option>
									  <option value="f" '.@$f.'>Femme</option>
									</select>
								</td>
							</tr>
						</table>
				</fieldset>
				
				<fieldset id="form">
					<legend>Infos contact</legend>
					
					<table class="table_compte">
						<tr>
							<td style="width:150px" class="left"><label for="msn">Msn</label></td>
							<td><input type="text" name="msn" id="msn" value="'.recupBdd($d->c_msn).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="site">Site internet</label></td>
							<td><input type="text" name="site" id="site" value="'.recupBdd($d->c_site).'" maxlength="250" onblur="verifSite(this.id)" /></td>
						</tr>
						<tr>
							<td class="left"><label for="blog">Blog</label></td>
							<td><input type="text" name="blog" id="blog" value="'.recupBdd($d->c_blog).'" maxlength="250" onblur="verifSite(this.id)" /></td>
						</tr>
						<tr>
							<td class="left"><label for="irc">Chan IRC</label></td>
							<td><input type="text" name="irc" id="irc" value="'.recupBdd($d->c_irc).'" maxlength="250" /></td>
						</tr>			
					</table>
				</fieldset>
	
				
				<fieldset id="form">
					<legend>Infos Hardware</legend>
					
					<table class="table_compte">
						<tr>
							<td class="left" style="width:150px"><label for="cpu">CPU</label></td>
							<td><input type="text" name="cpu" id="cpu" value="'.recupBdd($d->h_cpu).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="ram">Mémoire RAM</label></td>
							<td><input type="text" name="ram" id="ram" value="'.recupBdd($d->h_ram).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="stockage">Stockage</label></td>
							<td><input type="text" name="stockage" value="'.recupBdd($d->h_stockage).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="carte_graph">Carte graphique</label></td>
							<td><input type="text" name="carte_graph" id="carte_graph" value="'.recupBdd($d->h_carte_graph).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="carte_son">Carte son</label></td>
							<td><input type="text" name="carte_son" id="carte_son" value="'.recupBdd($d->h_carte_son).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="clavier">Clavier</label></td>
							<td><input type="text" name="clavier" id="clavier" value="'.recupBdd($d->h_clavier).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="souris">Souris</label></td>
							<td><input type="text" name="souris" id="souris" value="'.recupBdd($d->h_souris).'" maxlength="250" /></td>
						</tr>					
						<tr>
							<td class="left"><label for="moniteur">Moniteur</label></td>
							<td><input type="text" name="moniteur" id="moniteur" value="'.recupBdd($d->h_moniteur).'" maxlength="250" /></td>
						</tr>					
						<tr>
							<td class="left"><label for="ecouteur">Ecouteur/HP</label></td>
							<td><input type="text" name="ecouteur" id="ecouteur" value="'.recupBdd($d->h_ecouteur).'" maxlength="250" /></td>
						</tr>					
					</table>
				</fieldset>
	
	
				<fieldset id="form">
					<legend>Infos Software</legend>
					
					<table class="table_compte">
						<tr>
							<td class="left" style="width:150px"><label for="connexionn">Connexion</label></td>
							<td><input type="text" name="connexion" id="connexionn" value="'.recupBdd($d->s_connexion).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="fai">FAI</label></td>
							<td><input type="text" name="fai" id="fai" value="'.recupBdd($d->s_fai).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="resolution">Résolution</label></td>
							<td><input type="text" name="resolution" id="resolution" value="'.recupBdd($d->s_resolution).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="os">OS</label></td>
							<td><input type="text" name="os" id="os" value="'.recupBdd($d->s_os).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="jeux">Jeux préféré</label></td>
							<td><input type="text" name="jeux" id="jeux" value="'.recupBdd($d->g_jeux).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="map">Map préférée</label></td>
							<td><input type="text" name="map" id="map" value="'.recupBdd($d->g_map).'" maxlength="250" /></td>
						</tr>
						<tr>
							<td class="left"><label for="arme">Arme préférée</label></td>
							<td><input type="text" name="arme" id="arme" value="'.recupBdd($d->g_arme).'" maxlength="250" /></td>
						</tr>					
						<tr>
							<td class="left"><label for="sens">Sensibilité inGame</label></td>
							<td><input type="text" name="sens" id="sens" value="'.recupBdd($d->g_sens).'" maxlength="250" /></td>
						</tr>					
						<tr>
							<td class="left"><label for="clan">Team</label></td>
							<td><input type="text" name="clan" id="clan" value="'.recupBdd($d->g_clan).'" maxlength="250" /></td>
						</tr>					
					</table>
				</fieldset>		
	
	
				<fieldset id="form">
					<legend>Visuels et descriptions</legend>
					
					<table class="table_compte">
						<tr>
							<td class="left" style="width:150px"><b>Avatar</b></td>
							<td><img src="images/admin/perso9.gif" style="vertical-align:middle"/> <img src="images/puce1.gif" /> <em id="lienAvatar"><a href="#" onclick="affWindowsAvatar(); return false;" style="border-bottom:1px dotted #06F">Uploader un avatar</a></em></td>
						</tr>
						<tr>
							<td class="left" style="width:150px"><b>Config</b></td>
							<td><img src="images/admin/make.png" style="vertical-align:middle"/> <img src="images/puce1.gif" /> <em id="lienConfig"><a href="#" onclick="affWindowsConfig(); return false;" style="border-bottom:1px dotted #06F">Uploader votre config cs</a></em></td>
						</tr>
						<tr>
							<td class="left"><label for="signature">Signature</label></td>
							<td><textarea name="signature" id="signature" />'.recupBdd($d->signature).'</textarea></td>
						</tr>
						<tr>
							<td class="left"><label for="description">Petite description</label></td>
							<td><textarea name="description" id="description" />'.recupBdd($d->description).'</textarea></td>
						</tr>
					</table>
				
				</fieldset>
			<div id="form">
				<input type="submit" value="modifier mes infos" class="submit" style="margin-left:133px; width:130px" /><br /><br />
			</div>
			</form>';

	$design->zone('contenu', $contenu);

break;
###########################################################################################
#####   Editer mon compte : Vérification et enrgistrement                             #####
###########################################################################################
case "edit":


	if (!$_POST) {
		bloquerAcces('Accés interdit !');
	}
	
	$_nom=addBdd($_POST['nom']);
	$_prenom=addBdd($_POST['prenom']);
	$_pays=addBdd($_POST['pays']);
	$_ville=addBdd($_POST['ville']);
	$_sexe=addBdd($_POST['sexe']);
	$_date_naiss=addBdd($_POST['date_naiss']);
	$_msn=addBdd($_POST['msn']);
	$_site=addBdd($_POST['site']);
	$_blog=addBdd($_POST['blog']);
	$_irc=addBdd($_POST['irc']);
	$_cpu=addBdd($_POST['cpu']);
	$_ram=addBdd($_POST['ram']);
	$_stockage=addBdd($_POST['stockage']);
	$_carte_graph=addBdd($_POST['carte_graph']);
	$_carte_son=addBdd($_POST['carte_son']);
	$_clavier=addBdd($_POST['clavier']);
	$_souris=addBdd($_POST['souris']);
	$_moniteur=addBdd($_POST['moniteur']);
	$_ecouteur=addBdd($_POST['ecouteur']);
	$_connexion=addBdd($_POST['connexion']);
	$_resolution=addBdd($_POST['resolution']);
	$_os=addBdd($_POST['os']);
	$_fai=addBdd($_POST['fai']);
	$_map=addBdd($_POST['map']);
	$_arme=addBdd($_POST['arme']);
	$_sens=addBdd($_POST['sens']);
	$_jeux=addBdd($_POST['jeux']);
	$_clan=addBdd($_POST['clan']);
	//$_avatar=addBdd($_POST['avatar']);
	$_signature=addBdd($_POST['signature']);
	$_description=addBdd($_POST['description']);

	// On règle les champs nécessitant une modification
	$newDate=inverser_date($_date_naiss, 2);

	/*`avatar`='$_avatar',*/
	$sql=mysql_query("	UPDATE ".PREFIX."membres_detail
						SET
							`gen_nom`='$_nom',
							`gen_prenom`='$_prenom',
							`gen_pays`='$_pays',
							`gen_date_naiss`='$newDate',
							`gen_sexe`='$_sexe',
							`gen_ville`='$_ville',
							`c_msn`='$_msn',
							`c_blog`= '$_blog',
							`c_site`= '$_site',
							`c_irc`='$_irc', 
							`h_cpu`='$_cpu',
							`h_ram`='$_ram',
							`h_stockage`='$_stockage',
							`h_carte_graph`='$_carte_graph',
							`h_carte_son`='$_carte_son',
							`h_clavier`='$_clavier',
							`h_souris`='$_souris',
							`h_moniteur`='$_moniteur',
							`h_ecouteur`='$_ecouteur',
							`s_connexion`='$_connexion',
							`s_resolution`='$_resolution',
							`s_os`='$_os',
							`s_fai`='$_fai',
							`g_map`='$_map',
							`g_arme`='$_arme',
							`g_sens`='$_sens',
							`g_jeux`='$_jeux',
							`g_clan`='$_clan',
							`signature`= '$_signature',
							`description`='$_description'
						WHERE id_membre=".$_SESSION['sess_id'] );
							
	if ($sql) {
		$_SESSION['sess_mess_profil']="modif";
		header('location: '.URL.'membre/mon-compte/');
	} else {
		$contenu=miseenforme('erreur', 'Une erreur est survenue durant la mise à jour des informations de votre compte !<br /><br />'.mysql_error());
	}		
	
	$design->zone('contenu', $contenu);

break;
}
?>