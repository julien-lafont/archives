<?php
securite('4+');


switch(@$_GET['act']) {

default:

	if (!$_GET['openAjouter']==1) $styleA='style="display:none"';
	if (!$_GET['openGerer']==1)   $styleG='style="display:none"';
	if (!$_GET['openPhoto']==1)   $styleP='style="display:none"';	
	
		$c='<h2>Gestion des thèmes et des photos :</h2>
			
			<table id="cat" align="center" cellspacing="5" style="width:480px">
				<tr>
					<td><a href="#" onclick="Element.show(\'gerer_theme\'); Element.hide(\'ajouter_photo\'); Element.hide(\'gerer\'); return false">Gérer les thèmes</a></td>
					<td><a href="#" onclick="Element.show(\'ajouter_photo\'); Element.hide(\'gerer_theme\'); Element.hide(\'gerer\'); return false">Ajouter une photo</a></td>
					<td><a href="#" onclick="Element.show(\'gerer\'); Element.hide(\'gerer_theme\'); Element.hide(\'ajouter_photo\'); return false">Gérer les photos</a></td>
				</tr>
			</table>
			
			<table id="infos" style="padding:5px; width:90%; margin:10px auto; border:1px solid #ccc; height:60px; font-size:11px">
				<tr><td width="100"><img src="images/exclamation.png" /></td>
				<td><b>Petites informations sur les thèmes</b><br /><br />
				Seul les miniatures des 6 derniers thèmes sont affichées sur le site.<br />
				Un thème nouvellement créé sera par défaut caché, car il faut nécessairement qu\'il comporte deux photos différentes pour fonctionner ( sinon sa bug ! )<br /><br />
				Pour un thème on ne rentre pas des duels précis mais plusieurs photos, le script les sélectionnera aléatoirement et en fera un classement.</td></tr></table>
				
			
			
			<div id="gerer_theme" '.@$styleG.'>
				<br />
			  <form id="form1" action="?admin-themes&act=ajouterTheme" method="post">
				<fieldset id="form"><legend>Ajouter un thème</legend>
				  <table style="border:0">
				  	<tr><td width="110"><label>Nom du thème</label></td><td><input type="text" name="Anom" id="Anom" maxlength="255" /></td></tr>
				    <tr><td><label>Miniature</label></td><td><input type="text" name="Amin" id="Amin" maxlength="255"  /> <span style="font-size:11px; color:#666">( nom du fichier seulement )</span></td></tr>
				    <tr><td> <label>Description</label></td><td><input type="text" name="Adesc" id="Adesc" style="width:350px"/></td></tr>
					<tr><td></td><td><input type="submit" value="&nbsp;&nbsp;&nbsp; ajouter &nbsp;&nbsp;&nbsp;" class="submit" /></td></tr>
				  </table>
				</fieldset>
			  </form>

				<form id="form2" action="" method="post">
				<br /><fieldset id="form"><legend>Editer / Supprimer un thème</legend>
				  <table style="border:0">
				  	<tr><td width="110"><select id="id" name="id"/>'.
					
						$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes ORDER BY id DESC");
						while ($d=mysql_fetch_object($sql)) {
							$c.='<option value="'.$d->id.'">'.recupBdd($d->nom).'</option>';
						}
						
					$c.='</select> </td>
					<td><input type="submit" value="&nbsp;&nbsp;&nbsp; Supprimer &nbsp;&nbsp;&nbsp;" class="submit" onclick="$(\'form2\').action=\'?admin-themes&act=supprTheme\'"/> ou <input type="submit" value="&nbsp;&nbsp;&nbsp; Editer &nbsp;&nbsp;&nbsp;" class="submit" onclick="$(\'form2\').action=\'?admin-themes&act=editTheme\'" /></td></tr>
					
				  </table>
				</fieldset>
				</form>

				<br /><fieldset id="form"><legend>Afficher/Masquer un thème</legend>
				  <table style="border:0"><tr>
					<td width="200" style="vertical-align:top; text-align:center"><b>Eléments affichés</b><br />(cliquer pour masquer)<br /><br />';
						
						$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes WHERE afficher=1 ORDER BY id DESC");
						while ($d=mysql_fetch_object($sql)) {
							$c.='<a href="?admin-themes&act=masquer&id='.$d->id.'">'.recupBdd($d->nom).'</a><br />';
						}
						
					$c.='</td><td width="200" style="vertical-align:top; text-align:center"><b>Eléments masqués</b><br />(cliquer pour afficher)<br /><br />';
						
						$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes WHERE afficher=0 ORDER BY id DESC");
						while ($d=mysql_fetch_object($sql)) {
							$c.='<a href="?admin-themes&act=afficher&id='.$d->id.'">'.recupBdd($d->nom).'</a><br />';
						}

				  $c.='</td></tr></table>
				</fieldset>

			</div>
			
			<div id="ajouter_photo" '.@$styleA.'>';
			
				if (@$_GET['error']==1) $c.='<br /><br /><center><span style="color:red; font-size:11px">Merci de remplir tous les champs !</span></center>';
				if (@$_GET['ok']==1) $c.='<br /><br /><center><span style="color:#0066FF; font-size:11px">Photo ajouté avec succés !</span></center>';
				
				$c.='<br /><b>Ajouter une photo</b><br /><br />
				
				<form action="?admin-themes&act=ajouter" method="post">
				<table style="border:0; margin-left:30px; padding-left:5px; border-left:1px solid #00A8FF" id="form" >
				  	<tr><td width="110"><label>Nom de la photo</label></td><td><input type="text" name="nom" id="nom" maxlength="255" /></td></tr>
				    <tr><td><label>Nom du fichier</label></td><td><input type="text" name="img" id="img" maxlength="255"  /> </td></tr>
					<tr><td><label>Thème</label></td><td><select id="theme" name="theme"/>'.
					
						$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes ORDER BY id DESC");
						while ($d=mysql_fetch_object($sql)) {
							$c.='<option value="'.$d->id.'">'.recupBdd($d->nom).'</option>';
						}
						
					$c.='</select> </td></tr>
					<tr><td></td><td><br /><input type="submit" value="&nbsp;&nbsp;&nbsp; ajouter &nbsp;&nbsp;&nbsp;" class="submit" /></td></tr>
				  </table>
				  </form>

			</div>
			
			<div id="gerer" '.@$styleP.'><br />
			
				<b>Gérer les photos de quel thème ? </b><br />
				<ul>';
				
					$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes ORDER BY id DESC");
					while ($d=mysql_fetch_object($sql)) {
						$c.='<li><a href="?admin-themes&act=gerer&idTheme='.$d->id.'">'.recupBdd($d->nom).'</a></li>';
					}
					
				$c.='</ul>
			</div>';
break;

case "afficher":

	$sql=mysql_query("UPDATE ".PREFIX."themes SET afficher=1 WHERE id=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	header('location: ?admin-themes&openGerer=1');

break;
case "masquer":

	$sql=mysql_query("UPDATE ".PREFIX."themes SET afficher=0 WHERE id=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	header('location: ?admin-themes&openGerer=1');

break;

case "supprTheme":
	
	$sql=mysql_query("DELETE FROM ".PREFIX."themes WHERE id=".$_POST['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	header('location: ?admin-themes&openGerer=1');

break;

case "ajouterTheme":

	$nom=addslashes($_POST['Anom']);
	$min=addslashes($_POST['Amin']);
	$desc=addslashes($_POST['Adesc']);
	if (empty($nom) || empty($min)) message_redir('Les champs NOM et MINIATURES doivent être renseignés !','?admin-themes&openGerer=1'); 
	
	$sql=mysql_query("INSERT INTO ".PREFIX."themes (`nom`,`miniature`,`description`) VALUES ('$nom', '$min', '$desc')");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-themes&openGerer=1');
break;

case "editTheme";

	$id=$_POST['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."themes WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$c='<h2>Editer un thème : </h2><br />
	
		  <form id="form1" action="?admin-themes&act=editTheme2&id='.$id.'" method="post">
			<fieldset id="form"><legend>Ajouter un thème</legend>
			  <table style="border:0">
				<tr><td width="110"><label>Nom du thème</label></td><td><input type="text" name="nom" id="nom" maxlength="255" value="'.$d->nom.'"/></td></tr>
				<tr><td><label>Miniature</label></td><td><input type="text" name="min" id="min" maxlength="255"   value="'.recupBdd($d->miniature).'"/> <span style="font-size:11px; color:#666">( nom du fichier seulement )</span></td></tr>
				<tr><td> <label>Description</label></td><td><input type="text" name="desc" id="desc" style="width:350px"  value="'.recupBdd($d->description).'"/></td></tr>
				<tr><td><img src="'.MIN.recupBdd($d->miniature).'" style="border:1px solid #333"/></td><td><input type="submit" value="&nbsp;&nbsp;&nbsp; editer &nbsp;&nbsp;&nbsp;" class="submit" /></td></tr>
			  </table>
			</fieldset>
		  </form>';
break;

case "editTheme2":

	$nom=addslashes($_POST['nom']);
	$min=addslashes($_POST['min']);
	$desc=addslashes($_POST['desc']);
	$id=$_GET['id'];
	
	if (empty($nom) || empty($min)) message_redir('Les champs NOM et MINIATURES doivent être renseignés !','?admin-themes&openGerer=1'); 
	
	$sql=mysql_query("UPDATE ".PREFIX."themes SET `nom`='$nom', `miniature`='$min', `description`='$desc' WHERE id=$id");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-themes&openGerer=1');


break;

case "ajouter":

	$nom=addslashes($_POST['nom']);
	$img=addslashes($_POST['img']);
	$idTheme=addslashes($_POST['theme']);
	
	if (empty($nom) || empty($img)) message_redir('Les champs NOM et FICHIERS doivent être renseignés !','?admin-themes&openAjouter=1'); 

	
	$sql=mysql_query("INSERT INTO ".PREFIX."themes_photos (`id_theme`,`nom`,`img`) VALUES ('$idTheme', '$nom', '$img')");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_photos=nb_photos+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-themes&openAjouter=1&ok=1');

break;

case "gerer":

	$idTheme=$_GET['idTheme'];
	
	$c.='<h2>Gérer les photos du thème :</h2><br />
	
		&laquo; <a href="?admin-themes&openPhoto=1">Retour</a><br /><br />
		<table id="liste" align="center" style="width:600px">
			<tr>
				<td class="titre" width="20">ID</td>
				<td class="titre" width="314">Nom</td>	
				<td class="titre" width="75">Votes</td>	
				<td class="titre" width="52">Actions</td>	
			</tr>';
					
	$sqlL=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id_theme=$idTheme ORDER BY id DESC");
	$nb=mysql_num_rows($sqlL);
		if ($nb==0) $c.='<tr><td colspan="4" style="text-align:center"><br />Il n\'y a aucune photo dans ce thème.<br /><br />Allez au boulot ^^<br /><br />';
	while ($d=mysql_fetch_object($sqlL)) {
		$c.='<tr><td>'.$d->id.'</td>
			 <td>'.recupBdd($d->nom).'</td>
			 <td>'.$d->nb_votes.'</td>
			 <td><a href="?admin-themes&act=edit&id='.$d->id.'&idTheme='.$idTheme.'"><img src="images/boutons/edit.png" /></a> &nbsp; <a href="?admin-themes&act=suppr&id='.$d->id.'&idTheme='.$idTheme.'"><img src="images/boutons/del.png" /></a></td></tr>';
	}
		
	$c.='</table>
	<br /><br />
	&laquo; <a href="?admin-themes&openPhoto=1">Retour </a>';

break;

case "suppr":
	
	$sql=mysql_query("DELETE FROM ".PREFIX."themes_photos WHERE id=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-themes&act=gerer&idTheme='.$_GET['idTheme']);

break;

case "edit":

	$id=$_GET['id'];
	$idTheme=$_GET['idTheme'];
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id=$id");
	$p=mysql_fetch_object($sql);

	$c.='<h2>Editer une photo</h2><br />
	<form action="?admin-themes&act=edit2&id='.$id.'&idTheme='.$idTheme.'" method="post">
	<table style="border:0; margin-left:30px; padding-left:5px; border-left:1px solid #00A8FF" id="form" >
		<tr><td width="110"><label>Nom de la photo</label></td><td><input type="text" name="nom" id="nom" maxlength="255" value="'.recupBdd($p->nom).'"/></td> <td rowspan="4" style="vertical-align:top; padding-left:30px"><img src="'.PHOTO.$p->img.'" style="border:1px solid #ccc" /></td></tr>
		<tr><td><label>Nom du fichier</label></td><td><input type="text" name="img" id="img" maxlength="255" value="'.recupBdd($p->img).'" /> </td></tr>
		<tr><td><label>Thème</label></td><td><select id="theme" name="theme"/>'.
		
			$sql=mysql_query("SELECT id, nom FROM ".PREFIX."themes ORDER BY id DESC");
			while ($d=mysql_fetch_object($sql)) {
				if ($p->id_theme==$d->id) $select='selected';
				else					  $select='';
				$c.='<option value="'.$d->id.'" '.$select.'>'.recupBdd($d->nom).'</option>';
			}
			
		$c.='</select> </td></tr>
		<tr><td></td><td><br /><input type="submit" value="&nbsp;&nbsp;&nbsp; editer &nbsp;&nbsp;&nbsp;" class="submit" /></td></tr>
	  </table>
	  </form>';

break;

case "edit2":
	
	$id=$_GET['id'];
	$nom=addslashes($_POST['nom']);
	$img=addslashes($_POST['img']);
	$idTheme=addslashes($_POST['theme']);
	
	$sql=mysql_query("UPDATE ".PREFIX."themes_photos SET `id_theme`='$idTheme', `nom`='$nom', `img`='$img' WHERE id=$id");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-themes&act=gerer&idTheme='.$_GET['idTheme']);
	
break;

}

$design->template('admin');
$design->zone('contenu', $c);
$design->zone('categorie', 'GESTION DES THEMES');

?>