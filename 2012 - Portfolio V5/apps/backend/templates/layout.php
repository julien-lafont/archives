<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_stylesheets() ?>
<?php include_javascripts() ?>

<link rel="stylesheet" type="text/css" href="/js/markitup/images/style.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/js/markitup/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/js/markitup/markitup/sets/html/set.js"></script>
<link rel="stylesheet" type="text/css" href="/js/markitup/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="/js/markitup/markitup/sets/html/style.css" />

<script type="text/javascript">
	$(document).ready(function() {
		$('textarea').markItUp(mySettings);
	});
	
</script>
</head>
<body>


<nav>
  <ul>
    <li><?php echo link_to("Créations", "creation")?></li>
    <li><?php echo link_to("Articles", "article")?></li>
    <li><?php echo link_to("Catégories news", "categorie")?></li>
    <li><?php echo link_to("Catégories folio", "categorie_folio")?></li>
    <li><?php echo link_to("Commentaires", "commentaire")?></li>
    <li><?php echo link_to("Technos", "techno")?></li>
    <li><?php echo link_to("Utilisateurs", "sfGuardUser/index")?></li>
    <li><?php echo link_to("Permissions", "sfGuardPermission/index")?></li>
    <li><?php echo link_to("Groupes", "sfGuardGroup/index")?></li>
    <li><?php echo link_to("Tag", "tag/index")?></li>
    <li><?php echo link_to("Tagging", "tagging/index")?></li>
    <li><a href="javascript:$('textarea').trigger('preview');">#Preview</a></li>
  </ul>
</nav>

<?php echo $sf_content ?>

<p><strong>HELP :</strong><br />
Pour chaque réation, il faut créer :</p>
<ul>
	<li>Une miniature de 100*100</li>
	<li>Des images de démo en 800px de hauteur et les mettre dans le dossier en rapport avec le code du dossier</li>
	<li>Bandeau 610*118 (+2px certaines fois)</li>
</ul>

</body>
</html>


