<?php


//:: Récupérer dernière news
$sql = mysql_query("SELECT id,date,description FROM nouveautes ORDER BY date DESC LIMIT 1");
$data = mysql_fetch_object($sql);

//:: Top hommes
$sql3 = mysql_query("SELECT username, img_principale, portable FROM members WHERE active=1 AND img_valid=1 AND gender='h' ORDER BY note DESC LIMIT 0,1");
$data3 = mysql_fetch_object($sql3);
	if ($data3->portable) $tel=" <img src='images/portable.png' valign='absmiddle'>";
	$top_h='<a href="?p=infos&username='.$data3->username.'"><img src="upload/principal/'.$data3->img_principale.'" id="img3" style="margin-bottom:5px"></a> <a href="?p=infos&username='.$data3->username.'">'.ucfirst($data3->username).'</a>'.@$tel;


//:: Top femmes
$sql4 = mysql_query("SELECT username, img_principale, portable FROM members WHERE active=1 AND img_valid=1 AND gender='f' ORDER BY note DESC LIMIT 0,1"); 
$data4 = mysql_fetch_object($sql4);
if (!empty($data4->username)) {
	if ($data4->portable) $tel=" <img src='images/portable.png' valign='absmiddle'>";
	$top_f='<a href="?p=infos&username='.$data4->username.'"><img src="upload/principal/'.$data4->img_principale.'"  id="img3"></a><br><a href="?p=infos&username='.$data4->username.'">'.ucfirst($data4->username).'</a>'.@$tel;
} else { $top_f='<a href="?p=inscription"><img src="images/notopF.png" id="img3"></a>'; }

//:: LAST 
$sql5 = mysql_query("SELECT username, img_principale, portable FROM members WHERE active=1 AND img_valid=1 GROUP BY username ORDER BY joindate desc limit 0,3");
while ($data5 = mysql_fetch_object($sql5) ){  
	if ($data5->portable) $tel=" <img src='images/portable.png' valign='absmiddle'>";
	else $tel="";
	$lastimg.='<td align="center" valign="bottom"><a href="?p=infos&username='.$data5->username.'"><img src="upload/principal/'.$data5->img_principale.'" id="img"><br>'.ucfirst($data5->username).'</a>'.$tel.'</td>';
} 

//:: H 18 et -
$sql6= mysql_query("select * from members where gender='h' and age <= 17 and active=1 GROUP BY username desc limit 0,5") or die (mysql_error()); 
while ($data6 = mysql_fetch_object($sql6) )
{
	@$last1.='<a href="?p=infos&username='.$data6->username.'">'.ucfirst($data6->username).' › '.$data6->age.' ans<br>';
}
//:: H 18 et +
$sql7= mysql_query("select * from members where gender='h' and age > 17 and active=1 GROUP BY username desc limit 0,5");
while ($data7 = mysql_fetch_object($sql7) )
{
	@$last2.='<a href="?p=infos&username='.$data7->username.'">'.ucfirst($data7->username).' › '.$data7->age.' ans<br>';
}
//:: F 18 et -
$sql8= mysql_query("select * from members where gender='f'  and age <= 17 and active=1 GROUP BY username desc limit 0,5") or die (mysql_error());
while ($data8 = mysql_fetch_object($sql8) )
{
	@$last3.='<a href="?p=infos&username='.$data8->username.'">'.ucfirst($data8->username).' › '.$data8->age.' ans<br>';
}
//:: F 18 et +
$sql9= mysql_query("select * from members where gender='f'  and age > 17 and active=1 GROUP BY username desc limit 0,5"); 
while ($data9 = mysql_fetch_object($sql9) )
{
	@$last4.='<a href="?p=infos&username='.$data9->username.'">'.ucfirst($data9->username).' › '.$data9->age.' ans<br>';
}


head();

echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				  <td width="80%" align="left" valign="top"> 
				   
						<h3>Derni&egrave;re nouveaut&eacute;:</h3>
		
						
		
						<div style="margin-left:15px">
							<b>',$data->date,' : </b>',$data->description,'
							<!--<br><br><div style="background-color:#FFFFFF; width:150px; padding:2px 2px 2px 5px; height:14px; border:1px solid #999999;"> <a href="#null" onclick="javascript:window.open(\'?p=commentaire&id=',$data->id,'\',\'comment_news\',\'width=400,height=500,scrollbars=1,resizable=1\'); return false;"><strong><img src="images/people.png" style="border:0; vertical-align:middle; margin:0; padding:0"> Commentaires</strong></a> [',$data2->nbid,']</div>-->
						</div>
						
  
					<br><br><br>
					
					<table width="250" border="0" align="center" cellpadding="0" cellspacing="4" style="border:1px solid #FFFFFF; border-top:5px solid #FFFFFF; padding:2px">
					  <tr>
						<td width="50%" ><div align="center" style="background-color:#0099FF; padding:2px 0 2px 0; color:#FFFFFF;"><img src="images/ico_homme.gif"> Top Hommes <img src="images/ico_homme.gif"></div><br></td>
						<td width="50%"><div align="center" style="background-color:#0099FF; padding:2px 0 2px 0; color:#FFFFFF"><img src="images/ico_femme.gif"> Top Femmes <img src="images/ico_femme.gif"></div><br></td>
					  </tr>
					  <tr>
						<td valign="top"><div align="center">',$top_h,'</div></td>
						<td valign="top"><div align="center">',$top_f,'</div></td>
					  </tr>
					</table>
					
					<br><br>
					<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
					  <tr>
						<td colspan="3"><h3>Les derniers inscrits</h3></td>
					  </tr>
					  <tr>
					  		',$lastimg,'
					  </tr>
					  <tr>
					  	<td colspan="4"><br><br></td>
					  </tr>
					  <tr>
						<td width="25%" align="center" valign="top"><b>H 18 et moins</b><br><br>',$last1,'</td>
						<td width="25%" align="center" valign="top"><b>H 18 et plus</b><br><br>',$last2,'</td>
						<td width="25%" align="center" valign="top"><b>F 18 et moins</b><br><br>',$last3,'</td>
						<td width="25%" align="center" valign="top"><b>F 18 et plus</b><br><br>',$last4,'</td>
					  </tr>
					</table>
				
					
			  </td>
			</tr>
		  </table><br><br>
';
		
foot();

?>