<?php
securite_membre();

$design->zone('header','<link rel="stylesheet" href="include/js/lightbox/lightbox.css" type="text/css" media="screen" />
						<script src="include/js/lightbox/lightbox.js" type="text/javascript"></script>
						<script src="include/js/-profil.js" type="text/javascript"></script>
						<script src="include/js/-bulle_infos.js" type="text/javascript"></script>');

$pseudo=$_GET['arg1'];
$action=$_GET['arg2'];

switch($action)
{
default:
	
	// On recherche l'ID
	$sqlPre=mysql_query("SELECT id FROM ".PREFIX."membres WHERE pseudo='".addBdd(strtolower(trim($pseudo)))."'");
	$pre=mysql_fetch_object($sqlPre);
		$id=$pre->id;
		if (mysql_affected_rows()!=1)
		{
			bloquerAcces("Le membre que vous avez indiqu� n'est pas pr�sent dans notre base de donn�e !");
		}
	
	// On s�lectionne toutes les photos de ce membre
	$sql=mysql_query("	SELECT * 
						FROM ".PREFIX."galerie
						WHERE id_membre='$id'");
	$nbPhoto=mysql_affected_rows();
	
		// Aucune photo
		if ($nbPhoto==0)
		{
			$design->template('simple');
			$design->zone('titrePage', 'Galerie' );
			$design->zone('titre', 'Galerie de '.ucfirst($pseudo).' &nbsp;-&nbsp; <i>D4team.com</i>');
			$design->zone('contenu', miseenforme('message', 'Aucune photo dans la galerie de '.ucfirst($pseudo))."<br />" );
			$design->afficher();
			die();
		}
		
	$contenu='<div id="curseur" class="infobulle"></div>
			  <table id="voirGalerie">';
	
	
	// On met en forme le r�sultat
	$i=0;
	while ($d=mysql_fetch_object($sql)) 
	{
		if ($d->note_coeff>1) $pluriel="s";
				 
		$colone='<a href="images/upload/galerie/'.$id.'/'.$d->img.'" rel="lightbox" title="'.nl2br(recupBdd($d->description)).'">
				 	<img src="images/upload/galerie/'.$id.'/min_'.$d->img.'" class="imgGalerie" id="img'.$d->id.'" alt="'.tronquerChaine(recupBdd($d->description)).'" onmouseover="montre(this.id)" onmouseout="cache()"/>
				 </a><br />
				 <span id="note'.$d->id.'">Note : <strong>'.round($d->note, 1).'/5</strong> ( '.$d->note_coeff.' vote'.@$pluriel.' )</span>';
		
		// On v�rifie si l'utilisateur a d�j� vot� :
		$sqlVote=mysql_query("	SELECT count(id_photo) as nb
								FROM ".PREFIX."galerie_verif_vote
								WHERE id_photo='".$d->id."' AND id_membre='".$_SESSION['sess_id']."'");
		$vote=mysql_fetch_object($sqlVote);
		
		if ($vote->nb==0 AND $id!=$_SESSION['sess_id']) { /*  !!!!!!!!!!! AND $id!=$_SESSION['sess_id']  */
			$colone .= '<center id="vote'.$d->id.'">
							<ul class="star-rating">
							  <li><a href="#" onclick="noterPhoto('.$d->id.', 1); return false" title="Noter cette photo 1/5" class="one-star">1</a></li>
							  <li><a href="#" onclick="noterPhoto('.$d->id.', 2); return false" title="Noter cette photo 2/5" class="two-stars">2</a></li>
							  <li><a href="#" onclick="noterPhoto('.$d->id.', 3); return false" title="Noter cette photo 3/5" class="three-stars">3</a></li>
							  <li><a href="#" onclick="noterPhoto('.$d->id.', 4); return false" title="Noter cette photo 4/5" class="four-stars">4</a></li>
							  <li><a href="#" onclick="noterPhoto('.$d->id.', 5); return false" title="Noter cette photo 5/5" class="five-stars">5</a></li>
							</ul>
						</center>';
		}

		
		if ($i%2==0) 	$contenu.='<tr><td>'.$colone.'</td>';
		else			$contenu.='<td>'.$colone.'</td></tr>';
		$i++;
	
	}
	
	$contenu.='</table>';
	
	$design->zone('contenu', $contenu);
	$design->zone('titrePage', 'Galerie');
	$design->zone('titre', 'Galerie photo de '.ucfirst($pseudo).' &nbsp;&nbsp; <span id="lien_guestbook">[<a href="Guestbook/'.$pseudo.'/">guestbook</a>] &nbsp; [<a href="Profil/'.$pseudo.'/">profil</a>]</span>');

break;
}
?>