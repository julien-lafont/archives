<?php
is_admin(); // Script de vérification Anti-Hack

switch (@$_GET['action']) {

	default:
	
	$texte="<div class=\"titreBS\">Administration de la tribune libre :</div>";
	
	$query = "SELECT * FROM ix_box ORDER BY id DESC";
	$sql = mysql_query($query);	
	
	$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px">Pseudo</td>
				<td class="liste_titre" style="font-size:10px">Message</td>
				<td class="liste_titre" style="font-size:10px"></td>
				<td class="liste_titre" style="font-size:10px">IP</td>
				<td class="liste_titre" style="font-size:10px">Date</td>
			  </tr>';
			  
	while($data = mysql_fetch_array($sql)) {
		
						
		$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'>".$data['pseudo']."</td>
					<td class='liste_txt' style='font-size:10px'>".$data['message']."</td>
					<td class='liste_txt' style='font-size:10px'></td>
					<td class='liste_txt' style='font-size:10px'>".$data['ip']."</td>
					<td class='liste_txt' style='font-size:10px'>".$data['date']."</td>
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/tribune&action=suppr&id=".$data['id']."\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;<a href=\"?page=admin/tribune&action=editer&id=".$data['id']."\"><img src=\"images/edit.jpg\" border=0></a></td>
			    </tr>";	
	}
		 
	$texte.="</table>";
	
break;

#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_box WHERE id=".$_GET['id']) or die ("erreur sql ".mysql_error());
	rediriger("?page=admin/tribune");
break;

#########################################################################################################
#########################################################################################################
case "editer";

	$query = "SELECT * FROM ix_box WHERE id=".$_GET['id'];
	$sql = mysql_query($query);	$data=mysql_fetch_object($sql);
	
		$texte='<div class="titreBS">Editer un message :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmesg" id="formmesg" method="post" action="?page=admin/tribune&action=editer2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tbody><tr>
			   <td width="200px">Pseudo</td>
			   <td colspan="2"><input name="pseudo" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$data->pseudo.'">
			   </td>
			 </tr>
			 <tr>
			   <td>Message</td>
			   <td colspan="2"><input name="message" class="case_inscript" size="25" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->message . '"></td>
			 </tr>
			 <tr>
			   <td>Date <br> </td>
			   <td colspan="2"><input name="date" class="case_inscript" size="25" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->date . '"></td>
			  </tr>
			 <tr>
			   <td>IP</td>
			   <td colspan="2"><input name="ip" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->ip . '"></td>
			 </tr>
			 </tbody></table>
		   <p align="center">
		     <input type="hidden" name="id" value="'.$data->id.'"><input name="Submit" value="Envoyer" type="submit" />
		   </p>';
		   
break;

#########################################################################################################
#########################################################################################################
case "editer2";

		// Vérifications :
	    if (empty($_POST['pseudo']) || empty($_POST['message']) || !isset($_POST['date']) || !isset($_POST['ip'])) {
            @$_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. <br>";
            @$erreur++; }

		if (!ereg ("([0-9]{1,2}) ([0-9]{1,2}) ([0-9]{4})", $_POST['date'])) {
	        @$_SESSION['message'] .= ">> Format de date invalide. Elle doit être du type : 25-12-2005<br>";
            @$erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            			
            rediriger("?page=admin/tribunes&action=editer&id=".$_POST['id']);
			exit;
			
        } else {
		
			// Insertion dans la base de donnée
			$date= $_POST['date'];
						
			$pseudo=$_POST['pseudo'];
			$message=$_POST['message'];
			$ip=$_POST['ip'];
						
            $req = mysql_query("UPDATE `ix_box` SET date='$date', pseudo='$pseudo', message='$message', ip='$ip' WHERE id=".$_POST['id']) or die ("erreur sql " . mysql_error());
			rediriger("?page=admin/tribune");
		}
break;
}

(empty($_GET['action'])) ? $texte.="" : $texte.='<br><a href="?page=admin/tribune"><center>- Retour à l\'admin de la tribune -</center></a>';

	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin tribune libre");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>