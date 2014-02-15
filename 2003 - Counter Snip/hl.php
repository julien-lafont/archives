<?php 
//$IP = "213.186.49.11"; 
//$Port = "27015"; 

$ServerinfoCommand = "\377\377\377\377infostring\0"; 
$fp = fsockopen("udp://".$IP, $Port, $errno, $errstr); 
fwrite($fp, $ServerinfoCommand); 
$JunkHead = fread($fp,24); 

// Check to see if the server is running 
$CheckStatus = socket_get_status($fp); 
if($CheckStatus["unread_bytes"] == 0) 
{ 
    die("Le server n'est pas online, Désolé !"); 
} 

function hlsend ($udp, $str) 
{ 
fwrite($udp, "\377\377\377\377${str}\0\0"); 
fread($udp, 4); 
}

// Read through the returned data and put in variable 
$do = 1; 
$HLServerStats= ""; 
while($do) 
{ 
    $str = fread($fp,1); 
    $HLServerStats.= $str; 
    $status = socket_get_status($fp); 
    if($status["unread_bytes"]  == 0) {$do = 0;} 
} 
//Close the connection 
fclose($fp); 

// Explode the packet into an array. 
$HLServerStats = explode("\\", $HLServerStats); 

// Count the amount of keys in the array. 
$count = count($HLServerStats); 

// The amount of keys in the array MUST be an even number 
if($count % 2 == 0) 
{ 
    // Loop though all the keys and put them in the $ServerData array with the key values. 
    $i = 0; 
    while($count != $i) 
    { 
        $ServerData[$HLServerStats[$i]] = $HLServerStats[$i+1]; 
        $i = $i + 2; 
    } 
}  

?><body bgcolor="#FFFFFF" text="#000000" link="#FFFFFF" vlink="#FFFFCC" alink="#FFFF00">
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EAF9FF">
  <tr>
    <td height="30"><table width="60%" border="0" align="center" cellpadding="00" cellspacing="0" bgcolor="#5AB5FE">
      <tr>
        <td bgcolor="#66CCFF"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>Information Serveur
                : </strong></font></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><ul>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Nom
            du Server :</font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">          <?php  echo($ServerData["hostname"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Adresse
            : 
          </font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><?php  echo($ServerData["address"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Map
            en cours :</font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">          <?php  echo($ServerData["map"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Nombres
            de Joueurs 
          :</font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"> <?php  echo($ServerData["players"]); ?> 
          / 
          <?php  echo($ServerData["max"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Nombres
            de Bots : 
          </font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><?php  echo($ServerData["bots"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Mod
            :</font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">          <?php  echo($ServerData["gamedir"]); ?>
      </font></li>
      <li><font color="#003366" size="2" face="Arial, Helvetica, sans-serif">Passworld
            :</font><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"> 
            <?php  
			if ($ServerData["passworld"]=='')
				{echo ("Aucun");}
			else
				{echo($ServerData["passworld"]); }
			?>         
      </font></li>
      </ul>
    </td>
  </tr>
  <tr>
    <td height="30"><table width="60%" border="0" align="center" cellpadding="00" cellspacing="0" bgcolor="#5AB5FE">
      <tr>
        <td bgcolor="#66CCFF"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Kirikiri's
                Script. <a href="http://sniperman.free.fr">site</a></font></div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
 


<p>&nbsp;</p>
