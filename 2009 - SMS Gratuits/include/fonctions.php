<?php
include 'config.php';

function rediriger($url)
{
	header ("location: $url");
	exit;
} 

function connexion($login,$pass) {

	
	$ip = ip();
	$sql = mysql_query("SELECT id, pseudo, pass, level, ban FROM membres WHERE pseudo='$login' AND ban!=1") or die(mysql_error());
	$result = mysql_fetch_object($sql);
	
			if ( $result->pass==$pass AND $result->id!=0 ) 
			{
						$_SESSION['sess_id']= $result->id;
						$_SESSION['sess_pseudo'] = $login;
						//$_SESSION['sess_email']= $result->email;
						//$_SESSION['sess_nb']= $result->total;
						$_SESSION['sess_level']= $result->level;
						$_SESSION['sess_ban']= $result->ban;
						if($result->level==5) $_SESSION['sess_admin']=1;
						$sql_maj = mysql_query('UPDATE membres SET ip="'.$ip.'" WHERE pseudo="'.$login.'" ');
						return "ok";									
			} else {	
						return "bad";										
			}
}

function is_log() {
	if (isset($_SESSION['sess_id'])) return 1;
	else return 0;
}

function security() {
	if ($_SESSION['sess_id']==NULL)
		exit("Accés interdit !");
	
}

function deconnexion() { 

	session_unset();
	session_destroy();
	
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
	} // 2006-04-17 15:05:26 //
    if ($style == 4) { // Mysql aaaa-mm-jj hh:mm:ss  =>  Normal(-)
		$madate=substr($madate,0,10);
        list($a, $m, $j) = explode("-", $madate);
        $newdate = "$j-$m-$a";
	} 
	
    return $newdate;
} 



function GenKey($nbcaract = 8)
{
    $string = "0123456789";
    for($i = 0;$i < $nbcaract;$i++) {
        @$str .= $string[mt_rand() % strlen($string)];
    } 
    return $str;
} 


function recode($txt){ // Pour URL Rewriting
	 $new = ereg_replace("['?!:./, ]", "_", $txt);
	 $new= strtr($new,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
	return $new;
}

function ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
	else {$ip = $_SERVER['REMOTE_ADDR']; }
	return $ip;
}

function tm4b($request) {
if(!extension_loaded('curl')) $response = "Function requires CURL.";
else {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.tm4b.com/client/api/http.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
}

return $response;
} 
?>