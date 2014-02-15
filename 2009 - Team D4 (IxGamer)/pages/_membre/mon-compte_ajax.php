<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
case "affPass":

		?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				strong  { font-weight:normal;color:#FF9900; }	
				input 			{ background-color:#FFFFFF; border:1px solid #CCC; padding:2px 1px 2px 1px; text-align:center; margin-bottom:6px; font-size:12px; font-family:Verdana; color:#333333; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../../images/fond_input1.jpg) }
				input:focus		{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }
				#submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
			</style>
			<script src="../../include/js/-general.js"> </script>
			<script src="../../include/js/-inscription.js"> </script>
			<script src="../../include/js/prototype.js"> </script>
		</head>
		<body>	
				
			<h1>Changement de mdp</h1>
			Si vous souhaitez changer de mot de passe, remplisser ce formulaire <br /><br />
			<input type='password' name='newMdp' id='newMdp' /><br />
			<input type='submit' value='modifier' id='submit' onclick='modifPass(); return false'/>
			<img id='wait' src='../../images/wait2.gif' style='display:none'>
			
		</body>
		</html>
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
	
	if (empty($d->avatar)) 	$avatar=PATH."images/avatar/no_avatar.gif";
	else					$avatar=PATH."images/avatar/".$d->avatar;
	
		?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; margin-bottom:10px; margin-top:7px }
				strong  { font-weight:normal;color:#FF9900; }	
				input 			{ background-color:#FFFFFF; border:1px solid #CCC; padding:2px 1px 2px 1px; text-align:center; margin-bottom:6px; font-size:12px; font-family:Verdana; color:#333333; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../../images/fond_input1.jpg) }
				input:focus		{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }
				#submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
				td, p, div	{ font-size:11px; color:#333 }
				.avatar	{ padding:3px; border:1px solid #CCC; background-color:#FFFFFF; margin-top:5px }
				td	{ text-align:center;vertical-align:top }
				p { margin:5px !important; margin:2px }

			</style>
			<script src="../../include/js/-general.js"> </script>
			<script src="../../include/js/-inscription.js"> </script>
			<script src="../../include/js/prototype.js"> </script>
		</head>
		<body>	
		
		<?php // Modifier la phrase lié à l'avatar en cas de réussite //
			if ( isset($_GET['etat']) && ($_GET['etat']=="modifOk") ) 
			{
				?>
				<script type="text/javascript">
					window.onload=function(){
						parent.$("lienAvatar").innerHTML="Avatar modifié avec succés !";
						parent.$("lienAvatar").className="ok";
					}	
				</script>
				<?php
			}
		?>
		
			<h1>Gérer mon avatar</h1>
			
			<table>
				<tr>
					<td>Avatar actuel :<br /><img src="<?php echo $avatar ?>" class="avatar" /></td>
					<td><b>Si vous souhaitez changer votre avatar, sélectionnez votre image dans le formulaire ci-dessous.</b><br /><br />
					<form name="avatar" action="<?php echo PATH ?>pages/_membre/mon-compte_ajax.php?act=modifAvatar" method="post" enctype="multipart/form-data" > <!-- onsubmit="return champsAvatar()" -->
						<legend for="url">A partir d'un serveur internet</legend><br />
						<input type="text" name="url" id="url" style="width:180px" />
						<p>ou</p>
						<legend for="file">A partir de votre ordinateur</legend><br />
						<input type="file" name="fichier" id="fichier" /><br /><br />
						<input type="submit" value="Valider" id="submit" />
						<img id='wait' src='../../images/wait2.gif' style='display:none'>
					</form></td>
				</tr>
			</table>
			
			
		</body>
		</html>
		<?php

break;

case "modifAvatar":

	$chemin = PATH."images/avatar/"; /* OK $chemin = "../../images/avatar/"; */

	$cheminTemp = PATH."images/avatar/temp/"; /* OK = $cheminTemp = "../../images/avatar/temp/"; */
		
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
			if ($poidsFichier>=3000) {
				message_redir("------------- ERREUR -------------\\nVotre image a une taille supérieure à 1.5mo \\nVeuillez réduire votre image avant de recommancer", PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar");
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
				message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !", PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar");
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
		echo "<center>Une erreur est survenue durant l'enregistrement de votre nouvel avatar.<br /><br /><a href='".PATH."pages/_membre/mon-compte_ajax.php?act=affAvatar'>Retour</a></center>";
	}
	else 
	{
		$sql=mysql_query("UPDATE ".PREFIX."membres_detail SET avatar='$nouveauNom' WHERE id_membre=".$_SESSION['sess_id']);
		header('location: '.PATH.'pages/_membre/mon-compte_ajax.php?act=affAvatar&etat=modifOk');
	}
	
break;
}
?>