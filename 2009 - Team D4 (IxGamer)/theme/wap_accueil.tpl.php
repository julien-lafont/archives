<html>
<head>
	<title>D4 - {::titrePage::}</title>	
	<base href="{::baseUrl::}">
</head>
<body link="#00FF00">

	<h1><font color="#0066FF">Dimension 4 V. wap</font></h1>
		
	> <u><font color="#FF0000">Menu</font></u><br>
	<font color="#FF6600">{::menu_principal::}</font>
	
	<br>> <font color="#FF0000"><u>Brèves</font></u><br>
	{::breves::}
	
	<br>> <font color="#FF0000"><u>News</font></u><br>	
	{::news::}											
										
	<br><br><b>> <font color="#FF0000">LES NEWS</font></b><br>																			
	{--bloc--}
		<b><font color="#0066FF">{:titre:}</font></b><br>
		{:contenu:}<br>
		{:date:}<br><br>
	{--/bloc/--}
										
	{::pagination::}
											
</body>
</html>