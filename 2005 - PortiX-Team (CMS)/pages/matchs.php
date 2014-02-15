<?php

switch (@$_GET['action']) {
    default:

	$query = "SELECT * FROM ix_matchs ORDER BY id DESC";
	$sql = mysql_query($query);		
		
	$texte='<br><table class="liste_table" cellpadding=0 cellspacing=2 align="center">
  <tr>
    <td class="liste_titre" width=20%>Date</td>
    <td class="liste_titre" width=25%>Adversaire</td>
    <td class="liste_titre" width=15%>Type</td>
	<td class="liste_titre" width=20%>Score</td>
	<td class="liste_titre" width=10%>Détail</td>
    <td class="liste_titre" width=10%>Démos</td>
  </tr>
';
		while($data = mysql_fetch_array($sql)) {
		
			if ($data['score1']<$data['score2']) { $color="#FFC8C8"; $colortxt="#E71B1B"; @$perdu++; }
			if ($data['score1']>$data['score2']) { $color="#D0F8C8"; $colortxt="#52C174"; @$gagne++; }
			if ($data['score1']==$data['score2']) { $color="#C8D8FF"; $colortxt="#3A37CE"; @$egalite++; }
			
			if (!empty($data['site_adv'])) { $adversaire="<a href=\"".$data['site_adv']."\" target=\"_blank\">".$data['adversaire']."</a>"; }
			else { $adversaire=$data['adversaire']; }
					
			if (!empty($data['hltv'])) { $demo='<a href="'.$data['hltv'].'" target="_blank"><img src="images/video.png" border=0 style="border:1px solid #FFFFFF;" OnMouseOver="this.style.border=\'1px outset #F7A118\'" OnMouseOut="this.style.border=\'1px solid #FFFFFF\'"></a>'; }
			else if (!empty($data['screen'])) { $demo='<a href="'.$data['screen'].'" target="_blank"><img src="images/screen.png" border=0 style="border:1px solid #FFFFFF;" OnMouseOver="this.style.border=\'1px outset #F7A118\'" OnMouseOut="this.style.border=\'1px solid #FFFFFF\'"></a>'; }
			else $demo="-";
			
			$texte.="  <tr>
						<td class='liste_txt'>".inverser_date($data['date'])."</td>
						<td class='liste_txt'>$adversaire</td>
						<td class='liste_txt'>".$data['type']."</td>
						<td class='liste_txt' bgcolor='$color'><font color='$colortxt'><b>".$data['score1']."/".$data['score2']."</b></font></td>
						<td class='liste_txt'><a href=\"?page=matchs&action=detail&id=".$data['id']."\"><img src='images/rapport.png' border=0 style=\"border:1px solid #FFFFFF;\" OnMouseOver=\"this.style.border='1px outset #108AFB'\" OnMouseOut=\"this.style.border='1px solid #FFFFFF'\"></a></td>
						<td class='liste_txt'>$demo</td>
					  </tr>";	
		 }
		 
$texte.="</table><p align=\"center\"><img src=\"images/carre_vert.jpg\" alt=\"\" name=\"carre_rouge\" width=\"10\" height=\"10\" id=\"carre_rouge\" /> Gagné - <img src=\"images/carre_rouge.jpg\" alt=\"\" name=\"carre_rouge\" width=\"10\" height=\"10\" id=\"carre_rouge\" /> Perdu - <img src=\"images/carre_bleu.jpg\" alt=\"\" name=\"carre_rouge\" width=\"10\" height=\"10\" id=\"carre_rouge\" /> Egalité";
$texte.="<br><br><br><b>$gagne</b> matchs gagnés, <b>$perdu</b> matchs perdus et <b>$egalite</b> égalités.<br></p>";
		
			$afficher->AddSession($handle, "contenu");
       		$afficher->setVar($handle, "contenu.module_titre", "Liste des matchs");
			$afficher->setVar($handle, "contenu.module_texte", $texte );
            $afficher->CloseSession($handle, "contenu"); 
break;

case "detail":

	$query = "SELECT * FROM ix_matchs WHERE id=".$_GET['id'];
	$sql = mysql_query($query);	$data=mysql_fetch_object($sql);
	
	(file_exists("images/maps/" . $data->map1 . ".jpg")) ? $urlimg1="images/maps/" . $data->map1 . ".jpg" : $urlimg1="images/maps/none.jpg"; 
	(file_exists("images/maps/" . $data->map2 . ".jpg")) ? $urlimg2="images/maps/" . $data->map2 . ".jpg" : $urlimg2="images/maps/none.jpg"; 
	if (isset($data->map1)) { $imgmap1='<img src="'.$urlimg1.'" style="border:1px solid #000000">';  }
	if (isset($data->map2)) { $imgmap2='<img src="'.$urlimg2.'" style="border:1px solid #000000">';  }
	
			$maps='<table width="322" align="center" cellpadding="0" cellspacing="0" >
                  <tr bgcolor="#000000">
                    <td><div align="center"><font color="#FFFFFF">Map 1 : <b>'.$data->map1.'</b></font></div></td>
                    <td><div align="center"><font color="#FFFFFF">Map 2 : <b>'.$data->map2.'</b></font></div></td>
                  </tr>
                  <tr>
                    <td>'.@$imgmap1.'</td>
                    <td>'.@$imgmap2.'</td>
                  </tr>
                </table>';
	
		$texte='<p align="center"><br /><span class="txt2" style="font-size:13px; font-weight:bold"> D&eacute;tail du Match contre les 	'.$data->adversaire.'</SPAN></p>
                <p>'.$maps.'<br><br>
				<span class="txt2">Date</span> : '.inverser_date($data->date).@$case.'<br /> 
                <span class="txt2">Type</span> : '.$data->type.'<br />
				<span class="txt2">Line Up</span> : '.$data->lineup.'<br />
                <span class="txt2">Score</span> : <b>'.$data->score1.'</b> / '.$data->score2.'</p>
                <p><span class="txt2">Rapport : </span><br />
                	'.$data->rapport.'<br />
                 	<br />
                <span class="txt2"> Lien D&eacute;mo </span>: <a href="'.$data->hltv.'" target="_blank">'.$data->hltv.'</a><br />
                <span class="txt2">Lien Screen </span>: <a href="'.$data->screen.'" target="_blank">'.$data->screen.'</a> </p>
                <p align="center"><br>- Post&eacute; un commentaire -  ( a venir ! )<br>
                </p>';
	
		$afficher->AddSession($handle, "contenu");
		$afficher->setVar($handle, "contenu.module_titre", "Détail d'un match");
		$afficher->setVar($handle, "contenu.module_texte", $texte );
		$afficher->CloseSession($handle, "contenu"); 

}
				
?>