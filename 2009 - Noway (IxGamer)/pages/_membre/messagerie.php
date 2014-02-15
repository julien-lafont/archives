<?php

securite_membre();

$design->zone('titrePage', 'Messagerie privée');
$design->zone('titre', 'Consulter mes messages');
$design->zone('header', '<script type="text/javascript" src="javascript/-messagerie.js"></script>');

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
		<table style="width:90%; border:0; text-align:center; margin-left:40px" id="messagerieHeader"> 
			<tr>
				<td width="33%"><a href="#" OnClick="listeMsg(); return false" title="Voir mes messages" id="lien1"><img src="images/messagerie/mp_in.png" name="img3" id="img3"onMouseOver= "if (document.images) document.img3.src=\'images/messagerie/mp_in2.png\';" onMouseOut= "if (document.images) document.img3.src=\'images/messagerie/mp_in.png\';"></a></td>
				<td width="34%"><a href="#" OnClick="writeMsg(); return false" title="Envoyer un nouveau message" id="lien2"><img src="images/messagerie/mp_ecrire.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/messagerie/mp_ecrire2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/messagerie/mp_ecrire.png\';"></a></td>
				<td width="33%"><a href="#" OnClick="listeHist(); return false" title="Voir l\'historique de mes messages envoyés" id="lien3"><img src="images/messagerie/mp_sent.png" name="img2" onMouseOver= "if (document.images) document.img2.src=\'images/messagerie/mp_sent2.png\';" onMouseOut= "if (document.images) document.img2.src=\'images/messagerie/mp_sent.png\';"></a></td>
			</tr>
			<tr>
				<td class="cadre_lien"><div id="menuinbox1" class="menuinbox" style="margin-top:5px"><a href="#" OnClick="listeMsg(); return false" style="display:block; width:90%" title="Voir mes messages">Mes messages ('.$nb2.')</a></div></td>
				<td class="cadre_lien"><div id="menuinbox2" class="menuinbox" style="margin-top:5px"><a href="#" OnClick="writeMsg(); return false" style="display:block; width:90%" title="Envoyer un nouveau message">Ecrire un message</a></div></td>
				<td class="cadre_lien"><div id="menuinbox3" class="menuinbox" style="margin-top:5px"><a href="#" OnClick="listeHist(); return false" style="display:block; width:90%" title="Voir l\'historique de mes messages envoyés">Historique</a></div></td>
			</tr>
		</table><br>';
	
		$contenu.='
		
		<div id="messagerie">
		
		<div class="titreMessagerie">Mes messages</div>
		
		<center style="color:#555">Vous avez <span style="color:#FF4F98">'.$nb1.'</span> '.$message.' dont <span style="color:#FF4F98">'.$nb2.'</span> non-'.$lu.'<br><br>';
		
		if ($nb1!=0) {
			$contenu.='<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td class="top" width="28"> </td>
						<td class="top" width="200" style="text-align:left">Sujet</td>
						<td class="top" width="75" >Auteur</td>
						<td class="top" width="75" >Date</td>
						<td class="top" width="30"> </td>
					</tr>';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
			
				// Gestion des images
				if ($data->etat=="nouveau") $etat = "email.png";
				if ($data->etat=="important") $etat = "email_error.png";
				if ($data->etat=="lu") $etat = "email_open.png";
				if ($data->etat=="auto") $etat = "email_go.png";
				
				// Modification de la date
				$date1 = inverser_date(substr($data->date,0,10));
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				$contenu.='<tr id="tr'.$data->id.'">
							<td><img src="images/messagerie/'.$etat.'"></td>
							<td style="text-align:left"><a href="#" onclick="viewMp('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
							<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
							<td><span style="font-size:10px; color:#AAA">'.$date.'</span></td>
							<td><a href="#" onclick="supprMp('.$data->id.'); return false"><img src="images/messagerie/agt_stop.png"></a></td>
						</tr>';
			}
			
		$contenu.='</table><br>
		<div style="width:408px; padding:7px 2px 2px 2px">
			<img src="images/messagerie/email.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
			<img src="images/messagerie/email_open.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
			<img src="images/messagerie/email_error.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
			<img src="images/messagerie/email_go.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
		</div>';
		}
		

	$contenu.='</div><br /><br />
			
				
				<!-- PRELOAD -->
				<div style="display:none"><img src="images/messagerie/mp_in2.png"><img src="images/messagerie/mp_ecrire2.png";><img src="images/messagerie/mp_sent2.png";></div>';
	
	$design->zone('contenu', $contenu);
	//$design->zone('body', 'onload="init_chargement()"');

?>