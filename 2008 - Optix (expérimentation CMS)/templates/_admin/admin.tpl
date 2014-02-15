<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{$nomSite} - Administration</title>
	<link rel="stylesheet" type="text/css" href="templates/_admin/css/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="templates/_admin/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="templates/_admin/js/common.js" media="print" />
	<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" href="templates/_admin/css/ie6_or_less.css" />
	<![endif]-->
	<script type="text/javascript" src="templates/_admin/js/jquery.js"></script>
	<script type="text/javascript" src="templates/_admin/js/common.js"></script>
	<script type="text/javascript" src="javascript/wymeditor/jquery.wymeditor.pack.js"></script>
	<script type="text/javascript" src="javascript/admin.js"></script>	
    {$header}

</head>

<body id="type-a">
<div id="wrap">

	<div id="header">
		<br /><div id="site-name">Administration {$nomSite}</div><br />
	
	{$menu_admin}
	
	</div>
	
  <div id="content-wrap">
	
		
		<div id="content">
		
			<div id="breadcrumb">
				{$fil_ariane}
			</div>
					
			{$retour}
            
			<h1>{$titre}</h1>

			{$contenu}
			
					
			<div id="footer">
			<p>Administration du site {$nomSite} par <a href="#">Studio-Dev</a></p>
			</div>
			
		</div>
		
  </div>
</div>
</body>
</html>