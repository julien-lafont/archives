<?php

if (!isset($_GET['idBreve']))
{
	bloquerAcces("Vous ne pouvez accéder directement à cette page !"); 

}
//:: Affichage d'une brève en détail :://
else
{
	$id=$_GET['idBreve'];
	
	// ---------------------------------------------------------------------------------------------------------
	// Bloc Ecrire un message + BBcode
	// ---------------------------------------------------------------------------------------------------------
	$writeCom='<br />
		<form name="post" onsubmit="comSend(); return false"><fieldset id="form">
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
				
		<textarea name="messageBG" id="messageBG" class="size100" style="opacity:0.8" wrap="virtual"></textarea><br>
		<div class="fond_textarea1"></div>
		
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
	
			<input type="hidden" id="id_breve" value="'.$id.'" />
			<br /><input type="submit" class="submit" value="envoyer" style="width:120px"/><br /><br />
		</fieldset></form>';
//----------------------------------------------------------------------------------------------

	//- D'abord la brève
	$sql=mysql_query("	SELECT b.id, b.titre, b.contenu, b.date, m.pseudo, m.last_activity, md.gen_sexe
						FROM ".PREFIX."breves b
						LEFT JOIN ".PREFIX."membres m
						ON m.id=b.id_auteur
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						WHERE b.id=$id")
					or die('Erreur de selection '.mysql_error());

	$d=mysql_fetch_object($sql);
	
	$nb=mysql_affected_rows();
	if ($nb==0) {
		bloquerAcces("Cette brève n'est pas ( ou plus ) présente dans notre base de donnée");
	}
	
		// Contenu du blog Ecrire :
		if (is_log()) $comDetailHtml=$writeCom;
		else		  $comDetailHtml="<b>Vous devez être connecté pour pouvoir poster un commentaire</b>";

		// Actions admin
		if (is_admin()) $admin='<div class="bloc_admin_news" id="bloc_admin">Admin <br /><a href="?admin-breves&action=editer&id='.$d->id.'"><img src="images/boutons/playlist.png" /></a> &nbsp;<a href="#" onclick="ConfirmSupprBreve('.$d->id.'); return false"><img src="images/boutons/del.png" /></a></div>';
		
	$contenu='
		<div id="contenuNews">
			'.@$admin.recupBdd($d->contenu).'
		</div>
		<div style="text-align:right; margin:10px 0">
			Par <a href="profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a> le '.inverser_date($d->date, 6).'
		</div>
		
		<div id="posterCom" align="center"><a href="#" onclick="showWriteCom(); return false">Poster un commentaire</a></div>
		<center><div id="posterComDetail" style="display:none">'.$comDetailHtml.'</div></center>';
	
	//- Puis les commentaires
	
		// Pagination
		$sql_pre=mysql_query("SELECT count(id) as nb FROM ".PREFIX."breves_com WHERE id_breve=$id");
		$pre=mysql_fetch_object($sql_pre);
		$nbC=$pre->nb;

		$first=(int)$_GET['page']; 
		if ($first==null) $limit="LIMIT 0,15"; 
		else $limit="LIMIT $first,15";

		$nbpages=ceil($nbC/15); $current=(round($first/15))+1;
	
		$pagination="<center><div id='pagination'>";
		for ($i=1; $i<=$nbpages; $i++) {
			if ($i!=1) $pagination.=" . ";
			if ($i==$current) $pagination.= "<b>$i</b>";
			else $pagination.= '<a href="breves/'.$id.'/'.recode($d->titre).'/?page='.(($i*15)-15).'">'.$i.'</a>';
		}	
		$pagination.= '</div></center>';


	$sqlCom=mysql_query("SELECT b.id, b.message, b.date, b.id_auteur, m.pseudo, m.last_activity, md.gen_sexe, md.avatar
						 FROM ".PREFIX."breves_com b
						 LEFT JOIN ".PREFIX."membres m
						 ON m.id=b.id_auteur
						 LEFT JOIN ".PREFIX."membres_detail md
						 ON md.id_membre=b.id_auteur
						 WHERE b.id_breve=$id
						 ORDER BY b.date DESC
						 $limit");
						 
	if ($nbpages>1) $contenu.=$pagination;
	
		//:: Gestion des #id
		if (empty($first)) { $num=$nbC; }
		else { $num=$nbC-$first; }

	$i=0;
	while ($b=mysql_fetch_object($sqlCom)) 
	{
		if ($i%2==0) $class="comDetailA";
		else		 $class="comDetailB";
		if ($i==0)	 $class="comDetailATop";
		
		// On gère l'avatar
		if (empty($b->avatar)) 	$avatar="images/avatar/no_avatar_little2.gif";
		else					$avatar="images/avatar/".$b->avatar;
		
		// Actions administrateurs
		if (is_admin()) $admin='<br /><span class="admin">Admin : 
												<a href="#" onclick="adEdit('.$b->id.'); return false">edit</a> - 
												<a href="#" onclick="adSuppr('.$b->id.', '.$d->id.'); return false">suppr</a>';
		else $admin=NULL;
		
		// Editer MES commentaires
		if ($b->id_auteur==$_SESSION['sess_id']) $edit='<div style="width:16px; height:16px; float:right; margin:2px; margin-top:-13px"><a href="#" onclick="adEdit('.$b->id.'); return false"><img src="images/boutons/edit.png" /></a></div>';
		else $edit=NULL;
		
		$com='<table class="'.$class.'" id="com'.$b->id.'">
			<tr>
				<td rowspan=2 width="150" align="center" id="first"> <img src="'.$avatar.'" class="imgAvatarSmall">'.$admin.'</td>
				<td style="vertical-align:top; height:30px !important; height:10px; padding-left:7px;">#'.$num.' - Par <b><a href="profil/'.trim($b->pseudo).'/">'.trim(ucfirst($b->pseudo)).'</a></b> le <b style="font-size:10px">'.inverser_date($b->date,6).'</b>'.$edit.'</td>
			</tr>
			<tr>
				<td style="vertical-align:top; padding-left:7px; height:auto !important; height:50px">'.nl2br(bbcode(recupBdd($b->message))).'</td>
			</tr>
		
		</table>';
		
		$contenu.=$com;
		$i++;
		$num--;
	}
	
	// Pagination
	$nbpages=ceil($nbC/15); $current=(round($first/15))+1;
	
	$pagination="<center><div id='pagination'>";
		for ($i=1; $i<=$nbpages; $i++) {
			if ($i!=1) $pagination.=" . ";
			if ($i==$current) $pagination.= "<b>$i</b>";
			else $pagination.= '<a href="breves/'.$id.'/'.recode($d->titre).'/?page='.(($i*15)-15).'">'.$i.'</a>';
		}	
	
	$pagination.= '</div></center>';
	if ($nbpages>1) $contenu.=$pagination;

	
	$design->template('simple');
	$design->zone('titre', recupBdd($d->titre));
	$design->zone('titrePage', recupBdd($d->titre));	
	$design->zone('contenu', $contenu);
	$design->zone('header', '<script type="text/javascript" src="include/js/-breves.js"></script>
							 <script type="text/javascript" src="include/js/-profil.js"></script>');
	

}				
?>