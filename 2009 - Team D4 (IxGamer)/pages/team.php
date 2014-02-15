<?php

$design->zone('titrePage', 'Composition de la team');
$design->zone('titre', 'Les équipes Dimension4');
$design->zone('header', '<script type="text/javascript" src="include/js/moofx.js" ></script>
	<script type="text/javascript">
		function init() {
			var myDivs = document.getElementsByClassName(\'listePlayer\');
			var myLinks = document.getElementsByClassName(\'lienTeam\');
			var myAccordion = new fx.Accordion(myLinks, myDivs, {opacity: true});
		}
	</script>');

$contenu='<div id="team">';

$sqlCat=mysql_query("SELECT * FROM ".PREFIX."team_cat");
while ($cat=mysql_fetch_object($sqlCat)) 
{
	$contenu.='
	  <div class="cadreLien"><a class="lienTeam" onclick="setTimeout(\'scrollSimple();\',1000); return false">&raquo; '.recupBdd($cat->nom).'</a></div>
	  <div class="listePlayer">';
	  
	$sqlTeam=mysql_query("SELECT * FROM ".PREFIX."team WHERE id_team=".$cat->id);
	$nb=mysql_affected_rows();
	
	while ($player=mysql_fetch_object($sqlTeam))
	{
		$sqlPseudo=mysql_query("SELECT pseudo FROM ".PREFIX."membres WHERE id=".$player->id_membre);
		$ps=mysql_fetch_object($sqlPseudo);
		$pseudo=$ps->pseudo;
		
		if (is_log()) {
			$actions='<span class="PlayerActions">[<a href="Profil/'.$pseudo.'/">Profil</a>] &nbsp;
					 [<a href="Guestbook/'.$pseudo.'/">GuestBook</a>] &nbsp;
					 [<a href="Galerie-photo/'.$pseudo.'/">Galerie Photo</a>]';
		} else {
			$actions='<span class="PlayerActions">[<a href="Profil/'.$pseudo.'/">Profil</a>] &nbsp;
					 [<a href="#" onclick="showMessageNoLog(); return false">GuestBook</a>] &nbsp;
					 [<a href="#" onclick="showMessageNoLog(); return false">Galerie Photo</a>]';
		}
		
		if (empty($player->photo)) 	$photo="no_photo.jpg";
		else						$photo=$player->photo;
		
		$contenu.='<table class="onePlayer">
					<td >
						<b>'.recupBdd($player->pseudoAff).'</b><br /><br />
						'.nl2br(recupBdd($player->description)).'<br /><br />
						 '.$actions.'
						
					</td>
					<td style="padding-left:20px; text-align:center; width:120px; vertical-align:top">
						<a href="profil/'.$pseudo.'/"><img src="images/players/'.$photo.'" alt="'.recupBdd($player->pseudoAff).'" class="imgAvatar"></a><br />
						Age : '.recupBdd($player->age).' ans<br />
						Ville : '.recupBdd($player->ville).'<br /><br />
						
					</td>
				   </table>';
	} 
	if ($nb==0) {
		$contenu.='<br /><br />Cette section n\'a pas encore été renseignée<br /><br /><br />';
	}
	
	$contenu.='
	  </div>';
}

$contenu.='</div>
		   <script>init();</script>';

$design->zone('contenu', $contenu);

?>