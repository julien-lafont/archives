<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';


switch(@$_GET['act'])
{
case "detail":

	$nom=str_replace("creation_","", addBdd($_GET['nom']));	
	
		$sql=mysql_query("SELECT * FROM ".PREFIX."creations WHERE `nom_court`='".$nom."'") or die(mysql_error());
		$crea=mysql_fetch_object($sql);
		
	// On met les éléments récupérés en forme
	$lien_perm='<a href="'.URL.'portfolio-'.$crea->id.'-'.$crea->lien_perm.'.htm" title="Portfolio Studio-dev.fr : '.$crea->nom.'">Lien permanant</a>';
	
	$client=recupBdd($crea->client);
	$techno=recupBdd($crea->techno);
	$url=recupBdd($crea->url);
	$pres=recupBdd($crea->presentation);
	$flash=recupBdd($crea->flash);

			
	$images='<table style="width:100%">
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

	$detail='<div style="float:right;">'.$lien_perm.'</div>';
				
				if (!empty($pres)) $detail.='<p><strong>Présentation du site</strong><br />'.$pres.'</p>';
				if (!empty($flash)) $detail.='<p><strong>Présentation animée</strong><br />'.$flash.'</p>';
				if (!empty($images)) $detail.='<p><strong>Apercu</strong><br />'.$images.'</p>';
									

	$detail.='<div style="border-top:1px solid #ccc; margin-top:15px">
					<p><b>Url du site</b><br />
						'.$url.'</p>
						
					<p><b>Client</b><br />
						'.$client.'
					</p>
						
					<p><b>Service et technologie</b><br />
						 '.$techno.'</p>					

				</div>';
					
	
	
	echo2($detail);
	
	// On affiche la requête Json
	/*echo2 ('var infosCrea = { 
			  "id": \''.$crea->id.'\',
			  "nom": \''.json($crea->nom).'\', 
			  "lien_perm": \''.json($lien_perm).'\', 
			  "client": \''.json($client).'\', 
			  "techno": \''.json($techno).'\',
			  "pres": \''.json($pres).'\',
			  "url": \''.json($url).'\',
			  "images": \''.json($images).'\',
			  "flash": \''.json($flash).'\'
			} ');*/


break;
}

?>