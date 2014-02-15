<?php

	//-- Statistiques --//
	$s1=mysql_query("SELECT count(*) as nb FROM ".PREFIX."membres");
	$s1=mysql_fetch_object($s1);
		$nbMembre=$s1->nb;
	$s2=mysql_query("SELECT count(*) as nb FROM ".PREFIX."galerie");
	$s2=mysql_fetch_object($s2);
		$nbP1=$s2->nb;
	$s2b=mysql_query("SELECT count(*) as nb FROM ".PREFIX."galerieteam");
	$s2b=mysql_fetch_object($s2b);
		$nbP2=$s2b->nb;
		$nbPhotos=$nbP1+$nbP2;
	$s3=mysql_query("SELECT count(*) as nb FROM ".PREFIX."galerie_verif_vote");
	$s3=mysql_fetch_object($s3);
		$nbVotes=$s3->nb;
	$s4=mysql_query("SELECT SUM(nb_dl) as nb, count(*) as nbb FROM ".PREFIX."demos");
	$s4=mysql_fetch_object($s4);
		$nbDlMedias=$s4->nb;
		$nbMee=$s4->nbb;
	$s5=mysql_query("SELECT count(*) as nb FROM ".PREFIX."messagerie");
	$s5=mysql_fetch_object($s5);
		$nbMp=$s5->nb;
	$s6=mysql_query("SELECT count(*) as nb FROM ".PREFIX."guestbook") ;
	$s6=mysql_fetch_object($s6);
		$nbGb=$s6->nb;
	$s7=mysql_query("SELECT count(*) as nb FROM ".PREFIX."breves_com");
	$s7=mysql_fetch_object($s7);
		$nbCom1=$s7->nb;
	$s8=mysql_query("SELECT count(*) as nb FROM ".PREFIX."news_com") ;
	$s8=mysql_fetch_object($s8);
		$nbCom2=$s8->nb;
	$nbCom=$nbCom1+$nbCom2;
	$s9=mysql_query("SELECT count(*) as nb FROM ".PREFIX."forum_mess");
	$s9=mysql_fetch_object($s9);
		$nbFo=$s9->nb;
	$s10=mysql_query("SELECT SUM(nb_dl) as nb, count(*) as nbb FROM ".PREFIX."files_movies");
	$s10=mysql_fetch_object($s10);
		$nbFi=$s10->nb;
		$nbFii=$s10->nbb;
		$nbFiDe=$nbMee+$nbFii;
	$s11=mysql_query("SELECT count(*) as nb FROM ".PREFIX."coverage");
	$s11=mysql_fetch_object($s11);
		$nbCo=$s11->nb;
	$s12=mysql_query("SELECT count(*) as nb FROM ".PREFIX."war");
	$s12=mysql_fetch_object($s12);
		$nbWar=$s12->nb;
	$s13=mysql_query("SELECT count(*) as nb FROM ".PREFIX."news");
	$s13=mysql_fetch_object($s13);
		$nbNews=$s13->nb;	
	$s14=mysql_query("SELECT count(*) as nb FROM ".PREFIX."breves");
	$s14=mysql_fetch_object($s14);
		$nbBreves=$s14->nb;
	$s15=mysql_query("SELECT count(*) as nb FROM ".PREFIX."team_perso");
	$s15=mysql_fetch_object($s15);
		$nbTp=$s15->nb;
	$s16=mysql_query("SELECT count(*) as nb FROM ".PREFIX."team_perso_lineup");
	$s16=mysql_fetch_object($s16);
		$nbTpl=$s16->nb;
	
		$c='<div class="titreMessagerie">Statistiques</div>
		
			<blockquote>
				&nbsp; - News : <strong>'.$nbNews.'</strong><br />
				&nbsp; - Brèves : <strong>'.$nbBreves.'</strong><br />
				&nbsp; - Commentaires postés : <strong>'.$nbCom.'</strong><br />
				&nbsp; - Matchs : <strong>'.$nbWar.'</strong><br />
				&nbsp; - Coverage : <strong>'.$nbCo.'</strong><br /><br />
				
				&nbsp; - Membres : <strong>'.$nbMembre.'</strong><br />
				&nbsp; - Team perso : <strong>'.$nbTp.'</strong><br />
				&nbsp; - Membres team perso : <strong>'.$nbTpl.'</strong><br /><br />				
				
				&nbsp; - Fichiers et Demos : <strong>'.$nbFiDe.'</strong><br />
				&nbsp; - Téléchargements demos : <strong>'.$nbDlMedias.'</strong><br />
				&nbsp; - Téléchargements fichiers : <strong>'.$nbFi.'</strong><br /><br />
				
				&nbsp; - Photos hébergées : <strong>'.$nbPhotos.'</strong><br />
				&nbsp; - Votes : <strong>'.$nbVotes.'</strong><br /><br />

				&nbsp; - Messages privés : <strong>'.$nbMp.'</strong><br />
				&nbsp; - Messages sur les guestbooks : <strong>'.$nbGb.'</strong><br />
				&nbsp; - Messages sur le forum : <strong>'.$nbFo.'</strong><br />
			</blockquote>
				
				
				
				
				
';
				
				
	$design->zone('contenu', $c);

?>