<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Dimension4 - {::titrePage::} - D4Team.com</title>	
	<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="L'équipe dimension4, représentant le cyber-café D4 de Montpellier, acteur de l'esport principalement sur le jeu Counter Strike, et s'élevant dans le meilleur niveau du sud de la France." />
	<meta name="keywords" content="d4, dimension4, sud, team du sud, team, cs, counter-strike, esport, electronic sports" />
	<meta name="robots" content="noindex, nofollow"> 
	<base href="{::baseUrl::}" >
	
	<link rel="stylesheet" href="theme/styles.css" type="text/css" />	
	<script type="text/javascript" src="include/js/prototype.js"></script>
	<script type="text/javascript" src="include/js/-general.js"></script>
	{::header::}{::jvs-admin::}

	<script type="text/javascript" src="include/js/scriptaculous.js?load=effects,controls,niftycube"></script>
	
</head>
<body>
	<script type="text/javascript">
		window.onload=function(){
			Nifty("div.titreBleu", "smooth fixed-height");
			Nifty("div.titreOrange", "smooth fixed-height");
			Nifty("div.titreGris", "smooth fixed-height");
			new Effect.ScrollTo('simple',{duration:1});
		}	
	</script>
	
	<div id="page">
	
		<div id="cadre_membre">
			<h1><strong>L'équipe dimension4, représentant le cyber-café D4 de Montpellier, acteur de l'esport principalement sur le jeu Counter Strike, et s'élevant dans le meilleur niveau du sud de la France.</strong></h1>
			{::Menu_Log::}
		</div>
				
		<table id="general_table" cellpadding="0" cellspacing="0">
			<tr>
				<td id="bordureG" rowspan="5"><div id="bordureGtop"></div></td>
				<td id="header"><h2><strong>www.D4Team.com :</strong></h2>
								<a href="http://www.d4team.com" title="Dimension 4 : Top Team Francaise Counter-Strike - Cyber café Montpellier"><img src="theme/images/px.gif" width="165" height="107" alt="Header du site Dimension4 : Top 10 des Team CS française" /></a>
				</td>
				<td id="bordureD" rowspan="5"><div id="bordureDtop"></div></td>
			</tr>
			<tr>
				<td id="menu_top"><img src="theme/images/menu_haut.jpg" alt="Menu Horizontal de Dimension 4" width="834" height="26" usemap="#menu_haut" id="menu_haut" /></td>
			</tr>
			<tr>
				<td id="espace"></td>
			</tr>

<!--			<tr>
				<td id="bloc_pub">
				
					<table id="pub_table" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="3" id="pub_top"></td>
						</tr>
						<tr>
							<td id="pub_left"></td>
							<td id="pub_contenu"><a href="#"><img src="theme/images/fake_pub.jpg" alt="" /></a></td>
							<td id="pub_right"></td>
						</tr>
						<tr>
							<td colspan="3" id="pub_bottom"></td>
						</tr>
					</table>
					
				</td>
			</tr>
-->			<tr>
				<td><div id="bloc_left">
				
						<div id="menu">
							<img src="theme/images/menu_header.jpg" width="134" height="25" alt="Navigation du site Dimension4" /><br />
							<ul id="menu_contenu">
								{::menu_principal::}
							</ul>
							<img src="theme/images/menu_bottom.jpg" alt="" /><br  />
						</div>
						
						<div id="event">
							<img src="theme/images/event_header.jpg" width="134" height="34"  alt="Evènements de la Team Dimension4" /><br />
							  <p><a href="http://fr.worldcybergames.com" title="WORLD CYBER GAMES FRANCE"><img src="images/events/wcg2006.jpg" alt="WCG : World Cyber Games 2006" /></a></p> 
							<img src="theme/images/event_bottom.jpg" width="134" height="9"  alt="" /><br />
						</div>
						
						{::partners::}
						
					</div>
					
					<div id="bloc_cadreC">
					
					
						<table id="tableau_deux_blocs" cellpadding="0" cellspacing="0">
							<tr>
								<td class="tdBlocsBreves">

									<table id="bloc_breves" cellpadding="0" cellspacing="0">
										<tr>
											<td colspan="3" class="head"></td>
										</tr>
										<tr>
											<td class="left"></td>
											<td class="txt">
												<ul id="ulBreves">
													{::breves::}
												</ul>					
											</td>
											<td class="right"></td>
										</tr>
									</table>

								</td>
								<td class="tdBlocsClan">

									<table id="bloc_clan" cellpadding="0" cellspacing="0">
										<tr>
											<td colspan="3" class="head"></td>
										</tr>
										<tr>
											<td class="left"></td>
											<td class="txt">
												<ul id="ulClan">
													{::news::}
												</ul>					
											</td>
											<td class="right"></td>
										</tr>
									</table>

								</td>
								<td rowspan="2" class="tdLatteralDroit">
								
									{::head_sponsor::}
									
									{::sponsor::}

									{::team::}
									
									<div id="antibug_right"></div>
								</td>
							</tr>
							
							<tr>
								<td colspan="2" class="tdSimple">
									
									
									<table id="simple" cellpadding="0" cellspacing="0">
										<tr>
											<td colspan="3" class="titrePage"><h3>{::titrePage::}</h3></td>
										</tr>
										<tr>
											<td colspan="3" class="titre"><h4>{::titre::}</h4 ></td>
										</tr>
										<tr>
											<td class="left"></td>
											<td class="txt">
												
												<h5 class="profil">Profil de {::pseudo::}</h5>
												
												<table id="profil" cellpadding="0" cellspacing="0">
													<tr>
														<td class="tdTitre"><div class="titreGris">Général</div></td>
														<td class="tdTitre"><div class="titreBleu">Photo</div></td>
													</tr>
													<tr>
														<td class="tdUl"><ul>{::li_general::}</ul></td>
														<td class="tdImg"><img src="{::avatar::}" class="imgAvatar" /></td>
													</tr>

													<tr>
														<td class="tdTitre"><div class="titreGris">Hardware</div></td>
														<td class="tdTitre"><div class="titreGris">Software</div></td>
													</tr>
													<tr>
														<td class="tdUl"><ul>{::li_hardware::}</ul></td>
														<td class="tdUl"><ul>{::li_software::}</ul></td>
													</tr>
													
													<tr>
														<td colspan="2" class="tdContact">{::contact::}</td>
													</tr>
													
													<tr>
														<td colspan="2" class="tdContact">{::actions::}</td>
													</tr>
													
													<tr>
														<td class="tdTitre"><div class="titreOrange">Mes amis</div></td>
														<td class="tdTitre"><div class="titreOrange">Derniers visiteurs</div></td>
													</tr>
													<tr>
														<td class="tdUl2"><ul>{::li_amis::}</ul></td>
														<td class="tdUl2"><ul>{::li_visiteurs::}</ul>
														</td>
													</tr>

												</table>									
											
											</td>
											<td class="right"></td>
										</tr>
										<tr>
											<td colspan="3" class="foot"></td>
										</tr>
									</table>

									
							  	</td>
							</tr>
						</table>
	
					</div>
					
					<div class="clear"></div>
				</td>
			</tr>
			<tr>
				<td><img src="theme/images/footer.jpg" width="834" height="47" alt="Footer du site Dimension4" /></td>
			</tr>

		</table>

		<div id="ajax_path" class="hide"></div> <div id="ajax_newMess">{::NEW_MESS::}</div>
				
	</div>		

	{::menu_map::}

</body>
</html>