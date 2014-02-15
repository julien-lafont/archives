<?php

//::::: Page principale ::::://
if (empty($_GET['arg1']))
{

	$sql=mysql_query("SELECT * FROM ".PREFIX."medias ORDER BY id DESC");
	
	$c='<div id="infoInscription" style="font-size:12px">
			<b>Voici les médias de la team Dimension4.</b><br />
			<span style="font-size:10px">Vous devez être connecté pour télécharger ces fichiers</span>
		</div>';
	
	$nb=mysql_affected_rows();
	if ($nb==0) $c.='<br \><center>Aucun média disponible</center><br /><br />';
	
	else
	{
		$c.='<table id="listeMedias" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:28px"></td>
					<td style="width:300px"></td>
					<td style="width:65px"></td>
					<td style="width:90px"></td>
				</tr>';
		while ($d=mysql_fetch_object($sql)) {
			$c.='<tr>
					<td><img src="images/mini_d4.gif" alt="-" /></td>
					<td><a href="media/'.$d->id.'/'.recode(recupBdd($d->nom)).'/" title="MEDIA : '.recupBdd($d->nom).'">'.recupBdd($d->nom).'</a></td>
					<td style="text-align:right; padding-right:3px">'.$d->nb_dl.' <a href="media/'.$d->id.'/'.recode(recupBdd($d->nom)).'/" title="MEDIA : '.recupBdd($d->nom).'"><img src="images/boutons/download2.png" style="vertical-align:middle" /></a></td>
					<td style="padding-left:3px; text-align:center">'.recupBdd($d->auteur).'</td>
				 </tr>';
		}
		$c.='</table>';
	}
				
	
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'MEDIAS');
	$design->zone('titre', 'Médias de la team D4');

}
else
{

//::::: Fiche détaillée ::::://
if ($_GET['arg1']!="download")
{
	   $id=$_GET['arg1'];
	   $sql=mysql_query("SELECT * FROM ".PREFIX."medias WHERE id=$id");
	   $d=mysql_fetch_object($sql);
	   
	   if (is_log()) 
	   	$telecharger='<center><b>Télécharger</b><br />
						 <a href="media/download/'.$id.'/" target="_blank"><img src="images/download2.png" /></a>
					   </center>';
	   else
	   	$telecharger='<center><b>Télécharger</b><br />
						 <img src="images/no-download.png" /><br />
						 <span style="font-size:10px; color:#FF6600">
						 	Vous devez être connecté pour télécharger ce fichier.
						 </span>
					   </center>';
		
	   $c='<div id="retour"><a href="Media/">&lsaquo; Retour &lsaquo;</a></div>
	   <div id="infoInscription" style="font-size:14px">
			Fiche du média<br />
			<strong style="color:#00A8FF">'.stripslashes($d->nom).'</strong>
		   </div><br />
		   
		   <table style="width:100%; border:0">
		    <tr>
			 <td style="width:150px"><b>Ajouté le</b></td>
			 <td>le '.inverser_date($d->date, 6).'</td>
			</tr>
			<tr>
			 <td><b>Nb Téléchargements</b></td>
			 <td>'.$d->nb_dl.' fois</td>
			</tr>
			<tr>
			 <td><b>Taille du fichier</b></td>
			 <td>'.recupBdd($d->taille).' mo</td>
			</tr>
			<tr>
			 <td><b>Réalisateur</b></td>
			 <td>'.recupBdd($d->auteur).'</td>
			</tr>
		   </table>
		   
		   <br /><b>Infos supplémentaires</b><br />
		   '.nl2br(recupBdd($d->description)).'<br /><br />
		   
		   '.$telecharger;
		   
	$design->zone('contenu', $c);
	$design->zone('titrePage', 'MEDIAS');
	$design->zone('titre', 'Médias de la team D4');

}
//::::: Compteur download ::::://
else
{
	$id=$_GET['arg2'];
	if (empty($id)) die("Accés interdit !");
	
	securite_membre();
	  
	  $sql=mysql_query("UPDATE ".PREFIX."medias SET nb_dl=nb_dl+1 WHERE id=$id");
	  
	  $sql2=mysql_query("SELECT url FROM ".PREFIX."medias WHERE id=$id");
	  $d=mysql_fetch_object($sql2);
	  
	$fichier = recupBdd($d->url);
	header('location: '.$fichier);		
		
}

}







?>