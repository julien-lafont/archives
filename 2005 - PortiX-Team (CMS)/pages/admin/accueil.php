<?php
is_admin(); // Script de vérification Anti-Hack

	$texte="<br>Hello <b>".ucfirst($_SESSION['sess_pseudo'])."</b>, bienvenue sur votre espace d'administration.<br /><br />";
	$texte.="<table id=\"caseadmin\">
                    <tr>
                      <td><b class='txt2'>News</b></td>
                      <td><b class='txt2'>Membres</b></td>
                      <td><b class='txt2'>Statistiques</b></td>
                      <td><b class='txt2'>Articles</b></td>
                      <td><b class='txt2'>Configuration</b></td>
                    </tr>
					<tr>
                      <td id=\"tdadmin\"><a href=\"?page=admin/news\"><img src=\"images/admin/addedit.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></a></td>
                      <td id=\"tdadmin\"><a href=\"?page=admin/membres\"><img src=\"images/admin/profil.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></a></td>
                      <td id=\"tdadmin\"><a href=\"?page=admin/stats\"><img src=\"images/admin/stats.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></a></td>
                      <td id=\"tdadmin\"><a href=\"?page=admin/articles\"><img src=\"images/admin/article2.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></a></td>
                      <td id=\"tdadmin\"><a href=\"#\"><img src=\"images/admin/config.png\" width=\"48\" height=\"48\" border=\"0\" style=\"border:1px solid #000000; background-color:#FFFFFF; padding:3px\" onMouseover=\"this.style.border='1px solid #0099FF'\" onMouseout=\"this.style.border='1px solid #000000'\"/></a></td>
                    </tr>
					</table>
					<br><br>
				  <span class='txt2'>Administration des Modules :</span><br><br>
				  <table align=\"center\">
				  	<tr>
					  <td align=\"center\"><a href=\"?page=admin/matchs\">Matchs</a> | <br>-------- | <br>-------- | </td>
					  <td align=\"center\"><a href=\"?page=admin/tribune\">ShoutBox</a> | <br>-------- | <br>-------- | </td>
					  <td align=\"center\"><a href=\"?page=admin/upload\">Centre d'upload</a> | <br>-------- | <br>-------- | </td>
					  <td align=\"center\">-------- | <br>-------- | <br>--------</td>
					</tr>
				  </table>";
				  
    $afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Index de l'administration");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>