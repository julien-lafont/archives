<?php

// Protège la page : accessible seulement aux Admins
securite_admin();

	//-- Données contact
	$sqlContact=mysql_query("SELECT count(id) as nb FROM ".PREFIX."contact WHERE etat!='d-archive'");
		$c1=mysql_fetch_object($sqlContact);
		$contactTotal=$c1->nb;
	$sqlContact2=mysql_query("SELECT count(id) as nb FROM ".PREFIX."contact WHERE etat='a-nouveau'");
		$c2=mysql_fetch_object($sqlContact2);
		$contactNew=$c2->nb;
	

$contenu='<center>Bienvenu sur l\'espace d\'administration de <b>'.NOM.'</b><br /><br />
	
	<div id="cpanel">

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-membres">
				<img src="images/admin/newUser.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Membres</span>			</a>		</div>

	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-news">
				<img src="images/admin/kontact.png" alt="" align="middle" border="0" height="32" width="32">
				<span>News</span>			</a>		</div>
	</div>

	
	<div style="float: left;">
		<div class="icon">
			<a href="?admin-breves">
				<img src="images/admin/news_subscribe.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Brèves</span>			</a>		</div>
	</div>


	<div style="float: left;">
		<div class="icon">
			<a href="?admin-pages_simples">
				<img src="images/admin/welcome_32.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Articles HTML</span>			</a>		</div>
	</div>
	
	<div style="float: left;">
		<div class="icon">
			<a href="?admin-contact">
				<img src="images/admin/membres_mail.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Contacts</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-team">
				<img src="images/admin/team3.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Team</span>			
			</a>		
		</div>
	</div>
	
	<div style="float: left;">
		<div class="icon">
			<a href="?admin-galerie">
				<img src="images/admin/7363-pittux-PNG.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Gallerie</span>			</a>		</div>
	</div>
	
	<div style="float: left;">
		<div class="icon">
			<a href="?admin-medias">
				<img src="images/admin/camera.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Medias</span>			</a>		</div>
	</div>
	
		<div style="float: left;">
		<div class="icon">
			<a href="?admin-files">
				<img src="images/admin/Cinema_Tools.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Files & Movies</span>			</a>		</div>

	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-forum">
				<img src="images/admin/irc_protocol.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Forum</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-match">
				<img src="images/admin/package_games.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Matchs</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-awards">
				<img src="images/admin/award.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Awards</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-coverage">
				<img src="images/admin/voice-support.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Coverage</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-sponsor">
				<img src="images/admin/sponsor.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Sponsors</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-stats">
				<img src="images/admin/stats4.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Statistiques</span>			</a>		</div>
	</div>

	<div style="float: left;">
		<div class="icon">
			<a href="?admin-config">
				<img src="images/admin/configure.png" alt="" align="middle" border="0" height="32" width="32">
				<span>Configuration</span>			</a>		</div>
	</div>
		
</div>


<div class="clear"></div>';

	$design->zone('contenu', $contenu);
	$design->zone('titre', 'Accueil de l\'administration');
	$design->zone('titrePage', 'Admin');
?>