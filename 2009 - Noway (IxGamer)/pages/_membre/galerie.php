<?php
/**
 * Module Galerie membre
 * Affiche les news - Page d'accueil avec menus en plus - Gestion des commentaires
 *
 * Url : /Galerie/pseudo/
 */
securite_membre();


switch($_GET['action']) {

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Page d'accueil : affiche les différents liens 											   //
// ------------------------------------------------------------------------------------------------------------------------------ //
default:	

	unset($_SESSION['galerie']);
	
	$contenu='<div class="titreMessagerie">Ma galerie photo</div><br />
		
		<table style="width:90%; border:0; text-align:center; margin-left:40px"> 
			<tr>
				<td width="33%"><a href="membre/galerie/upload/" title="Uploader une image"><img src="images/galerie/uploader.png" name="img3" onMouseOver= "if (document.images) document.img3.src=\'images/galerie/uploader2.png\';" onMouseOut= "if (document.images) document.img3.src=\'images/galerie/uploader.png\';"></a></td>
				<td width="34%"><a href="membre/galerie/gerer/" title="Gérer ma galerie"><img src="images/galerie/gerer.png" name="img1" onMouseOver= "if (document.images) document.img1.src=\'images/galerie/gerer2.png\';" onMouseOut= "if (document.images) document.img1.src=\'images/galerie/gerer.png\';"></a></td>
				<td width="33%"><a href="Galerie-photo/'.$_SESSION['sess_pseudo'].'/" title="Accéder à ma galerie"><img src="images/galerie/ma_galerie.png" name="img2" onMouseOver= "if (document.images) document.img2.src=\'images/galerie/ma_galerie2.png\';" onMouseOut= "if (document.images) document.img2.src=\'images/galerie/ma_galerie.png\';"></a></td>
			</tr>
			<tr>
				<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="membre/galerie/upload/" style="display:block; width:90%" title="Uploader une photo">Uploader une photo</a></div></td>
				<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="membre/galerie/gerer/" style="display:block; width:90%" title="Gérer mes photos">Gérer mes photos</a></div></td>
				<td class="cadre_lien"><div class="menuinbox" style="margin-top:5px"><a href="Galerie-photo/'.$_SESSION['sess_pseudo'].'/" style="display:block; width:90%" title="Accéder à ma galerie">Accéder à ma galerie</a></div></td>
			</tr>
		</table>';


	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Gérer ma galerie');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Uploader une image : Etape 1 -> choix du fichier											   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "upload":


	$contenu='	<div id="retour"><a href="membre/galerie/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		<form id="form" action="membre/galerie/upload2/" method="post" enctype="multipart/form-data" style="clear:both">
			<center><br />
				<b><span style="color:#00A8FF">É</span>TAPE 1 : <span style="border-bottom:1px solid #FF9900">Uploader votre photo</span></b><br /><br /><br />
			<legend for="url">A partir d\'un serveur internet</legend><br />
			<input type="text" name="url" id="url" style="width:180px" />
			<p style="margin:5px !important; margin:2px">ou</p>
			<legend for="file">A partir de votre ordinateur</legend><br />
			<input type="file" name="fichier" id="fichier" /><br /><br /><br />
			<input type="submit" value="Suivant -->" class="submit" onclick="$(\'#wait\').css(\'display\', \'block\'); this.value=\'Upload en cours\'"/>
			<img id="wait" src="images/wait2.gif" style="display:none">
			</center>
		</form><br /><br />';
	

	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Uploader une image dans ma galerie');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Uploader une image : Etape 2 -> Upload													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "upload2":

	// On gère le chemin d'accés
	$chemin="images/upload/galerie/".$_SESSION['sess_id']."/";
	if (!is_dir($chemin)) { mkdir($chemin,0777); }
	@chmod($chemin, 0777);

	$cheminTemp = "images/upload/galerie/temp/"; 
		
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
				message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !", URL."pages/_membre/mon-compte_ajax.php?act=affAvatar");
			}
			if ($poidsFichier>=3000) {
				message_redir("------------- ERREUR -------------\\nVotre image a une taille supérieure à 3mo \\nVeuillez réduire votre image avant de recommancer", URL."pages/_membre/mon-compte_ajax.php?act=affAvatar");
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
				message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !", URL."pages/_membre/mon-compte_ajax.php?act=affAvatar");
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
		echo "<center>Une erreur est survenue durant l'enregistrement de votre nouvelle photo.<br /><br /><a href='".URL."pages/_membre/mon-compte_ajax.php?act=affAvatar'>Retour</a></center>";
	}
	else 
	{
		$_SESSION['galerie']['img']=$nouveauNom;
		
		header('location: '.URL.'membre/galerie/upload3/');
	}

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Uploader une image : Etape 3 -> Ajouter une descruiption													   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "upload3":
	
	$contenu='	<center><br /><b><span style="color:#00A8FF">É</span>TAPE 2 : <span style="border-bottom:1px solid #FF9900">Indiquez une description</span></b><br /><br /></center>
<center><br /><b>Si vous le souhaitez, indiquez une description à cette photo</b><br />( facultatif )<br /><br />
				<form name="desc" method="post" action="membre/galerie/upload4/">
				<fieldset id="form">
					<textarea name="desc" id="desc" class="size100"></textarea>
					<br /><br />
					<input type="submit" class="submit" value="Valider" />
				</fieldset>
				</form>
			  </center><br /><br />';

	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Uploader une image dans ma galerie');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Uploader une image : Etape 4 -> Final												  		   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "upload4":

	if ($_POST)
	{
		$img=$_SESSION['galerie']['img'];
		$desc=addBdd($_POST['desc']);
		$myId=$_SESSION['sess_id'];
		
		$sql=mysql_query("INSERT INTO ".PREFIX."galerie
						 (`id_membre` , `img` , `description`)
						 VALUES
						 ('$myId', '$img', '$desc')");
							 
	
		$contenu='<center><b>Votre photo a été uploadée avec succés !</b><br /><br />
					<a href="images/upload/galerie/'.$_SESSION['sess_id'].'/'.$img.'" target="_blank">
						<img src="images/upload/galerie/'.$_SESSION['sess_id'].'/min_'.$img.'" class="imgAvatar" />
					</a><br /><br />
					<i>'.addBdd($_POST['desc']).'</i><br /><br />
					<a href="membre/galerie/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a>
				  </center><br /><br />';
				  
		$design->zone('contenu', $contenu);
		$design->zone('titrePage', 'Galerie');
		$design->zone('titre', 'Upload réussi');
	}
	else
	{
		die("Accés interdit !");
	}

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Gérer ces différentes images																   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "gerer":

	$contenu= '<div id="curseur" class="infobulle"></div>
				<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
              	<tr>
				  <td colspan=3  class="liste_header">	Liste des Photos :<br />
				  										<span style="color:#333; font-weight:normal; font-size:10px">( Survoller une miniature pour voir sa description )</span>
														<br />&nbsp;
				  </td>
				</tr>
				  <tr>
				  <td class="liste_titre">Miniature</td>
				  <td class="liste_titre">Actions</td>
			  </tr>';
			  
	$sql = mysql_query("SELECT * FROM ".PREFIX."galerie WHERE id_membre=".$_SESSION['sess_id']." ORDER BY id DESC");		  
	while($data = mysql_fetch_object($sql)) {

		$contenu.= "<tr>
						<td>
							<center><a href='images/upload/galerie/".$_SESSION['sess_id']."/".$data->img."'><img src='images/upload/galerie/".$_SESSION['sess_id']."/min_".$data->img."' class='imgAvatar' width='100' height='80' id='img".$data->id."' onmouseover='tooltip.show(this, \"<u>Galerie</u><br /><br />".tronquerChaine(recupBdd($data->description),100)."\")' onmouseout='tooltip.hide(this)'></a></center>
						</td>
						<td class='liste_txt'>
							<a href='membre/galerie/description/".$data->id."/'><img src='images/boutons/playlist.png' /></a>&nbsp;&nbsp;
							<a href='membre/galerie/suppr/".$data->id."/'><img src='images/boutons/cancel.png' /></a>
						</td>
			   	   </tr>";	
	}
		 
	$contenu.= '</table><br /><center><a href="membre/galerie/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></center><br /><br />';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Gérer mes galerie');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Supprimmer une image de sa galerie														   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "suppr":
	
	$id=(int)$_GET['id'];
	$sqlpre=mysql_query("SELECT img FROM ".PREFIX."galerie WHERE id='$id' AND id_membre='".$_SESSION['sess_id']."'");
	$d=mysql_fetch_object($sqlpre);
	
		@unlink('images/upload/galerie/'.$_SESSION['sess_id'].'/'.$d->img);
		@unlink('images/upload/galerie/'.$_SESSION['sess_id'].'/min_'.$d->img);
		
	$sql=mysql_query("DELETE FROM ".PREFIX."galerie WHERE id='$id' AND id_membre='".$_SESSION['sess_id']."'");
	
	header('location: '.URL.'membre/galerie/gerer');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                  Modifier la description																	   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "description":
	
	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."galerie WHERE id='$id' AND id_membre='".$_SESSION['sess_id']."'");
	$d=mysql_fetch_object($sql);
	
	$contenu='<center><b>Modifier la description d\'une de mes photos : </b><br /><br />
					<form name="desc" method="post" action="membre/galerie/modifDescription/">
				<fieldset id="form">
					<textarea name="desc" id="desc" class="size100">'.recupBdd($d->description).'</textarea>
					<br /><br />
					<input type="hidden" name="id" value="'.$id.'" />
					<input type="submit" class="submit" value="Valider" />
				</fieldset>
				</form>
				<div id="retour"><a href="membre/galerie/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div><br /><br />';
				
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Gérer mes galerie');

break;

  // ------------------------------------------------------------------------------------------------------------------------------ //
 //                                   Modifier la description -> MAJ															   //
// ------------------------------------------------------------------------------------------------------------------------------ //

case "modifDescription":
	
	$id=(int)$_POST['id'];
	$desc=addBdd($_POST['desc']);
	
	$sql=mysql_query("UPDATE ".PREFIX."galerie
					  SET description='$desc'
					  WHERE id='$id' AND id_membre='".$_SESSION['sess_id']."'");

	header('location: '.URL.'membre/galerie/gerer');			 

break;
}
?>