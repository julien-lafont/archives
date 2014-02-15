<?php

// Protège la page : accessible seulement aux Admins
securite_admin();

	//-- Données contact
	$sqlContact=mysql_query("SELECT count(id) as nb FROM ".PREFIX."contact WHERE etat!='d-archive'");
		$c1=mysql_fetch_object($sqlContact);
		$contactTotal=$c1->nb;
	$sqlContact2=mysql_query("SELECT count(id) as nb FROM ".PREFIX."contact WHERE etat='a-nouveau'");
		$c2=mysql_fetch_object($sqlContact2);
		$contactNew=$c2->nb;
	
	//-- Statistiques --//
	$s1=mysql_query("SELECT count(*) as nb FROM ".PREFIX."membres");
	$s1=mysql_fetch_object($s1);
		$nbMembre=$s1->nb;
	$s2=mysql_query("SELECT count(*) as nb FROM ".PREFIX."galerie");
	$s2=mysql_fetch_object($s2);
		$nbPhotos=$s2->nb;
	$s3=mysql_query("SELECT count(*) as nb FROM ".PREFIX."galerie_verif_vote");
	$s3=mysql_fetch_object($s3);
		$nbVotes=$s3->nb;
	$s4=mysql_query("SELECT SUM(nb_dl) as nb FROM ".PREFIX."medias");
	$s4=mysql_fetch_object($s4);
		$nbDlMedias=$s4->nb;
	$s5=mysql_query("SELECT count(*) as nb FROM ".PREFIX."messagerie") or die(mysql_error());
	$s5=mysql_fetch_object($s5);
		$nbMp=$s5->nb;
	$s6=mysql_query("SELECT count(*) as nb FROM ".PREFIX."guestbook") or die(mysql_error());
	$s6=mysql_fetch_object($s6);
		$nbGb=$s6->nb;
	$s7=mysql_query("SELECT count(*) as nb FROM ".PREFIX."breves_com") or die(mysql_error());
	$s7=mysql_fetch_object($s7);
		$nbCom1=$s7->nb;
	$s8=mysql_query("SELECT count(*) as nb FROM ".PREFIX."news_com") or die(mysql_error());
	$s8=mysql_fetch_object($s8);
		$nbCom2=$s8->nb;
	$nbCom=$nbCom1+$nbCom2;
		
$contenu='<center>Bienvenu sur l\'espace d\'administration de D4team.com</center>
			<div id="menu_admin">
				<ul>
					<li><a href="?admin-membres">Gérer les membres</a></li>
					<li><a href="?admin-news">Gérer les news</a></li>
					<li><a href="?admin-breves">Gérer les brèves</a></li>
					<li><a href="?admin-pages_simples">Gérer les articles HTML</a></li>
					<li><a href="?admin-contact">Contact : <b>'.$contactNew.'</b> non-lus / '.$contactTotal.'</a></li>
					<li><a href="?admin-team">Gérer la team</a></li>
					<li><a href="?admin-galerie">Gérer la galerie</a></li>
					<li><a href="?admin-medias">Gérer les medias</a></li>
					<!--<li><a href="#" onclick="alert(\'A venir :)\'); return false">Gérer les blocs</a></li>-->
				</ul>
			</div>
			
			<div id="menu_admin_suite"
				<b>Stats rapides</b><br>
				&nbsp; - Membres : <strong>'.$nbMembre.'</strong><br />
				&nbsp; - Photos hébergées : <strong>'.$nbPhotos.'</strong><br />
				&nbsp; - Votes : <strong>'.$nbVotes.'</strong><br />
				&nbsp; - Téléchargements médias : <strong>'.$nbDlMedias.'</strong><br />
				&nbsp; - Messages échangés : <strong>'.$nbMp.'</strong><br />
				&nbsp; - Messages postés (guestbook) : <strong>'.$nbGb.'</strong><br />
				&nbsp; - Commentaires postés : <strong>'.$nbCom.'</strong><br />

			</div>';

	$design->zone('contenu', $contenu);
	$design->zone('titre', 'Accueil de l\'administration');
	$design->zone('titrePage', 'Admin');
?>