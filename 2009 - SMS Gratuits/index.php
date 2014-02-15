<?
ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src"); /* BUG OVH Xhtml */
ob_start("ob_gzhandler");
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include("include/fonctions.php");
	include("theme/theme.php");
	
// /* For Debug */ if ($_SESSION['sess_pseudo']!="yotsumi" && $_GET['debug']=!1 && array_shift(array_keys($_GET))!="partenaires" && array_shift(array_keys($_GET))!="partenaire") exit("En débuggae ! J'en ait pr 10-20mn !");

if (isset($_GET['login']) AND isset($_GET['pass'])) 
{
	$pseudo=strtolower(htmlspecialchars($_GET['login']));
	$pass=strtolower(htmlspecialchars($_GET['pass']));
	if (connexion($pseudo,$pass))
	{
		header('location: ?home');
	}
}

if (array_shift(array_keys($_GET))) $page = array_shift(array_keys($_GET));
else if (is_log()) $page="home";
else $page = "accueil";

if (file_exists('pages/' . $page . '.php')) {
    include 'pages/' . $page . '.php';
} else {
	$design['contenu']='<br>Impossible d\'afficher la page <u>'.$page.'</u>.<br><br><br><a href="index.php">Retourner à l\'accueil</a><br><br><br>';
} 

design();
ob_end_flush();

?>