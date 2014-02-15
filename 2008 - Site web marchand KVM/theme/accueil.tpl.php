<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{::nom::} > {::titre::}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta name="description" content="{::meta_description::}">
	<meta name="keywords" content="{::meta_keywords::}">
	
	<link rel="stylesheet" type="text/css" href="theme/style.css" media="screen" />
	<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" href="theme/admin/css/ie6_or_less.css" />
	<![endif]-->
	<script type="text/javascript" src="include/js/librairies/jquery.js"></script>
	<script type="text/javascript" src="include/js/librairies/interface.js"></script>
	<script type="text/javascript" src="include/js/-general.js"></script>
	{::header::}
</head>
<body id="type-d">
<div id="wrap">

	<div id="header">
		<br /><div id="site-name"><a href="{::URL::}" title="{::meta_description::}">{::nom::}</a></div><br />
	</div>
	
  <div id="content-wrap">
	

	<div id="content">
		
			<h1>{::titre::}</h1>
			
			<div class="bloc_produits">
				<h2>Derniers articles ajoutés</h2>
				<ul>{::bloc_produits_derniers_articles::}</ul>
			</div>
			
			<div class="bloc_produits">
				<h2>Produits populaires</h2>
				<ul>{::bloc_produits_populaires::}</ul>
			</div>

			<div class="bloc_produits">
				<h2>Produits coup de coeur</h2>
				<ul>{::bloc_produits_coup_de_coeur::}</ul>
			</div>
						
			<div id="footer">
			<p>{::nom::} by <a href="#">Studio-dev</a> and <a href="#">Web-Expect</a></p>
			</div>
			
	</div>
	
	
	
	<div id="sidebar">

			<div class="featurebox" id="bloc_membre">
				{::menu_connexion_membre::}
			</div>

			<div class="featurebox">
				{::menu_categories::}
			</div>

			<div class="featurebox" id="bloc_panier">
				{::menu_panier::}
			</div>

	</div>		
	
			
  </div>
</div>
</body>
</html>