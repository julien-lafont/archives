<?php
is_admin(); // Script de vérification Anti-Hack

switch (@$_GET['action']) {

	default:
	
	$texte="<div class=\"titreBS\">Administration Serveurs :</div>";
	$texte.="<div class=\"ajouter_centre\"><a href=\"?page=admin/server&action=ajouter\">» Ajouter un Serveur «</a></div><br>";

	
	$query = "SELECT * FROM ix_server ORDER BY id DESC";
	$sql = mysql_query($query);	
	
	$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px">Adresse IP :</td>
				<td class="liste_titre" style="font-size:10px">Type de jeux :</td>
				<td class="liste_titre" style="font-size:10px"></td>
			  </tr>';
			  
	while($data = mysql_fetch_array($sql)) {
		
						
		$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'>".$data['ip'].":".$data['port']."</td>
					<td class='liste_txt' style='font-size:10px'>".$data['jeux']."</td>
					<td class='liste_txt' style='font-size:10px'></td>
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/server&action=suppr&id=".$data['id']."\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;<a href=\"?page=admin/server&action=editer&id=".$data['id']."\"><img src=\"images/edit.jpg\" border=0></a></td>
			    </tr>";	
	}
		 
	$texte.="</table>";
	
break;

#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_server WHERE id=".$_GET['id']) or die ("erreur sql ".mysql_error());
	rediriger("?page=admin/server");
break;

#########################################################################################################
#########################################################################################################
case "ajouter":

	$texte='<div class="titreBS">Ajouter un serveur :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formserver" id="formserver" method="post" action="?page=admin/server&action=ajouter2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tbody><tr>
			   <td width="200px">Adresse IP </td>
			   <td colspan="2"><input name="ip" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text">
			   </td>
			 </tr>
			 <tr>
			   <td>Port </td>
			   <td colspan="2"><input name="port" class="case_inscript" size="25" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text"></td>
			 </tr>
			 <tr>
			   <td>Type <br> </td>
			   <td colspan="2"><input name="type" class="case_inscript" size="25" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="hlife"></td>
			  </tr>
		   </tbody></table>
		   <p align="center">
		     <input name="Submit" value="Ajouter" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
		   </p>';
		   	
break;

#########################################################################################################
#########################################################################################################
case "ajouter2":

	// Vérifications :
		
	    if (empty($_POST['ip']) || empty($_POST['port']) || !isset($_POST['type'])) {
            @$_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de remplir les champs IP, Port et Type.<br>";
            @$erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            
			// On met les champs déjà inscrits en sessions, pour éviter de les retapper
            $_SESSION['ip'] = $_POST['ip'];
            $_SESSION['port'] = $_POST['port'];
            $_SESSION['type'] = $_POST['type'];
			
            rediriger("?page=admin/server&action=ajouter");
			exit;
        } else {
		
			// Insertion dans la base de donnée

			$ip=$_POST['ip'];
			$port=$_POST['port'];
			$type=$_POST['type'];
			
            $req = mysql_query("INSERT INTO `ix_server` ( `ip` , `port` , `jeux`) VALUES ('$ip', '$port','$type')") or die ("erreur sql " . mysql_error());
			rediriger("?page=admin/server");
		}
break;

#########################################################################################################
#########################################################################################################
case "editer";

	$query = "SELECT * FROM ix_server WHERE id=".$_GET['id'];
	$sql = mysql_query($query);	$data=mysql_fetch_object($sql);
	
		$texte='<div class="titreBS">Editer un serveur :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmesg" id="formmesg" method="post" action="?page=admin/server&action=editer2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tbody><tr>
			   <td width="200px">Adresse IP</td>
			   <td colspan="2"><input name="ip" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$data->ip.'">
			   </td>
			 </tr>
			 <tr>
			   <td>Port</td>
			   <td colspan="2"><input name="port" class="case_inscript" size="25" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->port . '"></td>
			 </tr>
			 <tr>
			   <td>Type de jeux <br> </td>
			   <td colspan="2"><input name="type" value="hlife" class="case_inscript" size="25" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->jeux . '"></td>
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
	    if (empty($_POST['ip']) || empty($_POST['port']) || !isset($_POST['type'])) {
            @$_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. <br>";
            @$erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            			
            rediriger("?page=admin/server&action=editer&id=".$_POST['id']);
			exit;
			
        } else {
		
			// Insertion dans la base de donnée
			$ip=$_POST['ip'];
			$port=$_POST['port'];
			$type=$_POST['type'];
						
            $req = mysql_query("UPDATE `ix_server` SET ip='$ip', port='$port', jeux='$type' WHERE id=".$_POST['id']) or die ("erreur sql " . mysql_error());
			rediriger("?page=admin/server");
		}
break;
}

(empty($_GET['action'])) ? $texte.="" : $texte.='<br><a href="?page=admin/server"><center>- Retour à l\'admin serveur -</center></a>';

	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin Serveurs");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>