<?php
is_admin(); // Script de vérification Anti-Hack

switch (@$_GET['action']) {

	default:
	
	$texte="<div class=\"titreBS\">Administration des matchs :</div>";
	$texte.="<div class=\"ajouter_centre\"><a href=\"?page=admin/matchs&action=ajouter\">» Ajouter un Match «</a></div><br>";
	
	$query = "SELECT * FROM ix_matchs ORDER BY id DESC";
	$sql = mysql_query($query);	
	
	$texte.='<table class="liste_table" cellpadding=0 cellspacing=2 align="center">
              <tr>
				<td class="liste_titre" style="font-size:10px">Date</td>
				<td class="liste_titre" style="font-size:10px">Adversaire</td>
				<td class="liste_titre" style="font-size:10px">Maps</td>
				<td class="liste_titre" style="font-size:10px">Score</td>
				<td class="liste_titre" style="font-size:10px">Vid-Img</td>
				<td class="liste_titre" style="font-size:10px">Admin</td>
			  </tr>';
			  
	while($data = mysql_fetch_array($sql)) {
		
		if ($data['score1']<$data['score2']) { $color="#FFC8C8"; $colortxt="#E71B1B"; @$perdu++; }
		if ($data['score1']>$data['score2']) { $color="#D0F8C8"; $colortxt="#52C174"; @$gagne++; }
		if ($data['score1']==$data['score2']) { $color="#C8D8FF"; $colortxt="#3A37CE"; @$egalite++; }
		
		if (!empty($data['site_adv'])) { $adversaire="<a href=\"".$data['site_adv']."\" target=\"_blank\">".$data['adversaire']."</a>"; }
		else { $adversaire=$data['adversaire']; }
				
		if (!empty($data['hltv'])) $demo='Vidz';
		if (!empty($data['screen'])) $demo='Screen';
		if (!empty($data['hltv']) && !empty($data['screen'])) $demo='Vidz & Screen';

		$texte.="<tr>
					<td class='liste_txt' style='font-size:10px'>".inverser_date($data['date'])."</td>
					<td class='liste_txt' style='font-size:10px'>$adversaire</td>
					<td class='liste_txt' style='font-size:10px'>".$data['map1']." - ".$data['map2']."</td>
					<td class='liste_txt' style='font-size:10px'><font color='$colortxt'><b>".$data['score1']."/".$data['score2']."</b></font></td>
					<td class='liste_txt' style='font-size:10px'>".@$demo."</td>
					<td class='liste_txt' style='font-size:10px'><a href=\"?page=admin/matchs&action=suppr&id=".$data['id']."\"><img src=\"images/suppr.jpg\"  border=0></a>&nbsp;<a href=\"?page=admin/matchs&action=editer&id=".$data['id']."\"><img src=\"images/edit.jpg\" border=0></a></td>
			    </tr>";	
	}
		 
	$texte.="</table>";
	
break;

#########################################################################################################
#########################################################################################################
case "suppr":
	$req = mysql_query("DELETE FROM ix_matchs WHERE id=".$_GET['id']) or die ("erreur sql ".mysql_error());
	rediriger("?page=admin/matchs");
break;

#########################################################################################################
#########################################################################################################
case "ajouter":

	$texte='<div class="titreBS">Ajouter un match :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmatch" id="formmatch" method="post" action="?page=admin/matchs&action=ajouter2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tbody><tr>
			   <td width="200px">Team Adverse</td>
			   <td colspan="2"><input name="nomteam" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['nomteam'] . '">
			   </td>
			 </tr>
			 <tr>
			   <td>Site de la team </td>
			   <td colspan="2"><input name="siteteam" class="case_inscript" size="25" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['siteteam'] . '"></td>
			 </tr>
			 <tr>
			   <td>Date du match ( jj-mm-aaaa ) <br> </td>
			   <td colspan="2"><input name="date" class="case_inscript" size="25" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['date'] . '"></td>
			  </tr>
			 <tr>
			   <td>Type</td>
			   <td colspan="2"><input name="type" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['type'] . '"></td>
			 </tr>
			 <tr>
			   <td>Notre score - Leur score </td>
			   <td colspan="2"><input name="score1" class="case_inscript" size="5" maxlength="4" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['score1'] . '"/>
			     - 
			     <input name="score2" class="case_inscript" size="5" maxlength="4" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['score2'] . '"/></td>
			 </tr>
			 <tr>
			 	<td>&nbsp;<br><br></td><td></td><td></td>
			 <tr>
               <td>Map 1 </td>
               <td width="170px"><select class="formnews2" name="predef1" onchange="showmap1()" style="width: 160px; color:#333333">
			   <option value="none2.jpg">------ Map 1 ------</option>
				<option value="autre.jpg"> >> autre map</option>';

        $dossier = opendir ("images/maps/");
        while ($fichier = readdir ($dossier)) {
            if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db" && $fichier != "none.jpg" && $fichier != "autre.jpg") {
                $fichier2 = ereg_replace(".jpg", "", $fichier);
                $texte .= '<option value="' . $fichier . '">' . $fichier2 . '</option>';
            } 
        } 
        closedir ($dossier);
       $texte .= '</select> <br />
                 <br />
                 <input  name="autre1" class="case_inscript" size="23" maxlength="100" value="&agrave; remplir si autre" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" onclick="this.style.color=\'#0066FF\'; this.value=\'\'" style="font-style:italic; color:#888888"/></td>
				 <td width="120"><img src="images/maps/none2.jpg" name="predef_name1" width="118" height="89" alt="" align="absmiddle" style="border:1px solid #000000"></td>
			   </tr>
			 <tr>
               <td>Map 2 </td>
               <td width="170px"><select class="formnews2" name="predef2" onchange="showmap2()" style="width: 160px; color:#333333">
			   <option value="none2.jpg">------ Map 2 ------</option>
			<option value="autre.jpg"> >> autre map</option>';
        $dossier = opendir ("images/maps/");

        while ($fichier = readdir ($dossier)) {
            if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db" && $fichier != "none.jpg" && $fichier != "autre.jpg") {
                $fichier2 = ereg_replace(".jpg", "", $fichier);
                $texte .= '<option value="' . $fichier . '">' . $fichier2 . '</option>';
            } 
        } 
        closedir ($dossier);
       $texte .= '</select> <br />
                 <br />
                 <input  name="autre2" class="case_inscript" size="23" maxlength="100" value="&agrave; remplir si autre" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" onclick="this.style.color=\'#0066FF\'; this.value=\'\'" style="font-style:italic; color:#888888"/></td>
				 <td width="120"><img src="images/maps/none2.jpg" name="predef_name2" width="118" height="89" alt="" align="absmiddle" style="border:1px solid #000000"></td>
			   </tr>
			 <tr>
			 	<td>&nbsp;<br><br></td><td></td><td></td>
			 <tr>
			 <tr>
			   <td>Line Up :</td>
			   <td colspan="2"><input name="lineup" class="case_inscript" size="35" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['lineup'] . '"></td>
			   </tr>

			 <tr>
			   <td>Rapport</td>
			   <td  colspan="2"><textarea name="rapport" cols="35" rows="4" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. @$_SESSION['rapport'] . '</textarea></td>
			   </tr>
			 <tr>
			   <td>Lien vers D&eacute;mo ou Hltv</td>
			   <td  colspan="2"><input name="hltv" class="case_inscript" size="35" maxlength="150" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['hltv'] . '"/></td>
			   </tr>
			 <tr>
			   <td>Lien vers Screen </td>
			   <td  colspan="2"><input name="screen" class="case_inscript" size="35" maxlength="150" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @$_SESSION['screen'] . '"/></td>
			   </tr>
		   </tbody></table>
		   <p align="center">
		     <input name="Submit" value="Ajouter" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
		   </p>';
		   	
		    // On efface les varaibles session
         unset($_SESSION['nomteam']);
		 unset($_SESSION['nomteam']);
		 unset($_SESSION['siteteam']);
		 unset($_SESSION['date']);
		 unset($_SESSION['type']);
		 unset($_SESSION['score1']);
		 unset($_SESSION['score2']);
		 unset($_SESSION['rapport']);
		 unset($_SESSION['hltv']);
		 unset($_SESSION['screen']);
		 unset($_SESSION['lineup']);


break;

#########################################################################################################
#########################################################################################################
case "ajouter2":

	// Vérifications :
		
	    if (empty($_POST['nomteam']) || empty($_POST['date']) || !isset($_POST['score1']) || !isset($_POST['score2']) || empty($_POST['type'])) {
            @$_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de remplir les champs Nom_Team, Date, Score1, Score2 et Type.<br>";
            @$erreur++; }

		if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $_POST['date'])) {
	        @$_SESSION['message'] .= ">> Format de date invalide. Elle doit être du type : 25-12-2005<br>";
            @$erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            
			// On met les champs déjà inscrits en sessions, pour éviter de les retapper
            $_SESSION['nomteam'] = $_POST['nomteam'];
            $_SESSION['siteteam'] = $_POST['siteteam'];
            $_SESSION['date'] = $_POST['date'];
            $_SESSION['type'] = $_POST['type'];
            $_SESSION['score1'] = $_POST['score1'];
            $_SESSION['score2'] = $_POST['score2'];
            $_SESSION['rapport'] = $_POST['rapport'];
            $_SESSION['hltv'] = $_POST['hltv'];
			$_SESSION['screen'] = $_POST['screen'];
			$_SESSION['lineup'] = $_POST['lineup'];
			
            rediriger("?page=admin/matchs&action=ajouter");
			exit;
        } else {
		
			// Insertion dans la base de donnée
			$date2=@inverser_date($_POST['date'],2);
			
			$map1 = ereg_replace(".jpg", "", $_POST['predef1']);
			$map2 = ereg_replace(".jpg", "", $_POST['predef2']);
			if ($map1=="autre") $map1=$_POST['autre1'];
			if ($map2=="autre") $map1=$_POST['autre2'];
			if ($map1=="none") $map1="";
			if ($map2=="none") $map2="";
			
			$adv=$_POST['nomteam'];
			$siteadv=$_POST['siteteam'];
			$type=$_POST['type'];
			$score1=$_POST['score1'];
			$score2=$_POST['score2'];
			$rapport=$_POST['rapport'];
			$hltv=$_POST['hltv'];
			$screen=$_POST['screen'];
			$lineup=$_POST['lineup'];
			
            $req = mysql_query("INSERT INTO `ix_matchs` ( `date` , `adversaire` , `site_adv` , `score1` , `score2` , `type` , `map1` , `map2` , `rapport` , `hltv` , `screen` , `lineup`) VALUES ('$date2', '$adv','$siteadv','$score1','$score2','$type','$map1', '$map2', '$rapport', '$hltv', '$screen', '$lineup')") or die ("erreur sql " . mysql_error());
			rediriger("?page=admin/matchs");
		}
break;

#########################################################################################################
#########################################################################################################
case "editer";

	$query = "SELECT * FROM ix_matchs WHERE id=".$_GET['id'];
	$sql = mysql_query($query);	$data=mysql_fetch_object($sql);
	
		$texte='<div class="titreBS">Editer un match :</div>';
	    
		// Si un message d'erreur est envoyé, on l'affiche
        if (isset($_SESSION['message'])) {
            $texte .= "<div style=\"padding-left:20px; color:#FF0000\">" . stripslashes($_SESSION['message']) . "</div><br>";
            unset($_SESSION['message']);
        } 

	$texte.='<form name="formmatch" id="formmatch" method="post" action="?page=admin/matchs&action=editer2">
		   <table style="margin-left: 25px;" border="0" width="95%">
			 <tbody><tr>
			   <td width="200px">Team Adverse</td>
			   <td colspan="2"><input name="nomteam" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="'.$data->adversaire.'">
			   </td>
			 </tr>
			 <tr>
			   <td>Site de la team </td>
			   <td colspan="2"><input name="siteteam" class="case_inscript" size="25" maxlength="250" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->site_adv . '"></td>
			 </tr>
			 <tr>
			   <td>Date du match ( jj-mm-aaaa ) <br> </td>
			   <td colspan="2"><input name="date" class="case_inscript" size="25" maxlength="10" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . @inverser_date($data->date,3) . '"></td>
			  </tr>
			 <tr>
			   <td>Type</td>
			   <td colspan="2"><input name="type" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->type . '"></td>
			 </tr>
			 <tr>
			   <td>Notre score - Leur score </td>
			   <td colspan="2"><input name="score1" class="case_inscript" size="5" maxlength="4" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->score1 . '"/>
			     - 
			     <input name="score2" class="case_inscript" size="5" maxlength="4" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->score2 . '"/></td>
			 </tr>
			 <tr>
			 	<td>&nbsp;<br><br></td><td></td><td></td>
			 <tr>
               <td>Map 1 </td>
			   <td colspan="2"><input name="predef1" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->map1 . '"></td>
			   </tr>
			 <tr>
               <td>Map 2 </td>
			   <td colspan="2"><input name="predef2" class="case_inscript" size="25" maxlength="50" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->map2 . '"></td>
			   </tr>
			 <tr>
			 	<td>&nbsp;<br><br></td><td></td><td></td>
			 <tr>
			 <tr>
			   <td>Line Up :</td>
			   <td colspan="2"><input name="lineup" class="case_inscript" size="35" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' . $data->lineup . '"></td>
			  </tr>
			 <tr>
			   <td>Rapport</td>
			   <td  colspan="2"><textarea name="rapport" cols="35" rows="4" wrap="VIRTUAL" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'">'. $data->rapport . '</textarea></td>
			   </tr>
			 <tr>
			   <td>Lien vers D&eacute;mo ou Hltv</td>
			   <td  colspan="2"><input name="hltv" class="case_inscript" size="35" maxlength="150" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' .$data->hltv. '"/></td>
			   </tr>
			 <tr>
			   <td>Lien vers Screen </td>
			   <td  colspan="2"><input name="screen" class="case_inscript" size="35" maxlength="150" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'" type="text" value="' .$data->screen . '"/></td>
			   </tr>
		   </tbody></table>
		   <p align="center">
		     <input type="hidden" name="id" value="'.$data->id.'"><input name="Submit" value="Modifier" type="submit" class="case_inscript" onmouseover="this.style.border=\'1px solid #73BEF7\'" onmouseout="this.style.border=\'1px solid #666666\'"/>
		   </p>';
		   
break;

#########################################################################################################
#########################################################################################################
case "editer2";

		// Vérifications :
	    if (empty($_POST['nomteam']) || empty($_POST['date']) || !isset($_POST['score1']) || !isset($_POST['score2']) || empty($_POST['type'])) {
            @$_SESSION['message'] .= ">> Certains champs n'ont pas été renseignés. Il est obligatoire de remplir les champs Nom_Team, Date, Score1, Score2 et Type.<br>";
            @$erreur++; }

		if (!ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $_POST['date'])) {
	        @$_SESSION['message'] .= ">> Format de date invalide. Elle doit être du type : 25-12-2005<br>";
            @$erreur++; }

        if (@$erreur != 0) { // Si il ya eu des problèmes :
            			
            rediriger("?page=admin/matchs&action=editer&id=".$_POST['id']);
			exit;
			
        } else {
		
			// Insertion dans la base de donnée
			$date2=@inverser_date($_POST['date'],2);
						
			$adv=$_POST['nomteam'];
			$siteadv=$_POST['siteteam'];
			$type=$_POST['type'];
			$score1=$_POST['score1'];
			$score2=$_POST['score2'];
			$rapport=$_POST['rapport'];
			$hltv=$_POST['hltv'];
			$screen=$_POST['screen'];
			$map1=$_POST['predef1'];
			$map2=$_POST['predef2'];
			$lineup=$_POST['lineup'];
			
            $req = mysql_query("UPDATE `ix_matchs` SET date='$date2', adversaire='$adv', site_adv='$siteadv', score1='$score1', score2='$score2', type='$type', lineup='$lineup', map1='$map1', map2='$map2', rapport='$rapport', hltv='$hltv', screen='$screen' WHERE id=".$_POST['id']) or die ("erreur sql " . mysql_error());
			rediriger("?page=admin/matchs");
		}
break;
}

(empty($_GET['action'])) ? $texte.="" : $texte.='<br><a href="?page=admin/matchs"><center>- Retour à l\'admin des Matchs -</center></a>';

	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Admin matchs");
    $afficher->setVar($handle, "contenu.module_texte", $texte);
    $afficher->CloseSession($handle, "contenu");

?>