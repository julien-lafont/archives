<?php
if($_GET['post'] == "ok"){ 

$ip = $REMOTE_ADDR;
$date = date("d m Y");

$pseudo = $_POST['pseudo'];
$message = $_POST['message'];

//$insulte = '';
//$messagee = ereg_replace($insulte, '*****', $message);
  $req = mysql_query("INSERT INTO `ix_box` ( `pseudo` , `message` , `ip` , `date`) VALUES ('$pseudo','$message','$ip','$date')") or die ("erreur sql " . mysql_error());

 rediriger("?page=news");

}

else{ 
$texte='<br>
  <table width="111" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><textarea cols="20" rows="5" readonly>'; 
	  
	  $sql = mysql_mysql_query("SELECT pseudo, message FROM ix_box");
      while($result = mysql_fetch_array($sql) ) {
	  
	  $pseu = $result['pseudo'];
	  $msg = $result['message'];	  
	  
	  $texte.=$pseu." : ".$msg." "; 

	  }
	 
	  $texte.='</textarea>
</td>
    </tr><form name="form1" method="post" action="http://www.ixteam.free.fr/?page=tribune&post=ok">

    <tr>
      <td><input name="pseudo" type="text" id="pseudo" value="Pseudo"></td>
    </tr>
    <tr>
      <td><input name="message" type="text" id="message" value="Message" maxlength="100"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Envoyer"></td>
    </tr></form>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>';


 }
   
   $afficher->AddSession($handle, "contenu");
 $afficher->setVar($handle, "contenu.module_titre", "Shoutbox");
 $afficher->setVar($handle, "contenu.module_texte", $texte );
 $afficher->CloseSession($handle, "contenu");

 
?>