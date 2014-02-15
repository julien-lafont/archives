<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../../include/fonctions.php';
	
	
$id=(int)$_POST['id'];
$zone=addslashes($_POST['zone']);

// On liste les articles de la catégorie

$sql=mysql_query("SELECT * FROM ".PREFIX."produits WHERE id_cat=$id");

	$r="<ul>";
	
	if (mysql_num_rows($sql)==0) $r.='<li class="error">Aucun article dans cette catégorie</li>';
	
	while($d=mysql_fetch_object($sql)) {
		$r.='<li><a href="?admin-produits-pageAccueil&action=ajouter&zone='.$zone.'&id='.$d->id_produit.'">
					<img src="images/boutons/add.png">
				 </a>
				  '.recupBdd($d->nom).'</li>';		
		
	}
	
	$r.='</ul>';
	
echo2($r);

?>