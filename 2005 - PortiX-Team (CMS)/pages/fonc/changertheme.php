<?php
is_membre();

//$newtheme=addslashes($_GET['theme']);
(isset($_GET['theme'])) ? $newtheme=addslashes($_GET['theme']) : $newtheme=addslashes($_POST['theme']);
$redir_page=$_GET['newpage'];

$_SESSION['sess_theme']=$newtheme;
	$rq = 'UPDATE ix_membres  SET theme="'.$newtheme.'" WHERE pseudo="'.$_SESSION['sess_pseudo'].'" ';
	$sql = mysql_query($rq);

			
rediriger("?page=$redir_page");

?>