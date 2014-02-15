<?php
/**
 * Module Team
 * Affiche les membres de la team par catégorie
 *
 * Url : /team/
 */

$design->zone('titrePage', 'Composition de la team '.NOM);
$design->zone('titre', 'Composition des teams '.NOM);
$design->zone('header', '
	<script type="text/javascript">
		$(document).ready(function(){

			jQuery("#team").Accordion({
				showSpeed: "fast",
				hideSpeed: "fast",
				currentPanel: "false"
			}).change(function(event, newHeader, oldHeader, newContent, oldContent) {
				simpleLog(oldHeader.text() + " hidden");
				simpleLog(newHeader.text() + " shown");
			});
			
			jQuery.Accordion.setDefaults({
				showSpeed: 1000,
				hideSpeed: 150
			});	
		});
	</script>');

$contenu='<div id="team">';

// Sélection des différentes catégories de TEAM
$sqlCat=mysql_query("SELECT * FROM ".PREFIX."team_cat");
while ($cat=mysql_fetch_object($sqlCat)) 
{
	$contenu.='
	  <dl class="cadreLien"><h2>&raquo; '.recupBdd($cat->nom).'</h2></dl>
	  <dt class="listePlayer">';
	 
	// Sélection des membres dans la catégorie de team 
	$sqlTeam=mysql_query("SELECT * FROM ".PREFIX."team WHERE id_team=".$cat->id);
	$nb=mysql_affected_rows();
	
	while ($player=mysql_fetch_object($sqlTeam))
	{
		// Plus d'infos sur chaques joueurs
		$sqlPseudo=mysql_query("SELECT pseudo FROM ".PREFIX."membres WHERE id=".$player->id_membre);
		$ps=mysql_fetch_object($sqlPseudo);
		$pseudo=$ps->pseudo;
		
		// [NOWAY]
		// Affichage différent si la personne est connectée ou non
		/*if (is_log()) {
			$actions='<span class="PlayerActions" style="float:right; margin-top:-15px">
				<img src="theme/images/titre_left.png" />
					<a href="Profil/'.$pseudo.'/"><img src="theme/images/titre_profil.png" /></a>
				<img src="theme/images/separator.png" />
					<a href="Guestbook/'.$pseudo.'/"><img src="theme/images/titre_galery.png" /></a>
				<img src="theme/images/separator.png" />
					<a href="Galerie-photo/'.$pseudo.'/"><img src="theme/images/titre_guestbook.png" /></a>
				<img src="theme/images/titre_right.png" />
					</span>';
		} else {
			$actions='<span class="PlayerActions" style="float:right; margin-top:-15px">
				<img src="theme/images/titre_left.png" />
					<a href="Profil/'.$pseudo.'/"><img src="theme/images/titre_profil.png" /></a>
				<img src="theme/images/separator.png" />
					<a href="#" onclick="showMessageNoLog(); return false"><img src="theme/images/titre_galery.png" /></a>
				<img src="theme/images/separator.png" />
					<a href="#" onclick="showMessageNoLog(); return false"><img src="theme/images/titre_guestbook.png" /></a>
				<img src="theme/images/titre_right.png" />
					</span>';
		}
			// Supprime espaces
			$actions = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $actions); */
		
		if (is_log()) 
			$actions='<h3><a href="Profil/'.$pseudo.'/">Profil</a> - <a href="Guestbook/'.$pseudo.'/">Guestbook</a> - <a href="Galerie-photo/'.$pseudo.'/">Galerie</a></h3>';
		else
			$actions='<h3><a href="Profil/'.$pseudo.'/">Profil</a> - <a href="#" onclick="showMessageNoLog(); return false">Guestbook</a> - <a href="#" onclick="showMessageNoLog(); return false">Galerie</a></h3>';
		
		if (empty($player->photo)) 	$photo="no_photo.jpg";
		else						$photo=$player->photo;
		
		$contenu.='<table class="onePlayer">
					<tr>
						<td >
							<b>'.recupBdd($player->pseudoAff).'</b><br /><br />
							'.nl2br(recupBdd($player->description)).'<br /><br />
							
							
						</td>
						<td style="padding-left:20px; text-align:center; width:120px; vertical-align:top">
							<a href="profil/'.$pseudo.'/"><img src="images/players/'.$photo.'" alt="'.recupBdd($player->pseudoAff).'" class="imgAvatar"></a><br />
							Age : '.recupBdd($player->age).' ans<br />
							Ville : '.recupBdd($player->ville).'<br /><br /> 
							
						</td>
					  </tr>
					  <tr>
					  	<td colspan="2">
							'.$actions.'
						</td>
					  </tr>
				   </table>';
	} 
	if ($nb==0) {
		$contenu.='<br /><br />Cette section n\'a pas encore été renseignée<br /><br /><br />';
	}
	
	$contenu.='
	  </dt>';
}

$contenu.='</div>';

$design->zone('contenu', $contenu);

?>