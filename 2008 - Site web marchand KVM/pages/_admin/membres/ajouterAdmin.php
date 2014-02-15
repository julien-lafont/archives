<?php
securite_admin('membres');

	$page="?admin-membres-ajouteradmin";
	$table=PREFIX."membres";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="ajout_ok") $retour=miseEnForme('ok', "Le nouvel admin a été ajouté avec succés");	
		if ($mess=="ajout_bad") $retour=miseEnForme('bad', "Une erreur est survenue durant l'ajout du nouvel admin");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {
	
default:

	$c='<form name="droits" method="post" action="'.$page.'&action=ajouter" class="f-wrap-1">
		<fielset>
			
			<h3>Ajouter un administrateur au site</h3>
			
			<label for="id_admin"><b>Futur admin : </b>
				<select name="id_admin" id="id_admin">';
				
			// Liste des membres
			$sql=mysql_query("SELECT id_membre, pseudo FROM ".PREFIX."membres WHERE groupe=1");
			while ($d=mysql_fetch_object($sql)) {
				$c.='<option value="'.$d->id_membre.'">'.recupBdd($d->pseudo).'</option>';
			}
			$c.='</select></label><br /><br />
			
			<strong>Cet admin peut-il gérer les produits ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" name="droit_editorial" /> Oui<br />  
				<input type="radio" value="0" name="droit_editorial" /> Non
			</div><br />
			
			<strong>Cet admin peut-il gérer les membres ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" name="droit_membres" /> Oui<br />  
				<input type="radio" value="0" name="droit_membres" /> Non
			</div><br />
			
			<strong>Cet admin peut-il accéder et gérer les commandes ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" name="droit_gestion_commandes" /> Oui<br />  
				<input type="radio" value="0" name="droit_gestion_commandes" /> Non
			</div><br />
			
			<strong>Cet admin peut-il accéder à la configuration du site ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" name="droit_config" /> Oui<br />  
				<input type="radio" value="0" name="droit_config" /> Non
			</div><br />
			
			<input type="submit" class="f-submit" value="Ajouter l\'admin" />
						
		</fieldset>
		</form>';

break;

case "ajouter":

	// On récupère les données manuellement
	$id_admin=(int)$_POST['id_admin'];
	$editorial=$_POST['droit_editorial'];
	$membres=$_POST['droit_membres'];
	$gestion_commandes=$_POST['droit_gestion_commandes'];
	$config=$_POST['droit_config'];
	
	// On met le grade admin :
	$sql_1=mysql_query("UPDATE ".PREFIX."membres SET groupe=5 WHERE id_membre=".$id_admin);
	
	// On ajoute les données pour la gestion des droits
	$sql_2=mysql_query("INSERT INTO ".PREFIX."admins_droits 
						( `id_admin` , `droit_membres` , `droit_editorial` , `droit_gestion_commandes` , `droit_config` )
					  VALUES
					  	( $id_admin, $membres, $editorial, $gestion_commandes, $config ) ");
					  	
	if ($sql_1 && $sql_2) { header('location: '.$page.'&mess=ajout_ok'); die(); }
	else				  { header('location: '.$page.'&mess=ajout_bad'); die(); }
	
	
break;
}

	$design->zone('titre', 'Ajouter un admin');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>