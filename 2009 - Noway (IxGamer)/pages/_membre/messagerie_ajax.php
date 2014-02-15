<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
case "listemsg": 

	$my_id=$_SESSION['sess_id'];
	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,m.pseudo 
							FROM ".PREFIX."messagerie mp 
							LEFT JOIN ".PREFIX."membres m
							ON mp.id_exped=m.id 
							WHERE mp.id_dest=$my_id 
							ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));
		
		if ($nb1!=0) {
			echo2('<center>
			<div class="titreMessagerie">Mes messages</div>
			
			<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td class="top" width="28"> </td>
						<td class="top" style="text-align:left;" width="200">Sujet</td>
						<td class="top" width="75" style="text-align:center">Auteur</td>
						<td class="top" width="75" style="text-align:center">Date</td>
						<td class="top" width="30"> </td>
					</tr>');
				
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
				
				echo2('<tr id="tr'.$data->id.'">
						<td><img src="images/messagerie/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" onclick="viewMp('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
						<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
						<td><a href="#" onclick="supprMp('.$data->id.'); return false"><img src="images/messagerie/agt_stop.png"></a></td>
					</tr>');
			}
			
			echo2('</table><br>
			<div style="width:408px;  padding:7px 2px 2px 2px">
				<img src="images/messagerie/email.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
				<img src="images/messagerie/email_open.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
				<img src="images/messagerie/email_error.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
				<img src="images/messagerie/email_go.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center><br><br>');

		} else {
		echo2('<br><br><center><span style="color:#3399FF">Aucun message</span></center><br><br>');
		}
break;	
##############################################################################################
##############################################################################################
case "historique": 

	$my_id=$_SESSION['sess_id'];
	$sql_total=mysql_query("SELECT mp.id,mp.id_exped,mp.id_dest,mp.sujet,mp.message,mp.etat,mp.date,m.pseudo 
							FROM ".PREFIX."messagerie mp 
							LEFT JOIN ".PREFIX."membres m 
							ON mp.id_dest=m.id
							WHERE mp.id_exped=$my_id
							ORDER BY mp.date DESC") or die('Erreur de selection '.mysql_error());
	$nb1=round(mysql_num_rows($sql_total));
		
		if ($nb1!=0) {
			echo2('
			
			<div class="titreMessagerie">Historique de vos messages envoyés</div>

			<center><br><table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td class="top" width="28"> </td>
						<td class="top" style="text-align:left;" width="230">Sujet</td>
						<td class="top" width="75" style="color:#0066FF">Auteur</td>
						<td class="top" width="75" style="color:#0066FF"><center>Date</td>
					</tr>');
				
			while ( $data = mysql_fetch_object($sql_total) ) {
				
				// Gestion des images			
				if ($data->etat=="nouveau") $etat = "email.png";
				if ($data->etat=="important") $etat = "email_error.png";
				if ($data->etat=="lu") $etat = "email_open.png";
				if ($data->etat=="auto") $etat = "email_go.png";
					    
				// Modification de la date
				list($a, $m, $j) = explode("-", substr($data->date,0,10));
				$date1 = "$j.$m.$a";
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				echo2('<tr id="tr'.$data->id.'">
						<td><img src="images/messagerie/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" onclick="viewMpHist('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
						<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
					</tr>');
			}
			
			echo2('</table><br>
			<center><div style="width:408px;  padding:7px 2px 2px 2px">
				<img src="images/messagerie/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
				<img src="images/messagerie/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
				<img src="images/messagerie/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
				<img src="images/messagerie/icon_auto3.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center><br><br><br>');
		}

	
break;
##############################################################################################
##############################################################################################
case "supprmp":

	$id=round($_GET['id']);
	$sql=mysql_query("SELECT count(id) as nb FROM ".PREFIX."messagerie WHERE id_dest=".$_SESSION['sess_id']." AND id=$id");
	$d=mysql_fetch_object($sql);
	if ($d->nb!=1) { die("bad"); }
	else {
		$sql2=mysql_query("DELETE FROM ".PREFIX."messagerie WHERE id_dest=".$_SESSION['sess_id']." AND id=$id");
		echo $id; // on retourne l'id pr l'ajax
	}
break;
##############################################################################################
##############################################################################################
case "viewmp";

	$id=$_GET['id'];
	$my_id=$_SESSION['sess_id'];
	
	// Sélectionne les infos
	$sql=mysql_query("	SELECT mp.id,mp.id_exped,mp.sujet,mp.message,mp.etat,mp.date,m.pseudo, md.avatar
						FROM ".PREFIX."messagerie mp
						LEFT JOIN ".PREFIX."membres m
						ON m.id=mp.id_exped
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						WHERE mp.id_dest=$my_id AND mp.id=$id") 
				or die('Erreur de selection '.mysql_error());
	$data=mysql_fetch_object($sql);
	
	// Change l'état à 'lu'
	$sql2=mysql_query("UPDATE ".PREFIX."messagerie SET `etat`='lu' WHERE id=$id AND id_dest=$my_id");
	
	// Transforme la date
	list($a, $m, $j) = explode("-", substr($data->date,0,10));
	$date1 = "$j.$m.$a";
	$date2 = substr($data->date,11,2);
	$date3 = substr($data->date,14,2);
	$date = "Envoyé le ".$date1." à ".$date2."h".$date3;
	
	// On gère l'avatar
	if (empty($data->avatar)) 	$avatar="images/upload/avatar/no_avatar.gif";
	else						$avatar="images/upload/avatar/".$data->avatar;
	
	echo2 ('<div class="titreMessagerie">Lire un message</div>
	
		<center>
		<table style="border-bottom:1px solid #ddd;width:500px; padding-top:4px" align="center">
			<tr>
				<td style="width:150px; text-align:center" id="first"><a href="profil/'.trim($data->pseudo).'/">'.trim(ucfirst($data->pseudo)).'</a></td>
				<td style="height:15px;font-family:verdana; font-size:11px; color:#000; border-bottom:1px dotted #FFCC66; padding-bottom:2px"> &nbsp; <img src="images/boutons/email_open.png" /> &nbsp; '.recupBdd($data->sujet).'</td>
			</tr>
			
			<tr>
				<td style="vertical-align:top; padding-top:11px; text-align:center"><img src="'.$avatar.'" class="imgAvatar2"></td>
				<td style="vertical-align:top; padding-top:11px" class="message">'.recupBdd($data->message).'</td>
			</tr>
			<tr>
				<td></td>
				<td style="color:#AAA; text-align:right; height:15px; vertical-align:bottom; font-size:10px">'.$date.'</td>
			</tr>
		</table>
		
		<div style="margin-top:7px;">
			<a href="#" onclick="supprDirect('.$data->id.'); return false" title="Supprimer ce message" ><img src="images/boutons/email_delete.png" style="vertical-align:middle"> Supprimer</a> &nbsp; &nbsp; &nbsp;
			<a href="#" onclick="repondre('.$data->id.'); return false" title="Répondre à ce message"><img src="images/boutons/email_go.png" style="vertical-align:middle"> Répondre</a>
		</div>
		
		</center>');
break;
##############################################################################################
##############################################################################################
case "viewmpHist";

	$id=$_GET['id'];
	$my_id=$_SESSION['sess_id'];
		
	$sql=mysql_query("SELECT mp.id, mp.id_dest, mp.sujet, mp.message, mp.etat, mp.date, m.pseudo
					FROM ".PREFIX."messagerie mp
					LEFT JOIN ".PREFIX."membres m
					ON mp.id_dest=m.id
					LEFT JOIN ".PREFIX."membres_detail md
					ON md.id_membre=m.id
					WHERE mp.id_exped=$my_id AND mp.id=$id") 
			or die('Erreur de selection '.mysql_error());
	$data=mysql_fetch_object($sql);

	
	// Transforme la date
	list($a, $m, $j) = explode("-", substr($data->date,0,10));
	$date1 = "$j.$m.$a";
	$date2 = substr($data->date,11,2);
	$date3 = substr($data->date,14,2);
	$date = "Envoyé le ".$date1." à ".$date2."h".$date3;
	
	// On gère l'avatar
	if (empty($data->avatar)) 	$avatar="images/upload/avatar/no_avatar.gif";
	else						$avatar="images/upload/avatar/".$data->avatar;
	
	echo2( '<div class="titreMessagerie">Lire un message envoyé</div>
	
		<center>
		<table style="border-bottom:1px solid #ddd;width:500px; padding-top:4px" align="center">
			<tr>
				<td style="width:150px; text-align:center" id="first"><a href="profil/'.trim($data->pseudo).'/">'.trim(ucfirst($data->pseudo)).'</a></td>
				<td style="height:15px;font-family:verdana; font-size:11px; color:#000; border-bottom:1px dotted #FFCC66; padding-bottom:2px"> &nbsp; <img src="images/boutons/email_open.png" /> &nbsp; '.recupBdd($data->sujet).'</td>
			</tr>
			
			<tr>
				<td style="vertical-align:top; padding-top:11px; text-align:center"><img src="'.$avatar.'" class="imgAvatar2"></td>
				<td style="vertical-align:top; padding-top:11px" class="message">'.recupBdd($data->message).'</td>
			</tr>
			<tr>
				<td></td>
				<td style="color:#AAA; text-align:right; height:15px; vertical-align:bottom; font-size:10px">'.$date.'</td>
			</tr>
		</table>
		</center>');

break;

##############################################################################################
##############################################################################################
case "write";

	if (isset($_GET['id']))
	{
		$sql=mysql_query("	SELECT mess.sujet, mess.id_exped, m.pseudo
							FROM ".PREFIX."messagerie mess
							LEFT JOIN ".PREFIX."membres m
							ON mess.id_exped=m.id
							WHERE mess.id='".$_GET['id']."'");
		$d=mysql_fetch_object($sql);
		
		$sujet="Re: ".$d->sujet;
		$auteur=ucfirst($d->pseudo);
		$id_exped=$d->id_exped;
	
	}

	echo '<form action="#" method="post" class="form">
			
			<div class="titreMessagerie">Rédiger un nouveau message</div>
			
			<table id="write">
				<tr>
					<td style="width:85px;color:#555; vertical-align:top">Destinataire</td>
					<td>
						<input type="text" name="dest" id="dest" maxlength="255" value="'.@$auteur.'"> <img src="images/boutons/valider.png" style="display:none" id="pseudo_ok"  />
						
						<input type="hidden" name="dest_id" id="dest_id" value="'.@$id_exped.'" />
					</td>
				</tr>
				<tr>
					<td style="color:#555; vertical-align:top">Sujet</td>
					<td><input type="text" name="sujet" id="sujet" maxlength="255"  style="width:291px" value="'.@$sujet.'"></td>
				</tr>
				<tr>
					<td style="color:#555; vertical-align:top">Message<br></td>
					<td><textarea name="mess" id="mess" cols="42" rows="6"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><br /><a class="button" href="#" onclick="this.blur(); sendMsg(); return false"><span>Envoyer le message</span></a>
						</td>
				</tr>
			</table>
		</form>';

break;
##############################################################################################
##############################################################################################
case "write2";

		$destId=(int)$_POST['dest'];
		$message=nl2br(addBdd($_POST['mess']));
		$sujet=addBdd($_POST['sujet']);
		
		if (envoyerMp($destId, $sujet, $message))
		{
			header('location: ?act=listemsg');
		} else {
			die('bad');
		}

break;
##############################################################################################
##############################################################################################
case "send_profil";

		$destId=(int)$_POST['dest'];
		$message=nl2br(addBdd($_POST['mess']));
		$sujet=addBdd($_POST['sujet']);
		
		if (envoyerMp($destId, $sujet, $message))
		{
			echo "ok";
		} else {
			die('bad-');
		}

break;
##############################################################################################
##############################################################################################
case "autocomplete":
	
	if(isset($_POST['value'])){
	
			// on fait la requête
			$sql = "SELECT m.pseudo, m.id, m.last_activity, md.avatar, md.gen_prenom, md.gen_sexe
					FROM ".PREFIX."membres m
					LEFT JOIN ".PREFIX."membres_detail md
					ON md.id_membre=m.id 
					WHERE m.pseudo LIKE '".$_POST['value']."%'";
			$req = mysql_query($sql) or die (mysql_error());
	
			$i = 0;
			$r='<?xml version="1.0"?>
<ajaxresponse>';
			
			// on boucle sur tous les éléments
			while($d = mysql_fetch_object($req)){
			
				if ( time()>=$d->last_activity && time()<=($d->last_activity+5*60) )
				{ 
					if ($d->gen_sexe=="h") 	$img="ico_homme.gif";
					else 					$img="ico_femme.gif";
				} else 
				{ 
					if ($d->gen_sexe=="h") 	$img="ico_homme_off.gif";
					else 					$img="ico_femme_off.gif";
				}
				
				$r.='
<item>
	<text>'.ucfirst($d->pseudo).'</text>
	<value>'.ucfirst($d->pseudo).'</value>
	<id>'.$d->id.'</id>
</item>';

				if (++$i >= 10)
					$r.='<item><text>........</text><value></value><id></id></item>';
		
			}
			
			$r.='
</ajaxresponse>';
			echo2($r);
}

break;
}


/*	if(isset($_POST['value'])){
	
			// on fait la requête
			$sql = "SELECT m.pseudo, m.id, m.last_activity, md.avatar, md.gen_prenom, md.gen_sexe
					FROM ".PREFIX."membres m
					LEFT JOIN ".PREFIX."membres_detail md
					ON md.id_membre=m.id 
					WHERE m.pseudo LIKE '".$_POST['value']."%'";
			$req = mysql_query($sql) or die (mysql_error());
	
			$i = 0;
			echo '<ul class="contacts">';
			
			// on boucle sur tous les éléments
			while($d = mysql_fetch_object($req)){
			
				if ( time()>=$d->last_activity && time()<=($d->last_activity+5*60) )
				{ 
					if ($d->gen_sexe=="h") 	$img="ico_homme.gif";
					else 					$img="ico_femme.gif";
				} else 
				{ 
					if ($d->gen_sexe=="h") 	$img="ico_homme_off.gif";
					else 					$img="ico_femme_off.gif";
				}
					
				echo '	<li class="contact"><div class="image"><img src="images/'.$img.'" /></div><div class="nom">'.ucfirst($d->pseudo).'</div>
							<span class="informal" style="display:none">'.$d->id.'-idcache</span>							
						</li>';

					if (++$i >= 10)
						die('<li>...</li></ul>');
			}
			echo '</ul>';
			die();
}
*/
?>