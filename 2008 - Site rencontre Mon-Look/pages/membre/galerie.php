<?php
securite_membre();

		$add='<script src="include/only_ajax.js" type="text/javascript"></script>
		<script src="include/effet/jquery.js" type="text/javascript"></script>
		<script src="include/effet/thickbox.js" type="text/javascript"></script>
		<script src="include/effet/galerie.js" type="text/javascript"></script>
		<style type="text/css" media="all">
		@import "include/effet/global.css";
		</style>
';

if ($_GET['act']!="suppr") head($add);

switch($_GET['act']) {
default:	

echo '<h3>Gestion de votre galerie personelle</h3><br><br>

<table width="90%" align="center">
	<tr>
		<td align="right"><a href="?p=membre/galerie&act=upload"><img src="images/galerie/upload.png"></a></td>
		<td width=25></td>
		<td align="left"><a href="?p=membre/galerie&act=gerer"><img src="images/galerie/gerer.jpg"></a></td>
	</tr>
</table>
<br><br><br><br><br><br><br>';
break;
################################################################################################################################
################################################################################################################################
case "upload";

	$sql=mysql_query("SELECT count(id) as nb_tof FROM photos WHERE id_membre=".$_SESSION['sess_id']);
	$data=mysql_fetch_object($sql);
	
	if ($data->nb_tof<10) {
		echo '<h3>Uploader une photo :</h3>
		<br><br><center>Votre galerie compte actuellement <b style="color:#00A8FF">'.$data->nb_tof.'</b> photos / 20</center><br><br>
		<p style="font-size:12px"><b>Limitations</b><br>
		 &nbsp;&nbsp; » Taille maximale : <span class="lim">2mo</span><br>
		 &nbsp;&nbsp; » Extensions autorisées : <span class="lim">Jpg, Gif, Png</span><br>
		 &nbsp;&nbsp; » Vérification <span class="lim">systématique</span> des photos par un administrateur
		</p><br><br>
		<form action="?p=membre/galerie&act=upload2" method="post" enctype="multipart/form-data" name="upload"><br>
		&nbsp;&nbsp; Votre photographie <input type="file" name="img1"><br><br>
		&nbsp;&nbsp; Remplissez ce champs si vous souhaitez inclure une <b>description</b> <br>
		&nbsp;&nbsp; <textarea name="mess" id="mess" cols="42" rows="4"></textarea> <script>displaylimit("","mess",200)</script><br>
		<div class="envoyer" style="width:125px; margin-left:10px; margin-top:7px" OnClick="document.upload.submit()">Ajouter cette photo</div>
		</form>
		<br><br><center>- <a href="?p=membre/home">Retour à mon espace perso</a> -</center>';
	} else {
		echo '<h3>Uploader une photo :</h3>
		<br><br><center>Votre galerie compte actuellement <b style="color:#00A8FF">20</b> photos / 20<br><br>
		<b>Vous ne pouvez plus ajouter de nouvelles photographies</b>
		<br><br><br>- <a href="?p=membre/galerie">Retour à la gestion de ma galerie</a> -</center><br><br><br><br><br><br><br><br>';
	}
	


break;
################################################################################################################################
################################################################################################################################
case "upload2";

			$des=htmlspecialchars(addslashes($_POST['mess']));
			
			// Infos sur le fichier envoyé
			$nomFichier    = $_FILES["img1"]["name"] ;
			$nomTemporaire = $_FILES["img1"]["tmp_name"] ;
			$typeFichier   = $_FILES["img1"]["type"] ;
			$poidsFichier  = round($_FILES["img1"]["size"]/1024) ;
			$nom2 		   = explode(".", $nomFichier);
			$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
								
			// Vérifications
				if ($extension!="jpg" && $extension!="png" && $extension!="gif") {
					message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !","?p=membre/galerie&act=upload");
				}
				if ($poidsFichier>=2000) {
					message_redir("------------- ERREUR -------------\\nVotre image a une taille supérieure à 2mo \\nVeuillez réduire votre image avant de recommancer","?p=membre/galerie&act=upload");
				}

		// On récupère le dossier spécial de cet User si il n'a pas déjà été créé
		$sql=mysql_query("SELECT dir_galerie FROM members WHERE id_membre=".$_SESSION['sess_id']);
		$data=mysql_fetch_object($sql);
		if (!empty($data->dir_galerie)) {
			$dir="upload/galerie/".$data->dir_galerie."/";
		} else {
			$new_dir=substr(strtolower(recode($_SESSION['sess_pseudo'])), 0,5)."-".substr(md5($_SESSION['sess_pseudo']),0,5); 
			mkdir($new_dir);
			$sql2=mysql_query("UPDATE members SET `dir_galerie`='$new_dir' WHERE id_membre=".$_SESSION['sess_id']);
			$dir="upload/galerie/".$new_dir."/";
		}
		
		 /* Debug */ if (!is_dir($dir)) mkdir($dir);
		 $nom=substr(strtolower(recode($_SESSION['sess_pseudo'])), 0,5)."--".genKey().".".$extension;
		 
		 /* On copie l'img taille réelle */
			 copy($nomTemporaire, $dir."_big_".$nom); 
		 /* On la réduit à une taille correcte */
			 $img = RatioResizeImg($dir."_big_".$nom,850,650,$dir,"1",$nom);
		 /* On cré sa miniature */
			 $imgmin = RatioResizeImg($dir.$nom,120,140,$dir,"2",$nom);
		 /* Et on supprime l'image taille réelle */
			 unlink($dir."_big_".$nom);
			
			$sql = mysql_query("INSERT into photos (`id_membre` , `pseudo` , `valid` , `img` , `description`) VALUES ('".$_SESSION['sess_id']."','".$_SESSION['sess_pseudo']."','0','$nom','$des') ");
			message_redir('Votre photo a été ajouté avec succés !\\nUn administrateur doit validé cette photo avec qu\'elle soit diffusée sur le site.','?p=membre/galerie');


break;
################################################################################################################################
################################################################################################################################
case "gerer":
	echo '<table cellpadding=0 cellspacing=2 class="tabl_liste" style="width:90%">
              	<tr>
				  <td colspan=5  class="liste_header">Liste des Photos :</td>
				</tr>
				  <tr>
				  <td class="liste_titre">Miniature</td>
				  <td class="liste_titre">Etat</td>
				  <td class="liste_titre">Actions</td>
			  </tr>';
			  
	$sql_pre=mysql_query("SELECT dir_galerie FROM members WHERE id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql_pre);
	$dir=$d->dir_galerie;
	
	$sql = mysql_query("SELECT * FROM photos WHERE id_membre=".$_SESSION['sess_id']." ORDER BY id DESC");		  
	while($data = mysql_fetch_object($sql)) {
		
		if ($data->valid==0) $etat="<span style='color:#999999'>En attente</span>";
		if ($data->valid==1) $etat="<span style='color:#7AC100'>Accepté</span>";
		if ($data->valid==2) $etat="<span style='color:#FF0000'>Refusé</span>";
		
		echo "<tr>
					<td class='liste_txt' style='font-size:10px; font-weight:bold;color:#0066FF; height:30px'>";
					     // Image supprimé ?
						if ($data->valid==2) echo '<center>Supprimé</center></td>';
						else echo "<center><a href='upload/galerie/$dir/$data->img' target='_blank'><img src='upload/galerie/$dir/_min_$data->img' width=40 height=50 border=0 onMouseOver=\"JSFX.zoomIn(this,10,50)\" onMouseOut=\"JSFX.zoomOut(this)\" style='border:1px solid #000000; padding:2px'></a></center></td>";
					echo "	
					<td class='liste_txt' style='font-size:11px; font-family:\"Courier New\", Courier, mono'>$etat</td>
					<td class='liste_txt'><a href='?p=membre/galerie&act=modif_desc&id=".$data->id."' class='edit'>Description</a>&nbsp;&nbsp;
		<a href='pages/membre/galerie_ajax.php?act=suppr&height=130&width=220&id=".$data->id."' title='ajax' class='thickbox'>Supprimer</a></td>
			    </tr>";	
	}
		 
	echo "</table><br><br><center><a href='?p=membre/galerie'>Retour à la gestion de ma galerie</a></center><br><br><br><br><br><br><br><br><br><br>";
	
break;
################################################################################################################################
################################################################################################################################
case "suppr":

	$sql_pre=mysql_query("SELECT img FROM photos WHERE id=".$_GET['id']." AND id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql_pre);
	$sql=mysql_query("DELETE FROM photos WHERE id=".$_GET['id']." AND id_membre=".$_SESSION['sess_id']);
	
	unlink("upload/galerie/".$_SESSION['sess_dir']."/".$d->img);
	unlink("upload/galerie/".$_SESSION['sess_dir']."/_min_".$d->img);
	
	header("location: ?p=membre/galerie&act=gerer");
	 
break;
################################################################################################################################
################################################################################################################################
case "suppr":

case "modif_desc":

	$sql=mysql_query("SELECT * FROM photos WHERE id=".$_GET['id']." AND id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	echo '<h3>Modifier la description :</h3><br><br>
	<div align="middle">
		<img src="upload/galerie/'.$_SESSION['sess_dir'].'/_min_'.$d->img.'" id="img"><br><br>
		<textarea name="mess" id="mess" cols="42" rows="5">'.stripslashes($d->description).'</textarea> <br><script>displaylimit("","mess",200)</script><br><br>
		<div class="envoyer" style="width:125px; margin-left:10px; margin-top:7px" OnClick="majDescription()">Mettre à jour</div>
		<span style="display:none" id="idImg">'.$_GET['id'].'</span>
		<br><br><br>- <a href="?p=membre/galerie">Retour à la gestion de ma galerie</a> -</center><br>
	</div>';
break;
}

foot();






?>