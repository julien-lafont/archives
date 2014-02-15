<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Administration FaisTonChoix.fr</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="theme/css/style.css" media="screen" />
	<meta name="robots" content="noindex, nofollow">
	<link rel="shortcut icon" href="/favicon.ico" />
	<base href="{::baseUrl::}" />
	<script type="text/javascript" src="include/js/librairies/prototype.js"></script>
	<script type="text/javascript" src="include/js/librairies/scriptaculous/scriptaculous.js?load=effects,builder"></script>
	<script>var activer_jvs=1</script>
		<script type="text/javascript" src="include/js/general.js"></script>
		<script type="text/javascript" src="include/js/admin.js"></script>
</head>

<body>
<div id="wrap">
  <div id="top">
    <h2><a href="?admin-accueil" title="Accueil admin">Administration</a> <span style="font-size:11px">FaisTonChoix</span>&nbsp;&nbsp;<span style="font-size:11px; color:#FFF;  border-bottom:2px solid #FF9900; padding-bottom:1px">{::categorie::}</span></h2>
    <div id="menu">
      <ul>
        <li><a href="?admin-accueil" class="current">Admin</a></li>
        <li><a href="?accueil">Accueil</a></li>
        <li><a href="?admin-deco">D&eacute;connexion</a></li>
      </ul>
    </div>
  </div>
  
  
  <div id="content">

<div id="left">

{::contenu::}
 
</div>


<div id="right">
	{::menu_admin::}

	{::last_prop::}
</div>

<div id="clear"></div></div>
<div id="footer">
<p>Copyright 2007 Faistonchoix.fr. Coding by <a href="#">Studio-dev.fr</a></p>
</div>
</div>

</body>
</html>