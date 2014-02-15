<?php
securite_admin();

$menu='<div class="titreMessagerie">Administration du forum</div>
	
	<table style="width:550px; border:0; margin:0 auto 30px auto; text-align:center; ">
		<tr>
			<tr>
				<td class="cadre_lien" style="50%"><div class="menuinbox" style="margin-top:5px"><a href="?admin-forum&action=ajouter" style="display:block; width:90%" title="">Ajouter une catégorie</a></div></td>
				<td class="cadre_lien" style="50%"><div class="menuinbox" style="margin-top:5px"><a href="?admin-forum&action=reorg" style="display:block; width:90%" title="">Réorganiser les catégories</a></div></td>
			</tr>
		</tr>
	</table>';
	
	
switch(@$_GET['action']) {
default:
	$c=$menu;
	
	// Affichage des messages de retour
	if (@$_GET['mess']=="ajout_ok") 
	  $c.='<br /><center><span style="color:#0066FF">La catégorie a été ajoutée avec succés !</span></center><br />';

	if (@$_GET['mess']=="edit_ok") 
	  $c.='<br /><center><span style="color:#0066FF">La catégorie a été éditée avec succés !</span></center><br />';

	if (@$_GET['mess']=="reorg_ok") 
	  $c.='<br /><center><span style="color:#0066FF">Les catégories ont été réorganisées avec succés !</span></center><br />';
	 
	// Affichage des différentes cat :
	  $c.='<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
			<tr>
			  <td colspan=4 class="liste_header">	Liste des Forums :<br /><br /></td>
			</tr>
			  <tr>
			  <td class="liste_titre">Image</td>
			  <td class="liste_titre">Nom</td>
			  <td class="liste_titre"></td>
		  </tr>';

	$sql = mysql_query("SELECT * FROM ".PREFIX."forum_cat ORDER BY ordre ASC");		  
	while($d = mysql_fetch_object($sql)) {

		$c.= '<tr>
						<td class="liste_txt">
								<img src="'.recupBdd($d->image).'" />
						</td>
						
						<td class="liste_txt">
							'.recupBdd($d->nom).'
						</td>
						
						<td class="liste_txt">	
							<a href="?admin-forum&action=suppr&id='.$d->id.'" title="Supprimer la cat"><img src="images/boutons/cancel.png" /></a> &nbsp;
							<a href="?admin-forum&action=editer&id='.$d->id.'" title="Editer la cat"><img src="images/boutons/edit.png" /></a>						
						</td>
			   	   </tr>';	
	}
		 
	$c.= "</table>";
 
break;

case "ajouter":

	$c=$menu;
	
	if ($_GET['error']==1) $c.='<center><u style="color:#FF6600">Erreur : le formulaire n\'a pas été correctement remplis !</u></center><br /><br />';
	
	$c.='<div style="margin-left:25px">
			
			<b style="color:#0099FF; font-size:13px">Ajouter une catégorie au forum :</b>
			
			<form action="?admin-forum&action=ajouter2" method="post">
			<fieldset style="margin:15px 0 0 15px" id="form">
			
				<label for="nom">» Nom de la catégorie</label> <span class="requis">(requis)</span><br />
				<input type="text" name="nom" id="nom" maxlength="255" style="margin:5px 0 0 25px;"/><br /><br /><br />
				
				<label for="image" style="font-weight:bold">» Image illustrant la cat   : </label> <span style="color:#FF6600; font-weight:bold">50*50</span> <span class="requis">(requis)</span> <br />
						
				<br /><a class="button" style="margin-left:25px" href="#" onclick="this.blur(); openAsset(\'inpURL\'); return false"><span>Parcourir</span></a>
				<input type="text" name="inpURL" id="inpURL" style="margin-left:25px; margin-bottom:30px" value="">
				<img src="images/no_news.png" id="img_select" style="margin-left:70px"/><br />

				<label for="desc">» Description de la catégorie</label> <br /><br />
				<textarea name="desc" id="desc" class="size100" style="margin:5px 0 0 25px; width:440px"></textarea><br />

				<label for="niveau">» Niveau d\'accés minimum</label> <span class="requis">(requis)</span><br />
				<select name="niveau" id="niveau" style="margin:5px 0 0 25px;">
					<option value="0">Tous le monde, invité compris</option>
					<option value="1">Membres</option>
					<option value="3">La Team</option>
					<option value="4">Modérateurs</option>
					<option value="5">Admins</option>
				</select><br /><br /><br />


				<b>» Vérifier et envoyer la catégorie</b><br /><br />
				<input type="submit" class="submit" value="ajouter la cat"  style="margin-left:25px"/><br /><br />

			</fieldset>
			</form>
			
		</div>';

break;

case "ajouter2":

	$nom=addBdd($_POST['nom']);
	$image=addBdd($_POST['inpURL']);
	$desc=addslashes($_POST['desc']);
	$niveau=(int)$_POST['niveau'];
	
	if (empty($nom) || empty($image)) {
		header('location: ?admin-forum&action=ajouter&error=1');
	}
	
	// Sélection du dernier ordre :
	$sql=mysql_query("SELECT MAX(ordre) as maxx FROM ".PREFIX."forum_cat LIMIT 0,1");
	$d=mysql_fetch_object($sql);
		$max=round($d->maxx);
	
	// Insertion sql
	$sql=mysql_query("INSERT INTO ".PREFIX."forum_cat (`nom`,`image`,`description`,`niveau`,`ordre`)
											   VALUES ('$nom', '$image', '$desc', $niveau, $max)") or die(mysql_error());
	
	header('location: ?admin-forum&mess=ajout_ok');
	
break;

case "suppr":

	$id=(int)$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."forum_cat WHERE id='$id'");

	header('location: ?admin-forum');

break;

case "editer":

	$id=$_GET['id'];
		$sql=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=$id");
		$d=mysql_fetch_object($sql);
	
	$c=$menu;
	
	if ($_GET['error']==1) $c.='<center><u style="color:#FF6600">Erreur : le formulaire n\'a pas été correctement remplis !</u></center><br /><br />';
	
	// Gestion du Sélect : NIVEAU
	if ($d->niveau==0) $s0="selected";
	if ($d->niveau==1) $s1="selected";
	if ($d->niveau==3) $s3="selected";
	if ($d->niveau==4) $s4="selected";
	if ($d->niveau==5) $s5="selected";
	
	$c.='<div style="margin-left:25px">
			
			<b style="color:#0099FF; font-size:13px">Editer une catégorie au forum :</b>
			
			<form action="?admin-forum&action=editer2&id='.$id.'" method="post">
			<fieldset style="margin:15px 0 0 15px" id="form">
			
				<label for="nom">» Nom de la catégorie</label> <span class="requis">(requis)</span><br />
				<input type="text" name="nom" id="nom" maxlength="255" style="margin:5px 0 0 25px;" value="'.recupBdd($d->nom).'"/><br /><br /><br />
				
				<label for="image" style="font-weight:bold">» Image illustrant la cat   : </label><span style="color:#FF6600; font-weight:bold">50*50</span>  <span class="requis">(requis)</span> <br />
						
				<br /><a class="button" style="margin-left:25px" href="#" onclick="this.blur(); openAsset(\'inpURL\'); return false"><span>Parcourir</span></a>
				<input type="text" name="inpURL" id="inpURL" style="margin-left:25px; margin-bottom:30px" value="'.recupBdd($d->image).'" >
				<img src="'.recupBdd($d->image).'" id="img_select" style="margin-left:70px"/><br />

				<label for="desc">» Description de la catégorie</label> <br /><br />
				<textarea name="desc" id="desc" class="size100" style="margin:5px 0 0 25px; width:440px">'.recupBdd($d->description).'</textarea><br />

				<label for="niveau">» Niveau d\'accés minimum</label> <span class="requis">(requis)</span><br />
				<select name="niveau" id="niveau" style="margin:5px 0 0 25px;">
					<option value="0"'.@$s0.'>Tous le monde, invité compris</option>
					<option value="1"'.@$s1.'>Membres</option>
					<option value="3"'.@$s3.'>La Team</option>
					<option value="4"'.@$s4.'>Modérateurs</option>
					<option value="5"'.@$s5.'>Admins</option>
				</select><br /><br /><br />


				<b>» Vérifier et editer la catégorie</b><br /><br />
				<input type="submit" class="submit" value="éditer la cat"  style="margin-left:25px"/><br /><br />

			</fieldset>
			</form>
			
		</div>';

break;

case "editer2":
	
	$nom=addBdd($_POST['nom']);
	$image=addBdd($_POST['inpURL']);
	$desc=addslashes($_POST['desc']);
	$niveau=(int)$_POST['niveau'];
	$id=(int)$_GET['id'];
	
	if (empty($nom) || empty($image)) {
		header('location: ?admin-forum&action=editer&error=1');
	}
	
	// Edition sql
	$sql=mysql_query("UPDATE ".PREFIX."forum_cat SET `nom`='$nom', `image`='$image', `description`='$desc', `niveau`='$niveau' WHERE id=$id");
	
	header('location: ?admin-forum&mess=edit_ok');
	
break;

case "reorg":

	$sql=mysql_query("SELECT * FROM ".PREFIX."forum_cat ORDER BY ordre");
	
	$c=$menu;
	$c.='<script>
			$(document).ready(function () {
					$("#liste_cat_forum").Sortable({
						accept : "bouge",
						helperclass : "sorthelper",
						opacity: 	0.5,
						fit :	false
					})
			});
				
			function valid() {
				serial = $.SortSerialize("liste_cat_forum");
				liste=serial.hash;
				$("#listeF").val(liste);
				$("#form_reorg").submit();
			}
		</script>
		
		<div style="margin-left:25px">
			
			<form id="form_reorg" action="?admin-forum&action=reorg2" method="post">
				<input type="hidden" name="listeF" id="listeF" />
			</form>
			
			<center><b style="color:#0099FF; font-size:13px">Réorganiser l\'ordre des catégories :</b></center><br /><br />
			<a class="button" id="maj_forum" href="#" onclick="valid(); return false"><span>Mettre à jour</span></a><br /><br />
			
			<ul id="liste_cat_forum">';
		
				while ($d=mysql_fetch_object($sql)) {
					$c.='<li class="bouge" id="'.$d->id.'"><img src="'.recupBdd($d->image).'" /> '.recupBdd($d->nom).'</li>';
				}
			
	$c.='</ul>
		<br /><br /><br />
	  </div>';
	
break;

case "reorg2":

	parse_str($_POST['listeF']);
	
	foreach ($liste_cat_forum as $pos => $id) {
	   $sql=mysql_query("UPDATE ".PREFIX."forum_cat SET ordre='$pos' WHERE id='$id'");
	   @$ordre.="$id ";
	}
	
	header('location: ?admin-forum&mess=reorg_ok');

 
break;
}

	$design->zone('titrePage', 'Administration du forum');
	$design->zone('contenu', $c);

?>