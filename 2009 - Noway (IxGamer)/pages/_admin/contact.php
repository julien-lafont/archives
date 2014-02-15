<?php
securite_admin();

switch(@$_GET['action']) {
default:

	$contenu='<div id="curseur" class="infobulle"></div>
	
			<div id="retour"><a href="?admin-accueil"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			
			<br /><br><div id="infoInscription">
				Messages recus via le module contact
			</div>
			
			<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%" align="center">
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
								<option value="nouveau">Nouveau</option>
								<option value="lu">Lu</option>
								<option value="repondu">Répondu</option>
								<option value="archiver">Archiver</option>
								<option value="supprimer">Supprimer</option>
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

	$contenu='<div id="retour"><a href="?admin-contact"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
			<div style="margin-left:25px">
				<h2 style="text-align:center">Lire un message </h2><br />
				<b>Sujet : </b> '.$sujet.' <br />
				<b>Date : </b> '.inverser_date($d->date,6).'<br />
				<b>IP : </b> '.$d->ip.'<br />
				<b>Etat actuel : </b> '.$etat.'<br /><br />
				<b>Expéditeur : </b>'.$auteur.'<br /><br />
				<b>Message : </b><br /><br />
				'.nl2br(recupBdd($d->message)).'
			  </div>
			';
break;
}
	$design->zone('titrePage', 'Administration Contacts');
	$design->zone('titre', 'Gérer les messages en attente');
	$design->zone('contenu', $contenu);
	$design->zone('header', $header);

?>