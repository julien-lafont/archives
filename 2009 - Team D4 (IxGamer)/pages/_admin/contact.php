<?php
securite_admin();

switch(@$_GET['action']) {
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil">&lsaquo; Retour &lsaquo;</a></div>
			
			<br><div id="infoInscription">
				Seuls les actions indispensables sont disponibles pour le moment, de nombreuses autres fonctionnalitées arriveront par le suite.
			</div>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:100%">
			<tr>
			  <td colspan=6 class="liste_header">	Liste des messages :<br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre"><b>&rsaquo; LIRE &lsaquo;</b></td>
			  <td class="liste_titre">Etat</td>
			  <td class="liste_titre">Date</td>
			  <td class="liste_titre">Sujet</td>
			  <td class="liste_titre">Auteur</td>
			  <td class="liste_titre">Classer</td>
		  </tr>';

	$sql = mysql_query("SELECT id, etat, date, sujet, id_membre, nom
						FROM ".PREFIX."contact
						ORDER BY etat ASC, id DESC");		  
	while($d = mysql_fetch_object($sql)) {

		switch($d->etat) {
			default:
			case "a-nouveau": 	$etat="<b style='color:#00A8FF'>NOUVEAU</b>"; break;
			case "b-lu": 	  	$etat="<span style='color:#00A8FF'>Déjà lu</span>"; break;
			case "c-repondu": 	$etat="<span style='color:#FF3300'>Répondu</span>"; break;
			case "d-archive": 	$etat="<span style='color:#FF0000'>Archivé</span>"; break;
		}
		switch($d->sujet) {
			default:
			case "partenariat": $sujet="Partenariat"; break;
			case "recrutement": $sujet="Recrutement"; break;
			case "infos": 		$sujet="Informations"; break;
			case "manager": 	$sujet="Contact Manager"; break;
			case "pbm": 		$sujet="Pbm tech site"; break;
			case "autres": 		$sujet="Autres"; break;
		}
		
		if (isset($d->id_membre)) {
			$sqlMembre=mysql_query("SELECT pseudo FROM ".PREFIX."membres WHERE id=".$d->id_membre);
			$membre=mysql_fetch_object($sqlMembre);
			$auteur='<a href="profil/'.$membre->pseudo.'/">'.ucfirst($membre->pseudo).'</a>';
		} else {
			$auteur=recupBdd($d->nom);
		}
			
		$contenu.= '<tr id="tr'.$d->id.'">
						<td class="liste_txt"><a href="?admin-contact&action=lire&id='.$d->id.'"><img src="images/boutons/fonts.png" style="padding:1px; border:1px solid #ccc"/></a></td>
						<td class="liste_txt">'.$etat.'</td>
						<td class="liste_txt">'.inverser_date($d->date,5).'</td>
						<td class="liste_txt">'.$sujet.'</td>
						<td class="liste_txt">'.$auteur.'</td>
						<td class="liste_txt">
							<select class="mini" id="'.$d->id.'" onchange="classerContact(this)" >
								<option value="" style="color:#FFF; background-color:#00a8FF; text-align:center; font-weight:bold">- Classer -</option>
								<option value="Nouveau">Nouveau</option>
								<option value="Lu">Lu</option>
								<option value="Repondu">Répondu</option>
								<option value="Archiver">Archiver</option>
								<option value="Supprimer">Supprimer</option>
							</select>
						</td>
			   	   </tr>';	
	}
		 
	$contenu.= "</table>";
	
break;
##############################################################################################
##############################################################################################
case "lire":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."contact WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
		switch($d->sujet) {
			default:
			case "partenariat": $sujet="Partenariat"; break;
			case "recrutement": $sujet="Recrutement"; break;
			case "infos": 		$sujet="Informations"; break;
			case "manager": 	$sujet="Contact Manager"; break;
			case "pbm": 		$sujet="Pbm tech site"; break;
			case "autres": 		$sujet="Autres"; break;
		}
		
		switch($d->etat) {
			default:
			case "a-nouveau": 	$etat="Première lecture"; 
								$sql=mysql_query("UPDATE ".PREFIX."contact SET etat='b-lu' WHERE id=$id"); 
			break;
			case "b-lu": 	  	$etat="Déjà lu"; break;
			case "c-repondu": 	$etat="Répondu"; break;
			case "d-archive": 	$etat="Archivé"; break;
		}

		if (isset($d->id_membre)) {
			$sqlMembre=mysql_query("SELECT pseudo, email FROM ".PREFIX."membres WHERE id=".$d->id_membre);
			$membre=mysql_fetch_object($sqlMembre);
			$auteur='<u>Membre</u> - <a href="profil/'.$membre->pseudo.'/">'.ucfirst($membre->pseudo).'</a> - <a href="mailto:'.$membre->email.'">'.$membre->email.'</a>';
		} else {
			$auteur='<u>Invité</u> - '.recupBdd($d->nom).' - <a href="mailto:'.recupBdd($d->email).'">'.recupBdd($d->email).'</a>';
		}

	$contenu='<h2 style="text-align:center">Lire un message </h2><br />
			<b>Sujet : </b> '.$sujet.' <br />
			<b>Date : </b> '.inverser_date($d->date,6).'<br />
			<b>IP : </b> '.$d->ip.'<br />
			<b>Etat actuel : </b> '.$etat.'<br /><br />
			<b>Expéditeur : </b>'.$auteur.'<br /><br />
			<b>Message : </b><br /><br />
			'.nl2br(recupBdd($d->message)).'
			
			<br /><br /><br />
			<center>- <a href="?admin-contact">Retour</a> -</center>';
break;
}
	$design->zone('titrePage', 'Administration Contacts');
	$design->zone('titre', 'Gérer les messages en attente');
	$design->zone('contenu', $contenu);
	$design->zone('header', $header);

?>