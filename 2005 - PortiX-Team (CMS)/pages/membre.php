<?php
is_membre();
	
switch (@$_GET['action']) {

default:
	$texte='<div class="titreBS">Mon Compte :</div>';
	
	$texte.="<center>Bienvenue <span class='txt2'>".ucfirst($_SESSION['sess_pseudo'])."</span>, tu es sur ton <u>Panneau de controle</u>, choisi une action :</center><br><br>
					<table id=\"caseadmin\">
                    <tr>
                      <td><b class='txt2'>Mon Profil</b></td>
                      <td><b class='txt2'>Mes Stats</b></td>
                      <td><b class='txt2'>Options</b></td>
                      <td><b class='txt2'>Support</b></td>
                      <td><b class='txt2'>Messagerie</b></td>
                    </tr>
					<tr>
                      <td id=\"tdadmin\"><img src=\"images/admin/profil.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></div></td>
                      <td id=\"tdadmin\"><img src=\"images/admin/stats.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></td>
                      <td id=\"tdadmin\"><img src=\"images/admin/theme.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></div></td>
                      <td id=\"tdadmin\"><img src=\"images/admin/support.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></td>
                      <td id=\"tdadmin\"><img src=\"images/admin/message.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></div></td>
                    </tr>
                    <tr>
                      <td valign='top'><a href=\"?page=profil&id=".$_SESSION['sess_id']."\">Mon Profil</a><br><a href=\"?page=profil&action=editer\">Editer</a><br></td>
                      <td valign='top'><a href=\"?page=membre&action=stats\">Mes Stats</a></td>
                      <td valign='top'><a href=\"?page=membre&action=options\">Options</a></td>
                      <td valign='top'><a href=\"?page=support\">Support</a></td>
                      <td valign='top'><a href=\"?page=mp\">Accueil</a><br><a href=\"?page=mp&action=ecrire\">Envoyer un MP</a></td>
                    </tr>
                  </table><br>";
break;
case "stats":

	$sql = mysql_query("SELECT pseudo, inscript, niveau, nb_con FROM ix_membres WHERE id=".$_SESSION['sess_id']);
	//$sql_d = mysql_query("SELECT * FROM ix_membres_detail WHERE id_mbre=".$_SESSION['sess_id']);
	
	while ($data=mysql_fetch_object($sql)) {
		$pseudo=$_SESSION['sess_pseudo'];
		$date1=$data->inscript;
		$id=$_SESSION['sess_id']; 
		if ($data->niveau==0) $niveau="Membre"; 
			if ($data->niveau==1) $niveau="Modérateur"; 
			if ($data->niveau==2) $niveau="Administrateur";
		$nb_con=$data->nb_con;
	}
	
	// Nombres de jours depuis Inscription :*
	  $date1b=inverser_date($date1);
	  $date2 = date("Y-m-d"); $tDeb = explode("-", $date1); $tFin = explode("-", $date2);
	  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
  	  $nbjours=round((($diff / 86400)),1);

	// Nombres de messages ShoutBox :
	  $sql_shout = mysql_query("SELECT * FROM ix_box WHERE pseudo='$pseudo'");
	  $nb_shout = mysql_num_rows($sql_shout);
	// Nombres de News :
	  $sql_news = mysql_query("SELECT * FROM ix_news WHERE auteur='$id'");
	  $nb_news = mysql_num_rows($sql_news);
	// Nombres de Matchs joués ( recherche dans lineup ) :
	  $sql_match = mysql_query("SELECT * FROM ix_matchs WHERE lineup like '%".$pseudo."%'");
	  $nb_match = mysql_num_rows($sql_match);
	// FUN 
	  $sex1=(mt_rand(500, 700)/100);

	$texte='<div class="titreBS">Mes Stats :</div>';
	$texte.="Tu t'es inscrit le <span class=\"txt2\">$date1b</span>, tu es donc inscrit depuis <span class=\"txt2\">$nbjours</span> jours.<br><br>
			 Tu t'es connecté <span class=\"txt2\">$nb_con</span> fois sur ce site.<br><br>
			 Tu as posté <span class=\"txt2\">$nb_news</span> news, <span class=\"txt2\">0</span> commentaire, <span class=\"txt2\">0</span> articles et <span class=\"txt2\">$nb_shout</span> message dans la ShoutBox.<br><br>
			 Tu as déjà joué <span class=\"txt2\">$nb_match</span> matchs dans cette team.<br><br>
			 La longueur de ton sexe est d'environ : <span class=\"txt2\">$sex1</span> cm.<br><br>";

	$texte.='<br><a href="?page=membre"><center>- Retour à Mon Compte -</center></a><br>';

break;

case "options":

	$page=$_GET['page'];

	$sql = mysql_query("SELECT theme FROM ix_membres WHERE id=".$_SESSION['sess_id']);
	$data=mysql_fetch_object($sql);
	
	$texte='<div class="titreBS">Mes Options :</div>';
	
	$texte.='<FORM name="theme" method="post" action="?page=fonc/changertheme&newpage='.$page.'">
			<table>
			<tr>
			  <td width="130px">> Thème du site </td>
			  <td>
				
				<select name="theme">
				<option value="'.$ixteam['theme'].'">-- Themes --</option>';

				$dossier = opendir ("theme/");
		
				while ($fichier = readdir ($dossier)) {
					if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db") {
						$texte.= '<option value="' . $fichier . '">' . $fichier . '</option>';
					} 
				} 
				closedir ($dossier);
	$texte.='</select>

			</td>
		  </tr>
		  <tr>
		  	<td>> Langue </td>
			<td>  <select name="langue">
				  <option value="langue">-- Langue --</option>
				  <option value="fr">Français</option>
				  </select>
			</td>
		  </tr>
		  </table>
		   <input type="submit" name="Submit" value="Go !" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/></FORM><br>';
	$texte.='<br><a href="?page=membre"><center>- Retour à Mon Compte -</center></a><br>';

	
break;
}
		 $afficher->AddSession($handle, "contenu");
		 $afficher->setVar($handle, "contenu.module_titre", "Compte de  ".ucfirst($_SESSION['sess_pseudo']));
		 $afficher->setVar($handle, "contenu.module_texte", $texte );
		 $afficher->CloseSession($handle, "contenu");
?>