<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
	<title>Dump de base de donn&eacute;e v1.1</title>
</head>
<body>

<?php
//set_time_limit (120);
// --------------------------------------------------------connexion  online
include '../config.inc.php';
$serveur = HOTE; 
$login = LOGIN;
$pass = PASS; 
$base = BASE;


error_reporting(53);
$id= MYSQL_CONNECT($serveur,$login,$pass); 

if (!$id) {
// ----------------------------------------------------------connexion locale
include_once '../config.inc.php';
$serveur = HOTE; 
$login = LOGIN;
$pass = PASS; 
$base = BASE;

error_reporting(53);
$id= MYSQL_CONNECT($serveur,$login,$pass); 
}
mysql_select_db("$base"); 
?>








<?if ($mode) {?>



<?function entete($fp) { // -----------------------------------------FONCTION ENTETE HTML
//ecriture de l'entete
fwrite($fp,"<html>\n");
fwrite($fp,"<head>\n");
fwrite($fp,"<title>Cr&eacute;ation de la base</title>\n");
fwrite($fp,"</head>\n");
fwrite($fp,"<body>\n");
fwrite($fp,"<?php\n");

//ecriture de la connexion a la base (2)
fwrite($fp,'//'."connexion a online\n");
fwrite($fp,'$serveur'."= \"serveur\";\n"); 
fwrite($fp,'$login'."= \"login\";\n"); 
fwrite($fp,'$pass'."= \"password\";\n"); 
fwrite($fp,'$base'."= \"baseMysql\";\n\n"); 

fwrite($fp,"error_reporting(53);\n");
fwrite($fp,'$id= MYSQL_CONNECT($serveur,$login,$pass);'."\n\n"); 

fwrite($fp,'if (!$id) {'."\n");
fwrite($fp,'//'."connexion locale\n");
fwrite($fp,'$serveur'."= \"localhost\";\n"); 
fwrite($fp,'$login'."= \"root\";\n"); 
fwrite($fp,'$pass'."= \"\";\n"); 
fwrite($fp,'$base'."= \"baseMysql\";\n\n"); 

fwrite($fp,"error_reporting(53);\n");
fwrite($fp,'$id= MYSQL_CONNECT($serveur,$login,$pass);'."\n"); 

fwrite($fp,"}\n");
fwrite($fp,'mysql_select_db("$base");'."\n"); 
fwrite($fp,"\n");
}?>

 <? 
function pieddepage($fp) { // -----------------------------------------FONCTION PIEDDEPAGE HTML
//verification de la creation des tables
fwrite($fp,"\n".'//'."affichage des tables\n");
fwrite($fp,"echo \"Liste des tables de la base<P>\";"."\n");
fwrite($fp,'$result = mysql_listtables ($base);'."\n");
fwrite($fp,'$i = 0;'."\n");
fwrite($fp,'while ($i < mysql_num_rows ($result)) {'."\n");
fwrite($fp,'$tb_names[$i] = mysql_tablename ($result, $i);'."\n");
fwrite($fp,'echo $tb_names[$i] . '."\"<BR>\";"."\n");
fwrite($fp,'$i++;'."\n");
fwrite($fp,"}\n");
fwrite($fp,"mysql_close();\n");
fwrite($fp,"?>
  \n"); fwrite($fp,"</body>\n"); fwrite($fp,"</html>\n"); //fermeture du fichier
fclose($fp); 
}?>

<? 
function DROPTABLE($fp,$tbname) { // -----------------------------------------FONCTION PIEDDEPAGE HTML
fwrite($fp,'$query'." = \"DROP TABLE $tbname\";\n");
fwrite($fp,'$result'." = mysql_query(".'$query,$id'.");\n");
}?>

<? 
function CREATETABLE($fp,$tbname,$base) { // -----------------------------------------FONCTION CREATION DE TABLE
fwrite($fp,"\n".'//'."creation de la table $tbname\n");
fwrite($fp,'$query'." = \"CREATE TABLE $tbname(");
//listage des champs de la table
	$resultchamps = mysql_list_fields($base,$tbname);
	$j = 0;
	while ($j < mysql_num_fields($resultchamps)) {
		echo mysql_field_name($resultchamps,$j)."&nbsp;".mysql_field_type($resultchamps,$j)."&nbsp;".mysql_field_len($resultchamps,$j)."&nbsp;".mysql_field_flags($resultchamps,$j)."<BR>";
		fwrite($fp,mysql_field_name($resultchamps,$j)); //nom du champ
		switch(mysql_field_type($resultchamps,$j)) { //conversion type
			case "int":
				if (mysql_field_len($resultchamps,$j) <= 6) {
				fwrite($fp," SMALLINT");
				} elseif (mysql_field_len($resultchamps,$j) <= 9) {
				fwrite($fp," MEDIUMINT");
				} else {
				fwrite($fp," INT");
				}
				if (strpos(mysql_field_flags($resultchamps,$j),"ot_null")) {fwrite($fp," NOT NULL");}
				if (strpos(mysql_field_flags($resultchamps,$j),"auto_increment")) {fwrite($fp," AUTO_INCREMENT");}
				fwrite($fp,",");
				break;
				case "real":
				if (mysql_field_len($resultchamps,$j) <= 10) {
				fwrite($fp," FLOAT");
				} elseif (mysql_field_len($resultchamps,$j) <= 16) {
				fwrite($fp," DOUBLE");
				} else {
				fwrite($fp," DOUBLE");
				}
				fwrite($fp,",");
				break;
			case "string":
				fwrite($fp," VARCHAR(".mysql_field_len($resultchamps,$j)."),");
				break;
			case "blob":
				$textblob = "TEXT";
				if (strpos(mysql_field_flags($resultchamps,$j),"binary")) {$textblob = "BLOB";}
				if (mysql_field_len($resultchamps,$j) <= 255) {
				fwrite($fp," TINY$textblob,");
				} elseif (mysql_field_len($resultchamps,$j) <= 65535) {
				fwrite($fp," $textblob,");
				} else {
				fwrite($fp," MEDIUM$textblob,");
				}
				break;
			case "date":
				fwrite($fp," DATE,");
				break;
			case "time":
				fwrite($fp," TIME,");
				break;
			case "datetime":
				fwrite($fp," DATETIME,");
				break;
		}
		if (strpos(mysql_field_flags($resultchamps,$j),"primary_key")) {$iprim = $j;} //verif si clef primaire
		$j++;
	}
	fwrite($fp,"PRIMARY KEY(".mysql_field_name($resultchamps,$iprim).")"); //cl&eacute; primaire
	fwrite($fp,")\";\n");	
	fwrite($fp,'$result'." = mysql_query(".'$query,$id'.");\n");
// libère la variable $resultchamps /
mysql_free_result($resultchamps); 
}?>


<? 
function CREATEDATA($fp,$tbname,$base,$RadioGroup1,$id) { // -----------------------------------------FONCTION CREATION DONNEES
fwrite($fp,'//'."creation des donnes\n");

	$query2 = "SELECT * FROM $tbname"; 
	$result2 = mysql_query($query2,$id); 
	$champs = mysql_num_fields($result2); 

		if (($RadioGroup1!=0)&&($RadioGroup1)){
			$compteur=(($RadioGroup1-1)*50);
			$max=($RadioGroup1*50)-1;
		}else{
			$compteur=0;
			$max=mysql_num_rows($result2);
		}
echo "debut=".$compteur."<br>";
echo "max=".$max."<br>";


// Boucle temp qu'il y a un enregistrement (ligne) sinon False 
//&&

$tt=0;
	while(($row = mysql_fetch_row($result2))){ 
		
	   if (($compteur<=$max)&&($tt>=$compteur)) {
		fwrite($fp,'$query'." = \"INSERT INTO $tbname VALUES(");
		$c=0; 
		// Boucle jusqu'au dernier champ
		while ($c < $champs){ 
		// Affiche en colonne les champs
			if ($c != 0) {fwrite($fp,",");}
			$resultchamps = mysql_list_fields($base,$tbname);
			if (mysql_field_type($resultchamps,$c)== "string" or mysql_field_type($resultchamps,$c)== "blob" or mysql_field_type($resultchamps,$c)== "date" or mysql_field_type($resultchamps,$c)== "time" or mysql_field_type($resultchamps,$c)== "datetime") {fwrite($fp,"'");}
			if ($row[$c]) {}else{$row[$c]=0;}
			fwrite($fp,str_replace("//","\/\/",AddSlashes($row[$c]))); 
			if (mysql_field_type($resultchamps,$c)== "string" or mysql_field_type($resultchamps,$c)== "blob" or mysql_field_type($resultchamps,$c)== "date" or mysql_field_type($resultchamps,$c)== "time" or mysql_field_type($resultchamps,$c)== "datetime") {fwrite($fp,"'");}
			$c++; 
		} 
		fwrite($fp,")\";\n");
		fwrite($fp,'$result'." = mysql_query(".'$query,$id'.");\n");
	    ++$compteur;
	    echo $compteur."-----record : ".$tt."<BR>";
	    }
++$tt;
echo "tt=".$tt."<br>";
	} 
	
// libère la variable $result2 /
mysql_free_result($result2); 	
}?>




<?function DUMP($fp,$base,$RadioGroup1,$id,$var) {
entete($fp); // -- ENTETE AUTO
//suppression des tables de la base--------------------------------------------------------------------
fwrite($fp,'//'."suppression des tables existantes\n");
$result = mysql_listtables ($base);



$i = 0;
while ($i < mysql_num_rows ($result)) {
    $j = 0;
   	while ($j < mysql_num_rows ($result)) {
	if (($var[$j]==($i+1))&&($var[$j])){
    	    if (($RadioGroup1>1)&&($RadioGroup1)){
    	    	fwrite($fp,"//pas de drop des tables (fichier multipart)\n");
    	    	}
    	    else
    	    	{
    		$tbname = mysql_tablename ($result, $i);
    		DROPTABLE($fp,$tbname);
	    }
	}
    $j++;
	}
$i++;
}



//creation des tables------------------------------------------------------------------------------------
$result = mysql_listtables ($base);
$i = 0;
while ($i < mysql_num_rows ($result)) {
	
$j = 0;
     while ($j < mysql_num_rows ($result)) {
	if (($var[$j]==($i+1))&&($var[$j])){
  
        $tbname = mysql_tablename ($result, $i);
  
		  if (($RadioGroup1>1)&&($RadioGroup1)){
		    	    fwrite($fp,"//pas de création de table (fichier multipart)\n");
		  }
		  else                  //creation de la table pour autodump & table-part1 ....
		  {
		  CREATETABLE($fp,$tbname,$base);
		  }
        CREATEDATA($fp,$tbname,$base,$RadioGroup1,$id);
        }
$j++;
    }
$i++;
}

//---------- pied de fichier HTML auto
pieddepage($fp); 

mysql_free_result($result);
}?>











<?
//creation du fichier

if (($RadioGroup1>0)&&($RadioGroup1)){
	// récupération dun nom de la table
	$result = mysql_listtables ($base);
	$tb_name = mysql_tablename ($result, ($var[0]-1));
	$fp = fopen("auto-".$tb_name."-part".$RadioGroup1.".txt", "w");
	DUMP($fp,$base,$RadioGroup1,$id,$var);
}else{
	if ($mode==1){$fp = fopen("autofckdump.txt", "w");
	DUMP($fp,$base,$RadioGroup1,$id,$var);}
	}

// cas 1table=1 fichier (mode 2)

if ($mode==2){
// récupération dun nom de la table
$result = mysql_listtables ($base);
$i = 0;
while ($i < mysql_num_rows ($result)) {
	
	$j = 0; //--- test de la table selectionnée ou non
   	while ($j < mysql_num_rows ($result)) {
		if (($var[$j]==($i+1))&&($var[$j])){
		$tb_name = mysql_tablename ($result,($var[$j]-1));
		$fp = fopen("auto-".$tb_name.".txt", "w");
		$var2[0]=$i+1;
		DUMP($fp,$base,$RadioGroup1,$id,$var2);
		
		}
        ++$j;
        }
++$i;
}
}







?>






























<?
// else test if $mode
}else {                  
// ------------------------------------------------------------------------------- Affichage HTML ACCUEIL
?>
  <font color="#000066" face="Arial, Helvetica, sans-serif">AutoDump de Base de 
  Donn&eacute;es. V.1.1 (addon par maunakea)</font> </h3>


<? // ------------------------------------------------------------------------------- FORM1?>
<form action="fckdump.php" method="get" name="form2" id="form2">
  <h3>&nbsp;</h3>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
    <tr> 
      <td><table width="100%" border="0" cellpadding="4" cellspacing="1">
          <tr bgcolor="#FFCC66"> 
            <td colspan="3"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"><img src="dump.gif" width="24" height="30" align="absmiddle">&nbsp;Fichiers 
              unique | <strong>1 fichier de sauvegarde (initbase.php)</strong></font></td>
          </tr>
          <?  //affichage des tables
$result = mysql_listtables ($base);
$i = 0;
?>
          <tr bgcolor="#FFFFFF"> 
            <td width="226"><div align="center"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif">Choisissez 
                la/les table(s) :</font><br>
                <select name="var[]" size="6" multiple> // ----------- NB les [] permettent le traitement multiple !!!!
                  <?
while ($i < mysql_num_rows ($result)) {
$tb_names[$i] = mysql_tablename ($result, $i);
?>
                  <option value="<?echo $i+1;?>"><?echo $tb_names[$i];?> ( 
                  <? $SQL2 = "SELECT * FROM ".$tb_names[$i]; 
               $result2 = mysql_query($SQL2); 
               echo mysql_numrows($result2); ?>
                  records)</option>
                   
                  <? $i++;
 }?>
                </select>
              </div></td>
            <td width="223"><div align="center"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                <label>
                <select name="mode" id="mode">
                  <option value="1" selected>Fichier unique (autofckdump.php)</option>
                  <option value="2">Multi-fichiers (auto-table1.php3, auto-table2....)</option>
                </select>
                <br>
                NB : <font color="#FF0000"><strong>Enregistre tous les 'records<font color="#000066">'</font></strong></font></label>
                :<br>
                (peut poser probl&egrave;me sur serveur lents (timeout exceed)).</font></div></td>
            <td width="145"><div align="center"> 
                <input type="submit" name="Submit2" value="Dump it now !">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp; </p>
</form>
  
  
<? // ------------------------------------------------------------------------------- FORM2?>
<form name="form1" method="get" action="fckdump.php">
  <h3>&nbsp;</h3>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="4" cellspacing="1">
          <tr bgcolor="#FFCC66"> 
            <td colspan="3"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"><img src="dump.gif" width="24" height="30" align="absmiddle">&nbsp;Fichiers 
              Multi-parts | <strong>1 table = x fichier (auto-table-part1.php, 
              init-table-part2.php ...)</strong></font></td>
          </tr>
          <?  //affichage des tables
$result = mysql_listtables ($base);
$i = 0;
?>
          <tr bgcolor="#FFFFFF"> 
            <td width="38%"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif">Choisissez 
              la table :</font><br> <select name="var[]"> // ----------- NB les [] permettent le traitement multiple !!!!
                <?
while ($i < mysql_num_rows ($result)) {
$tb_names[$i] = mysql_tablename ($result, $i);
?>
                <option value="<?echo $i+1;?>"><?echo $tb_names[$i];?> ( 
                <? $SQL2 = "SELECT * FROM ".$tb_names[$i]; 
               $result2 = mysql_query($SQL2); 
               echo mysql_numrows($result2); ?>
                records)</option>
                 
                <? $i++;
 }?>
              </select></td>
            <td width="31%"><table width="329">
                <tr> 
                  <td width="321"><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input name="RadioGroup1" type="radio" value="1" checked>
                    1 à 50</label>
                    (part1) </font></td>
                </tr>
                <tr> 
                  <td><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input type="radio" name="RadioGroup1" value="2">
                    51 à 100</label>
                    (part2) </font></td>
                </tr>
                <tr> 
                  <td><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input type="radio" name="RadioGroup1" value="3">
                    101 à 150</label>
                    (part3) </font></td>
                </tr>
                <tr> 
                  <td><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input type="radio" name="RadioGroup1" value="4">
                    151 à 200</label>
                    (part4) </font></td>
                </tr>
                <tr> 
                  <td><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input type="radio" name="RadioGroup1" value="5">
                    201 à 250</label>
                    (part5) </font></td>
                </tr>
                <tr> 
                  <td><font color="#000066" size="2" face="Arial, Helvetica, sans-serif"> 
                    <label> 
                    <input type="radio" name="RadioGroup1" value="6">
                    251 à 300</label>
                    (part6)</font></td>
                </tr>
              </table></td>
            <td width="31%"><div align="center">
            <input type="hidden" name="mode" value="1">
                <input type="submit" name="Submit" value="Dump it now !">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp; </p>
  </form>
  
<?

mysql_close();
  
    ?>
</body>
</html>

 <?} //-- fin if $mode 
 ?>