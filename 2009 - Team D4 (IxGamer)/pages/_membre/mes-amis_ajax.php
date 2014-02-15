<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
case "infos":
	
	$id=(int)$_GET['id'];
	$sql=mysql_query("	SELECT m.pseudo, md.avatar, md.gen_prenom, md.gen_pays, md.g_clan, amis 
						FROM ".PREFIX."membres m
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id 
						WHERE id_membre=$id");
	$d=mysql_fetch_object($sql);
	
	
	if (empty($d->avatar))	{ $avatar="no_avatar.gif"; }
	else					{ $avatar=$d->avatar; }

	echo $id.SEPARATOR;
	echo '	<div class="image"><img src="images/avatar/'.$avatar.'" id="img'.$id.'" /></div>
			<div style="float:right;"><a href="#" onclick="supprAmi('.$id.'); return false;"><img src="images/boutons/agt_stop.png" alt="<b>Supprimer</b> '.$d->pseudo.' de ma liste d\'amis" id="supprAmi'.$id.'" onmouseover="montre(this.id)" onmouseout="cache()"/></a></div>
			<div class="infos">
				Prénom : '.$d->gen_prenom.'<br />
				Pays : '.$d->gen_pays.'<br />
				Clan : '.$d->g_clan.'<br />
			</div>
			<div class="separation"></div>
			<div class="actions">
				<span>&rsaquo;</span> <a href="profil/'.$d->pseudo.'/">Son profil</a><br /><br />
				<span>&rsaquo;</span> <a href="#" onclick="alert(\'Cette action n\\\'est pas disponible directement.\nIl vous suffit d\\\'aller sur son profil et de cliquer sur Envoyer un message\'); return false">Envoyer un message</a><br />
				<span>&rsaquo;</span> <a href="galerie-photo/'.$d->pseudo.'/">Voir sa galerie</a><br />
				<span>&rsaquo;</span> <a href="membre/guestbook/'.$d->pseudo.'/">Voir son guestbook</a>
			</div>';

break;

case "suppr":

	$id=$_GET['id'];
	
	$sql=mysql_query("SELECT amis FROM ".PREFIX."membres_detail WHERE id_membre=".$_SESSION['sess_id']);
	$d=mysql_fetch_object($sql);
	
	$listA=explode('-', $d->amis);
	if (!in_array($id, $listA))
	{
		die("Error : ami inconnu");
	} 
	
	$tempTab=array_flip($listA);
	unset($tempTab[$id]);
	$newTab=array_flip($tempTab);
	$newAmis=implode('-', $newTab);

	$upd=mysql_query("UPDATE ".PREFIX."membres_detail SET amis='$newAmis'");
	if ($upd) echo "ok".SEPARATOR.$id;
	else	  echo "bad";

break;
}
?>