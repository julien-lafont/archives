<?php
/**
 * Module Team perso
 * Permet au membre de créer sa team ou d'en rejoindre une particulière
 *
 * Url : /membre/team-perso/
 */
securite_membre();



  // ------------------------------------------------------------------------------------------------------------------------------ //
 //          				   ############       		MENU du module		 	 ############ 									   //
// ------------------------------------------------------------------------------------------------------------------------------ //

		//::-- Déjà leader d'une lineup ?
		$sqlV1=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$nb1=mysql_num_rows($sqlV1);
		
		//::-- Déjà membre d'une team ?
		$sqlV2=mysql_query("SELECT id_team FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
		$nb2=mysql_num_rows($sqlV2);
		
		
		//-- Leader --//
		if ($nb1!=0) {
			
			$d=mysql_fetch_object($sqlV1);
			
			$menu='<div class="titreMessagerie">Team perso</div><br />
				<table style="width:95%; border:0; text-align:center; margin-left:10px"> 
					<tr>
						<td width="20%"><a href="membre/team-perso/editer/" ><img src="images/ma-team/edit.png"></a></td>
						<td width="20%"><a href="team/equipe-'.$d->id.'-'.recode(recupBdd($d->nom)).'-'.recode($d->pays).'.htm" ><img src="images/ma-team/mymac.png"></a></td>
						<td width="20%"><a href="membre/team-perso/gerer/"><img src="images/ma-team/kuser.png"></a></td>
						<td width="20%"><a href="membre/team-perso/quitter/" ><img src="images/ma-team/password.png"></a></td>
						<td width="20%"><a href="membre/team-perso/supprimer/"><img src="images/ma-team/button_cancel.png"></a></td>
					</tr>
					<tr>
						<td class="cadre_lien" style="vertical-align:top"><div class="menuinbox" style="margin-top:10px"><a href="membre/team-perso/editer/" style="display:block; width:80%" >Editer infos de ma team</a></div></td>
						<td class="cadre_lien" style="vertical-align:top"><div class="menuinbox" style="margin-top:10px"><a href="team/equipe-'.$d->id.'-'.recode(recupBdd($d->nom)).'-'.recode($d->pays).'.htm" style="display:block; width:80%" >Page de la Team</a></div></td>
						<td class="cadre_lien" style="vertical-align:top"><div class="menuinbox" style="margin-top:10px"><a href="membre/team-perso/gerer/" style="display:block; width:80%" >Gerer la lineup</a></div></td>
						<td class="cadre_lien" style="vertical-align:top"><div class="menuinbox" style="margin-top:10px"><a href="membre/team-perso/quitter/" style="display:block; width:80%" >Quitter le leadership</a></div></td>
						<td class="cadre_lien" style="vertical-align:top"><div class="menuinbox" style="margin-top:10px"><a href="membre/team-perso/supprimer/" style="display:block; width:80%" >Supprimer la team</a></div></td>
					</tr>
				</table><br /><br />';

		//-- Membre d'une team --//
		} else if ($nb2!=0) {
		
			$e=mysql_fetch_object($sqlV2);
			$id_team=$e->id_team;
			
			$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id=$id_team");
			$d=mysql_fetch_object($sql);
			
			$menu='<div class="titreMessagerie">Team perso</div>
				<table style="width:70%; border:0; text-align:center; margin-left:130px"> 
					<tr>
						<td width="20%"><a href="team/equipe-'.$d->id.'-'.recode(recupBdd($d->nom)).'-'.recode($d->pays).'.htm" ><img src="images/ma-team/mymac.png"></a></td>
						<td width="20%"><a href="membre/team-perso/partir/" ><img src="images/ma-team/down2.png"></a></td>
					</tr>
					<tr>
						<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="team/equipe-'.$d->id.'-'.recode(recupBdd($d->nom)).'-'.recode($d->pays).'.htm" style="display:block; width:90%" >Page de la Team</a></div></td>
						<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="membre/team-perso/partir/" style="display:block; width:90%" >Quitter la team</a></div></td>
					</tr>
				</table><br /><br />';
					
		//-- Rien ^^ --//			
		} else 
			$menu='<div class="titreMessagerie">Team perso</div>
				<table style="width:70%; border:0; text-align:center; margin-left:130px"> 
					<tr>
						<td width="50%"><a href="membre/team-perso/rejoindre/" title="Rejoindre une team"><img src="images/ma-team/rejoindre_groupe.png"></a></td>
						<td width="50%"><a href="membre/team-perso/creer/" title="Créer ma team"><img src="images/ma-team/creer_groupe.png"></a></td>
					</tr>
					<tr>
						<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="membre/team-perso/rejoindre/" title="Rejoindre une team" style="display:block; width:90%" >Rejoindre une team</a></div></td>
						<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="membre/team-perso/creer/" title="Créer ma team" style="display:block; width:90%" >Créer une team</a></div></td>
					</tr>
				</table><br /><br />';



switch($_GET['action']) {

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Page d'accueil : affiche les différents liens 											   //
// ------------------------------------------------------------------------------------------------------------------------------ //
default:	

	$c=$menu;
	$c.="<div style='margin:40px 50px 0 50px; text-align:center; font-size:11px'>
			Ce module permet aux membres d'une team de se regrouper pour mieux se faire connaitre au sein de la communauté ".NOM.".<br /><br />
			Vous pouvez soit rejoindre une équipe existante ou alors créer votre propre team.
		 </div>";

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Créer sa team perso																		   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "creer-erreur":
case "creer":

	// Vérifications  :
		//::-- Déjà leader d'une lineup ?
		$sqlV1=mysql_query("SELECT id FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$nb1=mysql_num_rows($sqlV1);
			if ($nb1!=0) bloquerAcces("Vous êtes déjà leader d'une team. Vous ne pouvez donc pas en créer une seconde.");
			
		//::-- Appartient à une team ?
		$sqlV2=mysql_query("SELECT id FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
		$nb2=mysql_num_rows($sqlV2);
			if ($nb2!=0) bloquerAcces("Vous appartenez déjà à une team, vous ne pouvez donc pas en créer une.<br />Merci de quitter préalablement votre team actuelle.<br /><br /><a href='#'>Quitter ma team</a>");
			
			
	$c=$menu;
	$c.='<div class="titreMessagerie">Créer sa team perso</div>
			 <div id="infoInscription">
				Utilisez ce formulaire pour créer et devenir leader d\'une team</b>
			  </div><br />';
		
		if ($_GET['action']=="creer-erreur") {
			$c.='<center><strong style="color:#FF6600">Le formulaire n\'a pas été remplis correctement</strong></center>';
		}	  
		
		  $c.='<br /><form id="form" name="post" method="post" action="membre/team-perso/creer-verif/">
			  <fieldset style="margin-left:20px">
			  				
				<label for="nom" style="font-weight:bold">» Nom de la team</label>  &nbsp;<span class="requis">requis</span><br />
					<input type="text" name="nom" id="nom" style="margin-left:25px" /><br /><br />

				<label for="site" style="font-weight:bold">» Site internet</label><br />
					<input type="text" name="site" id="site" style="margin-left:25px; width:350px" /><br /><br />

				<label for="pays" style="font-weight:bold">» Pays principal de la team</label> &nbsp;<span class="requis">requis</span><br />
				<select name="pays" id="pays" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom').'
				</select><br /><br />
				
				<label for="detail" style="font-weight:bold">» Plus d\'infos la team</label><br />
					
					<div style="margin:10px 0 0 60px">
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
					</div>

				<textarea name="messageBG" id="messageBG" class="size150" style="margin-left:25px !important; text-align:left;" /></textarea><br /><br />

				<b>» Valider</b><br /><br />
				<input type="submit" class="submit" value="Creer la team"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
	<br /><br />';
	


break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Créer sa team perso : vérif et ajours sql													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "creer-verif":

		//::-- Déjà leader d'une lineup ?
		$sqlV1=mysql_query("SELECT id FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$nb1=mysql_num_rows($sqlV1);
			if ($nb1!=0) bloquerAcces("Vous êtes déjà leader d'une team. Vous ne pouvez donc pas en créer une seconde.");
			
		//::-- Appartient à une team ?
		$sqlV2=mysql_query("SELECT id FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']." AND etat=1");
		$nb2=mysql_num_rows($sqlV2);
			if ($nb2!=0) bloquerAcces("Vous appartenez déjà à une team, vous ne pouvez donc pas en créer une.<br />Merci de quitter préalablement votre team actuelle.<br /><br /><a href='#'>Quitter ma team</a>");
		
		//::-- Si il a fait une demande on l'annule :
		$sqlV3=mysql_query("DELETE FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']." AND etat=0");

	if (empty($_POST['nom']) || empty($_POST['pays'])) {
		header('location: '.URL.'membre/team-perso/creer-erreur/');
	}
	
	$nom=addBdd($_POST['nom']);
	$site=addBdd($_POST['site']);
	$pays=addBdd($_POST['pays']);
	$description=addBdd($_POST['messageBG']);
	$id=$_SESSION['sess_id'];
	
	$sql=mysql_query("INSERT INTO ".PREFIX."team_perso (`nom`,`site`,`pays`,`description`,`id_leader`) VALUES ('$nom', '$site', '$pays', '$description', $id)");
	
	header('location: '.URL.'membre/team-perso/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Créer sa team perso : vérif et ajours sql													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "editer-erreur":
case "editer":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');
		

	$c=$menu;
	$c.='<div id="infoInscription">
				Utilisez ce formulaire pour éditer la team '.recupBdd($d->nom).'</b>
			  </div><br />';
		
		if ($_GET['action']=="editer-erreur") {
			$c.='<center><strong style="color:#FF6600">Le formulaire n\'a pas été remplis correctement</strong></center>';
		}	  
		
		  $c.='<br /><form id="form" name="post" method="post" action="membre/team-perso/editer-verif/">
			  <fieldset style="margin-left:20px">
			  				
				<label for="nom" style="font-weight:bold">» Nom de la team</label>  &nbsp;<span class="requis">requis</span><br />
					<input type="text" name="nom" id="nom" value="'.recupBdd($d->nom).'" style="margin-left:25px" /><br /><br />

				<label for="site" style="font-weight:bold">» Site internet</label><br />
					<input type="text" name="site" id="site" value="'.recupBdd($d->site).'" style="margin-left:25px; width:350px" /><br /><br />

				<label for="pays" style="font-weight:bold">» Pays principal de la team</label> &nbsp;<span class="requis">requis</span><br />
				<select name="pays" id="pays" style="width:100px; margin-left:25px">
					<option value=""> &nbsp; &nbsp; &nbsp; / &nbsp; &nbsp;</option>
					'.liste_pays('nom', $d->pays).'
				</select><br /><br />
				
				<label for="detail" style="font-weight:bold">» Plus d\'infos la team</label><br />
					
					<div style="margin:10px 0 0 60px">
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
					</div>

				<textarea name="messageBG" id="messageBG" class="size150" style="margin-left:25px !important; text-align:left;" />'.stripslashes($d->description).'</textarea><br /><br />
	
				<input type="hidden" name="id" value="'.$d->id.'" />
				<b>» Valider</b><br /><br />
				<input type="submit" class="submit" value="Editer la team"  style="margin-left:25px; width:130px"/><br /><br />

			  </fieldset>
			  </form>
	<br /><br />';
		
break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Editer sa team perso : vérif et ajours sql													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "editer-verif":

	if (empty($_POST['nom']) || empty($_POST['pays'])) {
		header('location: '.URL.'membre/team-perso/editer-erreur/');
	}
	
	$nom=addBdd($_POST['nom']);
	$site=addBdd($_POST['site']);
	$pays=addBdd($_POST['pays']);
	$description=addBdd($_POST['messageBG']);
	$id=(int)$_POST['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."team_perso SET
						nom='$nom',
						site='$site',
						pays='$pays',
						description='$description'
					  WHERE id=$id");
	
	header('location: '.URL.'membre/team-perso/');

break;
		

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 						  Gérer la lineup													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "gerer":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');

	$c=$menu;
	$c.='<div id="infoInscription">
				Gérer les membres de la line-up <br /><b>Rôle/Place/Statut de chaque joueur au sein de l\'équipe</b>
		  </div><br />
		  
		  <form id="form" name="form" method="post" action="membre/team-perso/gerer2/" style="margin-left:25px">
		  <ul id="liste_perso">';
		  
		$sql2=mysql_query("SELECT l.id, l.id_membre, l.statut, l.etat, m.pseudo FROM ".PREFIX."team_perso_lineup l
							LEFT JOIN ".PREFIX."membres m
							ON m.id=l.id_membre
							WHERE l.id_team=".$d->id."
							ORDER BY l.etat");
			$nb2=mysql_num_rows($sql2);
			if ($nb2==0) $c.='<li>Aucun membre</li>';
			
		while ($e=mysql_fetch_object($sql2)) {
			if ($e->etat==0) { 
				$etat='<a href="membre/team-perso/accepter/?id='.$e->id.'" style="color:#0099FF">Accepter</a>|<a href="membre/team-perso/refuser/?id='.$e->id.'" style="color:#FF6600">Refuser</a>';
				$color='#999';
			} else {
				$etat='<a href="membre/team-perso/radier/?id='.$e->id.'" style="color:#FF0000">Radier le joueur</a>';
				$color='#000';
			}
			
			$c.='<li class="teamperso_li"><strong style="color:'.$color.'"><a href="profil/'.$e->pseudo.'/" target="_blank">'.recupBdd($e->pseudo).'</a></strong> ['.$etat.'] <span class="right2">Rôle <input type="text" name="lineup'.$e->id.'" value="'.recupBdd($e->statut).'" /></span></li>';
		
		}
		
	$c.='</ul>
	
	<br /><br /><input type="submit" value="Modifier" class="submit" /></form><br /><br />';

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Accepter un joueur														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "accepter":

	$id=$_GET['id'];
	
	// On accepte le membre
	$sql=mysql_query("UPDATE ".PREFIX."team_perso_lineup SET etat=1 WHERE id=$id");
	
	// Sélection des infos sur la team
	$sql2=mysql_query("SELECT t.nom, t.id, l.id_membre FROM ".PREFIX."team_perso t
						LEFT JOIN ".PREFIX."team_perso_lineup l
						ON l.id_team=t.id
						WHERE l.id=$id");
		$d=mysql_fetch_object($sql2);
	
	// On envoie un MP au demandeur pour confirmer
	$dest=$d->id_membre;
	$etat='auto';
	$sujet='Vous êtes acceptée dans la team '.recupBdd($d->nom);
	$message='	Vous avez envoyé une demande pour intégrer la team '.recupBdd($d->nom).'.<br /><br />
				Nous somme heureux de vous annoncer que votre demande a été <b>acceptée.</b>';		
	envoyerMp($dest, addslashes($sujet), addslashes($message), $etat);
	
	header('location: '.URL.'membre/team-perso/gerer/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Refuser un joueur														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "refuser":

	$id=$_GET['id'];
	
	
	// Sélection des infos sur la team
	$sql2=mysql_query("SELECT t.nom, t.id, l.id_membre FROM ".PREFIX."team_perso t
						LEFT JOIN ".PREFIX."team_perso_lineup l
						ON l.id_team=t.id
						WHERE l.id=$id");
		$d=mysql_fetch_object($sql2);

	// On supprime la demande
	$sql=mysql_query("DELETE FROM ".PREFIX."team_perso_lineup WHERE id=$id");

	// On envoie un MP au demandeur pour confirmer
	$dest=$d->id_membre;
	$etat='auto';
	$sujet='Vous n\'avez pas été accepté dans la team '.recupBdd($d->nom);
	$message='	Vous avez envoyé une demande pour intégrer la team '.recupBdd($d->nom).'.<br /><br />
				Nous avons le regret de vous annoncer que votre demande a été <b>refusée.</b>';		
	envoyerMp($dest, addslashes($sujet), addslashes($message), $etat);
	
	header('location: '.URL.'membre/team-perso/gerer/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Radier un joueur															   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "radier":

	$id=$_GET['id'];
	
	// Sélection des infos sur la team
	$sql2=mysql_query("SELECT t.nom, t.id, l.id_membre FROM ".PREFIX."team_perso t
						LEFT JOIN ".PREFIX."team_perso_lineup l
						ON l.id_team=t.id
						WHERE l.id=$id");
		$d=mysql_fetch_object($sql2);

	// On supprime le membre
	$sql=mysql_query("DELETE FROM ".PREFIX."team_perso_lineup WHERE id=$id");

	// On envoie un MP au demandeur pour confirmer
	$dest=$d->id_membre;
	$etat='auto';
	$sujet='Vous n\'avez pas été radié dans la team '.recupBdd($d->nom);
	$message='	Vous faisiez jusqu\'a ce jour parti de la team '.recupBdd($d->nom).'.<br /><br />
				Nous avons le regret de vous annoncer que vous a été <b>radié</b> de cette équipe par décision du leader.';		
	envoyerMp($dest, addslashes($sujet), addslashes($message), $etat);
	
	header('location: '.URL.'membre/team-perso/gerer/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Gérer la lineup : MAJ														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "gerer2":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');


	foreach($_POST as $cle=>$valeur) {
		$id=str_replace('lineup', '', $cle);
		$valeur=addBdd($valeur);
		
		$sql=mysql_query("UPDATE ".PREFIX."team_perso_lineup SET statut='$valeur' WHERE id=$id") or die(mysql_error());
	}
	
	header('location: '.URL.'membre/team-perso/gerer/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Quitter le leadership  													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "quitter":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');

	$c=$menu;
	$c.='
	
		<div style="text-align:center; margin:30px 0 30px 0; font-weight:bold">
			A qui voulez-vous laisser le leadership de la team ?<br /><br />
			
			<form name="quitter" id="form" action="membre/team-perso/quitter2/" method="post">
			<select name="newLeader" >
				<option value="">Sélectionnez joueur</option>';
				
			$sql2=mysql_query("SELECT l.id, l.id_membre, l.statut, m.pseudo FROM ".PREFIX."team_perso_lineup l
							LEFT JOIN ".PREFIX."membres m
							ON m.id=l.id_membre
							WHERE l.id_team=".$d->id);
			
			while ($e=mysql_fetch_object($sql2)) {
				$c.='<option value="'.$e->id_membre.'" style="font-weight:normal">'.recupBdd($e->pseudo).'</option>';
			}
	
	$c.='	</select>
				
			<br /><br /><input type="submit" class="submit" value="Quitter le poste de leader" style="width:200px" />
		</form>
	</div>';
		
break;
		 
  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 		  Quitter le leadership : MAJ 					 									   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "quitter2":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');

		// Aucun joueur sélectionné ?
		if (empty($_POST['newLeader'])) { header('location: '.URL.'membre/team-perso/quitter/'); exit(); }
		$new=(int)$_POST['newLeader'];
		
		// Maj du leader :
		$sql=mysql_query("UPDATE ".PREFIX."team_perso SET id_leader=".$new." WHERE id=".$d->id);
		
		header('location: '.URL.'membre/team-perso/');

break;

  //------------------------------------------------------------------------------------------------------------------------------- //
 //                			       	      		 Membre : quitter une équipe													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "partir":

		//::-- Déjà membre d'une team ?
		$sqlV2=mysql_query("SELECT id FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
		$nb2=mysql_num_rows($sqlV2);
			
			if ($nb2==0) bloquerAcces('Acces interdit ! ');
		
		// Suppression
		$sql=mysql_query("DELETE FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
		
		header('location: '.URL.'membre/team-perso/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 				  Supprimer la team 														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "supprimer":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');

	$c=$menu;
	$c.='<div style="text-align:center; margin:30px 0 30px 0; font-weight:bold">
			Etes-vous sûr de vouloir supprimer la team ?<br /><br />
			<a href="membre/team-perso/supprimer2/" style="color:#F00">OUI</a>
				 &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp; &nbsp; &nbsp; &nbsp; 
			<a href="membre/team-perso" style="color:#0F0">NON</a>
		</div>';

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 		  Supprimer la team : MAJ SQL														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "supprimer2":

		//::-- Déjà leader d'une lineup ?
		$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$d=mysql_fetch_object($sql);
			$nb1=mysql_num_rows($sql);
			
		if ($nb1==0) bloquerAcces('Acces interdit ! ');
	
		// On supprime les entrées lineup liées à la team
		$sql2=mysql_query("DELETE FROM ".PREFIX."team_perso_lineup WHERE id_team=".$d->id);
		
		// On supprime la team 
		$sql3=mysql_query("DELETE FROM ".PREFIX."team_perso WHERE id=".$d->id);
		
		header('location: '.URL.'membre/team-perso/');
		
break;


  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 		  Rejoindre une team																   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "rejoindre":

		//::-- Déjà leader d'une lineup ?
		$sqlV1=mysql_query("SELECT id FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
		$nb1=mysql_num_rows($sqlV1);
		
		//::-- Déjà membre d'une team ?
		$sqlV2=mysql_query("SELECT id FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
		$nb2=mysql_num_rows($sqlV2);
		
		//::-- Vérification 
		if ($nb1!=0 || $nb2!=0) bloquerAcces('Accés interdit');

	$c='<div class="titreMessagerie">Rejoindre une team</div> <br /><br />
	
	<form name="integrer" method="post" action="membre/team-perso/postuler/">
	<fieldset id="form" style="text-align:center">
		
		<img src="images/ma-team/rejoindre_groupe.png" alt="Rejoindre" /><br /><br />
		
		<span style="font-size:12px; color:#FF6600">Postuler pour intégrer la team ...</span><br /><br />
		<select name="idTeam">
			<option value="">Nom de la team</option>';
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."team_perso ORDER BY id DESC");
	while ($d=mysql_fetch_object($sql)) {
		$c.='<option value="'.$d->id.'">'.recupBdd($d->nom).'</option>';
	}
			
	$c.='</select> &nbsp; <input type="submit" class="submit" value="Postuler" />
	
		</fieldset>
   </form>';

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 		  Rejoindre une team : POSTULER														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "postuler":

	//::-- Déjà leader d'une lineup ?
	$sqlV1=mysql_query("SELECT id FROM ".PREFIX."team_perso WHERE id_leader=".$_SESSION['sess_id']);
	$nb1=mysql_num_rows($sqlV1);
	
	//::-- Déjà membre d'une team ?
	$sqlV2=mysql_query("SELECT id FROM ".PREFIX."team_perso_lineup WHERE id_membre=".$_SESSION['sess_id']);
	$nb2=mysql_num_rows($sqlV2);
	
	//::-- Vérification 
	if ($nb1!=0 || $nb2!=0) bloquerAcces('Accés interdit');

		$id=(int)$_POST['idTeam'];
		$my=$_SESSION['sess_id'];
	
	//::-- Sélection des infos sur la team
	$sqlI=mysql_query("SELECT * FROM ".PREFIX."team_perso WHERE id=$id");
	$d=mysql_fetch_object($sqlI);
	
	// Ajout du nom dans la liste des postulants
	$sql=mysql_query("INSERT INTO ".PREFIX."team_perso_lineup (`id_membre`, `id_team`) VALUES ($my, $id)");
	
	// Envoie d'un message privé
	$dest=$d->id_leader;
	$etat='auto';
	$sujet= $_SESSION['sess_pseudo'].' désire intégrer votre team';
	$message='	Le membre <b>'.$_SESSION['sess_pseudo'].'</b> postule pour intégrer la team '.recupBdd($d->nom).' dont vous êtes le leader.<br /><br />
				Rendez vous sur la page <a href="membre/team-perso/gerer/" title="Gerer la lineup">Gérer la lineup</a> de votre espace membre pour choisir d\'accepter ou de refusée l\'entrée de ce membre dans votre équipe.';		
	envoyerMp($dest, addslashes($sujet), addslashes($message), $etat);
	
	header('location: '.URL.'membre/team-perso/confirmation-postuler/');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                 		  Rejoindre une team : POSTULER	-> Confirmation										   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "confirmation-postuler":

	$c='<div class="titreMessagerie">Rejoindre une team</div> <br /><br />
	
	<div style="text-align:center">
		
		<img src="images/ma-team/rejoindre_groupe.png" alt="Rejoindre" /><br /><br />
		
		<b>Votre demande à été envoyée au leader de la team</b><br /><br />
		Vous serez tenu au courant par message privé de la suite de votre requête.
	</div>';

break;
}

	$design->zone('contenu', $c);
	$design->zone('titrePage', 'Gérer ma team');
	$design->zone('header', '<script type="text/javascript" src="javascript/-profil.js"></script>');

?>