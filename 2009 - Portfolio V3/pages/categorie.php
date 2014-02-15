<?php

	$id_cat=@$_GET['id'];
	
	if (empty($id_cat)) {
		$design->template('simple');
		$design->zone('titre', '<a href="'.URL.'">Aucune cat&eacute;gorie ne correspond</a>');
		$design->zone('contenu', miseEnForme('erreur', 'La cat&eacute;gorie &agrave; laquelle vous essayez d\'acc&eacute;der est introuvable.'));
		$design->afficher(); exit();
	}
	
	// Sélection des infos sur la catégorie :
	$sql=mysql_query("SELECT nom, description FROM ".PREFIX."news_cat WHERE id=".$id_cat) or die(mysql_error());
	$d=mysql_fetch_array($sql); extract(recupBdd($d));
	
	// Sélection des news de la catégorie :
	$sql2=mysql_query("SELECT * FROM ".PREFIX."news WHERE idcat=".$id_cat." ORDER BY id DESC");
	$nb=mysql_num_rows($sql2);
	
	if ($nb==0) 
		$c=miseEnForme('message', "Cette cat&eacute;gorie d'actualit&eacute; ne contient aucune news !");
		
	else {
	
		$c='<br /><br /><div id="plan">
				<ul>';
				
			while ($n=mysql_fetch_array($sql2)) {
				extract(recupBdd($n));
				$c.='<li style="float:left">
						<a href="actualite-'.$id.'-'.$url.'.htm" title="Afficher l\'actualité : '.$titre.'"><strong style="font-variant:small-caps; font-size:12px">'.$titre.'</strong></a>
						<div style="margin-left:20px">
							<p>'.$apercu.'</p>
						</div>
					  </li>';
			}				  
		
		$c.='	</ul>
				<div style="clear:both"></div>
			</div>';
			
	}
	
	$design->template('simple');
	$design->zone('titrePage','News dans la cat&eacute;gorie '.$nom);
	$design->zone('titre','<a href="categorie-'.$id_cat.'-'.recode($nom).'.htm" title="Categorie '.$nom.' > '.$description.'">Actualit&eacute; de la cat&eacute;gorie <u>'.$nom.'</u></a>');
	$design->zone('contenu', $c);

?>