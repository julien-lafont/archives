<?php
securite_membre();

// Si aucun pseudo n'est sélectionné
if (empty($_GET['pseudo']))
{
	bloquerAcces("Accés direct interdit.");
}

$design->zone('header', '<script type="text/javascript" src="javascript/-profil.js" ></script>');
$design->zone('titrePage', 'Guestbook de '.ucfirst($_GET['pseudo']));

// Corespondance Pseudo->Id
$sqlMembre = mysql_query("SELECT id FROM ".PREFIX."membres WHERE pseudo='".addBdd(strtolower($_GET['pseudo']))."'");
	$membre=mysql_fetch_object($sqlMembre);	
	$id = $membre->id;
	if (mysql_affected_rows()!=1)
	{
		bloquerAcces("Le membre que vous avez indiqué n'est pas présent dans notre base de donnée !");
	}

// ---------------------------------------------------------------------------------------------------------
// Bloc Ecrire un message + BBcode
// ---------------------------------------------------------------------------------------------------------
$writeMess='
		<div id="imgMessage" style="text-align:center">
			<br /><br /><a href="#" onclick="gbWrite(); return false"><img src="images/profil/writeGB.png" /></a><br />
			<b style="font-size:10px">Laisse un message sur le guestbook de '.ucfirst($_GET['pseudo']).'</b><br /><br />
		</div>
		
		<div id="writeMessage" style="display:none; text-align:center">
		<br />
		<form name="post" onsubmit="gbSend(); return false"><fieldset id="form">
			<img src="images/bbcode/tb_bold.gif" width="24" height="24" onclick="bbstyle(0)" onMouseOver="this.src=\'images/bbcode/tb_bold_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_bold.gif\'" onMouseDown="this.src=\'images/bbcode/tb_bold_down.gif\'; ">
			<img src="images/bbcode/tb_italic.gif" width="24" height="24" onclick="bbstyle(2)" onMouseOver="this.src=\'images/bbcode/tb_italic_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_italic.gif\'" onMouseDown="this.src=\'images/bbcode/tb_italic_down.gif\'; ">
			<img src="images/bbcode/tb_underline.gif" width="24" height="24" onclick="bbstyle(4)" onMouseOver="this.src=\'images/bbcode/tb_underline_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_underline.gif\'" onMouseDown="this.src=\'images/bbcode/tb_underline_down.gif\'; ">&nbsp;&nbsp;
			<img src="images/bbcode/tb_hyperlink.gif" width="24" height="24" onclick="bbstyle(16)" onMouseOver="this.src=\'images/bbcode/tb_hyperlink_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_hyperlink.gif\'" onMouseDown="this.src=\'images/bbcode/tb_hyperlink_down.gif\'; ">
			<img src="images/bbcode/tb_image_insert.gif" width="24" height="24" onclick="bbstyle(14)" onMouseOver="this.src=\'images/bbcode/tb_image_insert_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_image_insert.gif\'" onMouseDown="this.src=\'images/bbcode/tb_image_insert_down.gif\'; ">&nbsp;&nbsp;
			<img src="images/bbcode/tb_left.gif" width="24" height="24" onclick="bbstyle(18)" onMouseOver="this.src=\'images/bbcode/tb_left_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_left.gif\'" onMouseDown="this.src=\'images/bbcode/tb_left_down.gif\'; ">
			<img src="images/bbcode/tb_center.gif" width="24" height="24" onclick="bbstyle(20)" onMouseOver="this.src=\'images/bbcode/tb_center_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_center.gif\'" onMouseDown="this.src=\'images/bbcode/tb_center.gif\'; ">
			<img src="images/bbcode/tb_right.gif" width="24" height="24" onclick="bbstyle(22)" onMouseOver="this.src=\'images/bbcode/tb_right_over.gif\'" onMouseOut="this.src=\'images/bbcode/tb_right.gif\'" onMouseDown="this.src=\'images/bbcode/tb_right_down.gif\'; ">
			<select name="addbbcode18" onChange="bbfontstyle(\'[color=\' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" style="vertical-align:top; width:75px">
				<option style="color:black; background-color: #FAFAFA" value="#444444">Couleur</option>
				<option style="color:darkred; background-color: #FAFAFA" value="darkred">Rouge foncé</option>
				<option style="color:red; background-color: #FAFAFA" value="red">Rouge</option>
				<option style="color:orange; background-color: #FAFAFA" value="orange">Orange</option>
				<option style="color:brown; background-color: #FAFAFA" value="brown">Marron</option>
				<option style="color:yellow; background-color: #FAFAFA" value="yellow">Jaune</option>
				<option style="color:green; background-color: #FAFAFA" value="green">Vert</option>
				<option style="color:olive; background-color: #FAFAFA" value="olive">Olive</option>
				<option style="color:cyan; background-color: #FAFAFA" value="cyan">Cyan</option>
				<option style="color:blue; background-color: #FAFAFA" value="blue">Bleu</option>
				<option style="color:darkblue; background-color: #FAFAFA" value="darkblue">Bleu foncé</option>
				<option style="color:indigo; background-color: #FAFAFA" value="indigo">Indigo</option>
				<option style="color:violet; background-color: #FAFAFA" value="violet">Violet</option>
				<option style="color:white; background-color: #FAFAFA" value="white">Blanc</option>
				<option style="color:black; background-color: #FAFAFA" value="black">Noir</option>
				</select><br>
				
		<textarea name="messageBG" id="messageBG" class="size100"></textarea><br>
		
		<div id="smiley">
		  <a href="javascript:emoticon(\'8-:\')"><img src="images/smileys/blink.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\'^:\')"><img src="images/smileys/CADQ0UD5.png" width="19" height="19" border="0" /></a>
		  <a href="javascript:emoticon(\':cool:\')"><img src="images/smileys/cool.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':pet:\')"><img src="images/smileys/cool40.gif" width="21" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':evil:\')"><img src="images/smileys/evil.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':D\')"><img src="images/smileys/06.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':bad:\')"><img src="images/smileys/128.gif" width="29" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':good:\')"><img src="images/smileys/ok.gif" width="21" height="21" border="0" /></a>
		  <a href="javascript:emoticon(\':lang:\')"><img src="images/smileys/130.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':rah:\')"><img src="images/smileys/32.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':??:\')"><img src="images/smileys/91.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':)\')"><img src="images/smileys/original.gif" width="18" height="18" border="0" /></a>
		  <a href="javascript:emoticon(\':scotch:\')"><img src="images/smileys/shutup.gif" width="20" height="20" border="0" /></a>
		  <a href="javascript:emoticon(\':intello:\')"><img src="images/smileys/smartass.gif" width="25" height="22" border="0" /></a>
		  <a href="javascript:emoticon(\':whaou:\')"><img src="images/smileys/w00t.gif" width="18" height="20" border="0" /></a> 
		  <a href="javascript:emoticon(\':!:\')"><img src="images/smileys/sign56.gif" width="20" height="20" border="0" /></a><br>
	
			<input type="hidden" id="id_membre" value="'.$id.'" />
			<br /><input type="submit" class="submit" value="envoyer" id="sendGb"/>
			<img src="images/indicator2.gif" style="display:none" id="waitGb"/><br /><br />
		</fieldset></form>
	</div>
';
//----------------------------------------------------------------------------------------------

// Sélections des données :
	
	$nbPseudo=mysql_affected_rows();
	if ($nbPseudo==0) {	
		$contenu=miseenforme('erreur', "Le membre que vous avez indiqué n'est pas présent dans notre base de donnée !");
		$design->zone('contenu', $contenu);
		$design->template('simple');
		$design->afficher();
		die();
	}

	// Pagination
	$sql_pre=mysql_query("SELECT count(id) as nb FROM ".PREFIX."guestbook WHERE id_membre=$id");
	$pre=mysql_fetch_object($sql_pre);
	$nbG=$pre->nb;

	$first=(int)$_GET['page']; 
	if ($first==null) $limit="LIMIT 0,10"; 
	else $limit="LIMIT $first,10";
	
	$nbpages=ceil($nbG/10); $current=(round($first/10))+1;
	if ($nbpages>1) {
		$pagination="<center><div id='pagination'>";
			for ($i=1; $i<=$nbpages; $i++) {
				if ($i!=1) $pagination.=" . ";
				if ($i==$current) $pagination.= "<b>$i</b>";
				else $pagination.= "<a href='membre/guestbook/".$_GET['pseudo']."/?page=".(($i*10)-10)."'>$i</a>";
			}	
		$pagination.= '</div></center>';
		$design->zone('pagination', $pagination);
	}
	
	// Gestion du nom de Gb non-lu ?
	if ($id==$_SESSION['sess_id'] && $nbG!=$_SESSION['sess_gb_lu']) {
		$_SESSION['sess_gb_lu']=$nbG;
		$sqlLu=mysql_query("UPDATE ".PREFIX."membres SET nb_gb_lu=$nbG WHERE id=$id");
	}
		

$sql=mysql_query("	SELECT g.id as idG, g.message, g.date, m.pseudo, m.last_activity, md.gen_sexe, md.avatar
					FROM ".PREFIX."guestbook g
					LEFT JOIN ".PREFIX."membres m
					ON m.id=g.id_auteur
					LEFT JOIN ".PREFIX."membres_detail md
					ON md.id_membre=m.id
					WHERE g.id_membre=$id
					ORDER BY g.date DESC
					$limit
				") or die(mysql_error());


// Aucun message dans les Guestbook [
if ($nbG==0)
{
	$design->template('simple');

	$design->zone('titrePage', 'Guestbook' );
	$design->zone('titre', 'Guestbook de '.ucfirst($_GET['pseudo']).' &nbsp;-&nbsp; <i>'.NOM.'</i>');
	$design->zone('contenu', miseenforme('message', 'Aucun message sur le Guestbook de '.ucfirst($_GET['pseudo']))."<br />".$writeMess."<br />" );
	
}
// Si il y a des messages
else 
{

	//:: Affichage du guestBook
	$design->template('blocs');
	
	//:: Gestion des #id
	if (empty($first)) { $num=$nbG; }
	else { $num=$nbG-$first; }
	
	$design->bloc('bloc', array('titre', 'contenu') );
	while ($d=mysql_fetch_object($sql))
	{
		// Sélection de l'image en fonction de l'icone
		$img=imgOnline($d->gen_sexe, $d->last_activity);
	
		// Modification de la date
		$date1 = inverser_date(substr($d->date,0,10));
		$date2 = substr($d->date,11,2);
		$date3 = substr($d->date,14,2);
		$date = $date1." ".$date2.":".$date3;
		
				
		$titre='<span style="font-size:11px">#'.$num.'</span> &nbsp;<img src=images/'.$img.' /> <b>'.ucfirst($d->pseudo).'</b> 
				<span style="font-size:9px">@ '.$date.'</span>
				
				<span style="font-size:10px; margin-left:100px">
					  <a href="Profil/'.$d->pseudo.'/">Profil</a> - 
					  <a href="Guestbook/'.$d->pseudo.'/">Guestbook</a> - 
					  <a href="Galerie-photo/yotsumi/'.$d->pseudo.'/">Galerie</a>		
				</span>';
				
		$contenu=bbcode(nl2br(recupBdd($d->message)));
		
		$design->blocOccurence( array($titre, $contenu) );
		$num--;
	}
	
	// On affiche le bloc message
	$design->blocOccurence( array("<strong>Ecrire un message</strong>", $writeMess) );
}


?>