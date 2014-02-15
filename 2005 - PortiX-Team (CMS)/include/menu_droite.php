<?

// ---------------------------------------------------------- //
//           Configuration des menus de DROITE                //
//                                                            // 
// Pour créer un menu, il suffit de mettre le contenu de      //
//  celui ci dans une variable nommée $menudroitetxt[x] et    //
//  $menudroitetitre[x] où X est un même nombre pas encore    //
//  utilisé.												  //
// ---------------------------------------------------------- //
//                                                            // 
// Liste des menus déjà définis :							  //
//  1- AUCUN 												  //
// ---------------------------------------------------------- //

$menu_titre=array();
$menu_txt=array();


	// => Mettez ici les différents menus //
	
$menu_titre[1]="Test du Menu 1";
$menu_txt[1]="- <a href=\"".$ixteam['url']."?page=inscription\">Inscription</a><br>Blablabla<br>Blablabla<br>Blablabla<br>Blablabla<br><br>Blablabla<br>Blablabla<br>Blablabla<br>Blablabla";


for ($i=1;$i<=99;$i++){ 
	if (isset($menu_titre[$i])) {
 	$afficher->AddSession($handle,"menud");
    $afficher->setVar($handle,"menud.titre",$menu_titre[$i]);
    $afficher->setVar($handle,"menud.texte",$menu_txt[$i]);
 	$afficher->CloseSession($handle,"menud");
	}
}

?>