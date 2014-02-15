<?php

// Préparation des miniatures latérales :
	$liste='<ul style="display:none">';
	$sql=mysql_query("SELECT * FROM ".PREFIX."creations ORDER BY annee DESC, id DESC");
	while ($d=mysql_fetch_object($sql)) {
		$liste.="<li><a href='".URL."portfolio-".$d->id."-".$d->lien_perm.".htm' title='Réalisation de Julien LAFONT pour Studio-Dev : ".recupBdd($d->nom)."'><strong>".recupBdd($d->nom)."</strong></a></li>
		";
	}
	$liste.='</ul>';



switch(@$_GET['act']) {

default:
case "detail":

	$id=intval($_GET['id']);
	if ($id==0) {
		$sqlId=mysql_query("SELECT max(id) as idmax FROM ".PREFIX."creations");
		$sqId=mysql_fetch_object($sqlId);
		$id=$sqId->idmax;
	}	
	
	$sql=mysql_query("SELECT * FROM ".PREFIX."creations WHERE id=$id");
	$crea=mysql_fetch_object($sql);

	// On met les éléments récupérés en forme
	$lien_perm='<a href="'.URL.'portfolio-'.$crea->id.'-'.$crea->lien_perm.'.htm" title="Portfolio Studio-dev.fr : '.$crea->nom.'">Lien permanant</a>';
	
	$client=recupBdd($crea->client);
	$techno=recupBdd($crea->techno);
	$url=recupBdd($crea->url);
	$pres=recupBdd($crea->presentation);
	$flash=recupBdd($crea->flash);
	
	// Script aperçu animé
	if (!empty($flash)) {
		$header="<script type='text/javascript'>
					$(document).ready( function(){
					    $('ul#animated-portfolio').animatedinnerfade({
						speed: 1000,
						timeout: 5000,
						type: 'sequence',
						containerheight: '250px',
						containerwidth: '400px',
						animationSpeed: 7000,
						animationtype: 'fade',
						bgFrame: 'none',
						controlBox: 'none',
						displayTitle: 'none'
						});
					} ); 
					</script>";
	}

	// Zone description Méta-tag
		if ($_GET['act']=="detail") {
			$desc = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", strip_tags($pres));
			$desc = str_replace('"', '', $desc);
			$design->zone('meta_description', tronquerChaine($desc, 200));
		} else {
			$design->zone('meta_description', "Retrouvez sur mon portfolio la présentation de mes dernières réalisations : Blog 2.0, Chansons-Paroles, Fais ton choix ...");	
		}
			
	$images='<table style="width:80%">
			<tr>
				 <td style="width:50%; text-align:center"><img src="images/creations/'.$crea->img1.'" alt="Création : '.$crea->nom.' par Yotsumi" /></td>
				 <td style="text-align:center"><img src="images/creations/'.$crea->img2.'" alt="Création : '.$crea->nom.' par Yotsumi" /></td>
			</tr>';
			
	if (!empty($crea->img3)) 		
	$images.='<tr>
				<td style="text-align:center"><img src="images/creations/'.$crea->img3.'" alt="Création : '.$crea->nom.' par Yotsumi" /></td>
				<td style="text-align:center"><img src="images/creations/'.$crea->img4.'" alt="Création : '.$crea->nom.' par Yotsumi" /></td>
			</tr>';
			
	$images.='</table>';

	$detail='
			<div style="float:right;">'.$lien_perm.'</div>';
				
				if (!empty($pres)) $detail.='<p><strong>Présentation du site</strong><br />'.$pres.'</p>';
				if (!empty($flash)) $detail.='<p><strong>Présentation animée</strong><br />'.$flash.'</p>';
				if (!empty($images)) $detail.='<p><strong>Apercu</strong><br />'.$images.'</p>';
									

	$detail.='<div style="border-top:1px solid #ccc; margin-top:15px;">
					<p><b>Url du site</b><br />
						'.$url.'</p>
						
					<p><b>Client</b><br />
						'.$client.'
					</p>
						
					<p><b>Service et technologie</b><br />
						 '.$techno.'</p>					

				</div>';
					

	// Puis on affiche le tout
	$c='<table id="img_no_border">
				<tr>
					<td id="liste_creations" style="text-align:center">
						<br />
						<SCRIPT language="Javascript">show_flash(320, 450, "images/scroll.swf");</script>
						'.$liste.'
					</td>
					<td style="vertical-align:top; ">						
						<div style="margin-left:10%; margin-bottom:7px; font-size:15px; color:#333; font-weight:bold">
							Réalisation : <span id="nomRea">'.recupBdd($crea->nom).'</span>
						</div>
						<div id="aff_detail" style="margin-left:10%;border-top:1px solid #ccc;">
								'.$detail.'
						</div>
						
					</td>
				</tr>
			</table>';
					
	$design->zone('titre', '<a href="portfolio.htm" title="Afficher les dernières créations de Julien LAFONT">Portfolio de Julien LAFONT</a>');
	
	if ($_GET['act']=="detail") $design->zone('titrePage', 'Apercu de mes derniers développements : '.recupBdd($crea->nom));
	else					    $design->zone('titrePage', 'Portfolio : Présentation de mes dernières réalisations web 2.0.');

break;
}


	$design->zone('header', $header);
	$design->template('simple');
	$design->zone('contenu', $c);


?>