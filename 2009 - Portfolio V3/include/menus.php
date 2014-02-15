<?php
// ---------------------------------------------------------------------------
// On forme les menus ( dynamiquement ou code HTML direct ) 
// Et on leur assigne leur zone sur les templates
// ---------------------------------------------------------------------------


//-- Bloc Connexion --//
if (!is_admin()) {
	$con='<h4 id="con_mess">Entrez vos identifiants de connexion</h4>
		
		<form name="connexion" action="#" method="post" onsubmit="connexion_ajax(); return false">
		<fieldset id="form_connexion">
		
			<label for="con_login">
				<input type="text" name="con_login" id="con_login" maxlength="30" value="Login" onclick="if (this.value==\'Login\') this.value=\'\'" />
			</label><br />
			
			<label for="con_pass">
				<input type="password" name="con_pass" id="con_pass" maxlength="30" value="YoTsumi" onclick="if (this.value==\'YoTsumi\') this.value=\'\'" />
			</label>
			
		<div class="formactions">
			<input type="submit" name="submit" id="con_sub" class="submit" value="Connexion" />
		</div>
		
		<br /><div id="liens">&rsaquo; <a href="#">Mot de passe perdu</a> &lsaquo;</div>
	
		</fieldset>
		</form>';
}
else 
{
	$con="<div style='text-align:center'>
			<p>&nbsp;</p>
			<p>Bienvenue <b>".$_SESSION['sess_pseudo']."</b></p>
			<p><a href='?admin/accueil'>Accéder à l'administration</a><br />
			   <a href='?admin/deco'>Déconnexion</a><br /></p>
		  </div>";
}
$design->zone('zone_connexion', $con);


//-- Bloc Catégories --//
	$mCats='<li><a href="'.URL.'" title="Accueil Studio-dev.fr : Portfolio de Yotsumi"><b>Page d\'accueil</b></a> </li>';
	$sql_cats=mysql_query("SELECT * FROM ".PREFIX."news_cat ORDER BY ordre ASC");
	while($cats=mysql_fetch_object($sql_cats)) {
		$sql_nb=mysql_query("SELECT id FROM ".PREFIX."news WHERE idcat=".$cats->id);
		$nb=mysql_num_rows($sql_nb);
		$mCats.='<li><a href="categorie-'.$cats->id.'-'.recode($cats->nom).'.htm" title="Afficher les articles et billets de la catégorie '.$cats->nom.'">'.$cats->nom.'</a> ('.$nb.')</li>';
	}
	$design->zone('menu_categories', $mCats);						
	
	
//-- Bloc dernières news --//
	$mNews="";
	$sql_news=mysql_query("SELECT * FROM ".PREFIX."news ORDER BY id DESC LIMIT 0,10");
	while ($news=mysql_fetch_object($sql_news)) {
		$date=substr(inverser_date($news->date,4),0,5);
		if ($page=="news")  $ajax='onclick="direct_news('.$news->id.'); return false"';
		$mNews.='<li><a href="actualite-'.$news->id.'-'.recode($news->url).'.htm" '.$ajax.'><span class="date">'.$date.'</span>'.recupBdd($news->titre).'</a></li>';
	}
	$design->zone('dernieres_news', $mNews);						


	
//-- Bloc Portfolio --// 
	$mPort='<li><a id="port7" href="'.URL.'portfolio-12-blog-2-0-de-samuel-hounkpe.htm" title="" rel="'.htmlentities('<b>Blog 2.0</b><br /><div style=\'width:174px; height:150px;\' class="black_loading"><img src=\'images/min/hk.png\' border=\'0\' alt=\'Hounkpe\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/hk.png" /></a></li>
			<li><a id="port8" href="'.URL.'portfolio-11-chansons-paroles-traductions-clips-musique-francaise-et-internationale.htm" title="" rel="'.htmlentities('<b>Chansons-Paroles</b><br /><div style=\'width:173px; height:150px;\' class="black_loading"><img src=\'images/min/cp.png\' border=\'0\' alt=\'Chansons-Paroles\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/cp.png" /></a></li>
			<li><a id="port6" href="'.URL.'portfolio-9-Fais-ton-choix-Duels-de-photos-en-ligne.htm" title="" rel="'.htmlentities('<b>Fais Ton Choix</b><br /><div style=\'width:193px; height:150px;\' class="black_loading"><img src=\'images/min/ftc.png\' border=\'0\' alt=\'ImagUp Recherche\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/ftc.png" /></a></li>
			<li><a id="port1" href="'.URL.'portfolio-2-Team-Dimension-4.htm" title="" rel="'.htmlentities('<b>D4 Team</b><br /><div style=\'width:215px; height:160px;\' class="black_loading"><img src=\'images/min/d4.jpg\' border=\'0\' alt=\'Site D4\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/d43.png" /></a></li>
			<li><a id="port3" href="'.URL.'portfolio-4-Regie-publicitaire-nouvelle-generation.htm" title="" rel="'.htmlentities('<b>WixPay</b><br /><div style=\'width:193px; height:160px;\' class="black_loading"><img src=\'images/min/wixpay.jpg\' border=\'0\' alt=\'Site MonStyle\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/wixpay1.png" /></a></li>
			<li><a id="port4" href="'.URL.'portfolio-3-Hegergeur-de-blog-revolutionnaire-en-web-2-0.htm" title="" rel="'.htmlentities('<b>Wix-Blog</b><br /><div style=\'width:180px; height:144px;\' class="black_loading"><img src=\'images/min/wixblog.jpg\' border=\'0\' alt=\'Site Wix-Blog\'/></div>').'" onmouseover="montre(this.id)" onmouseout="cache();" ><img src="images/portfolio/wixblog3.png" /></a></li>
';
	$design->zone('portfolio', $mPort);


//-- Bloc Portfolio --//
	$mDesign='<li><a href="images/design/BewareDesign-big.png" class="thickbox"title="Beware Design"><img src="images/design/BewareDesign-min.png" alt="" /></a></li>
			  <li><a href="images/design/iluxine-big.png" class="thickbox" title="Iluxine"><img src="images/design/iluxine-min.png" alt="" /></a></li>
			  <li><a href="#" onclick="alert(\'Vous êtes déjà entrain de voir ce design !\');" title="rien"><img src="images/design/pf1.png" alt="Design PortFolio" /></a></li>';
	$design->zone('designs', $mDesign);
	
		



?>