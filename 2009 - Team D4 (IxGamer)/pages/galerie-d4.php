<?php
$design->zone('header','<link rel="stylesheet" href="include/js/lightbox/lightbox.css" type="text/css" media="screen" />
						<script src="include/js/lightbox/lightbox.js" type="text/javascript"></script>
						<script src="include/js/-bulle_infos.js" type="text/javascript"></script>');

$idCat=(int)@$_GET['idCat'];

//:: Affichage des catégories :://
if (empty($idCat))
{
	$sql=mysql_query("SELECT * FROM ".PREFIX."galerieteam_cat ORDER BY id DESC"); 
	$nbCat=mysql_affected_rows();
	
		// Aucune photo
		if ($nbCat==0)
		{
			$design->template('simple');
			$design->zone('titrePage', 'Galerie' );
			$design->zone('titre', 'Galerie D4 &nbsp;-&nbsp; <i>D4team.com</i>');
			$design->zone('contenu', miseenforme('message', 'Aucune Catégorie dans notre galerie<br />') );
			$design->afficher();
			die();
		}
		
	$contenu='<div id="infoInscription" style="font-size:13px">
				<b>Voici la galerie photo de la team D4.</b><br />
				Cliquez sur une miniature pour voir les photos de cette catégorie.
			  </div><br />
			  
			  <div id="curseur" class="infobulle"></div>
			  <table id="voirGalerie">';
	
	
	// On met en forme le résultat
	$i=0;
	while ($d=mysql_fetch_object($sql)) 
	{
		if (empty($d->img)) $min="default/no_min1b.jpg";
		else				$min=$d->img; 
		
		// Nombre des photos ?
		$sqlNb=mysql_query("SELECT count(id) as nb FROM ".PREFIX."galerieteam WHERE id_cat=".$d->id);
		$nb=mysql_fetch_object($sqlNb);
		
		$desc=recupBdd(nl2br($d->description));
		$desc=wordwrap($desc, 75, "<br />");
		
		$colone='<b>'.recupBdd($d->nom).'</b> ('.$nb->nb.')<br />
				 <a href="Galerie-D4/'.$d->id.'/'.recode($d->nom).'/">
				 	<img src="images/upload/galerieD4/'.$min.'" class="imgGalerie" id="img'.$d->id.'" alt="'.$desc.'" onmouseover="montre(this.id)" onmouseout="cache()"/>
				 </a> ';
		
		if ($i%2==0) 	$contenu.='<tr><td>'.$colone.'</td>';
		else			$contenu.='<td>'.$colone.'</td></tr>';
		$i++;
	
	}
	
	$contenu.='</table>';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'GALERIE');
	$design->zone('titre', 'Galerie photo  la team D4');

} 
//:: Affichage des photos d'une catégorie :://
else 
{

	$sqlCat=mysql_query("SELECT nom, description FROM ".PREFIX."galerieteam_cat WHERE id=$idCat");
	$cat=mysql_fetch_object($sqlCat);
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."galerieteam WHERE id_cat=$idCat ORDER BY id DESC ") or die(mysql_error()); 
	$nbPhoto=mysql_affected_rows();
	
		// Aucune photo
		if ($nbPhoto==0)
		{
			$design->template('simple');
			$design->zone('titrePage', 'Galerie' );
			$design->zone('titre', 'Galerie D4 &nbsp;-&nbsp; <i>D4team.com</i>');
			$design->zone('contenu', '<div id="infoInscription" style="font-size:13px">
										<b>'.recupBdd($cat->nom).'</b><br />
										'.nl2br(recupBdd($cat->description)).'
									  </div><br /><center>Aucune photo dans cette catégorie<br /><br />
									  - <a href="Galerie-d4/">Retour à la Galerie</a> -</center><br /><br />' );
			$design->afficher();
			die();
		}
		
	$contenu='<div id="retour"><a href="Galerie-d4/">&lsaquo; Retour &lsaquo;</a></div>
	<div id="infoInscription" style="font-size:13px">
				<b>'.recupBdd($cat->nom).'</b><br />
				'.nl2br(recupBdd($cat->description)).'
			  </div><br />
			  
			  <div id="curseur" class="infobulle"></div>
			  <table id="voirGalerie">';
	
	// On met en forme le résultat
	$i=0;
	while ($d=mysql_fetch_object($sql)) 
	{
		$desc=recupBdd(nl2br($d->description));
		$desc=wordwrap($desc, 75, "<br />");
		
		$colone='<a href="images/upload/galerieD4/'.$d->photo.'" rel="lightbox" title="'.$desc.'">
				 	<img src="images/upload/galerieD4/min_'.$d->photo.'" class="imgGalerie" id="img'.$d->id.'" alt="'.tronquerChaine(recupBdd(nl2br($d->description))).'" onmouseover="montre(this.id)" onmouseout="cache()"/>
				 </a> ';
		
		if ($i%2==0) 	$contenu.='<tr><td>'.$colone.'</td>';
		else			$contenu.='<td>'.$colone.'</td></tr>';
		$i++;
	
	}
	
	$contenu.='</table>
	<div id="retour"><a href="Galerie-d4/">&lsaquo; Retour &lsaquo;</a></div>';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'GALERIE -'.recupBdd($cat->nom));
	$design->zone('titre', 'Galerie photo la team D4');

}
?>