<?php
/**
 * Module  News
 * Affiche les news - Page d'accueil avec menus en plus - Gestion des commentaires
 *
 * Url : /actualite-noway/
 *       /actualite-noway/#/Description_facultative/ ( #=numéro de la news )
 */

//:: Affiche toutes les news : page d'accueil :://
if (!isset($_GET['idNews']))
{
	$design->template('accueil');
	$design->zone('titrePage', 'Actualité de la team');
	
	// On sélectionne les 5 dernières news
	$sql=mysql_query("	SELECT n.id, n.titre, n.apercu, n.contenu, n.date, n.nb_com, n.image, m.pseudo, m.last_activity, md.gen_sexe
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."membres m
						ON m.id=n.id_auteur
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						ORDER BY n.id DESC
						LIMIT 0,5")
					or die('Erreur de selection '.mysql_error());
		
	// On définit un bloc qui va se répter dans les templates
	$design->bloc('bloc', array('id', 'titre', 'contenu', 'auteur', 'date', 'commentaire', 'image', 'admin') );	

		$nb=mysql_num_rows($sql);
		if ($nb==0) $design->blocOccurence( array(0, "Désolé mais ...", "Aucune news n'a encore été écrite", "Admin", "", "", "", "") );
	
	while($d=mysql_fetch_object($sql))
	{
		$contenu='';
		
		// On récupère et on met en forme les news
		$titre=recupBdd($d->titre);
		
		if (is_admin()) $admin='<div class="bloc_admin_news" id="bloc_admin" onMouseOver="$(this).css({opacity:1})" onMouseOut="$(this).css({opacity:0.5})"><a href="?admin-news&action=editer&id='.$d->id.'"><img src="images/boutons/fonts.png" /></a> &nbsp;<a href="#" onclick="ConfirmSuppr('.$d->id.'); return false"><img src="images/boutons/del.png" /></a></div>';
		
		$auteur='<a href="Profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a> <img src="images/'.imgOnline($d->gen_sexe, $d->last_activity).'" />';
		$date=inverser_date($d->date, 6);
		
		//-- Contenu --// 
		if (empty($d->apercu)) {
			$contenu=recupBdd($d->contenu);
		} else {
			$contenu=recupBdd($d->apercu).'<div style="text-align:center; margin-top:7px">
												<a href="Actualite-'.recode(NOM).'/'.$d->id.'/'.recode($d->titre).'.htm">» Lire la suite &laquo;</a>
										   </div>';
		}
		
		if ($d->nb_com==0) {
			$com="Aucun commentaire";
		} else {
			$com='Commentaires ('.$d->nb_com.')';
		}
		$commentaire='<a href="Actualite-'.recode(NOM).'/'.$d->id.'/'.recode($d->titre).'.htm">'.$com.'</a>';
		
		// Une occurence du bloc News
		$design->blocOccurence( array($d->id, $titre, $contenu, $auteur, $date, $commentaire, recupBdd($d->image), @$admin) );
	}

}
//:: Affichage d'une news en détail :://
else
{
	$id=$_GET['idNews'];
	
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
				
		<textarea name="messageBG" id="messageBG" class="size100" style="opacity:0.8"></textarea><br>
		<div class="fond_textarea1"></div>
		
		<div id="smiley" style="display:none">
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
	    </div>
			<input type="hidden" id="id_news" value="'.$id.'" />
			<br /><input type="submit" class="submit" value="envoyer" style="width:120px" id="send_com_news" /><br /><br />
		</fieldset></form>';
//----------------------------------------------------------------------------------------------

	//- D'abord la news
	$sql=mysql_query("	SELECT n.id, n.titre, n.apercu, n.contenu, n.date, m.pseudo, m.last_activity, md.gen_sexe
						FROM ".PREFIX."news n
						LEFT JOIN ".PREFIX."membres m
						ON m.id=n.id_auteur
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						WHERE n.id=$id")
					or die('Erreur de selection '.mysql_error());

	$d=mysql_fetch_object($sql);
	
	$nb=mysql_affected_rows();
	if ($nb==0) {
		bloquerAcces("Cette news n'est pas ( ou plus ) présente dans notre base de donnée");
	}
	
		// Contenu du blog Ecrire :
		if (is_log()) $comDetailHtml=$writeCom;
		else		  $comDetailHtml="<b>Vous devez être connecté pour pouvoir poster un commentaire</b>";
		
		// Actions admin
		if (is_admin()) $admin='<div class="bloc_admin_news" id="bloc_admin" style="float:right; filter:alpha(opacity=100);-moz-opacity:1;opacity:1; margin-right:10px; margin-top:27px"><a href="?admin-news&action=editer&id='.$d->id.'"><img src="images/boutons/playlist.png" /></a> &nbsp;<a href="#" onclick="ConfirmSupprNews('.$d->id.'); return false"><img src="images/boutons/del.png" /></a></div>';

	$contenu='
		<div id="contenuNews">
			'.@$admin.recupBdd($d->contenu).'
		</div>
		<div style="text-align:right; margin:10px 5px 0 0">
			Par <a href="Profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a> le '.inverser_date($d->date, 6).'
		</div>
		
		<div id="posterCom" align="center"><a href="#" onclick="showWriteCom(); return false">Poster un commentaire</a></div>
		<center><div id="posterComDetail" style="display:none">'.$comDetailHtml.'</div></center>';
	
	//- Puis les commentaires
	
		// Pagination
		$sql_pre=mysql_query("SELECT count(id) as nb FROM ".PREFIX."news_com WHERE id_news=$id");
		$pre=mysql_fetch_object($sql_pre);
		$nbC=$pre->nb;

		$first=(int)$_GET['page']; 
		if ($first==null) $limit="LIMIT 0,".NB_COM_NEWS; 
		else $limit="LIMIT $first,".NB_COM_NEWS;

		$nbpages=ceil($nbC/NB_COM_NEWS); $current=(round($first/NB_COM_NEWS))+1;
	
		$pagination="<center><div id='pagination'>";
		for ($i=1; $i<=$nbpages; $i++) {
			if ($i!=1) $pagination.=" . ";
			if ($i==$current) $pagination.= "<b>$i</b>";
			else if ($i==1) $pagination.= '<a href="Actualite-'.recode(NOM).'/'.$id.'/'.recode($d->titre).'.htm">'.$i.'</a>';
			else $pagination.= '<a href="Actualite-'.recode(NOM).'/'.$id.'/page-'.$i.'/'.recode($d->titre).'.htm">'.$i.'</a>';
		}	
		$pagination.= '</div></center>';


	$sqlCom=mysql_query("SELECT c.id, c.message, c.date, c.id_auteur, m.pseudo, m.last_activity, md.gen_sexe, md.avatar
						 FROM ".PREFIX."news_com c
						 LEFT JOIN ".PREFIX."membres m
						 ON m.id=c.id_auteur
						 LEFT JOIN ".PREFIX."membres_detail md
						 ON md.id_membre=c.id_auteur
						 WHERE c.id_news=$id
						 
						 $limit");
						 
	if ($nbpages>1) $contenu.=$pagination;

		//:: Gestion des #id
		if (empty($first)) { $num=$nbC; }
		else { $num=$nbC-$first; }

	$i=0;
	$num=1;
	while ($c=mysql_fetch_object($sqlCom)) 
	{
	
		if ($i%2==0) $class="comDetailA";
		else		 $class="comDetailB";
		if ($i==0)	 $class="comDetailATop";
		
		// On gère l'avatar
		if (empty($c->avatar)) 	$avatar="images/upload/avatar/no_avatar.gif";
		else					$avatar="images/upload/avatar/".$c->avatar;
		
		// Actions administrateurs
		if (is_admin()) $admin='<br /><span class="admin">Admin : 
												<a href="#" onclick="adEdit('.$c->id.'); return false">edit</a> - 
												<a href="#" onclick="adSuppr('.$c->id.', '.$d->id.'); return false">suppr</a>';
		else $admin=NULL;
		
		// Editer MES commentaires
		if ($c->id_auteur==$_SESSION['sess_id']) $edit='<div style="width:16px; height:16px; float:right; margin:2px; margin-top:-13px"><a href="#" onclick="adEdit('.$c->id.'); return false"><img src="images/boutons/edit.png" /></a></div>';
		else $edit=NULL;
		
		$com='<table class="'.$class.'" id="com'.$c->id.'">
			<tr>
				<td rowspan=2 width="150" align="center" id="first"> <img src="'.$avatar.'" class="imgAvatarSmall">'.$admin.'</td>
				<td style="vertical-align:top; height:30px !important; height:10px; padding-left:7px;">#'.$num.' - Par <b><a href="Profil/'.trim($c->pseudo).'/">'.trim(ucfirst($c->pseudo)).'</a></b> le <b style="font-size:10px">'.inverser_date($c->date,6).'</b>'.$edit.'</td>
			</tr>
			<tr>
				<td style="vertical-align:top; padding-left:7px; height:auto !important; height:50px">'.nl2br(bbcode(recupBdd($c->message))).'</td>
			</tr>
		
		</table>';
		
		$contenu.=$com;
		$i++;
		
		$num++;
	}
	
	if ($nbpages>1) $contenu.=$pagination;

	
	$design->template('simple');
	$design->zone('titre', recupBdd($d->titre));
	$design->zone('contenu', $contenu);
	$design->zone('header', '<script type="text/javascript" src="javascript/-news.js"></script>
							 <script type="text/javascript" src="javascript/-profil.js"></script>');
	
	$design->zone('titrePage', 'Actualité : '.recupBdd($d->titre));
	metatag(recupBdd($d->contenu), extraire_keywords($d->contenu." ".recupBdd($d->titre)));
}				
?>