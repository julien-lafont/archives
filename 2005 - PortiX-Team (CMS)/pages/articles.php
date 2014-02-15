<?php
$id=$_GET['id'];

if (!$id) {

	$contenu="<div class=\"titreBS\">Liste des articles :</div>
		<ul class='menu-spe'>";
	
	$sql = mysql_query("SELECT id, sujet FROM ix_articles");
	while ( $data=mysql_fetch_object($sql) ) {
		$contenu.="<li><a href='?page=articles&id=$data->id'>".stripslashes($data->sujet)."</a></li>";
	}
	$contenu.="</ul>";

} else {

	$sql = mysql_query("SELECT * FROM ix_articles WHERE id=$id");
	$data=mysql_fetch_object($sql);
	
		$sql2 = mysql_query("SELECT id, pseudo FROM ix_membres WHERE id=$data->auteur") or die;
		$_aut = mysql_fetch_object($sql2);
	
	$contenu="<div class=\"titreBS\">".stripslashes($data->sujet)."</div><br>".stripslashes($data->texte)."
				<div align='right'>Rédigé par <a href='?page=profil&id=".$_aut->id."'>".ucfirst($_aut->pseudo)."</a> le ".inverser_date($data->date)." - Lu $data->nbvue fois";
	
	$sql3 = mysql_query("UPDATE ix_articles set nbvue=nbvue+1 WHERE id=$id");
}
	$afficher->AddSession($handle, "contenu");
    $afficher->setVar($handle, "contenu.module_titre", "Articles du site");
    $afficher->setVar($handle, "contenu.module_texte", $contenu);
    $afficher->CloseSession($handle, "contenu");
?>

