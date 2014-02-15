<?php
/*  ---------------------------------------------------------------------------------------------------------------
	  Accés direct : revoir une photo
	    -> Affichage dans la modalbox d'une photo ( clic depuis le classement thème )
    --------------------------------------------------------------------------------------------------------------- */

	$id=(int)$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."themes_photos WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	if ($d->nom) {
		$design->template('photo');
		$design->zone('nom', recupBdd($d->nom));
		$design->zone('img', PHOTO.recupBdd($d->img));
		$design->zone('votes', $d->nb_votes);
	}
	else
	{
		exit('Photo invalide !'.$d->nom);
	}
	
	
?>