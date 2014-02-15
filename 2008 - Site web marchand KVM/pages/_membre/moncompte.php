<?php
securite_membre();

switch(@$_GET['action']) {

default:

	$c='<div style="text-align:center">
			<strong>Bonjour '.ucfirst($_SESSION['sess_pseudo']).', bienvenu(e) sur votre espace personnel</strong><br /><br />
			Vous pourrez y suivre l\'avancée de vos commandes en cours, garder une trace de toutes vos commandes effectuée via notre site mais surtout enregistrer préalablement vos coordonnées qui nous servirons lors de la livraison.
			<table style="width:80%; margin:30px auto">
				<tr>
					<td style="width:33%; text-align:center"><a href="mon-compte-infos.htm">Coordonnées de livraison</a></td>
					<td style="width:33%; text-align:center"><a href="mon-compte-statut.htm">Suivi de mes commandes</a></td>
					<td style="width:33%; text-align:center"><a href="mon-compte-historique.htm">Historique de mes achats</a></td>
				</tr>
				<tr>
					<td style="width:33%; text-align:center"><br /><a href="mon-compte-infos.htm"><img src="images/membre/ftp.png" alt="livraison" /></a></td>
					<td style="width:33%; text-align:center"><br /><a href="mon-compte-statut.htm"><img src="images/membre/timelist.png" alt="Suivi" /></a></td>
					<td style="width:33%; text-align:center"><br /><a href="mon-compte-historique.htm"><img src="images/membre/cal.png" alt="Historique" /></a></td>
				</tr>
			</table>
		</div><br /><br />';
		
break;

case "modif_devise":

	$id_devise=(int)$_POST['id_devise'];
	
	// Cette devise existe-t-elle ?
	$sqlVerif=mysql_query("SELECT nom FROM ".PREFIX."devises WHERE id_devise=$id_devise");
	$nb=mysql_num_rows($sqlVerif);
		if ($nb!=1) bloquerAcces('Erreur : devise inexistante !');
		
	// Maj de la sql membre
	$sqlMaj=mysql_query("UPDATE ".PREFIX."membres_config SET id_devise=$id_devise WHERE id_membre=".$_SESSION['sess_id']);
	$_SESSION['sess_id_devise']=$id_devise;
	
	header('location: '.$_SERVER['HTTP_REFERER']);

break;

case "infos":
	
	// Sélection des données 
	$sql=mysql_query("	SELECT * 
						FROM ".PREFIX."membres_infos mi
						LEFT JOIN  ".PREFIX."membres m
						ON m.id_membre=mi.id_membre
						WHERE m.id_membre=".$_SESSION['sess_id']) or die(mysql_error());
		extract(recupBdd(mysql_fetch_array($sql)));
		
	// Gestion select/radio : GENRE
	if ($genre=="h") $sG1='checked="checked"';
	else			 $sG2='checked="checked"';
	
	$c= '<form action="mon-compte-infos-modif.htm" method="post" class="f-wrap-1">
			
			<fieldset>
			
			<h3>Modifier les informations de mon compte</h3>
			<div style="text-align:center; margin-bottom:10px">Utilisez ce formulaire pour mettre à jour les informations concernant votre compte sur '.NOM.', et particulièrement vos coordonnées postales.</div>
			
			<h5>Coordonnées postales</h5>
			<label for="genre"><b>Civilité</b> <br />
				<div style="margin:-25px 0 0 225px">	<input name="genre" type="radio" value="h" style="width:15px" tabindex="1" '.$sG1.' /> Monsieur <br />
						<input name="genre" type="radio" value="f" style="width:15px" '.$sG2.' /> Madame<br />
				</div>
			</label>
			
			<label for="nom"><b>Nom</b>
				<input id="nom" name="nom" type="text" class="f-name" tabindex="2" maxlength="50" style="width:130px" value="'.$nom.'" /><br />
			</label>

			<label for="prenom"><b>Prenom</b>
				<input id="prenom" name="prenom" type="text" class="f-name" tabindex="3" maxlength="50" style="width:130px" value="'.$prenom.'" /><br />
			</label>

			<label for="adresse"><b>Adresse postale</b>
				<textarea id="adresse" name="adresse" class="f-comments" rows="4" cols="30" tabindex="4">'.$adresse.'</textarea><br />
			</label>
			
			<label for="cp"><b>Code postal</b>
				<input id="cp" name="cp" type="text" class="f-name" tabindex="5"  maxlength="5" style="width:50px" value="'.$cp.'" /><br />
			</label>

			<label for="ville"><b>Ville</b>
				<input id="ville" name="ville" type="text" class="f-name" tabindex="6" style="width:130px" maxlength="50" value="'.$ville.'" /><br />
			</label>

			<label for="pays"><b>Pays</b>
				<input id="pays" name="pays" type="text" class="f-name" tabindex="7" style="width:130px" maxlength="50" value="'.$pays.'" /><br />
			</label>

			<label for="tel"><b>Téléphone fixe</b>
				<input id="tel" name="tel" type="text" class="f-name" tabindex="8" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$tel.'" /><br />
			</label>
			
			<label for="portable"><b>Téléphone portable</b>
				<input id="portable" name="portable" type="text" class="f-name" tabindex="9" style="width:130px; letter-spacing:1px" maxlength="13" value="'.$portable.'" /><br />
			</label>
			
			<br /><h5>Mon compte '.NOM.'</h5>
			<label for="email"><b>Adresse email</b>
				<input id="email" name="email" type="text" class="f-name" tabindex="10" maxlength="75" value="'.$email.'"/><br />
			</label>
	
			<!--<label for="newsletter"><b>Recevoir la newsletter ?</b>
				<select name="newsletter" id="newsletter" class="f-name" style="width:130px" tabindex="11">
					<option value="none">Non</option>
					<option value="html">Oui, en html</option>
					<option value="txt">Oui, en texte</option>
				</select>
			</label>-->
			
			<br /><br />
			<input type="submit" value="Mettre à jour" class="f-submit" tabindex="12" /><br />

		</fieldset>
		</form>';

break;

case "infos_modif":
	
		// Nombres d'éléments dans la seconde catégorie ( infos membre )
		$nb_elements=1;
		
	// On sépare les donnés envoyées en 2 tableaux :
	$donnes_membres  = addslashes_array( array_slice ($_POST, -$nb_elements), 					true );
	$donnes_postales = addslashes_array( array_slice ($_POST, 0, count($_POST)-$nb_elements), 	true );
	
	// Met à jours les données de la table membres_infos
	$sql1 = majBdd( PREFIX."membres_infos", '`id_membre`='.$_SESSION['sess_id'], $donnes_postales );

	// Met à jours les données de la table membres
	$sql2 = majBdd( PREFIX."membres", '`id_membre`='.$_SESSION['sess_id'], $donnes_membres, array('email') );
	
	header('location: mon-compte-infos.htm');
	
break;
}
	$design->zone('contenu', $c);
	$design->zone('titre', 'Gérer mon compte');

?>