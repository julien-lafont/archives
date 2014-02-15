<?php

securite_membre();

$design->zone('titrePage', 'Messagerie privée');
$design->zone('titre', 'Consulter mes messages');
$design->zone('header', '<script type="text/javascript" src="include/js/-messagerie.js"></script>');

switch(@$_GET['action']) {
default:
	
	$my_id=$_SESSION['sess_id'];

	// Sélection de tous les messages
	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,m.pseudo 
							FROM ".PREFIX."messagerie mp 
							LEFT JOIN ".PREFIX."membres m
							ON mp.id_exped=m.id 
							WHERE mp.id_dest=$my_id 
							ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));

	// Nombre de messages non-lus
	$sql_new=mysql_query("SELECT count(id) as nb FROM ".PREFIX."messagerie WHERE `id_dest`=$my_id AND (`etat`='nouveau' OR `etat`='important' OR `etat`='auto')");
	$d1=mysql_fetch_object($sql_new);
	$nb2=round($d1->nb);
	
	// Facultatif : pluriel et fautes d'horthographes 
	($nb1>1) ? $message="messages" : $message="message";
	($nb2>1) ? $lu="lus" : $lu="lu";
	
	$contenu='		
		<table style="width:100%; border:0; text-align:center" id="messagerieHeader"> 
			<tr>
				<td width="33%"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(this); listeMsg(); return false" title="Voir mes messages" id="lien1"><img src="images/messagerie/mp_in.png" name="img3" onMouseOver= "if (document.images) document.img3.src=\'images/messagerie/mp_in2.png\';" onMouseOut= "if (document.images) document.img3.src=\'images/messagerie/mp_in.png\';"></a></td>
				<td width="34%"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(this); writeMsg(); return false" title="Envoyer un nouveau message" id="lien2"><img src="images/messagerie/mp_ecrire.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/messagerie/mp_ecrire2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/messagerie/mp_ecrire.png\';"></a></td>
				<td width="33%"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(this); listeHist(); return false" title="Voir l\'historique de mes messages envoyés" id="lien3"><img src="images/messagerie/mp_sent.png" name="img2" onMouseOver= "if (document.images) document.img2.src=\'images/messagerie/mp_sent2.png\';" onMouseOut= "if (document.images) document.img2.src=\'images/messagerie/mp_sent.png\';"></a></td>
			</tr>
			<tr>
				<td class="cadre_lien"><div id="menuinbox" style="margin-top:5px"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(\'lien1\'); listeMsg(); return false" style="display:block; width:90%" title="Voir mes messages">Mes messages ('.$nb2.')</a></div></td>
				<td class="cadre_lien"><div id="menuinbox" style="margin-top:5px"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(\'lien2\'); writeMsg(); return false" style="display:block; width:90%" title="Envoyer un nouveau message">Ecrire un message</a></div></td>
				<td class="cadre_lien"><div id="menuinbox" style="margin-top:5px"><a href="#" OnCLick="new Effect.ScrollTo(\'messagerieHeader\', {duration:1, offset:-20}); new Effect.Pulsate(\'lien3\'); listeHist(); return false" style="display:block; width:90%" title="Voir l\'historique de mes messages envoyés">Historique</a></div></td>
		</table><br>';
	
		$contenu.='<div id="messagerie" style="width:100%;">
		<center style="color:#555">Vous avez <span style="color:#FF4F98">'.$nb1.'</span> '.$message.' dont <span style="color:#FF4F98">'.$nb2.'</span> non-'.$lu.'<br><br>
			<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>';
		
		if ($nb1!=0) {
			$contenu.='<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td width="28"> </td>
						<td style="text-align:left; color:#0066FF" width="200">Sujet</td>
						<td width="75" style="color:#0066FF">Auteur</td>
						<td width="75" style="color:#0066FF"><center>Date</td>
						<td width="30"> </td>
					</tr>';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
			
				// Gestion des images
				if ($data->etat=="nouveau") $etat = "icon_new.png";
				if ($data->etat=="important") $etat = "icon_fav.png";
				if ($data->etat=="lu") $etat = "icon_lu.png";
				if ($data->etat=="auto") $etat = "icon_auto.png";
				
				// Modification de la date
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				$contenu.='<tr id="tr'.$data->id.'">
						<td style="border-left:3px solid #0099FF;"><img src="images/messagerie/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" onclick="viewMp('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
						<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
						<td><a href="#" onclick="supprMp('.$data->id.'); return false"><img src="images/messagerie/agt_stop.png"></a></td>
					</tr>';
			}
			
			$contenu.='</table><br>
			<div style="width:408px; padding:2px; border:1px solid #CCC;">
				<img src="images/messagerie/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
				<img src="images/messagerie/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
				<img src="images/messagerie/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
				<img src="images/messagerie/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div>';
		}
		

	$contenu.='</div>
			</div>
				
				<!-- PRELOAD -->
				<div style="display:none"><img src="images/messagerie/mp_in2.png"><img src="images/messagerie/mp_ecrire2.png";><img src="images/messagerie/mp_sent2.png";></div>';
	
	$design->zone('contenu', $contenu);

}
?>