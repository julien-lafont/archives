<?php
include("include/config.php");
include("include/vtemplate.class.php");
$db = mysql_connect($sqlhost, $sqluser, $sqlpass) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
mysql_select_db($sqlbase, $db) or die ("<center><b>Erreur de connexion base</b></center>");

infos_generales();
stats();

	// Listes des smileys :
	$smy1 = array("8-:" , "^:" , ":cool:" , ":pet:" , ":evil:" , ":D" , ":bad:" , ":good:" , ":lang:" , ":rah:" , ":??:" , ":)" , ":scotch:" , ":intello:" , ":whaou:" , ":!:" , ":zzz:" , ":bye:" , ":yeux:" , ":rrah:" , ":coool:" , ":hein:" , ":locked:" , ":censored:" , ":spam:");
	$smy2 = array("blink.gif" , "CADQ0UD5.png" , "cool.gif" , "cool40.gif" , "evil.gif" , "06.gif" , "128.gif" , "ok.gif" , "130.gif" , "32.gif" , "91.gif" , "original.gif" , "shutup.gif" , "smartass.gif" , "w00t.gif" , "sign56.gif" , "61.gif" , "sign05.gif" , "unsure.gif" , "basic_15.png" , "basic_13.png" , "basic_2.png" , "sign52.gif" , "sign53.gif" , "sign54.gif");

function infos_generales()
{
    $sql_gen = mysql_query("SELECT * FROM ix_config");
    global $ixteam;
    while ($num = mysql_fetch_object($sql_gen)) {
        $ixteam[$num->nom] = stripslashes("$num->valeur");
    } 

    if (!empty($_SESSION['sess_theme'])) $ixteam['theme'] = $_SESSION['sess_theme'];
} 

function rediriger($url)
{
	header ("location: $url");
	exit;
} 

function message_redir($msg,$url)
{
    echo'<script language="javascript" type="text/javascript">
		<!-- 
		alert("' . $msg . '"); 
		-->
		</script>';
		
	echo "<html><body bgcolor=\"#F7F7F7\" alink=\"#0066FF\" vlink=\"#0066FF\"><br><br><br><br><br><br><br><br><center><div style=\"font-face:Verdana; font-size:14px; color=#222222; border:1px solid #000000; width:80%; background-color:#FFFFFF\"><br>Redirection en cours à l'adresse : <a href=\"" . $ixteam['url'] . $url . "\">" . $ixteam['url'] . $url . "</a><br><br><br>La redirection ne s'effectuent pas automatiquement si le <font color=\"#FF0000\">javascript</font> n'est pas activé dans les options de votre navigateur.<br>Il est fortement conseillé de l'activer. [ <a href=\"http://www.ixteam.free.fr/javascript.htm\">AIDE ICI</a> ]<br><br></div></center></body></html>";
	echo'<script language="javascript" type="text/javascript">
	<!--
	window.location.replace("' . $url . '");
	-->
	</script>';
	exit;

} 

function is_admin()
{
    if ($_SESSION['sess_niveau'] != 2) {
        rediriger("?page=fonc/erreur&num=1");
    } 

    $sql = mysql_query("SELECT last_ip FROM ix_membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != $_SERVER['REMOTE_ADDR']) {
        rediriger("?page=fonc/erreur&num=2");
    } 
} 

function is_modo()
{
    if ($_SESSION['sess_niveau'] != 1 AND $_SESSION['sess_niveau'] != 2 ) {
        rediriger("?page=fonc/erreur&num=1");
    } 

    $sql = mysql_query("SELECT last_ip FROM ix_membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != $_SERVER['REMOTE_ADDR']) {
        rediriger("?page=fonc/erreur&num=2");
    } 
} 


function is_membre()
{
    if (!isset($_SESSION['sess_id'])) {
        rediriger("?page=fonc/erreur&num=1");
    } 

    $sql = mysql_query("SELECT last_ip FROM ix_membres WHERE pseudo='" . $_SESSION['sess_pseudo'] . "'");
    $result = mysql_fetch_object($sql);
    if ($result->last_ip != $_SERVER['REMOTE_ADDR']) {
        rediriger("?page=fonc/erreur&num=2");
    } 
} 

function inverser_date($madate, $style = 1)
{
    if ($style == 1) { // Mysql  =>  Normal(.)
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j.$m.$a";
    } 
    if ($style == 2) { // Normal(-)  =>  Mysql
        list($j, $m, $a) = explode("-", $madate);
        $newdate = "$a-$m-$j";
    } 
    if ($style == 3) { // Mysql  =>  Normal(-)
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j-$m-$a";
    } 
    return $newdate;
} 

function GenPass($nbcaract = 8)
{
    $string = "abcdefghijklmnopqrstuvwxyz0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$pass .= $string[mt_rand() % strlen($string)];
    } 
    return $pass;
} 

function bbcode($text)
{	
	global $smy1; global $smy2; 
    $text = preg_replace("#\[img\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", "'<img src=\\1' . str_replace(' ', '%20', '\\3') . '>'", $text);
    $text = preg_replace("#\[url\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/url\]#sie", "'<a href=\"\\1' . str_replace(' ', '%20', '\\3') . '\" target=blank>\\1\\3</a>'", $text);
    $text = preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/", "<a href=$1 target=blank>$2</a>", $text);

    $text = preg_replace("/\[b\](.+?)\[\/b\]/", "<b>$1</b>", $text);
    $text = preg_replace("/\[i\](.+?)\[\/i\]/", "<i>$1</i>", $text);
    $text = preg_replace("/\[u\](.+?)\[\/u\]/", "<u>$1</u>", $text);

    $text = preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/", "<font color=\"$1\">$2</font>", $text);
	
	$text = preg_replace("/\[\/\-(.+?)\]/", "</div>", $text);
    $text = preg_replace("/\[\-(.+?)\]/", "<div align=\"$1\">", $text);
	
	for ($i=0;$i<=count($smy1);$i++) {
		$text = str_replace($smy1[$i],'<img src="images/smileys/'.$smy2[$i].'" style="border:0"/>',$text); 
	}
		
    return $text;
} 


function nav() {

	if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE") != false) 
		$nav="ie";  
	else
		$nav="moz";  
	return $nav;
}

function stats() {

	$date = date("Y-m-d H:i:s");

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }

	$navigateur = $_SERVER['HTTP_USER_AGENT'];

	if (isset($_SERVER['HTTP_REFERER'])) {
		if (eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) { $referer ='';}
		else { $referer = $_SERVER['HTTP_REFERER'];} }
	else {  $referer ='';}

	if ($_SERVER['QUERY_STRING'] == "") {$page = $_SERVER['PHP_SELF'];}
	else { $page = $_SERVER['QUERY_STRING'];}

	$idmbre = $_SESSION['sess_id'];
	
	$sql = mysql_query("INSERT INTO ix_stats (`page`,`id_mbre`,`date`,`nav`,`referer`,`ip`) VALUES ('$page','$idmbre','$date','$navigateur','$referer','$ip')");
}

?>
