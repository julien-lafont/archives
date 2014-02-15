<?php
securite_admin('config');

	$page="?admin-config-general";
	$table=PREFIX."config";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		if ($mess=="modif_ok") $retour=miseEnForme('ok', "Mise à jour effectuée avec succés !");
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM ".$table);
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Configuration</a> / <strong>Configuration du site</strong>';
	
	// Mise en forme du bloc principal
	$c= '
		<form action="'.$page.'&action=modifier" method="post">
		<fieldset>
		
			<table class="table1">
			<tbody>
				<th style="width:40%">Description de la clé</th>
				<th>Valeur</th>
			</tbody>';
	
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));
	
		$c.='<tr>
				<td><label for="'.$cle.'"><strong>'.$description.'</strong></label></td>
				<td><input id="'.$cle.'" name="'.$cle.'" value="'.$valeur.'" type="text" class="f-name" style="width:90%"/></td>
			</tr>';
	}
	
	$c.='	<tr>
				<td colspan="2"><input type="submit" value="Submit" class="f-submit"/></td>
			</tr>
		</table>
	
	</fieldset>
	</form>';
			
break;

case "modifier":

	foreach($_POST as $cle=>$val) {
		
		$val=mysql_real_escape_string($val);
		
		// modification dans la bdd 
		$sql=mysql_query("UPDATE $table SET `valeur`='$val' WHERE `cle`='$cle'");
	}

	header('location: '.$page.'&mess=modif_ok');
	
break;

}	
	
	$design->zone('titre', 'Configuration du site');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);

?>