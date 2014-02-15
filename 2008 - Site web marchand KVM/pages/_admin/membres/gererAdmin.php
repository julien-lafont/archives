<?php
securite_admin('membres');

	$page="?admin-membres-gereradmin";
	$table=PREFIX."membres";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		
		if ($mess=="droits_ok") $retour=miseEnForme('ok', "Les droits de cet admin ont été modifiés avec succés");	
		if ($mess=="annuler_ok") $retour=miseEnForme('ok', "Le grade d'admin a été retiré à cet utilisateur");	
		$design->zone('retour', $retour);
	}
	
switch(@$_GET['action']) {


default:
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gerer">Gestion des membres</a> / <strong>Gestion des admins</strong>';
	
	// On effectue la requête
	$sql=mysql_query("	SELECT *
						FROM $table m
						LEFT JOIN ".PREFIX."membres_infos mi
						ON mi.id_membre=m.id_membre		
						WHERE m.groupe>4
						ORDER BY m.id_membre DESC") or die(mysql_error());
						
	while($d=mysql_fetch_array($sql)) {
		
		// On récupère les données 
		extract(recupBdd($d));	
		
		$c.= '<table class="table_3">
				<tr>
					<td class="g"><h5>Membre <span>#'.$id_membre.'</span></h5>
						<ul>
							<li><strong>Pseudo</strong> : '.$pseudo.'</li>
							<li><strong>Nom</strong> : '.$nom.'</li>
							<li><strong>Prénom</strong> : '.$prenom.'</li>
						</ul>
					</td>
					
					<td class="c"><h5>Contact</h5><br />
						<ul>
							<li><strong>Tel</strong> : '.$tel.'</li>
							<li><strong>Portable</strong> : '.$portable.'</li>
							<li><strong>Email</strong> : '.$email.'</li>
						</ul>
					</td>
					
					<td class="d"><h5>Actions</h5><br />
						<div class="boutonBlanc"><a href="?admin-membres-gererAdmin&action=droits&id='.$id_membre.'">Editer les droits</a></div>
						<div class="boutonBlanc"><a href="?admin-membres-gererAdmin&action=annulerAdmin&id='.$id_membre.'">Définir comme membre</a></div>
					</td>
				</tr>
			</table>';
	
	}		

break;

case "droits":
	
	$id=(int)$_GET['id'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."admins_droits WHERE id_admin=".$id);
	extract(mysql_fetch_array($sql));
	
	$fil_ariane='<a href="?admin-accueil">Admin</a> / <a href="#">Membres</a> / <a href="?admin-membres-gererAdmin">Gestion des admin</a> / <strong>Gestion des admins</strong>';

	// On gère les droits
	if ($droit_membres==1) $a1='checked="checked"';
	else				   $a0='checked="checked"';

	if ($droit_editorial==1) $b1='checked="checked"';
	else				     $b0='checked="checked"';
	
	if ($droit_gestion_commandes==1) $c1='checked="checked"';
	else				  			 $c0='checked="checked"';
	
	if ($droit_config==1)  $d1='checked="checked"';
	else				   $d0='checked="checked"';	
	
	$c='<form name="droits" method="post" action="'.$page.'&action=droits2&id='.$id.'" class="f-wrap-1">
		<fielset>
			
			<h3>Modifier les droits de cet admin</h3>
			
			<strong>Cet admin peut-il gérer les produits ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" '.@$a1.' name="droit_editorial" /> Oui<br />  
				<input type="radio" value="0" '.@$a0.' name="droit_editorial" /> Non
			</div><br />
			
			<strong>Cet admin peut-il gérer les membres ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" '.@$b1.' name="droit_membres" /> Oui<br />  
				<input type="radio" value="0" '.@$b0.' name="droit_membres" /> Non
			</div><br />
			
			<strong>Cet admin peut-il accéder et gérer les commandes ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" '.@$c1.' name="droit_gestion_commandes" /> Oui<br />  
				<input type="radio" value="0" '.@$c0.' name="droit_gestion_commandes" /> Non
			</div><br />
			
			<strong>Cet admin peut-il accéder à la configuration du site ?</strong><br />
			<div style="margin-left:20px">
				<input type="radio" value="1" '.@$d1.' name="droit_config" /> Oui<br />  
				<input type="radio" value="0" '.@$d0.' name="droit_config" /> Non
			</div><br />
			
			<input type="submit" class="f-submit" value="Mettre à jour" />
						
		</fieldset>
		</form>';
	
break;

case "droits2":
	
	$id=(int)$_GET['id'];
	majBdd(PREFIX."admins_droits", "id_admin=".$id, $_POST);
	
	header('location: '.$page.'&mess=droits_ok');

break;

case "annulerAdmin":

	$id=(int)$_GET['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."membres SET groupe=1 WHERE id_membre=".$id);
	
	header('location: '.$page.'&mess=annuler_ok');
	
break;
}

	$design->zone('titre', 'Gestion des admins');
	$design->zone('fil_ariane', $fil_ariane);
	$design->zone('contenu', $c);
	
?>