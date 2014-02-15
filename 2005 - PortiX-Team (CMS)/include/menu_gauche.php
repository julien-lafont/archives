<?

// ---------------------------------------------------------- //
//           Configuration des menus de GAUCHE                //
//                                                            // 
// Pour créer un menu, il suffit de mettre le contenu de      //
//  celui ci dans une variable nommée $menudroitetxt[x] et    //
//  $menudroitetitre[x] où X est un même nombre pas encore    //
//  utilisé.												  //
// ---------------------------------------------------------- //

$menu_txt=array();
$menu_titre=array();

	// => Mettez ici les différents menus //
	
$menu_titre[1]="Menu Général";
$menu_txt[1]='&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=news">News</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=news&action=archives">Archives</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=profil">Membres</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=matchs">Les Matchs</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=telechargement">Téléchargements</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=upload">Centre d\'upload</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=articles">Articles</a><br>
&nbsp;&nbsp;&nbsp;&nbsp;- <a href="?page=prop_articles">Proposer un article</a><br>';	
//-----------------------------------------------------------------

if (empty($_SESSION['sess_id'])) {

	$menu_titre[2]="Connexion";
	$menu_txt[2]='<br><form name="identification" method="Post" action="?page=fonc/identification"><table><tr><td align="center">Pseudo</td><td><input type="text" name="login" class="case_inscript" style="width:70px; height:12px;font-size:10px;"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'4px solid #305FA3\'"></td></tr>
				 <tr><td align="center">Pass</td><td><input type="password" name="pass" class="case_inscript" style="width:70px; height:12px;font-size:10px;" onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"></td></tr>
				 <tr><td><input type="hidden" name="page" value="'.@$_GET['page'].'"></td><td align="right"><input type="submit" value="OK" class="case_inscript" style="width:30px; height:16px;font-size:11px;"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'"></td></tr></table></form>
				 &nbsp;&nbsp;&nbsp;&nbsp;. <a href="?page=inscription">Inscription</a><br>
				 &nbsp;&nbsp;&nbsp;&nbsp;. <a href="#"  ONCLICK="alert(\'En cours de codage !\');">Mot de Passe ?</a><br>';
} else {		

		$sql_nbmess = mysql_query("SELECT * FROM ix_mp WHERE id_dest=".$_SESSION['sess_id']." AND etat='nouveau'");
		$nb_mess = mysql_num_rows($sql_nbmess);
		if ($nb_mess!=0) {
			if (nav()=='moz') 	$mess="<br><center><a href=\"?page=mp\"><img src=\"images/newmail.png\" border=0></a><span class='txt2'><br><blink>Nouveau Message !</blink></span></center>"; 
			else 				$mess="<br><center><a href=\"?page=mp\"><img src=\"images/newmail2.png\" border=0></a><span class='txt2'><br><blink>Nouveau Message !</blink></span></center>";
		}
		
	$menu_titre[2]="Votre compte";
	$menu_txt[2]='<br>Bienvenue <b>'.ucfirst($_SESSION['sess_pseudo']).'</b><br>'.$mess.'<br>
				 &nbsp;&nbsp;&nbsp;&nbsp;. <a href="?page=fonc/deconnection">Se déconnecter</a><br>';
	if (isset($_SESSION['sess_id'])) 	$menu_txt[2].='<br>&nbsp;&nbsp;&nbsp;&nbsp;. <a href="?page=membre">Mon compte</a>';
	if ($_SESSION['sess_niveau']!=0) 	$menu_txt[2].='<br>&nbsp;&nbsp;&nbsp;&nbsp;. <a href="?page=admin/accueil">Administration</a><br>';
}
						 
	//-----------------------------------------------------------------

if (!empty($_SESSION['sess_id'])) { // IL FAUT ETRE CONNECTER POUR VOIR LE MENU
$menu_titre[3]="Thèmes";
$menu_txt[3]='<center><br>Changer de thème :</br>
				<FORM name="theme"><select name="theme" onChange="ouvrir()">
				<option value="'.$ixteam['theme'].'">-- Themes --</option>';

        $dossier = opendir ("theme/");

        while ($fichier = readdir ($dossier)) {
            if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db") {
                $menu_txt[3] .= '<option value="' . $fichier . '">' . $fichier . '</option>';
            } 
        } 
        closedir ($dossier);
$menu_txt[3].='</select><input type="hidden" name="newpage" value="'.@$_GET['page'].'"></FORM></center>';
}
  
	//-----------------------------------------------------------------
	
	$menu_titre[5]="Shoutbox V2";
	$menu_txt[5]='<br><div style="width:150px; height:200px; overflow:auto;"><div>';
	
	$sql = mysql_query("SELECT pseudo, message FROM ix_box ORDER BY id DESC LIMIT 10");
			
			while($result = mysql_fetch_object($sql) ) { 
			$sql_ps = mysql_query("SELECT pseudo FROM ix_membres WHERE id=".$result->pseudo);
			$ps = mysql_fetch_object($sql_ps);
			
			$idps = $result->pseudo;
			$pseudo = ucfirst($ps->pseudo);
			$msg = $result->message;
			
			$menu_txt[5].="<b><a href='?page=profil&id=$idps' target='_blank'>$pseudo</a></b><br>$msg<br><br>"; 
			}
			
	$menu_txt[5].='</div></div><br>';
	
	if (!empty($_SESSION['sess_id'])) { // Si on est connecte !

	$menu_txt[5].='<div id="poster" style="cursor:pointer" OnClick="document.getElementById(\'poster2\').style.display=\'block\'; document.getElementById(\'poster\').style.display=\'none\';">
						<center>- Poster un message -</center>
					</div>
					<div id="poster2" style="display:none">
						<form name="shoutbox" method="Post" action="?page=fonc/shoutbox"> 
						<center><textarea name="message" id="newst" rows="3" wrap="PHYSICAL" class="txt_comnews" style="width:90%; border:1px solid #000000"></textarea></center>
						<input type="hidden" name="page" value="'.$_GET['page'].'">
						<input type="submit" value="&nbsp;Chatter" class="case_inscript" style="width:98%; height:18px;font-size:12px;"  onMouseOver="this.style.border=\'1px solid #73BEF7\'" onMouseOut="this.style.border=\'1px solid #666666\'">
						</form>
					</div>';
	 } else {
	 
  	$menu_txt[5].='<i><center>Vous devez être loggé pour Chatter</center></i>';
	
	}

	//-----------------------------------------------------------------

 
for ($i=1;$i<=99;$i++){ 
	if (isset($menu_titre[$i])) {
    $afficher->AddSession($handle,"menug");
    $afficher->setVar($handle,"menug.titre",$menu_titre[$i]);
    $afficher->setVar($handle,"menug.texte",$menu_txt[$i]);
    $afficher->CloseSession($handle,"menug"); 
	}
}

?>