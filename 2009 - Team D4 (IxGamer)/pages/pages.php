<?php

if (!isset($_GET['idPage']))
{
	bloquerAcces("Vous ne pouvez accéder directement à cette page !"); 

}
//:: Affichage de la page :://
else
{
	$id=$_GET['idPage'];
	
	$sql=mysql_query("SELECT id, titre, contenu, date FROM ".PREFIX."pages WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$nb=mysql_affected_rows();
	if ($nb==0) {
		bloquerAcces("Cette page n'est pas ( ou plus ) présente dans notre base de donnée");
	}
	
		// Actions admin
		if (is_admin()) $admin='<div class="bloc_admin_news" id="bloc_admin">Admin <br /><a href="?admin-pages_simples&action=editer&id='.$d->id.'"><img src="images/boutons/playlist.png" /></a> &nbsp;<a href="#" onclick="alert(\'Action désactivée pour raison de sécurité\n Si vous souhaitez vraiment supprimer la page, allez dans l\\\'administration\'); return false"><img src="images/boutons/del.png" /></a></div>';
		
	$contenu='
		<div id="contenuNews">
			'.@$admin.recupBdd($d->contenu).'
		</div>';
		
	$design->template('simple');
	$design->zone('titre', recupBdd($d->titre));
	$design->zone('titrePage', recupBdd($d->titre));	
	$design->zone('contenu', $contenu);
	$design->zone('header', '');
	

}				
?>