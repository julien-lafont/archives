<?php
securite_membre();

head();
echo "<center><b>Bienvenue sur votre Espace Personnel</b></center><br>";

// Indique si la photo principale est choisie ou non, ainsi que son status
$sql_photo=mysql_query("SELECT img_principale, img_valid FROM members WHERE username='".$_SESSION['sess_pseudo']."'");
	$phot=mysql_fetch_object($sql_photo);
	
	// Si aucune photo n'est envoyée
	if (empty($phot->img_principale)) { echo "
			<table style='width:90%; border:1px solid #FFFFFF; border-top:4px solid #FFFFFF; padding:4px' align='center'>
				<tr>
					<td width='50' ><img src='images/panneau/error_50.png' ALT='ATTENTION'></td>
					<td><center>Vous n'avez pas encore ajouter votre Photo Principale !<br><br>
						Rendez vous dans '<a href='?p=membre/profil'>Mon Profil</a>' (Etape 5) pour ajouter votre photo ( </td>
				</tr>
			</table><br>";
	}
	
	if (!empty($phot->img_principale) && $phot->img_valid==0) { echo "
			<table style='width:90%; border:1px solid #FFFFFF; border-top:4px solid #FFFFFF; padding:4px' align='center'>
				<tr>
					<td width='50' ><img src='images/panneau/msn.png' ALT='ATTENTION'></td>
					<td><center>Votre photo principale est en cours de validation</td>
				</tr>
			</table><br>";
	}

	if (!empty($phot->img_principale) && $phot->img_valid==2) { echo "
			<table style='width:90%; border:1px solid #FFFFFF; border-top:4px solid #FFFFFF; padding:4px' align='center'>
				<tr>
					<td width='50' ><img src='images/panneau/error_50.png' ALT='ATTENTION'></td>
					<td><center>Votre photo principale a été <b style='color:#FF0000'>refusée</b>.<br><br>
					Rendez vous dans '<a href='?p=membre/profil'>Mon Profil</a>' (Etape 5) pour soumettre une nouvelle photo. </td>
				</tr>
			</table><br>";
	}
	
	// Nbre de message en attente
	$sql1=mysql_query("SELECT count(id) as nb FROM mp WHERE `id_dest`=".$_SESSION['sess_id']." AND (`etat`='nouveau' OR `etat`='important')");
	$d1=mysql_fetch_object($sql1);
	$nb=round($d1->nb);

	
// Affichage du menu en vignette
echo '
	<table style="width:90%; padding:40px" align="center">
		<tr>
			<td width="50%" align="center"><a href="?p=membre/profil"><img src="images/home/profil.png" name="img3" onMouseOver= "if (document.images) document.img3.src=\'images/home/profil_hover.png\';" onMouseOut= "if (document.images) document.img3.src=\'images/home/profil.png\';"></a></td>
			<td width="50%" align="center"><a href="?p=membre/inbox"><img src="images/home/mail.png" name="img2" onMouseOver= "if (document.images) document.img2.src=\'images/home/mail_hover.png\';" onMouseOut= "if (document.images) document.img2.src=\'images/home/mail.png\';"></a></td>
		</tr>
		<tr>
			<td align="center" style="padding-top:5px"><div class="menuhome"><a href="?p=membre/profil">&nbsp;&nbsp;&nbsp;&nbsp;Mon Profil&nbsp;&nbsp;&nbsp;&nbsp;</a></div><br><br></td>
			<td align="center"><div class="menuhome"><a href="?p=membre/inbox">Boite de réception ('.$nb.')</a></div><br><br></td>
		</tr>
		<tr>
			<td align="center"><a href="#"><a href="?p=membre/galerie"><img src="images/home/photo2.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/home/photo2_hover2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/home/photo2.png\';"></a></td>
			<td align="center"><a href="?p=membre/smylcredit"><img src="images/home/credit1.png" name="img4" onMouseOver= "if (document.images) document.img4.src=\'images/home/credit1_hover.png\';" onMouseOut= "if (document.images) document.img4.src=\'images/home/credit1.png\';"></a></td>
		</tr>
		<tr>
			<td  align="center" style="padding-top:5px"><div class="menuhome"><a href="?p=membre/galerie">&nbsp;&nbsp;Album Photo&nbsp;&nbsp;</a></div><br></td>
			<td  align="center"><div class="menuhome"><a href="?p=membre/smylcredit">&nbsp;Smyl\' Crédit&nbsp;</a></div><br></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><a href="#" OnClick=" window.open (\'chat/index.php?PHPSESSID='.session_id().'\', \'chat\', config=\'height=435, width=720\')"><img src="images/home/chat.png" name="img5" onMouseOver= "if (document.images) document.img5.src=\'images/home/chat_hover.png\';" onMouseOut= "if (document.images) document.img5.src=\'images/home/chat.png\';"></a></td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="padding-top:5px"><div class="menuhome"><a href="#" OnClick=" window.open (\'chat/index.php?PHPSESSID='.session_id().'\', \'chat\', config=\'height=435, width=720\')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chat privé&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div></td>
		</tr>
	</table>
	<div style="float:right; padding:2px; text-align:right; margin-right:30px; font-weight:bold">
		<span style="color:#FFFFFF; font-size:13px">›</span> <span style="color:#00A8FF">Se déconnecter</span> <span style="color:#FFFFFF; font-size:13px">›</span>
		<a href="?p=fonctions/deco"><img src="images/home/deco2.png" style="vertical-align:middle" name="img7" onMouseOver= "if (document.images) document.img7.src=\'images/home/deco2_hover.png\';" onMouseOut= "if (document.images) document.img7.src=\'images/home/deco2.png\';"></a> 
	</div>
	<br><br><br>
	<div style="float:right; padding:2px; text-align:right; margin-right:30px; font-weight:bold">
		<span style="color:#FFFFFF; font-size:13px">›</span> <span style="color:#00A8FF">Fermer mon compte</span> <span style="color:#FFFFFF; font-size:13px">›</span>
		<a href="?p=membre/profil&action=supprCompte"><img src="images/home/stop.png" style="vertical-align:middle" name="img6" onMouseOver= "if (document.images) document.img6.src=\'images/home/stop_hover.png\';" onMouseOut= "if (document.images) document.img6.src=\'images/home/stop.png\';"></a> 
	</div>

	<div style="display:none" class="preload"><img src="images/home/photo2_hover2.png"><img src="images/home/mail_hover.png"><img src="images/home/profil_hover.png"><img src="images/home/deco_hover.png"><img src="images/home/chat_hover.png"></div>';
			
	
	
foot();

?>