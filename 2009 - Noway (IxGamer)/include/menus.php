<?php

//:: ----- Bloc Head Sponsors ----- :://
$design->zone('head_sponsor', recupBdd(SPONSOR));

//:: ----- Bloc WHAT IS NOWAY ----- :://
$design->zone('what_is', recupBdd(BLOC_ABOUT_US));


//:: ----- Dernières brèves = Scene ----- :://
$sqlBreves=mysql_query("SELECT b.id, b.titre, b.date, b.contenu, b.pays, count(c.id) as nb
						FROM ".PREFIX."breves b
						LEFT JOIN ".PREFIX."breves_com c ON c.id_breve=b.id
						GROUP BY b.id
						ORDER BY b.id DESC LIMIT 0,5");
$nbB=0;
while ($b=mysql_fetch_object($sqlBreves)) {
	if ($nbB%2==1) $class="class='alt'"; else $class="";
	if (empty($b->pays)) $b->pays="France";
	@$breves.='<li '.$class.'><img src="images/upload/banque_image/flags/'.$b->pays.'.gif" alt="Drapeau" /> <a href="Breves/'.$b->id.'/'.recode($b->titre).'.htm" onmouseover="tooltip.show(this, \'<u>'.$b->titre.'</u><br /><br /><p>'.tronquerChaine(strip_tags(str_replace("\r\n"," ",$b->contenu)),150).'</p>\',\'big\');" onmouseout="tooltip.hide(this)">'.tronquerChaine(recupBdd($b->titre),25).'</a> <span>('.round($b->nb).')</span></li>';
	$nbB++;
}
	$design->zone('breves', $breves);


//:: ----- Derniers Résultats = Results ----- :://
$sqlRes=mysql_query("SELECT id, jeu, adversaire, nata, scoret, scoreadv FROM ".PREFIX."war ORDER BY date DESC LIMIT 0,5");
$nbR=0;
while ($r=mysql_fetch_object($sqlRes)) {
	if ($nbR%2==1) $class="class='alt'"; else $class="";
	if (empty($r->nata)) $r->nata="France";
	
	if ($r->scoret>$r->scoreadv)  { $class1="win"; $class2="lose"; $terme="vainqueur";   }
	if ($r->scoreadv>$r->scoret)  { $class1="lose"; $class2="win"; $terme="perdant"; }
	if ($r->scoreadv==$r->scoret) { $class1="egal"; $class2="egal"; $terme="ex-aequo";  }
	
	// Mise en forme du score sur 2 chiffres
	if ($r->scoreadv<10) $r->scoreadv="0".$r->scoreadv;
	if ($r->scoret<10) $r->scoret="0".$r->scoret;

	@$results.='<li '.$class.'><img src="'.CHEMIN_JEU.$r->jeu.'.png"> <a href="results/match-'.$r->id.'-'.recode(NOM).'-'.$terme.'-contre-'.recupBdd(recode($r->adversaire)).'.htm">'.NOM.' <span class="'.$class1.'">['.$r->scoret.']</span> vs <span class="'.$class2.'">['.$r->scoreadv.']</span> <img src="'.CHEMIN_PAYS.$r->nata.'.gif" /> '.recupBdd($r->adversaire).' </a></li>';
	$nbR++;
}
	$design->zone('results', $results);


//:: ----- Mini Gallery ----- :://
$sqlGalerie=mysql_query("SELECT * FROM ".PREFIX."galerieteam ORDER BY id DESC LIMIT 0,9");
while($g=mysql_fetch_object($sqlGalerie)) {
	@$galerie.='<li><a href="'.URL.'images/upload/galerieOfficielle/'.$g->photo.'" class="thickbox"><img src="pages/fonctions/redim.php?imgfile='.URL.'images/upload/galerieOfficielle/min_'.$g->photo.'&max_width=120&max_height=95" class="effect"/></a></li>';

}
	$design->zone('galerie', $galerie);



//:: ----- Prochains évènements = Coverage ---- :://
$sqlCov=mysql_query("SELECT id, nom, date, pays, jeu FROM ".PREFIX."coverage ORDER BY date DESC LIMIT 0,5");
$nbC=0;
while ($c=mysql_fetch_object($sqlCov)) {
	if ($nbC%2==1) $class="class='alt'"; else $class="";
	
	// On s'occupe de la date
	list($date, $heure) = explode(" ", $c->date);
	list($annee, $mois, $jour) = explode("-", $date);
	list($h, $mn, $sec) = explode(":", $heure);
	
	$t=mktime((int)$h, (int)$mn, 0, (int)$mois, (int)$jour, (int)$annee);
	$now=time();  /* aide : */ $_h=3600; $_j=24*3600;
		
	// Gestion des différents évènements
	if 		( $now>($t+$_h) ) 					$info="Done";
	elseif	( $now>$t && $now<=($t+$_h) ) 		$info="Live";
	elseif  ( $now>($t-$_h) && $now<=$t )		$info="Live in ".round((($now-$t)/60)).'mn';
	elseif	( $now>($t-$_j) && $now<=($t-$_h) )	$info=$h.':'.$mn;
	elseif	( $now<=($t-$_h) )					$info=$jour.'-'.$mois;

	@$coverage.='<li '.$class.'><img src="'.CHEMIN_JEU.$c->jeu.'.png"> 
					<a href="coverage/evenement-'.$c->id.'-'.recode(recupBdd($c->nom)).'-le-'.inverser_date($c->date, 4).'.htm" title="Accéder à l\'évènement '.recupBdd($c->nom).'">'.recupBdd($c->nom).'</a> <span class="right">'.$info.'</span>
				</li>';
	$nbC++;
}
	$design->zone('coverage', $coverage);


//:: ----- Membres de la team  ----- :://

$sqlMembre=mysql_query("SELECT tc.nom, t.id_membre, t.pseudoAff, t.photo, m.pseudo 
						FROM ".PREFIX."team t 
						LEFT JOIN ".PREFIX."team_cat tc
						ON tc.id=t.id_team
						LEFT JOIN ".PREFIX."membres m
						ON m.id=t.id_membre
						WHERE tc.afficher=1
						ORDER BY t.id_team ASC") or die(mysql_error());
	
	$team='';
	$oldTeam='';
	
	while($m=mysql_fetch_object($sqlMembre)) {
	
		if ($oldTeam!=$m->nom) {
			if (!empty($team)) $team.='</ul>';
			$team.='<div class="titre_team">'.recupBdd($m->nom).'</div>
					<ul class="liste_team">';
		}
		
		$team.='<li><a href="profil/'.recode(recupBdd($m->pseudo)).'/" title="Accéder au profil de '.recupBdd($m->pseudo).'"><img src="pages/fonctions/redim.php?imgfile='.URL.'images/players/'.$m->photo.'&max_width=50&max_height=50" /></a></li>';
		$oldTeam=$m->nom;
	}
	$team.='</ul>';
	
$design->zone('team', $team);
		
		
		
//:: ----- Derniers Fichiers ----- :://
$sqlFiles=mysql_query("SELECT * 
						FROM ".PREFIX."files_movies
						ORDER BY id DESC
						LIMIT 0,5");
	while($me=mysql_fetch_object($sqlFiles)) {
		@$files.='<li><a href="files/movies/detail-'.$me->id.'-'.recode(recupBdd($me->nom)).'.htm" onmouseover="tooltip.show(this, \'<u>Nos Fichiers</u><br /><br /> <b>'.recupBdd($me->nom).'</b><br /><strong>'.$me->nb_dl.'</strong> dls\')" onmouseout="tooltip.hide(this)">'.tronquerChaine(recupBdd($me->nom), 32).'</a></li>';	
	}
	if (mysql_affected_rows()==0) { $files='<li><center>Aucun fichier</center></li>'; }
$design->zone('last_medias', $files);



//:: ----- Derniers Topics ----- :://
$sqlTopics=mysql_query("(SELECT m.id, m.id_cat, m.titre, c.nom, count(mm.id) as nb, pseudo
						FROM ".PREFIX."forum_mess m
						LEFT JOIN ".PREFIX."forum_cat c
						ON c.id=m.id_cat
						LEFT JOIN ".PREFIX."forum_mess mm
						ON mm.id_mess=m.id
						LEFT JOIN ".PREFIX."membres mb
						ON mb.id=m.id_membre
						WHERE m.id_mess=0
						GROUP BY m.id
						ORDER BY m.id DESC
						LIMIT 0,5)") or die(mysql_error());
	while($mess=mysql_fetch_object($sqlTopics)) {
		@$topics.='<li><a href="Forum/_'.$mess->id.'/'.recode(recupBdd($mess->nom)).'/'.recode(recupBdd($mess->titre)).'.htm" onmouseover="tooltip.show(this, \'<u>Forum '.NOM.'</u><br /><br /> <em>'.tronquerChaine($mess->titre,16).'</em><br />Par '.ucfirst($mess->pseudo).'<br /><strong>'.$mess->nb.'</strong> réponses\')" onmouseout="tooltip.hide(this)" title="">'.tronquerChaine(recupBdd($mess->titre), 28).'</a></li>';	
	}
	if (mysql_affected_rows()==0) { $topics='<li><center>Aucun Thread</center></li>'; }
$design->zone('last_topics', $topics);

//:: ----- Pub ----- :://
if (function_exists('file_get_contents')) {
	$pub=@file_get_contents('http://www.ix-gamer.net/elem_general/pub.txt');
}	else $pub="";
	$design->zone('pub', $pub);


?>

