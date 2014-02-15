<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_membre(true);

	function frame_erreur($txt) {
		echo '<script type="text/javascript">
				window.onload=function() {
					window.parent.$("#fenetreIn").html("'.$txt.'");
				}
			</script>';
	}
			
			
switch(@$_GET['act'])
{
case "affPass":

		?>
			<div id="fenetreIn">
				<div class="titreMessagerie" style="margin:10px auto 20px 80px">Changement de MDP</div>
				Si vous souhaitez changer de mot de passe, remplissez ce formulaire <br /><br />
				<form id="form">
					<input type='password' name='newMdp' id='newMdp' style="margin-top:10px"/><br />
					<input type="submit" class="submit" id="submit" value="Modifier" onClick="this.blur(); modifPass(); return false" />
				</form>
				<img id='wait' src='images/wait2.gif' style='display:none'>
			</div>
			
		<?php
		
break;

case "modifPass":

	$newPass=addBdd(trim(strtolower($_GET['newPass'])));
	$pass=crypt(md5($newPass), CLE);
	
	$sql=mysql_query("UPDATE ".PREFIX."membres SET `mdp`='$pass' WHERE `id`='".$_SESSION['sess_id']."'");
	if ($sql) 	echo "ok";
	else		echo "erreur";

break;

case "affAvatar":

	$sql=mysql_query("SELECT avatar FROM ".PREFIX."membres_detail WHERE id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	if (empty($d->avatar)) 	$avatar=URL."images/upload/avatar/no_avatar.gif";
	else					$avatar=URL."images/upload/avatar/".$d->avatar;
	
			// Modifier la phrase lié à l'avatar en cas de réussite //
			if ( isset($_GET['etat']) && ($_GET['etat']=="modifOk") ) 
			{
				?>
					<script type="text/javascript">
						window.onload=function() {
							window.parent.$('#fenetreIn').html(document.getElementById('fenetreIn').innerHTML);
						}
					</script>				
				<?php
			}

				?>
	 
			
			<div id="fenetreIn">
				<div class="titreMessagerie" style="margin:10px auto 20px 80px">Gérer mon avatar</div>
			<table style="width:95%; margin-left:7px">
				<tr>
					<td>Avatar actuel :<br /><img src="<?php echo $avatar ?>" class="avatar" /></td>
					<td style="padding:4px"><b>Changer d'avatar :</b><br /><br />
					<form name="avatar" action="<?php echo URL ?>pages/_membre/mon-compte_ajax.php?act=modifAvatar" method="post" enctype="multipart/form-data" target="hiddeniframe"  onsubmit="$('#wait').show(); $('#submittt').hide();"> <!-- onsubmit="return champsAvatar()" -->
						<legend for="url">A partir d'un serveur internet</legend><br />
						<input type="text" name="url" id="url" style="width:180px" />
						<p>ou</p>
						<legend for="file">A partir de votre ordinateur</legend><br />
						<input type="file" name="fichier" id="fichier" /><br /><br />
						<input type="submit" value="Valider" id="submittt" />
						<img id='wait' src='images/wait2.gif' style='display:none'><br />
						<strong>Taille max</strong> : 200 ko <br />
						<strong>Formats autorisés</strong> : jpg/gif/png
						
						<iframe name="hiddeniframe" src="about:blank"></iframe>
					</form></td>
				</tr>
			</table>
			</div>
			
	<?php  

break;

case "modifAvatar":

	$chemin = "../../images/upload/avatar/"; /* OK $chemin = "../../images/avatar/"; */

	$cheminTemp = "../../images/upload/avatar/temp/"; /* OK = $cheminTemp = "../../images/avatar/temp/"; */
		
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
				frame_erreur("Le format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !");
			}
			if ($poidsFichier>=200) {
				frame_erreur("Votre image a une taille supérieure à 200ko <br />Veuillez réduire votre image avant de recommancer");
			}
		
		// Gestion du nom du fichier :
		$nouveauNom=recode($nomSimple[0]).".".$extension;
		while (file_exists($chemin.$nouveauNom)) {
			$nouveauNom  = recode($nomSimple[0])."_".GenKey(5).".".$extension; 
		}		

		// On copie l'image dans un répertoire temporaire
		$copy=copy($nomTemporaire, $cheminTemp.$nomFichier);

		// On cré la miniature à partir de la photo grand format
		$imgmin = creerMiniature($cheminTemp.$nomFichier, 140, 160, $chemin.$nouveauNom);

		// Suppression du fichier original
		unlink($cheminTemp.$nomFichier);

	}
	else
	{
		$extension = strtolower(array_pop(explode(".", $_POST['url'] )));
		
		// Vérifications
			if ($extension!="jpg" && $extension!="png" && $extension!="gif") {
				frame_erreur("Le format du fichier n'est pas autorisé.<br />Les extensions valides sont JPG, PNG et GIF !");
			}

		// Gestion du nom du fichier :
		$nouveauNom=GenKey(10).".".$extension;
		while (file_exists($chemin.$nouveauNom)) {
			$nouveauNom  = GenKey(10).".".$extension;
		}		

		// On copie l'image dans un répertoire temporaire
		$copy=copy($_POST['url'], $cheminTemp.$nouveauNom);

		// On cré la miniature à partir de la photo grand format
		$imgmin = creerMiniature($cheminTemp.$nouveauNom, 140, 160, $chemin.$nouveauNom);

		// Suppression du fichier original
		unlink($cheminTemp.$nouveauNom);
	}

	// Check error
	if ($imgmin===false) 
	{ 
		frame_erreur("<center>Une erreur est survenue durant l'enregistrement de votre nouvel avatar.<br /><br /><a href='".PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar'>Retour</a></center>");
	}
	else 
	{
		echo "OK - $nouveauNom - ".$_SESSION['sess_id'];
		$sql=mysql_query("UPDATE ".PREFIX."membres_detail SET avatar='$nouveauNom' WHERE id_membre=".$_SESSION['sess_id']) or die(mysql_error());
		//header('location: '.URL.'pages/_membre/mon-compte_ajax.php?act=affAvatar&etat=modifOk');
	}
	
break;

case "affConfig":

	$sql=mysql_query("SELECT url_config, date_config FROM ".PREFIX."membres_detail WHERE id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	
	// Config déjà up ?
	if (empty($d->url_config)) 	$statut='<img src="'.URL.'images/profil/Desktop_Apps.png" /><br /><br /><b>Aucune config</b>';
	else						$statut='<img src="'.URL.'images/profil/ZIP.png" /><br /><br /><b>Uploadée le<br /></b>'.$d->date_config;
	
			// Modifier la phrase lié à l'avatar en cas de réussite //
			if ( isset($_GET['etat']) && ($_GET['etat']=="modifOk") ) 
			{
				?>
					<script type="text/javascript">
						window.onload=function() {
							window.parent.$('#fenetreIn').html(document.getElementById('fenetreIn').innerHTML);
						}
					</script>				
				<?php
			}

				?>
	 
			
			<div id="fenetreIn">
				<div class="titreMessagerie" style="margin:10px auto 20px 80px">Gérer ma config</div>
			<table style="width:95%; margin-left:7px">
				<tr>
					<td><u>Statut actuel</u><br /><br /><?php echo $statut; ?></td>
					<td style="padding:4px"><b>Uploader ma config :</b><br /><br />
					<form name="avatar" action="<?php echo URL ?>pages/_membre/mon-compte_ajax.php?act=modifConfig" method="post" enctype="multipart/form-data" target="hiddeniframe"  onsubmit="$('#wait').show(); $('#submittt').hide();"> <!-- onsubmit="return champsAvatar()" -->
						<legend for="file">A partir de votre ordinateur</legend><br />
						<input type="file" name="fichier" id="fichier" /><br /><br />
						<input type="submit" value="Valider" id="submittt" />
						<img id='wait' src='images/wait2.gif' style='display:none'>
						
						<br /><br />Fichier rar ou zip, taille max 250ko
						
						<iframe name="hiddeniframe" src="about:blank"></iframe>
					</form></td>
				</tr>
			</table>
			</div>
			
	<?php  

break;

case "modifConfig":

	$chemin = "../../configs_up/";

	if ($_FILES["fichier"])
	{
		$nomFichier    = $_FILES["fichier"]["name"] ;
		$nomTemporaire = $_FILES["fichier"]["tmp_name"] ;
		$typeFichier   = $_FILES["fichier"]["type"] ;
		$poidsFichier  = round($_FILES["fichier"]["size"]/1024) ;
		$nomSimple 	   = explode(".", $nomFichier);
		$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
		
		// Vérifications
			if ($extension!="rar" && $extension!="zip" ) {
				frame_erreur("Le format du fichier n'est pas autorisé.<br />Les extensions valides sont ZIP ou RAR !");
			}
			if ($poidsFichier>=250) {
				frame_erreur("Votre fichier a une taille supérieure à 250ko <br />Veuillez réduire votre image avant de recommancer");
			}
		
		// Gestion du nom du fichier :
		$nouveauNom=NOM.'-config-'.recode($_SESSION['sess_pseudo']).'.'.$extension; 
		while (file_exists($chemin.$nouveauNom)) {
			unlink($chemin.$nouveauNom);
		}		

		// On copie l'image dans un répertoire temporaire
		$copy=copy($nomTemporaire, $chemin.$nouveauNom);

	}
	else { die('error'); }
	
	// Check error
	if ($copy===false) 
	{ 
		frame_erreur("<center>Une erreur est survenue durant l'enregistrement de votre nouvelle config.</center>");
	}
	else 
	{
			$date=date('j-m-Y');
		$sql=mysql_query("UPDATE ".PREFIX."membres_detail SET url_config='$nouveauNom', date_config='$date' WHERE id_membre=".$_SESSION['sess_id']);
		header('location: '.URL.'pages/_membre/mon-compte_ajax.php?act=affConfig&etat=modifOk');
	}
	
break;

}
?>