<?php
is_membre();

if ($_POST) { // Si le forumulaire a bien été envoyé
	$message = trim(htmlspecialchars($_POST['message']));
	$id = $_SESSION['sess_id'];
	$date = date("Y-m-d H:m:s");
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$page = htmlspecialchars($_POST['page']);
	
	$sql = mysql_query("INSERT INTO ix_box (`pseudo`,`message`,`ip`,`date`) VALUES ('$id','$message','$id','$date')");
	rediriger("?page=$page");

}
else {
	message_redir("C'est pas bien de vouloir accéder à cette page !","?page=news");
}

?>
