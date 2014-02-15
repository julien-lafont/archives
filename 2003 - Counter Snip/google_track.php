<?
// FICHIER google_track.php
$tmp_list = explode(".", $REMOTE_ADDR);
if (($tmp_list[0] == "64" && $tmp_list[1] == "68" && $tmp_list[2] == "82") || ($tmp_list[0] == "216" && $tmp_list[1] == "239" && $tmp_list[2] == "46"))
{
$url_google = $_SERVER["SCRIPT_NAME"];
if ($_SERVER["QUERY_STRING"] != "")
$url_google .= "?".$_SERVER["QUERY_STRING"];
$f = fopen("google.txt","a");
fputs($f, "[ ".date("j-m-Y H:i")." | $REMOTE_ADDR ] : [ http://$HTTP_HOST"."$url_google ]
");
fclose($f);
}
?>