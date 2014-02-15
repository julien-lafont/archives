<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Fais ton choix .fr - Décide qui sera le vainqueur des duels</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Description" content="Sur Faistonchoix.fr, décide qui sera le vainqueur des duels. Passe un moment fun et participe aux tirages au sort pour gagner de nombreux cadeaux ! Fais ton choix et affirme toi dans les mini-débats" />
	<meta name="Keywords" content="faistonchoix, fais-ton-choix, fais ton choix, faittonchoix, fait ton choix, duel, duels, fight, combat, match, face à face, photo, image, photos, images, cadeau, kdo, theme, tendance, vote, fun, détente, simpa, topouflop, top ou flop, yotsumi, studio-dev, studio dev, web 2.0, flickr, imagup ,vainqueur" />
	<meta name="author" content="Julien LAFONT alias YoTsumi on freelance@studio-dev.fr for www.studio-dev.fr">
	<meta name="robots" content="all">
	<link rel="shortcut icon" href="/favicon.ico" />
	<base href="{::baseUrl::}" />
	
	<link rel="stylesheet" href="theme/style.css" type="text/css" />	
	<!--[if lte IE 6]> <!-- S'il vous plait, pour la santé des développeurs, merci de ne plus utiliser internet explorer ..... -->
	   <link href="theme/ie-only.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link rel="stylesheet" href="include/js/librairies/modalbox/modalbox.css" type="text/css" media="screen" />
	<script>{::activ_jvs::}</script>
	<script type="text/javascript" src="include/js/librairies/prototype.js"></script>
	<script type="text/javascript" src="include/js/librairies/scriptaculous/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="include/js/librairies/modalbox/modalbox.js"></script>
	<script type="text/javascript" src="include/js/general.js"></script>

</head>
<body>
		<!--[if lte IE 6]> 
			{::fleche_gauche::} {::fleche_droite::}
		<![endif]-->	
		
			
	<div id="container">
	
		<div id="top"></div> 
		<!--[if !IE]> <-->
			{::fleche_gauche::} {::fleche_droite::}
		<!--> <![endif]-->
		
		<!--[if IE 7]>
			{::fleche_gauche::} {::fleche_droite::}
		 <![endif]--> 
		<div id="main">
			
			<div id="banner"><a href="{::baseUrl::}" title="Duels de photos : décide qui sera le vainqueur des duels"><img src="theme/images/header.png" alt="Fais Ton Choix .fr - Décide qui sera le vainqueur des duels de photos" /></a></div>
			
			<div id="duel">
				<div id="globalImage1" style="height:277px">{::interImage1::}</div>
				<div id="interImages"><img src="theme/images/fight.png" alt="Lancer le duel sur Faistonchoix.fr"/><div id="statut_vote">{::statut_vote::}</div></div>
				<div id="globalImage2"  style="height:277px">{::interImage2::}</div>
			</div>
			
	
		</div>

		<div id="clear"></div>
		<div id="bottom"><h2>Vote pour l'opposant que tu veux défendre en cliquant sur sa photo.</h2></div>
	
	</div>

	<div id="principe"><a href="principe_du_site.htm" onclick="afficher_principe(); return false" title="Faistonchoix.fr : sa sert à quoi ?" id="lien_principe"></a></div>
	<!--<div id="avenir"><a href="a_venir_sur_faistonchoix.htm" title="Ce qui va bientôt arriver !" id="lien_avenir" ></a></div>-->

<div id="containerLarge" >

	<div id="topL"><img id="wait3" src="images/wait.gif" style="position:relative; left:857px; top:25px; display:none"/></div>
		
		<div id="inTablePrincipal">
			<table id="tablePrincipal" align="center">
				<tr>
					<td style="width:33%">
						
						<h3>Duels par th&egrave;mes </h3>
						<ul id="thumbs">
							{::themes_duels::}
						</ul>
						
						<div class="clear"></div>
						<div id="theme_retour" style="display:none">
							<a href="{::baseUrl::}" title="Retour aux duels avec Fais ton choix"><img src="images/retour_little2.png" alt="retour" /> Retour aux duels généraux</a>
						</div>
	
					</td>
					
					<td style="width:33%; height:294px">
					
							{::derniers_duels::}
						
						<div id="soumettre" style="height:228px; display:none">
							<p style="font-size:13px; color:#FF6600">Utilisez ce formulaire pour soumettre vos idées de duels.</p>
							
						<form name="proposer" action="#">
							<label for="idee1">
								<input type="text" id="idee1" style="margin:5px" class="good" maxlength="255" />
							</label>
							
								<br /><span style="color:#FF3333; font-variant:small-caps">vs</span><br />
								
							<label for="idee2" >
								<input type="text" id="idee2"  style="margin:5px" class="good" maxlength="255" />
							</label>
														
							<br /><br /><span style="font-size:10px">Vous pouvez aussi laissez votre pseudo et l'adresse de votre site (facultatif)</span><br /><br />
							<input type="text" id="soum_pseudo" class="little" value="Votre pseudo" maxlength="255" onclick="if (this.value=='Votre pseudo') this.value=''" /> <input type="text" id="soum_site" class="little" maxlength="255" value="Votre site" onclick="if (this.value=='Votre site') this.value=''"/> 
							
							<br /><br /><a href="#" onclick="form_soumettre(); return false" title="Soumettre ce nouveau duel"><img src="images/ok.png" alt="ok" name="ok" onMouseOver="if (document.images) document.ok.src='images/ok_hover.png';" onMouseOut= "if (document.images) document.ok.src='images/ok.png';"/></a>

						</form>
						
						</div>
						
						<div id="soumettreOk" style="display:none">
							<p style="font-size: 13px; color: rgb(255, 102, 0);">Votre duel a été soumis à notre équipe</p>
							<p>Si celui ci est accepté, vous bénéficirez d'un bonus de point pour le concours.</p>
							
							<br><br><a href="#" onclick="fin_soumission(); return false" title="Retour à la page principale"><img src="images/retour_little.png" style="vertical-align:middle"> &nbsp;Retourner à la liste des duels</a><br />
									<a href="#" onclick="afficher_soumettre(); return false" title="Soumettre un nouveau duel"><img src="images/irc_protocol.png"  style="vertical-align:middle"/> &nbsp;Soumettre un nouveau duel</a><br>
							
						</div>
	
					</td>
					
					<td style="width:33%">
						
						<h3>Espace Kdos</h3>
						<div id="kdos">{::espace_kdos::}</div>
						<div id="classement" style="display:none"></div>
							
						<ul id="liens">
						  <br />
						  <li id="kdo_lien1" style="display:none; color:#0099FF"><b>&rsaquo;</b> <a href="#" title="Mes statistiques" onclick="montrer_stats(); return false">Connexion et Stats</a></li>
						  <li id="kdo_lien2"><b style="color:#0099FF">&rsaquo;</b> <a href="classement_des_membres_les_plus_actifs.htm" title="Voir les membres les plus actifs" onclick="montrer_classement(); return false">Voir le classement</a></li>
						  <li id="kdo_lien3"><b style="color:#0099FF">&rsaquo;</b> <a href="informations_concours.htm" title="Informations sur le grand concours" onclick="afficher_concours(); return false">Informations sur le concours</a></li>
					   </ul>	
					   								
					</td>
				</tr>
			</table>
			
			<table align="center" id="icones">
				<tr>
					<td class="llien"><img src="images/display.png" /> &nbsp;<a href="outils_webmaster.htm" title="Des outils pour vous Webmasters" onclick="afficher_webmaster(); return false">Outils pour webmaster</a></td>
					<td class="llien"><img src="images/irc_protocol.png" /> &nbsp;<a href="#" onclick="afficher_soumettre(); return false" style="under">Soumettre un duel</a></td>
					<td onmouseover="$('TW-Pop').style.display='block';" onmouseout="$('TW-Pop').style.display='none';"><img src="images/rss3.png" /> <a href="#" style="border-bottom:1px solid #00A8FF">Flux Rss</a>
						<div id="TW-feed"><ul id="TW-Pop" style="display:none">
						<li><a href="#" onclick="$('TW-Pop').style.display='none'; return false"><img src="images/agt_stop.png" style="float:right" /></a><b>&nbsp;&nbsp;Flux Rss</b><br /><br /></li>
						<li><a href="{::baseUrl::}rss.xml" title="Subscribe to my feed"><img src="images/rss.png" style="border:0"/></a></li>
						<li><a href="http://www.netvibes.com/subscribe.php?url={::baseUrl::}rss.xml"><img alt="Add to netvibes" src="http://www.netvibes.com/img/add2netvibes.gif" border="0"></a></li>
						<li><a href="http://fusion.google.com/add?feedurl={::baseUrl::}rss.xml"><img src="http://www.google.com/webmasters/add-to-google-plus.gif" alt="Google Reader or Homepage" border="0"></a></li>
						<li><a href="http://add.my.yahoo.com/rss?url={::baseUrl::}rss.xml"><img src="http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif" border="0" alt="Add to My Yahoo!"></a></li>
						<li><a href="http://www.bloglines.com/sub/{::baseUrl::}rss.xml"><img src="http://www.bloglines.com/images/sub_modern9.gif" alt="Subscribe with Bloglines" border="0" /></a></li>
						<li><a href="http://my.msn.com/addtomymsn.armx?id=rss&ut={::baseUrl::}rss.xml&ru={::baseUrl::}"><img src="http://sc.msn.com/44/G,UCH%7BZBSS3%7BOS%7BSE469LG.gif" border="0"></a></li>
						<li><a href="http://feeds.my.aol.com/add.jsp?url={::baseUrl::}rss.xml"><img src="http://myfeeds.aolcdn.com/vis/myaol_cta1.gif" alt="Add to My AOL" border="0"/></a></li></ul></div>
					 </td>
				</tr>
			</table>
		</div>
		
		
		
		<div id="concours"  style="display:none">
		
			<div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
		
			<br /><h2>Le concours Images-Fight</h2><br /><br />
						
			<p>A la fin de chaque mois, un utilisateur figurant parmis les <span>10 membres les plus actifs</span>, sélectionné aléatoirement, gagne un <span>cadeau</span> offert par notre partenaire <a href="#" style="border-bottom:1px solid #00A8FF"></a></p>
				
			<p>Pour que ce cadeau soit au plus proche de vos envies, nous avons décidé que ce serait un <span>chèque cadeau d'un montant de 20€</span>, vendu sous la forme d'une carte 'Kadeos'.<br />
			Celle-ci est utilisable dans plus de 500 magasins comme la FNAC, mais aussi sur internet via le site de La Redoute ou de la Fnac.</p>
			
				<center><a href="http://www.kadeos.fr/html/idee_cadeaux/carte_cadeau_kadeos_chargeable.asp" target="_blank" title="Plus d'informations sur la carte Kadeos"><img src="images/kdo.gif" /></a></center>
			
			<p><b>Comment sont comptabilisés les points ?</b><br />
			   A chaques actions que vous pouvez effectuer sur Fight-Image est attribué un certains nombres de points. C'est en <span>participant régulièrement</span> au site grâce aux votes, en soumettant des duels et en participant aux campagnes spéciales que vous pourrez convoiter le titre de membre actif.<br />
			   Par la suite il est juste nécessaire d'avoir un peu de chance !</p>

			<p><b>Pourquoi les comptes ne sont pas protégés par un mot de passe ?</b><br />
			   La réponse est extrèmement simple ! Imaginons que quelqu'un se connecte à Images-Fight en utilisant votre propre adresse email, alors que vous être actuellement second au classement, que peut-il alors faire ? Voter, soumettre des duels .... <span>seulement des actions qui vous rapporteront des points en plus</span>, absolument rien qui ne pourrait vous être préjudiciable. C'est pour cela que nous avons jugé facultatif de mettre en place une sécurité.</p>

			<p>En ce qui concerne les gagnants, nous avons mis en place une règle pour éviter qu'une même personne ne gagne tous les cadeaux :
				<span>un gagnant ne peut plus participer au tirage au sort pour les 4 prochaines sessions.</span></p>
				
			<div style="float:left"><br /><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour2.png"/></a></div>
		</div>
		
		
		
		<div id="webmaster" style="display:none">
		
			<div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
			<br /><h2>Les outils webmaster</h2><br /><br />
			
			<p>Pour installer notre <span>module de vote</span> sur votre site, copiez simplement ce code HTML à l'endroit désiré sur votre page</p>
			<center><form name="formBlur"><textarea name="web" id="webmaster_textarea"><div id="faistonchoix"></div>
<script src='{::baseUrl::}webmaster/module.js'> </script></textarea>
					</form></center>
				
			<br /><br />
			<p>Si vous souhaitez <span>parler de nous</span> sur votre site, n'hésitez pas à utiliser les visuels suivants :</p>
			
				<div style="margin-left:100px; margin-top:20px; float:left"><img src="webmaster/banniere.jpg" alt="banniere" /></div>    
				<br /><br /><br /><br />&nbsp;&nbsp;<a href="#" onclick="new Effect.BlindDown('banniere_html'); return false">Code HTML</a> - <a href="#" onclick="new Effect.BlindDown('banniere_bbcode'); return false">BBcode</a><br /><br /><br /><br />
					<center id="banniere_html" style="display:none"><b>Code HTML de la bannière</b><br /><textarea><a href="{::baseUrl::}" title="faistonchoix.fr - Duels de photos en ligne" target="_blank"><img src="{::baseUrl::}webmaster/banniere.png" border="0" /> </a></textarea><br /><br /></center>
					<center id="banniere_bbcode" style="display:none"><b>BBcode de la bannière</b><br /><textarea>[url={::baseUrl::}][img]{::baseUrl::}webmaster/banniere.png[/img][/url]</textarea><br /><br /></center>
					
				<div style="margin-left:100px; margin-top:20px;"><img src="webmaster/userbar.png" style=" float:left"/></div>    
				&nbsp;&nbsp;&nbsp;<a href="#" onclick="new Effect.BlindDown('user_html'); return false">Code HTML</a> - <a href="#" onclick="new Effect.BlindDown('user_bbcode'); return false">BBcode</a><br /><br />
					<center id="user_html" style="display:none"><b>Code HTML de la Userbar</b><br /><textarea><a href="{::baseUrl::}" title="faistonchoix.fr - Duels de photos en ligne" target="_blank"><img src="{::baseUrl::}webmaster/userbar.png" border="0" /> </a></textarea><br /><br /></center>
					<center id="user_bbcode" style="display:none"><b>BBcode de la Userbar</b><br /><textarea>[url={::baseUrl::}][img]{::baseUrl::}webmaster/userbar.png[/img][/url]</textarea><br /><br /></center>
			
			<div class="clear"></div><br />
			<div style="float:left"><br /><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour2.png"/></a></div>

		</div>

		<div id="principeC" style="display:none">
		
			<div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
			<br /><h2>A quoi sert le site Faistonchoix.fr ?</h2><br /><br />
			
			La grande question que tout le monde se pose ! <br /><br />
			<p>Les mauvaises langues répondront à rien, mais si, ce site a bien une raison d'exister : vous permettre de <span>passer un moment simpa</span> en votant pour des duels originaux, de <span>débattre de votre choix</span> avec les autres membres ( pour bientôt ), et aussi de participer aux tirages aux sorts mensuels pour <span>gagner de nombreux cadeaux</span> !</p>
			
			<p>Du point de vue pratique, c'est trés simple : vous avez en face de vous deux photos illustrant deux idée opposées, à vous de choisir celle pour laquelle votre coeur balance ( en cliquant dessus ^^ ). Vous pourrez par la suite expliquer la raison de ce vote dans les mini débats.<br />
			Vous avez aussi surement remarqué les <b>duels par thèmes</b>, là le but est d'effectuer un classement des photos dans une catégorie précise.</p>		
				
			<div class="clear"></div><br />
			<div style="float:left"><br /><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour2.png"/></a></div>

		</div>
	
	<div id="clear"></div>
	
	<div id="bottomL"></div>
	
</div>

{::barre_sup::}

<div id="copy">&copy; 2007 <a href="{::baseUrl::}" title="Duels de photos en ligne"><strong>Faistonchoix.fr</strong></a> 'Décide qui sera le vainqueur' | Site développé par <a href="http://www.studio-dev.fr" target="_blank" title="Développement de site webs 2.0 par YoTsumi"><strong>Studio-dev.fr</strong></a> par YoTsumi | <a href="mailto:faistonchoix@studio-dev.fr" title="Contacter le staff de faistonchois.fr"><strong>Nous contacter</strong></a> | <a href="probleme_technique.htm" title="Comment résoudre vos problèmes" rel="nofollow"><strong>Problème technique ?</strong></a> | <a href="sitemap.htm"><b>Plan du site</b></a></div>

<div id="partenaires">
	{::partenaires::}
</div>

{::pub_bas_page::}

<!-- Zone de stockage temporaire et de preload -->
<div style="width:0px; height:0px; overflow:hidden">
	<span id="numDuel">{::numDuel::}</span>
	<span id="themeId">0</span>
	<span id="last_duel">{::lastDuel::}</span>
	<span id="first_duel">{::firstDuel::}</span>
	<img src="images/doublevote.png" />
	<img src="images/loader_blue.gif" />
	<img src="images/star.png" />
	<img src="theme/images/gauche_hover.png" />
	<img src="theme/images/droite_hover.png" />
	<img src="images/ok.png" />
	<img src="images/ok_hover.png" />
</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1473239-1";
urchinTracker();
</script>
</body>
</html>