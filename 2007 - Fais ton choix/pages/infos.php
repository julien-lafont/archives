<?php
/*  ---------------------------------------------------------------------------------------------------------------
	   Accés direct ( sans ajax-> no jvs ) pour les pages d'infos
	     -> Outils webmaster
	     -> Concours
	     -> Problèmes techniques
	     -> Principe du site
	     -> A venir
	     -> Plan du site ( référéncement )
    --------------------------------------------------------------------------------------------------------------- */

// !!!!!!! Certaines de ces pages sont accessibles directement dans le fichier 'accueil.tpl.php' ( copier/coller ) !!!!!! //

switch($_GET['page']) {

 case "webmaster":
 
	$c='<div id="webmaster"><div style="float:right"><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
			<br /><h2>Les outils webmaster proposés par Faistonchoix.fr</h2><br /><br />
			
			<p>Pour installer notre <span>module de vote</span> sur votre site, copiez simplement ce code HTML à l\'endroit désiré sur votre page</p>
			<center><form name="formBlur"><textarea name="web" id="webmaster_textarea"><div id="faistonchoix"></div>
<script src="{::baseUrl::}webmaster/module.js"> </script></textarea>
					</form></center>
					
			<br /><br />
			<p>Si vous souhaitez <span>parler de nous</span> sur votre site, n\'hésitez pas à utiliser les visuels suivants :</p>
			
				<div style="margin-left:100px; margin-top:20px; float:left"><img src="webmaster/banniere.jpg" alt="banniere" /></div>    
				<br /><br /><br /><br />&nbsp;&nbsp;<a href="#" onclick="new Effect.BlindDown(\'banniere_html\'); return false">Code HTML</a> - <a href="#" onclick="new Effect.BlindDown(\'banniere_bbcode\'); return false">BBcode</a><br /><br /><br /><br />
					<center id="banniere_html" style="display:none"><b>Code HTML de la bannière</b><br /><textarea><a href="{::baseUrl::}" title="faistonchoix.fr - Duels de photos en ligne" target="_blank"><img src="{::baseUrl::}webmaster/banniere.png" border="0" /> </a></textarea><br /><br /></center>
					<center id="banniere_bbcode" style="display:none"><b>BBcode de la bannière</b><br /><textarea>[url={::baseUrl::}][img]{::baseUrl::}webmaster/banniere.png[/img][/url]</textarea><br /><br /></center>
					
				<div style="margin-left:100px; margin-top:20px;"><img src="webmaster/userbar.png" style=" float:left"/></div>    
				&nbsp;&nbsp;&nbsp;<a href="#" onclick="new Effect.BlindDown(\'user_html\'); return false">Code HTML</a> - <a href="#" onclick="new Effect.BlindDown(\'user_bbcode\'); return false">BBcode</a><br /><br />
					<center id="user_html" style="display:none"><b>Code HTML de la Userbar</b><br /><textarea><a href="{::baseUrl::}" title="faistonchoix.fr - Duels de photos en ligne" target="_blank"><img src="{::baseUrl::}webmaster/userbar.png" border="0" /> </a></textarea><br /><br /></center>
					<center id="user_bbcode" style="display:none"><b>BBcode de la Userbar</b><br /><textarea>[url={::baseUrl::}][img]{::baseUrl::}webmaster/userbar.png[/img][/url]</textarea><br /><br /></center>
			
			<div class="clear"></div><br />
			<div style="float:left"><br /><a href="\'.URL.\'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div></div>';
		
	$design->template('contenu');
	$design->zone('titrePage', 'Outils Webmaster');
	$design->zone('contenu', $c);
  
break;
##############################################################################################################################
##############################################################################################################################
case "concours":
 
	$c='<div id="concours">
		
			<div style="float:right"><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
		
			<br /><h2>Le concours Images-Fight</h2><br /><br />
						
			<p>A la fin de chaque mois, un utilisateur figurant parmis les <span>10 membres les plus actifs</span>, sélectionné aléatoirement, gagne un <span>cadeau</span> offert par notre partenaire <a href="#" style="border-bottom:1px solid #00A8FF"></a>.</p>
			
			<p>Pour que ce cadeau soit au plus proche de vos envies, nous avons décidé que ce serait un <span>chèque cadeau d\'un montant de 20€</span>, vendu sous la forme d\'une carte \'Kadeos\'.<br />
			Celle-ci est utilisable dans plus de 500 magasins comme la FNAC, mais aussi sur internet via le site de La Redoute ou de la Fnac.</p>
			
				<center><a href="http://www.kadeos.fr/html/idee_cadeaux/carte_cadeau_kadeos_chargeable.asp" target="_blank" title="Plus d\'informations sur la carte Kadeos"><img src="images/kdo.gif" /></a></center>
			
			<p><b>Comment sont comptabilisés les points ?</b><br />
			   A chaques actions que vous pouvez effectuer sur Fight-Image est attribué un certains nombres de points. C\'est en <span>participant régulièrement</span> au site grâce aux votes, en soumettant des duels et en participant aux campagnes spéciales que vous pourrez convoiter le titre de membre actif.<br />
			   Par la suite il est juste nécessaire d\'avoir un peu de chance !</p>

			<p><b>Pourquoi les comptes ne sont pas protégés par un mot de passe ?</b><br />
			   La réponse est extrèmement simple ! Imaginons que quelqu\'un se connecte à Images-Fight en utilisant votre propre adresse email, alors que vous être actuellement second au classement, que peut-il alors faire ? Voter, soumettre des duels .... <span>seulement des actions qui vous rapporteront des points en plus</span>, absolument rien qui ne pourrait vous être préjudiciable. C\'est pour cela que nous avons jugé facultatif de mettre en place une sécurité.</p>

			<p>En ce qui concerne les gagnants, nous avons mis en place une règle pour éviter qu\'une même personne ne gagne tous les cadeaux :
				<span>un gagnant ne peut plus participer au tirage au sort pour les 4 prochaines sessions.</span></p>
				
			<div style="float:left"><br /><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div>
		</div>';
		
	$design->template('contenu');
	$design->zone('titrePage', 'Informations sur le concours');
	$design->zone('contenu', $c);
 
break;
##############################################################################################################################
##############################################################################################################################
case "pbm":
	$c='<div id="concours">
		
			<div style="float:right"><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
		
			<br /><h2>Résoudre mes problèmes :</h2><br /><br />
						
			<p>Pour fonctionner dans les meilleurs conditions et bénéficier de tous les services, <b>le javascript doit être activé</b> sur votre navigateur internet<br />
			Si vous ne savez pas comment activer le javascript, rendez vous sur <a href="http://www.ixteam.free.fr/javascript.htm" rel="nofollow"><span>cette page.</span></a></p>
			
			<p>Si votre configuration n\'est pas assez puissant pour gérer les différents effets de transition, <a href="faistonchoix_version_lite.htm"  rel="nofollow"><span>cliquez ici pour accéder à une version allégée</span></a> du site.</p>
			
			<p>Le site est optimisé pour Firefox et Internet Explorer 7, pour une résolution d\'écran supérieure à 1024*768.<br /><br />Si vous ne possédez pas encore Firefox, nous vous invitons à installer ce navigateur plus rapide, plus léger, et surtout beaucoups plus sécurisé via ce lien : [PUB GOOGLE]</p>
			<div style="float:left"><br /><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div>
		</div>';
		
	$design->template('contenu');
	$design->zone('titrePage', 'Informations sur le concours');
	$design->zone('contenu', $c);


break;
##############################################################################################################################
##############################################################################################################################
case "principe":

			$c='<div id="concours"><div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
			<br /><h2>A quoi sert le site Faistonchoix.fr ?</h2><br /><br />
			
			La grande question que tout le monde se pose ! <br /><br />
			<p>Les mauvaises langues répondront à rien, mais si, ce site a bien une raison d\'exister : vous permettre de <span>passer un moment simpa</span> en votant pour des duels originaux, de <span>débattre de votre choix</span> avec les autres membres ( pour bientôt ), et aussi de participer aux tirages aux sorts mensuels pour <span>gagner de nombreux cadeaux</span> !</p>
			
			<p>Du point de vue pratique, c\'est trés simple : vous avez en face de vous deux photos illustrant deux idée opposées, à vous de choisir celle pour laquelle votre coeur balance ( en cliquant dessus ^^ ). Vous pourrez par la suite expliquer la raison de ce vote dans les mini débats.<br />
			Vous avez aussi surement remarqué les <b>duels par thèmes</b>, là le but est d\'effectuer un classement des photos dans une catégorie précise.</p>	
			
			<div class="clear"></div><br />
			<div style="float:left"><br /><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div></div>';
				
	$design->template('contenu');
	$design->zone('titrePage', 'A quoi sert le site Faistonchoix.fr');
	$design->zone('contenu', $c);


break;
##############################################################################################################################
##############################################################################################################################
case "avenir":

			$c='<div id="concours"><div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
			<br /><h2>Les services à venir</h2><br /><br />
			
			<p>La principale fonction que nous rajouterons à trés court terme est la création de <span>mini-débats</span> autours des duels. Vous pourrez ainsi expliquer les raisons qui vous ont poussé à voter pour tel ou tel photo.<p>
			

			<p>Du point de vue développement, le grand défi sera de rendre le site entièrement compatible aux navigateurs ayant le javascript désactivé. C\'est déjà le cas pour les fonctions principales, mais de nombreuses actions nottament sur la zone membre ne sont pas accessibles.</p>
			
			<p>Si vous avez d\'autres idées n\'hésitez pas à nous en faire part.</p>
			
			<div class="clear"></div><br />
			<div style="float:left"><br /><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div></div>';
				
	$design->template('contenu');
	$design->zone('titrePage', 'Les services à venir');
	$design->zone('contenu', $c);


break;
##############################################################################################################################
##############################################################################################################################
case "sitemap":

	$c='<div id="concours"><div style="float:right"><a href="#" onclick="afficher_principal(); return false" title="Retour à la page principale"><img src="images/retour.png" /></a></div>
	<br /><h2>Sitemap faistonchoix.fr</h2><br /><br />
	
	<table style="margin-left:40px; width:100%; border:0">
		<tr>
			<td width="33%" style="vertical-align:top; line-height:20px">
				<b>Liens principaux : </b><br /><br />
				
				<a href="'.URL.'" title="Fais ton choix : décide qui sera le vainqueur">Accueil du site</a>
				<br /><a href="'.URL.'informations_concours.htm" title="Toutes les infos sur le grand concours FaisTonChoix.fr">Informations sur le concours</a>
				<br /><a href="'.URL.'classement_des_membres_les_plus_actifs.htm" title="Afficher le classement des membres les plus actifs">Classement des membres</a>
				<br /><a href="'.URL.'principe_du_site.htm" title="A quoi sert donc ce site ?">Principe du site</a>
				<br /><a href="'.URL.'a_venir_sur_faistonchoix.htm" title="Ce qui sera bientôt implanté">A venir</a>
				
				<br /><br />
				<a href="'.URL.'probleme_technique.htm" title="Un problème ? La solution se trouve ici !">Problème technique ?</a>
				<br /><a href="'.URL.'faistonchoix_version_lite.htm" title="Version allégée du site">Version light</a>
				<br /><a href="'.URL.'faistonchoix_version_normale.htm" title="Version normale">Version normale</a>
				
				<br /><br />
				<a href="'.URL.'sitemap.htm" title="Plan de Faistonchoix.fr">Sitemap</a>
			</td>
			<td width="33%" style="vertical-align:top; line-height:20px">
			<b>Liste des duels : </b><br /><br />';
			
			$sqlD=mysql_query("SELECT id, nom1,nom2 FROM ".PREFIX."duels ORDER BY id DESC");
			while ($d=mysql_fetch_object($sqlD)) {
				$c.='<a href="'.URL.'duel-'.recode(recupBdd($d->nom1)).'_ou_'.recode(recupBdd($d->nom2)).'-'.$d->id.'.htm" title="Afficher le duel '.recupBdd($d->nom1).' contre '.recupBdd($d->nom2).'">Duel <b>'.recupBdd($d->nom1).'</b> vs <b>'.recupBdd($d->nom2).'</b></a><br />';
			}
			
			$c.='</td>
			<td width="33%" style="vertical-align:top; text-align:center">
			<b>Liste des thèmes : </b><br /><br />';
			
			$sqlT=mysql_query("SELECT id, nom, miniature FROM ".PREFIX."themes ORDER BY id DESC");
			while ($theme=mysql_fetch_object($sqlT)) {
				$c.='<a href="'.URL.'theme-'.recode(recupBdd($theme->nom)).'-'.$theme->id.'.htm" title="Accéder aux duels du thème '.recupBdd($theme->nom).' sur Faistonchoix.fr" ><img src="'.MIN.$theme->miniature.'" style="width:70px; height:70px" id="minTheme'.$theme->id.'" style="border:1px solid #333"/></a><br /><b>'.recupBdd($theme->nom).'</b><br /><br />';
			}
			
			$c.='</td>
		</tr>
	</table>
	
	<div class="clear"></div><br />
	<div style="float:left"><br /><a href="'.URL.'" title="Retour à la page principale"><img src="images/retour2.png"/></a></div></div>';

	$design->template('contenu');
	$design->zone('titrePage', 'Les services à venir');
	$design->zone('contenu', $c);



break;
##############################################################################################################################
##############################################################################################################################
default:
	exit("Accés interdit");
break;
}

?>