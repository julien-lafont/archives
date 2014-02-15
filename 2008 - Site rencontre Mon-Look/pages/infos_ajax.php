<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();

		function envoyerMp($idfrom, $iddest, $sujet, $message ) {
				
			$sql=mysql_query("INSERT INTO mp ( `id_exped` , `id_dest` , `sujet` , `message` , `date`, `etat`  )  
										VALUES ('$idfrom' , '$iddest', '$sujet' , '$message', NOW( ), 'auto' )");
			if ($sql) return "ok"; 
			else return "pas ok";	
		}
		function is_log() {
			if (isset($_SESSION['sess_pseudo'])) return 1;
			else return 0;
		}
		if (is_log()==0) { echo " Ta rien à foutre ici !"; exit; }

include '../include/config.inc.php';
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");

switch($_GET['act']) {
	case "vote1":
		echo '<a href="#" onClick="retour(\''.$_GET['pseudo'].'\'); return false;"><img src="images/profil/reload.png" style="float:right;margin-right:5px; margin-top:0px"></a>
			<div id="profil" style="width:100%; text-align:center; margin:0px; padding:0px"><br><b>Voter pour '.$_GET['pseudo'].'</b><br><br>
				<select name="vote" id="vote">
				   <option value="10">10/10 Number #1</option>
				   <option value="9">9/10 Mmmm Sexy</option>
				   <option value="8">8/10 Salut toi !</option>
				   <option value="7">7/10 Pas pire.</option>
				   <option value="6">6/10 Moyenne</option>
				   <option value="5" selected>5/10 Bofff</option>
				   <option value="4">4/10 Pas mon style !</option>
				   <option value="3">3/10 Cause perdue ..</option>
				   <option value="2">2/10 Rien n\'a dire..</option>
				   <option value="1">1/10 Beurkkk</option>
				 </select><br>
				 <div class="envoyer" style="width:115px; margin-top:5px; margin-left:auto; margin-right:auto; cursor: hand" OnClick="vote2()">Valider</div>
				 <br>
				 
			</div>';
	break;
	###############################################################################################################
	case "vote2":
		$note=(int)addslashes($_GET['note']);
		$id=(int)addslashes($_GET['id']);		
		if ($note>10) exit; // protection
		
		// On vérifie si le gars n'a pas déjà voté pour cette personne
			$sql=mysql_query("SELECT count(de) as nb FROM verif_vote WHERE `de`='".$_SESSION['sess_id']."' AND `a`='$id'");
			$dat=mysql_fetch_object($sql);
			if ($dat->nb!=0) { echo '<div style="width:100%; text-align:center"><br><b style="color:#FF0000">Erreur !</b><br><b>Vous ne pouvez pas voter 2x pour la m&ecirc;me personne !</b><br><br>'; exit; }
			if ($id==$_SESSION['sess_id']) { echo '<div style="width:100%; text-align:center"><br><b style="color:#FF0000">Erreur !</b><br><b>Vous ne pouvez pas voter pour vous même ! !</b><br><br>'; exit; }
		// On récupère la note et le coeff actuel,
			$sql2=mysql_query("SELECT note, coeff_note FROM members WHERE `id_membre`=$id");
			$data=mysql_fetch_object($sql2);
		// On calcul le nouveau et on met à jour la BDD
			$newcoeff=$data->coeff_note+1;
			$newnote=(($data->note*$data->coeff_note)+$note)/($newcoeff);
			$sql3=mysql_query("UPDATE members SET `note`='$newnote', `coeff_note`='$newcoeff' WHERE `id_membre`='$id'") or die('Erreur de selection '.mysql_error());
		// Ainsi que la table de vérification des votes
			$sql4=mysql_query("INSERT INTO verif_vote (`de`,`a`) VALUES ('".$_SESSION['sess_id']."','$id')");
		// Puis on envoie un message à l'heureux élu !
			$sujet="Nouveau vote de ".ucfirst($_SESSION['sess_pseudo']);
			$message="<center><b>Nouveau vote</b></center><br><br><a href=\'?p=infos&username=".$_SESSION['sess_pseudo']."\'>".ucfirst($_SESSION['sess_pseudo'])."</a> vous a attribué la note <b>$note</b>.<br>
					  <br>Votre nouvelle note moyenne est <b>".round($newnote,1)."</b> avec <b>$newcoeff</b> notes.";
			envoyerMp($_SESSION['sess_id'], $id, $sujet, $message);
			 
			echo round($newnote,1).'/10---'.$newcoeff.'---<div style="width:100%; text-align:center"><br><b>Votre vote a bien &eacute;t&eacute; pris en compte</b><br><br><img src="images/indicator_arrows.gif"><br><i>Redirection en cours</i></div><br>';
	break;
	###############################################################################################################
	case "mess1":
		echo '<a href="#" onClick="retour(\''.$_GET['pseudo'].'\'); return false;"><img src="images/profil/reload.png" style="float:right;margin-right:5px; margin-top:0px"></a><div id="profil" style="width:100%; text-align:center; margin:0px; padding:0px"><br>
		   <b>Envoyer un message &agrave; '.ucfirst($_GET['pseudo']).'</b><br><br>
		   <textarea name="mess" id="mess" cols="30" rows="6">'.stripslashes($d->occupations).'</textarea><br>
		   <center><div class="envoyer" id="send" style="width:135px;margin-top:4px" OnClick="if (document.getElementById(\'mess\').value.length>=10) { mess2(); } else { alert(\'Votre message est trop court !\'); }">Envoyer</div></center></div>';
	break;
	###############################################################################################################
	case "mess2":
		$exp=$_SESSION['sess_id'];
		$dest=(int)$_GET['dest'];
		$message=nl2br(addslashes(htmlspecialchars($_GET['mess'])));

			$sql1=mysql_query("SELECT username FROM members WHERE id_membre=$exp");
			$dat=mysql_fetch_object($sql1);
		$nomexp=$dat->username;
		$sujet=ucfirst($dat->username)." vous a envoyé un message";
		
				function ip() {
					if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
					elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
					else {$ip = $_SERVER['REMOTE_ADDR']; }
					return $ip;
				}

		$sql=mysql_query("INSERT INTO mp ( `id_exped` , `id_dest` , `sujet` , `message` , `date` , `ip` )  
								VALUES ('$exp' , '$dest', '$sujet' , '$message', NOW( ) , '".ip()."')");
								
		echo '<div style="width:100%; text-align:center"><br><b>Message envoyé avec succés</b><br><br><img src="images/indicator_arrows.gif"><br><i>Redirection en cours</i></div><br>';
		
		
	break;
	###############################################################################################################
	###############################################################################################################
	case "retour":
	
	$pseudo=$_GET['pseudo'];
	$pseudoo=strtolower($_GET['pseudo']);
	
	// Copier / Coller de infos.php
	if (is_log()==0) {
		$lien2=$lien3=$lien4="document.getElementById('fonctions').innerHTML='<center><b style=\'color:#FF6600\'><br>Vous devez être inscrit pour accéder à ces fonctions</b><br><br><a href=\'?p=inscription\'>S\'inscrire</a><br><br></center>';round(); return false";
		$lien1="href='#' onClick=\"document.getElementById('fonctions').innerHTML='<center><b style=\'color:#FF6600\'><br>Vous devez être inscrit pour accéder à ces fonctions</b><br><br><a href=\'?p=inscription\'>S\'inscrire</a><br><br></center>';round(); return false\"";
	} else {
		$lien4='sms1(\''.$pseudo.'\'); return false';
		$lien3='vote1(\''.$pseudo.'\'); return false';
		$lien2='mess1(\''.$pseudo.'\'); return false';
		$lien1='href="?p=galerie&pseudo='.$pseudo.'"';
	}

	echo '<center><b style="color:#FF6600">› » Actions disponibles « ‹</b></center><br>';
		
		// Condition accéder galerie ( Ya des photos ? )
		$sql_tof=mysql_query("SELECT count(id) as nbtof FROM photos WHERE pseudo='$pseudoo'");
		$datanb=mysql_fetch_object($sql_tof);
		if ($datanb->nbtof!=0)
					echo '<div>
						<table id="infos"><tr><td width=50><a '.$lien1.'><img src="images/profil/photo.png" align="absmiddle"></a></td>
						 <td style="text-align:center; font-size:12px; color:#0066FF"><a '.$lien1.'>Visionner la galerie photo de '.$pseudo.'</a></td></tr></table>
					</div>';
		else
					echo '<div>
						<table id="infos"><tr><td width=50><img src="images/profil/photo.png" align="absmiddle"></td>
						 <td style="text-align:center; font-size:12px; color:#0066FF">Aucune photo dans la galerie de '.$pseudo.'</td></tr></table>
					</div>';
	
		// Condition Envoyer un SMS ( Pas à soi même , Num portable définis)
		$sql=mysql_query("SELECT id_membre, portable, img_principale, img_valid FROM members WHERE username='$pseudoo'");
		$data=mysql_fetch_object($sql);
		if ($_SESSION['sess_pseudo']!=$pseudoo AND !empty($data->portable)) echo '
				<div>
						<table id="infos" style="width:100%"><tr><td width=50><a href="#" OnClick="'.$lien4.'"><img src="images/profil/sms.png" align="absmiddle"></a></td>
						 <td style="text-align:center; font-size:12px; color:#0066FF"><a href="#" OnClick="'.$lien4.'">Ecrire un SMS à '.$pseudo.'</a></td></tr></table>
					</div>';
		
		// Condition écrire un message ( Pas à soi même )
		if ($_SESSION['sess_pseudo']!=$pseudoo) 
				echo '<div>
						<table id="infos" style="width:100%"><tr><td width=50><a href="#" OnClick="'.$lien2.'"><img src="images/profil/message.png" align="absmiddle"></a></td>
						 <td style="text-align:center; font-size:12px; color:#0066FF"><a href="#" OnClick="'.$lien2.'">Envoyer un message à <br>'.$pseudo.'</a></td></tr></table>
					</div>';
				
		// Condition Vote ( déjà voté ? - A une photo ? )
		$sql2=mysql_query("SELECT count(de) as nb FROM verif_vote WHERE `de`='".$_SESSION['sess_id']."' AND `a`='".$data->id_membre."'");
		$dat=mysql_fetch_object($sql2);
		if ($dat->nb==0 && $pseudoo!=$_SESSION['sess_pseudo'] AND isset($data->img_principale) AND $data->img_valid==1) 
				echo '<div>
						<table id="infos" style="width:100%"><tr><td width=50><a href="#" OnClick="'.$lien3.'"><img src="images/profil/note.png" align="absmiddle"></a></td>
						 <td style="text-align:center; font-size:12px; color:#0066FF"><a href="#" OnClick="'.$lien3.'">Attribuer une note à <br>'.$pseudo.'</a></td></tr></table>
					</div>';

break;
}
                            
mysql_close();
?>