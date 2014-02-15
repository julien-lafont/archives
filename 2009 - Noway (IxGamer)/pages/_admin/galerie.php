<?php
securite_admin();

	$design->zone('titrePage', 'Administration Galerie');
	$design->zone('titre', 'Gérer la galerie de la team');

	
switch(@$_GET['action'])
{
default:

	$contenu='
			  
			  <div class="titreMessagerie">Galerie photo</div>
			  <div id="infoInscription">
				Utilisez cette page pour gérer la galerie de la team '.NOM.'
			  </div><br>
			  
	 <center><div id="posterNews"><a href="?admin-galerie&action=upload">Uploader une photo</a></div></center>
	 <center><div id="posterNews"><a href="?admin-galerie&action=gererCat">Gérer les catégories</a></div></center>';
	
	$contenu.= '<div id="curseur" class="infobulle"></div>
				<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:95%">
              	<tr>
				  <td colspan=3  class="liste_header">	Liste des Photos :<br />
				  										<span style="color:#333; font-weight:normal; font-size:10px">( Survoller une miniature pour voir sa description )</span>
														<br />&nbsp;
				  </td>
				</tr>
				  <tr>
				  <td class="liste_titre">Catégorie</td>
				  <td class="liste_titre">Miniature</td>
				  <td class="liste_titre">Actions</td>
			  </tr>';
			  
	$sql = mysql_query("SELECT g.id, g.photo, g.description, c.nom 
						FROM ".PREFIX."galerieteam g
						LEFT JOIN ".PREFIX."galerieteam_cat c
						ON c.id=g.id_cat
						ORDER BY id_cat") or die(mysql_error());
	$nb=mysql_affected_rows();
	
	if ($nb==0) {
		$contenu.="<tr><td colspan=3><center><br /> Aucune photo !<br /></td></tr></table>";
	}
	else
	{
		while($data = mysql_fetch_object($sql)) {
	
			$contenu.= "<tr>
							<td class='liste_txt'>".$data->nom." </td>
							<td class='liste_txt'>
								<center><a href='images/upload/galerieOfficielle/".$data->photo."'><img src='images/upload/galerieOfficielle/min_".$data->photo."' class='imgAvatar' width='70' height='60' id='img".$data->id."' ".' onmouseover="tooltip.show(this, \'<u>'.recupBdd($data->nom).'</u><br /><br /><p>'.tronquerChaine(strip_tags(nl2br(recupBdd($data->description))),150).'</p>\');" onmouseout="tooltip.hide(this)" />'."</a></center>
							</td>
							<td class='liste_txt'>
								<a href='?admin-galerie&action=editPhoto&id=".$data->id."'><img src='images/boutons/playlist.png' /></a> &nbsp; 
								<a href='?admin-galerie&action=supprPhoto&id=".$data->id."'><img src='images/boutons/cancel.png' /></a>
								
							</td>
					   </tr>";	
		}
		$contenu.="</table>";
	}
	
	$design->zone('contenu', $contenu);
	
break;
#######################################################################################################
#######################################################################################################
case "upload":

	// On sélectionne les catégoreis	
	$sql=mysql_query("SELECT nom, id FROM ".PREFIX."galerieteam_cat");
	$select='<select name="idCat">';
		while ($d=mysql_fetch_object($sql)) {
			$select.='<option value="'.$d->id.'">'.recupBdd($d->nom).'</option>';
		}
	$select.='</select>';
	
	$contenu='
		<div id="retour"><a href="?admin-galerie"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		<br><form id="form" action="?admin-galerie&action=upload2" method="post" enctype="multipart/form-data" >
			<center><br />
				<b><span style="color:#00A8FF">É</span>TAPE 1 : <span style="border-bottom:1px solid #FF9900">Uploader votre photo</span></b><br /><br /><br />
			<legend for="url">A partir d\'un serveur internet</legend><br />
			<input type="text" name="url" id="url" style="width:180px" />
			<p style="margin:5px !important; margin:2px">ou</p>
			<legend for="file">A partir de votre ordinateur</legend><br />
			<input type="file" name="fichier" id="fichier" /><br /><br /><br />
			
			<br /><b><span style="color:#00A8FF">É</span>TAPE 2 : <span style="border-bottom:1px solid #FF9900">Indiquez une description</span></b> (facultatif)<br /><br />
			<textarea name="desc" id="desc" class="size100"></textarea><br /><br /><br />
			
			<br /><b><span style="color:#00A8FF">É</span>TAPE 3 : <span style="border-bottom:1px solid #FF9900">Choississez la catégorie</span></b><br /><br />
			'.$select.'<br /><br /><br />
			
			<input type="submit" value="Valider" class="submit" onclick="$(\'wait\').style.display=\'block\'; this.value=\'Upload en cours\'"/>
			<img id="wait" src="images/wait2.gif" style="display:none">
			</center><br /><br />
		</form>';
	$design->zone('contenu', $contenu);

break;
case "upload2":

	// On gère le chemin d'accés
	$chemin="images/upload/galerieOfficielle/";
	if (!is_dir($chemin)) { mkdir($chemin,0777); }
	@chmod($chemin, 0777);

	$cheminTemp = "images/upload/galerieOfficielle/temp/"; 
		
	if (empty($_POST['url']))
	{
		$nomFichier    = $_FILES["fichier"]["name"] ;
		$nomTemporaire = $_FILES["fichier"]["tmp_name"] ;
		$typeFichier   = $_FILES["fichier"]["type"] ;
		$poidsFichier  = round($_FILES["fichier"]["size"]/1024) ;
		$nomSimple 	   = explode(".", $nomFichier);
		$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
		
		// Vérifications
			if ($extension!="jpg" && $extension!="png" && $extension!="gif") {
				message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !", PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar");
			}
			if ($poidsFichier>=5000) {
				message_redir("------------- ERREUR -------------\\nVotre image a une taille supérieure à 5mo \\nVeuillez réduire votre image avant de recommancer", PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar");
			}
		
		// Gestion du nom du fichier :
		$nouveauNom=recode($nomSimple[0]).".".$extension;
		while (file_exists($chemin.$nouveauNom)) {
			$aleatoire=GenKey(5);
			$nouveauNom  = recode($nomSimple[0])."_".$aleatoire.".".$extension; 
		}		
	
		// On copie l'image dans un répertoire temporaire
		$copy=copy($nomTemporaire, $cheminTemp.$nomFichier);
		
		// On cré une photo taille résonable
		$img = creerMiniature($cheminTemp.$nomFichier, 850, 650, $chemin.$nouveauNom);

		// On cré la miniature à partir de la photo grand format
		$imgmin = creerMiniature($cheminTemp.$nomFichier, 200, 160, $chemin."min_".$nouveauNom);

		// Suppression du fichier original
		unlink($cheminTemp.$nomFichier);

	}
	else
	{
		$extension = strtolower(array_pop(explode(".", $_POST['url'] )));
		
		// Vérifications
			if ($extension!="jpg" && $extension!="png" && $extension!="gif") {
				message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !", PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar");
			}

		// Gestion du nom du fichier :
			$nomAlea=GenKey(10);
		$nouveauNom=$nomAlea.".".$extension;
		while (file_exists($chemin.$nouveauNom)) {
				$nomAlea=GenKey(10);
			$nouveauNom    = $nomAlea.".".$extension; 
		}		

		// On copie l'image dans un répertoire temporaire
		$copy=copy($_POST['url'], $cheminTemp.$nouveauNom);

		// On cré une photo taille résonable
		$img = creerMiniature($cheminTemp.$nomFichier, 850, 650, $chemin.$nouveauNom);

		// On cré la miniature à partir de la photo grand format
		$imgmin = creerMiniature($cheminTemp.$nomFichier, 200, 160, $chemin."_min".$nouveauNomMin);

		// Suppression du fichier original
		unlink($cheminTemp.$nouveauNom);
	}

	// Check error
	if ($imgmin===false) 
	{ 
		echo "<center>Une erreur est survenue durant l'enregistrement de votre nouvelle photo.<br /><br /><a href='?admin-galerie'>Retour</a></center>";
	}
	else 
	{
		$photo=$nouveauNom;
		$description=addBdd($_POST['desc']);
		$id_cat=$_POST['idCat'];
		
		$sql=mysql_query("INSERT INTO ".PREFIX."galerieteam (`id_cat`,`description`,`photo`) VALUES ('$id_cat', '$description', '$photo') ") or die(mysql_error());
		header('location: ?admin-galerie');
	}

break;
#######################################################################################################
#######################################################################################################
case "supprPhoto":

	$id=$_GET['id'];
	$sql=mysql_query("DELETE FROM ".PREFIX."galerieteam WHERE id=$id");
	
	header('location: ?admin-galerie');
break;
#######################################################################################################
#######################################################################################################
case "editPhoto":

	$id=$_GET['id'];
	
	$sqlInfos=mysql_query("SELECT * FROM ".PREFIX."galerieteam WHERE id=$id");
	$info=mysql_fetch_object($sqlInfos);
	
	// On sélectionne les catégoreis	
	$sql=mysql_query("SELECT nom, id FROM ".PREFIX."galerieteam_cat");
	$select='<select name="idCat">';
		while ($d=mysql_fetch_object($sql)) {
			if ($d->id==$info->id_cat) $selected="selected";
			else $selected="";
			$select.='<option value="'.$d->id.'" '.$selected.'>'.recupBdd($d->nom).'</option>';
		}
	$select.='</select>';

	
	$contenu='	
		<div id="retour"><a href="?admin-galerie"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
				
		<br><form id="form" action="?admin-galerie&action=editPhoto2" method="post" enctype="multipart/form-data" >
			<center><br />
				 <div class="titreMessagerie">Editer les infos d\'une photo</div><br /><br /><br />
			<br /><b><span style="color:#00A8FF">É</span>TAPE 2 : <span style="border-bottom:1px solid #FF9900">Indiquez une description</span></b> (facultatif)<br /><br />
			<textarea name="desc" id="desc" class="size100">'.recupBdd($info->description).'</textarea><br /><br /><br />
			
				Catégorie :<br />
				'.$select.'<br /><br /><br />
			
			<input type="hidden" name="id" value="'.$id.'" />
			<input type="submit" value="Editer" class="submit" />
			</center>
		</form><br /><br />';
		
	$design->zone('contenu', $contenu);

break;
case "editPhoto2":

	$description=addBdd($_POST['desc']);
	$id_cat=$_POST['idCat'];
	$id=$_POST['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."galerieteam
					  SET
					  	id_cat='$id_cat',
						description='$description'
					  WHERE id=$id");
					  
	header('location: ?admin-galerie');			 

break;
#######################################################################################################
#######################################################################################################
#######################################################################################################
#######################################################################################################
case "gererCat":

	// Préparation du select pour les catégories
	$sql=mysql_query("SELECT nom, id FROM ".PREFIX."galerieteam_cat");
	$liste=array();
	while ($d=mysql_fetch_object($sql)) {
		$liste[$d->id]=$d->nom;
	}
	
	  $contenu='		<div id="retour"><a href="?admin-galerie"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>

	  			
				<br><center><div id="posterNews"><a href="?admin-galerie&action=ajCat">Ajouter une catégorie</a></div></center>
				<br /><div id="team" style="margin-left:25px"><div class="cadreLien"><a class="lienTeam">&raquo; Liste des catégories de la Galerie</a></div></div><br />';
	  	
		$sqlCat=mysql_query("SELECT * FROM ".PREFIX."galerieteam_cat") or die(mysql_error());
		
		$nb=mysql_affected_rows();
		if ($nb==0) {
			$contenu.="<br /><br /><center>Aucune catégorie !<br /><br />";
		}
		else
		{
			while ($cat=mysql_fetch_object($sqlCat)) 
			{
				if (empty($cat->img)) { $min="default/no_min.jpg"; $imgDefault="<i>Miniature par défault</i><br />"; }
				else				  { $min=$cat->img; $imgDefault=""; }
				
				$contenu.='
						<table style="border:0; width:90%; border-bottom:1px solid #ccc; margin-bottom:7px; margin-left:50px" align="center">
						  <tr>
							<td style="width:210px; text-align:center"> '.$imgDefault.'<img src="images/upload/galerieOfficielle/'.$min.'" class="imgGalerie" /></td>
							<td style="text-align:center">
								<b>'.recupBdd($cat->nom).'</b><br />
								'.recupBdd($cat->description).'<br /><br />
								
								<a href="?admin-galerie&action=editCat&id='.$cat->id.'">Editer</a><br />
								<a href="?admin-galerie&action=changerMinCat&id='.$cat->id.'">Changer miniature</a><br />
								<a href="?admin-galerie&action=supprCat&id='.$cat->id.'">Supprimer catégorie</a>
								
								<center><div id="supprCat'.$cat->id.'" class="supprCat">
									<br /><form id="form" method="post" action="?admin-galerie&action=supprCat&id='.$cat->id.'">
										Supprimer la catégorie et transférer ses photos vers :
										<select name="transfert" style="width:150px">';
										foreach($liste as $id=>$nom) {
											if ($id!=$cat->id) $contenu.='<option value="'.$id.'">'.$nom.'</option>';
										}
							$contenu.='<option value="suppr">>Supprimer les photos</option>
										</select>
										<input type="submit" class="submit" value="Supprimer" />
									</form>
								</div></center>
							</td>
						   </tr>
						 </table>';
			}
		}				
							

	$design->zone('contenu', $contenu);

break;
#######################################################################################################
#######################################################################################################
case "ajCat":
	
	$contenu='<div id="retour"><a href="?admin-galerie&action=gererCat"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		
		<center>
		  <div style="border:1px solid #ccc; background-color:#FAFAFA; padding:5px;width:60%; margin:5px">
			<b>Ajouter une catégorie</b><br /><br />
			<form name="newCat" method="post" action="?admin-galerie&action=ajCat2" id="form">
				Nom<br />
				<input type="text" name="nom" maxlength="150" style="text-align:center" /><br /><br />
				
				Description <br />
				<textarea name="desc"></textarea><br /><br />
				
				<input type="submit" class="submit" value="Ajouter" />
			</form>
		  </div>
		</center><br /><br />';
		
	$design->zone('contenu', $contenu);
	
break;
case "ajCat2":
	
	$nom=addBdd($_POST['nom']);
	$desc=addBdd($_POST['desc']);
	
	$sql=mysql_query("INSERT INTO ".PREFIX."galerieteam_cat (`nom`,`description`) VALUES ('$nom', '$desc') ");
	header('location: ?admin-galerie&action=gererCat');

break;
#######################################################################################################
#######################################################################################################
case "editCat":
	
	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."galerieteam_cat WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$contenu='<div id="retour"><a href="?admin-galerie&action=gererCat"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		
		<center>
		  <div style="border:1px solid #ccc; background-color:#FAFAFA; padding:5px;width:60%; margin:5px">
			<b>Editer une catégorie</b><br /><br />
			<form name="newCat" method="post" action="?admin-galerie&action=editCat2&id='.$id.'" id="form">
				Nom<br />
				<input type="text" name="nom" value="'.recupBdd($d->nom).'" maxlength="150" style="text-align:center" /><br /><br />
				
				Description <br />
				<textarea name="desc">'.recupBdd($d->description).'</textarea><br /><br />
				
				<input type="submit" class="submit" value="Editer" />
			</form>
		  </div>
		</center><br /><br />';
		
	$design->zone('contenu', $contenu);
	
break;
case "editCat2":
	
	$nom=addBdd($_POST['nom']);
	$desc=addBdd($_POST['desc']);
	$id=$_GET['id'];
	
	$sql=mysql_query("UPDATE ".PREFIX."galerieteam_cat SET nom='$nom', description='$desc' WHERE id=$id");
	header('location: ?admin-galerie&action=gererCat');

break;
#######################################################################################################
#######################################################################################################
case "changerMinCat":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT img FROM ".PREFIX."galerieteam_cat WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	if (empty($d->img)) $min="default/no_min.jpg";
	else				$min=$d->img;
	
	$contenu='<div class="titreMessagerie">Changer la miniature de cette catégorie</div>
		<br \><br \><center><b>Image actuelle</b><br />
		<img src="images/upload/galerieOfficielle/'.$min.'"class="imgGalerie" /><br /><br />
		
		<b>Modifier la miniature : </b><br /><br />
		<form id="form" action="?admin-galerie&action=changerMinCat2&id='.$id.'" method="post" onsubmit="return verifChangeMin();">
		
		<table style="width:100%; border:0">
		  <tr>
		  	<td style="text-align:center">
				<input type="hidden" id="newImg" name="newImg" value="'.$d->img.'" />
				<select class="formnews2" id="selectImg" onChange="showimage()">
						<option value="default/error.jpg">--------- Miniature ---------</option>
						<option value="default/no_min.jpg">Image par défaut</option><br>
						<option value="default/error.jpg"> </option>';
		
				$dossier = opendir ("images/upload/galerieOfficielle/");
		
				while ($fichier = readdir ($dossier)) {
					if ($fichier != "." && $fichier != ".." && $fichier != "Thumbs.db" && strpos($fichier, "min_")!==false) {
					
						$fichier2 = ereg_replace(".jpg",  "", $fichier);
						$fichier2 = ereg_replace(".jpeg", "", $fichier);
						$fichier2 = ereg_replace(".png",  "", $fichier);
						$fichier2 = ereg_replace(".gif",  "", $fichier);
						$contenu .= '<option value="' . $fichier . '">' . $fichier2 . '</option>';
					} 
				} 
				closedir ($dossier);
		
				$contenu .= '</select><br /><br /><div style="font-size:10px">Les images sont situés dans <b>images/upload/galerieOfficielle/</b><br /><br />
											   Leur nom doit commencer par "_min" et finir par .jpg, .png, .gif</div>
				
			</td>
		    <td>
			 	<img src="images/upload/galerieOfficielle/default/no_min.jpg" id="imgCible" width="200" height="160" alt="Miniature" align="absmiddle" class="imgGalerie" />
			</td>
		   </tr>
		   <tr>
		   	<td style="text-align:center"><input type="submit" class="submit" value="Modifier la miniature" style="width:165px"/></td>
			<td></td>
		   </tr>
		 </table>
		
		
		</form></center><br /><br />';
	
	$design->zone('contenu', $contenu);

break;
case "changerMinCat2":

	$id=$_GET['id'];
	$img=$_POST['newImg'];
	
	$sql=mysql_query("UPDATE ".PREFIX."galerieteam_cat SET img='$img' WHERE id=$id");
	header('location: ?admin-galerie&action=gererCat');
	
break;
#######################################################################################################
#######################################################################################################
case "supprCat";

	$id=$_GET['id'];
	$transfert=$_POST['transfert'];
	
	if ($transfert=="suppr") {
		
		// On supprimes les images
		$sql1=mysql_query("SELECT img FROM ".PREFIX."galerieteam WHERE id_cat=$id");
		while ($d1=mysql_fetch_object($sql1))
		{
			
			@unlink('images/upload/galerieOfficielle/'.$d1->img);
			@unlink('images/upload/galerieOfficielle/min_'.$d1->img);
		}
		
		// On supprimer les occurences de ces img dans Mysql
		$sql2=mysql_query("DELETE FROM ".PREFIX."galerieteam WHERE id_cat=$id");
		
		// On supprime la catégorie
		$sql3=mysql_query("DELETE FROM ".PREFIX."galerieteam_cat WHERE id=$id");
		
	}
	else
	{
		// On transfert les images vers la nouvelle catégorie
		$sql1=mysql_query("UPDATE ".PREFIX."galerieteam SET id_cat='$transfert' WHERE id_cat='$id'");
		
		// On supprimer la catégorie
		$sql2=mysql_query("DELETE FROM ".PREFIX."galerieteam_cat WHERE id=$id");
	
	}
	header('location: ?admin-galerie&action=gererCat');
}

?>