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
			echo '<center><div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>
			<table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
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
				
				echo  '<tr id="tr'.$data->id.'">
						<td style="border-left:3px solid #0099FF;"><img src="images/messagerie/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" onclick="viewMp('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
						<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
						<td><a href="#" onclick="supprMp('.$data->id.'); return false"><img src="images/messagerie/agt_stop.png"></a></td>
					</tr>';
			}
			
			echo '</table><br>
			<div style="width:408px; padding:2px; border:1px solid #CCC;">
				<img src="images/messagerie/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
				<img src="images/messagerie/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
				<img src="images/messagerie/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
				<img src="images/messagerie/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center>';

		} else {
		echo '<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div><br><br><center><span style="color:#3399FF">Aucun message</span></center><br><br>';
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
			echo '<div id="wait" style="display:none"><center><img src="images/indicator2.gif"></center></div>
			<center style="color:#555">Historique de vos messages envoyés<br><br>
			<br><table class="liste_mess" cellpadding=0 cellspacing=0 align="center">
					<tr>
						<td width="28"> </td>
						<td style="text-align:left; color:#0066FF" width="230">Sujet</td>
						<td width="75" style="color:#0066FF">Auteur</td>
						<td width="75" style="color:#0066FF"><center>Date</td>
					</tr>';
				
			while ( $data = mysql_fetch_object($sql_total) ) {
				
				// Gestion des images			
				if ($data->etat=="nouveau") $etat = "icon_new.png";
				if ($data->etat=="important") $etat = "icon_fav.png";
				if ($data->etat=="lu") $etat = "icon_lu.png";
				if ($data->etat=="auto") $etat = "icon_auto.png";
					    
				// Modification de la date
				list($a, $m, $j) = explode("-", substr($data->date,0,10));
				$date1 = "$j.$m.$a";
				$date2 = substr($data->date,11,2);
				$date3 = substr($data->date,14,2);
				$date = $date1."<br>".$date2."h".$date3;
				
				echo'<tr id="tr'.$data->id.'">
						<td style="border-left:3px solid #0099FF;"><img src="images/messagerie/'.$etat.'"></td>
						<td style="text-align:left"><a href="#" onclick="viewMpHist('.$data->id.'); return false">'.ucfirst(recupBdd($data->sujet)).'</a></td>
						<td><a href="profil/'.$data->pseudo.'/" >'.ucfirst($data->pseudo).'</a> </td>
						<td><span style="font-size:10px; color:#333333">'.$date.'</span></td>
					</tr>';
			}
			
			echo '</table><br>
			<center><div style="width:408px; padding:2px; border:1px solid #ccc;">
				<img src="images/messagerie/icon_new.png" style="vertical-align:middle"> Nouveau &nbsp;&nbsp;
				<img src="images/messagerie/icon_lu.png" style="vertical-align:middle"> Déjà lu &nbsp;&nbsp;
				<img src="images/messagerie/icon_fav.png" style="vertical-align:middle">  Important &nbsp;&nbsp; 
				<img src="images/messagerie/icon_auto.png" style="vertical-align:middle"> Automatique &nbsp;&nbsp;
			</div></center><br>';
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
	if (empty($data->avatar)) 	$avatar="images/avatar/no_avatar.gif";
	else						$avatar="images/avatar/".$data->avatar;
	
	echo '<table style="border:1px dashed #0099FF; border-left:3px solid #0099FF; width:100%; padding-top:4px">
			<tr>
				<td rowspan=3 width="150" align="center" id="first">
					<a href="profil/'.trim($data->pseudo).'/">'.trim(ucfirst($data->pseudo)).'</a><br><br>
					 <img src="'.$avatar.'" class="imgAvatar2"><br>
					 <a href="#" onclick="supprDirect('.$data->id.'); return false" title="Supprimer" ><img src="images/messagerie/button_cancel.png"></a> &nbsp;&nbsp; 
					 <a href="#" onclick="repondre('.$data->id.'); return false"  title="Répondre"><img src="images/messagerie/reply.png"></a>
				</td>
				<td align="center" style="height:15px;font-family:verdana; font-size:12px; color:#0066FF">'.recupBdd($data->sujet).'</td>
			</tr>
			
				<tr><td style="vertical-align:top; padding-top:11px">'.recupBdd($data->message).'</td></tr>
				<tr><td style="color:#555555; text-align:right; height:15px; vertical-align:bottom">'.$date.'</td></tr>
			
		</table><div id="wait"></div>';

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
	if (empty($data->avatar)) 	$avatar="images/avatar/no_avatar.gif";
	else						$avatar="images/avatar/".$data->avatar;
	
	echo '<table style="border:1px dashed #0099FF; border-left:3px solid #0099FF; width:100%">
			<tr>
				<td rowspan=3 width="120" align="center" id="first"><a href="profil/'.trim($data->pseudo).'/">'.ucfirst($data->pseudo).'</a><br><br>
					 <img src="'.$avatar.'" class="imgAvatar2"><br></td>
				<td  align="center" style="height:15px;font-family:verdana; font-size:12px; color:#0066FF;">'.recupBdd($data->sujet).'</td>
			</tr>
			
				<tr><td style="vertical-align:top; padding-top:11px">'.recupBdd($data->message).'</td></tr>
				<tr><td style="color:#555555; text-align:right; height:15px; vertical-align:bottom">'.$date.'</td></tr>
			
		</table><div id="wait"></div>';

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

	echo '<form action="?" method="post">
			<table id="write">
				<tr>
					<td style="width:85px;color:#555; vertical-align:top">Destinataire</td>
					<td><div id="wait" style="display:none; float:right; margin-right:23px"><img src="images/indicator2.gif"></div>
						<input type="text" name="dest" id="dest" maxlength="255" value="'.@$auteur.'">
						<div class="update" id="dest_update"></div>
						<input type="hidden" name="dest_id" id="dest_id" value="'.@$id_exped.'" /><br/> 
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
					<td><input type="button" class="submit" value="envoyer" onclick="sendMsg()"; style="width:100px" /></td>
				</tr>
			</table>
		</form>
		<script type="text/javascript">
			new Ajax.Autocompleter ("dest",
                        "dest_update",
                        "pages/_membre/messagerie_ajax.php?act=autocomplete",
                        {
                                method: "post",
                                paramName: "dest",
                                afterUpdateElement: ac_return
                        });
		</script>';

break;
##############################################################################################
##############################################################################################
case "write2";

		$destId=(int)$_POST['dest'];
		$message=nl2br(addBdd($_POST['mess']));
		$sujet=addBdd($_POST['sujet']);
		
		if (envoyerMp($destId, $sujet, $message))
		{
			echo 'ok|:|'.miseenforme('message', '<b>Message envoyé avec succés</b><br><br><img src="images/indicator_arrows.gif"><br><i>Redirection en cours</i>');
		} else {
			die('bad');
		}

break;
##############################################################################################
##############################################################################################
case "autocomplete":
	
	if(isset($_POST['dest'])){
	
			// on fait la requête
			$sql = "SELECT m.pseudo, m.id, m.last_activity, md.avatar, md.gen_prenom, md.gen_sexe
					FROM ".PREFIX."membres m
					LEFT JOIN ".PREFIX."membres_detail md
					ON md.id_membre=m.id 
					WHERE m.pseudo LIKE '".$_POST['dest']."%'";
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

break;
}
?>