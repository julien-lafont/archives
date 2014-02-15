<?php

function bloc_login() {

	$txt='<h4>Veuillez vous identifier :</h4><br>
			<form name="identification" method="post" action="?p=fonctions/identification">
				<div style="margin-left:20px">
					<input type="text" name="pseudo" style="background-image:url(images/formulaires/pseudo.png);" maxlength="50" class="input_log" value="Login" onclick="this.value=\'\'"><br>
					<input type="password" name="pass" style="background-image:url(images/formulaires/pass.png); margin-top:10px" maxlength="50" class="input_log" value="password"  onclick="this.value=\'\'"><br>
					<div class="envoyer" style="width:115px; margin-top:5px" OnClick="document.identification.submit()">Se connecter</div>
				</div>
			</form>
			
			&nbsp;&nbsp;&nbsp;<img src="images/puce/blan1.jpg"> <a href="?p=inscription">Inscription</a><br>
			&nbsp;&nbsp;&nbsp;<img src="images/puce/blan1.jpg"> <a href="?p=mdpperdu">Mot de Passe ?</a>';
	
	return $txt;
}

function bloc_membre() {

		$sql1=mysql_query("SELECT count(id) as nb FROM mp WHERE `id_dest`=".$_SESSION['sess_id']." AND (`etat`='nouveau' OR `etat`='important')");
		$d1=mysql_fetch_object($sql1);
		$nb=round($d1->nb);
		
	$txt='<div id="logOn"><h4>Mon compte</h4><br> 
		Bienvenu <b>'.ucfirst($_SESSION['sess_pseudo']).'</b><br><br>
		&nbsp;&nbsp;&nbsp;<img src="images/puce/blan1.jpg"> <a href="?p=fonctions/deco"><b>D</b>éconnexion<a/><br>
		&nbsp;&nbsp;&nbsp;<img src="images/puce/rouge.png"> <a href="?p=membre/home"><b>E</b>space Perso</a><br>
		&nbsp;&nbsp;&nbsp;<img src="images/puce/blan1.jpg"> <a href="?p=membre/inbox"><b>B</b>oite réception</a> <i>('.$nb.')</i>';
		if ($_SESSION['sess_admin']==1) 
			$txt.='<br><br>&nbsp;&nbsp;&nbsp;<img src="images/puce/rouge.png"> <a href="?p=admin/home&secure='.$_SESSION['sess_secure'].'"><b>A</b>dministration</a></div>';
		else $txt.='</div>';
	
	return $txt;
}

function bloc_stats() {

	// Système de cache pour limiter les appels Mysql !
	if (!isset($_SESSION['cache_stats'])) {
		$sql1=mysql_query("SELECT count(id_membre) as nbid FROM members");
		$d1=mysql_fetch_object($sql1);
		$_SESSION['cache_stats']=round($d1->nbid);
	}
		
	$temps=time()-3600; // 1h
		$sql2=mysql_query("SELECT count(id_membre) as nbcon FROM members WHERE online=1 AND lastdate>=$temps");
		$d2=mysql_fetch_object($sql2);
	
	$txt='<h4>Statistiques</h4><br> 
		<b>'.round($_SESSION['cache_stats']).'</b> membres inscrits<br>
		<b>'.round($d2->nbcon).'</b> membre(s) connecté(s)<br>
		<a href="?p=top&a=enLigne">Voir les membres connectés</a><br>';
	
	return $txt;
}
function bloc_profil() {
	
	$txt='<h4>Voir profil de : </h4><br>
		<form name="direct" action="" method="GET">
		  <input type="text" name="username" style="background-image:url(images/formulaires/nom.png); margin-left:10px" maxlength="50" class="input_log" value="Son pseudo" onclick="this.value=\'\'">
		  <input name="submit" type="image" src="images/formulaires/search2.jpg" style="vertical-align:middle"  class="no" value="">
		  <input type="hidden" name="p" value="infos">
		</form>';
	return $txt;
}


?>