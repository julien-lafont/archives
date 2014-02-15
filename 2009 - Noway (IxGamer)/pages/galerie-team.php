<?php
/**
 * Module Galerie photo de la team officielle
 * Affiche la galerie photo de la team
 *
 * Url : /galerie-officielle/
 */

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
			$design->zone('titre', 'Galerie officielle '.NOM);
			$design->zone('contenu', miseenforme('message', 'Aucune Catégorie dans notre galerie<br />') );
			$design->afficher();
			die();
		}
		
	$contenu='<div class="titreMessagerie">Galerie photo officielle de '.NOM.'</div>
			  
			  <table id="voirGalerie">';
	
	// On met en forme le résultat
	$i=0;
	while ($d=mysql_fetch_object($sql)) 
	{
		if (empty($d->img)) $min="default/no_min.jpg";
		else				$min=$d->img; 
		
		// Nombre des photos ?
		$sqlNb=mysql_query("SELECT count(id) as nb FROM ".PREFIX."galerieteam WHERE id_cat=".$d->id);
		$nb=mysql_fetch_object($sqlNb);
		
		$desc=recupBdd(nl2br($d->description));
		
		$colone='<b>'.recupBdd($d->nom).'</b> ('.$nb->nb.')<br />
				 <a href="galerie-officielle/'.$d->id.'/'.recode($d->nom).'/" onmouseover="tooltip.show(this, \'<u>'.recupBdd($d->nom).'</u><br /><br /><p>'.tronquerChaine(strip_tags($desc),150).'</p>\',\'big\');" onmouseout="tooltip.hide(this)">
				 	<img src="images/upload/galerieOfficielle/'.$min.'" class="imgGalerie" id="img'.$d->id.'" alt="'.$desc.'"/>
				 </a> ';
		
		if ($i%2==0) 	$contenu.='<tr><td>'.$colone.'</td>';
		else			$contenu.='<td>'.$colone.'</td></tr>';
		$i++;
	
	}
	
	$contenu.='</table>';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie photo de la team '.NOM);

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
			$design->zone('contenu', '<div id="infoInscription" style="font-size:13px">
										<b>'.recupBdd($cat->nom).'</b><br />
										'.nl2br(recupBdd($cat->description)).'
									  </div><br /><center>Aucune photo dans cette catégorie<br /><br />
									  - <a href="Galerie-officielle/">Retour à la Galerie</a> -</center><br /><br />' );
			$design->afficher();
			die();
		}
		
	$contenu='<div id="retour"><a href="galerie-officielle/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
	
		<div class="titreMessagerie">Galerie photo '.NOM.' : '.recupBdd($cat->nom).'</div>
		
		<div id="infoInscription" style="font-size:13px">
				'.nl2br(recupBdd($cat->description)).'
		 </div><br />
			  
			  <table id="voirGalerie">';
	
	// On met en forme le résultat
	$i=0;
	while ($d=mysql_fetch_object($sql)) 
	{
		$desc=recupBdd(nl2br($d->description));
		$desc=wordwrap($desc, 75, "<br />");
		
		$colone='<a href="images/upload/galerieOfficielle/'.$d->photo.'" class="thickbox">
				 	<img src="images/upload/galerieOfficielle/min_'.$d->photo.'" class="imgGalerie" id="img'.$d->id.'" onmouseover="tooltip.show(this, \'<u>Détail galerie</u><br /><br /><p>'.tronquerChaine(strip_tags(recupBdd(nl2br($d->description))),150).'</p>\');" onmouseout="tooltip.hide(this)"/>
				 </a> ';
		
		if ($i%2==0) 	$contenu.='<tr><td>'.$colone.'</td>';
		else			$contenu.='<td>'.$colone.'</td></tr>';
		$i++;
	
	}
	
	$contenu.='</table>
	<div id="retour"><a href="galerie-officielle/"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div><br /><br />
';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie officielle : '.recupBdd($cat->nom));

}
?>