<?php
securite('5+');

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
   <url>
	  <loc>http://www.faistonchoix.fr/</loc>
	  <lastmod>2007-03-03</lastmod>
	  <changefreq>always</changefreq>
   </url>
   <url>
      <loc>'.URL.'informations_concours.htm</loc>
   </url>
   <url>
      <loc>'.URL.'classement_des_membres_les_plus_actifs.htm</loc>
   </url>
   <url>
      <loc>'.URL.'principe_du_site.htm</loc>
   </url>
   <url>
      <loc>'.URL.'a_venir_sur_faistonchoix.htm</loc>
   </url>
   <url>
      <loc>'.URL.'probleme_technique.htm</loc>
   </url>
   <url>
      <loc>'.URL.'faistonchoix_version_lite.htm</loc>
   </url>
   <url>
      <loc>'.URL.'faistonchoix_version_normale.htm</loc>
   </url>
   <url>
      <loc>'.URL.'sitemap.htm</loc>
   </url>';
	
$sqlD=mysql_query("SELECT id, nom1,nom2 FROM ".PREFIX."duels ORDER BY id DESC");
while ($d=mysql_fetch_object($sqlD)) {
$xml.='
	<url>
		<loc>'.URL.'duel-'.recode(recupBdd($d->nom1)).'_ou_'.recode(recupBdd($d->nom2)).'-'.$d->id.'.htm</loc>
   </url>';
}

$sqlT=mysql_query("SELECT id, nom, miniature FROM ".PREFIX."themes ORDER BY id DESC");
while ($theme=mysql_fetch_object($sqlT)) {
$xml.='
	<url>
		<loc>'.URL.'theme-'.recode(recupBdd($theme->nom)).'-'.$theme->id.'.htm</loc>
   </url>';
}
	
	$xml .= '
</urlset>';
		   
	//$fp = fopen("sitemap.xml", 'w+');
	//fputs($fp, $xml);
	//fclose($fp);
	
	
	$c='<h2>Référencemen : Sitemap</h2><br /><br />
	
	<center><b>Sitemap.xml mis à jour !</b></center><br /><br />
	<textarea style="width:100%; height:500px; font-family:verdana; font-size:11px; padding:4px; border:1px solid #ccc">'.$xml.'</textarea>';
	
	$design->template('admin');
	$design->zone('contenu', $c);
	$design->zone('categorie', 'SITEMAP');


?>