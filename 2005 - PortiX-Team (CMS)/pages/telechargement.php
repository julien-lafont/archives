<?php

$page = $_GET['page'];
if($id == ""){

	

	  $sql = mysql_query("SELECT * FROM ix_dl_cat");
      while($result = mysql_fetch_array($sql) ) {
	  
	  $cat = $result['nom'];
	  $descri = $result['description'];
	  $idcat = $result['idcat'];

	$texte.='<li><strong><a href="?page=telechargement&id='.$idcat.'">'.$cat.'</a> :</strong></li><br>'.$descri.'<br><br>';
	
	} // while ligne 9
   } // if ligne 4	
if($id != ""){
				 
	  $sql2 = mysql_query("SELECT * FROM ix_dl_fichier WHERE cat=".$id."");
	  while($result2 = mysql_fetch_array($sql2) ) {
	  $nom = $result2['nom'];
	  $descriptionfichier = $result2['description'];
	  $nbrdl = $result2['nbdl'];
	  $url = $result2['url'];
	  $idfichier = $result2['idfichier'];
	  
	  $texte.='- <strong><a href=?page=telechargement&id='.$id.'&data='.$idfichier.' target=_blank>'.$nom.'</a></strong> <br>'.$descriptionfichier.'<br><br>';
	 } // while ligne 22    
    } // if ligne 19
	
if($data != ""){
	   
	  $idfichier = $_GET['data'];  
	  $sql3 = mysql_query("SELECT url FROM ix_dl_fichier WHERE idfichier=".$idfichier."");
	  $result3 = mysql_fetch_array($sql3)
	  ?>	  
	  <script language="javascript">document.location.href="<? echo($result3['url']); ?>"</script>
      <?
	 } // if ligne 33
	 
	  $afficher->AddSession($handle, "contenu");
	 $afficher->setVar($handle, "contenu.module_titre", "Telechargement");
	 $afficher->setVar($handle, "contenu.module_texte", $texte );
	 $afficher->CloseSession($handle, "contenu");
?>