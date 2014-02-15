<?php

function head($add="") {
  echo '<HTML>
<HEAD>
<TITLE>Mon-Look.com / Rencontre , Amiti&eacute; et Plus</TITLE>
<META NAME="description" CONTENT="Mon-Look vous permet de savoir ce que votre entourage pense de votre apparence physique
en publiant votre photo et en vous permettant de recevoir des messages gratuitement.">
<META NAME="keywords" CONTENT="rencontre, apparence physique, conseil, photo, vote, message, gratuit, publicitées, information, amis, amie, ami, ">
<META NAME="subject" CONTENT="Mon-Look.com rencontre sur internet amitié ou autres.">
<META NAME="author" CONTENT="Eric Lavigne Brière">
<META NAME="copyright" CONTENT="© Mon-Look.com">
<META NAME="revisit-after" CONTENT="1 day">
<META NAME="identifier-url" CONTENT="http://www.mon-look.com">
<META NAME="reply-to" CONTENT="support@mon-look.com">
<META NAME="Classification" CONTENT="rencontre, amitié, photo, amusement">
<META http-equiv="Content-Language" CONTENT="fr">
<META http-equiv="Content-type" CONTENT="text/html;charset=iso-8859-1">
<META NAME="location" CONTENT="France, FRANCE">

<link rel="stylesheet" href="design/style.css" type="text/css">
'.$add.'
</HEAD>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" id="top">
  <tr>
    <td width="118" rowspan="3" valign="top">
		<img src="design/images/inter_princ1_01.jpg" width="118" height="100" alt="">
		<img src="design/images/inter_princ1_06.jpg" width="118" height="121" alt="" class="bugie">
		<img src="design/images/inter_princ1_11.jpg" width="118" height="379" alt="" class="bugie"></td>
    <td width="450"><img src="design/images/inter_princ1_02.jpg" width="450" height="100" alt=""></td>
    <td width="88" valign="top"><img src="design/images/inter_princ1_03.jpg" width="88" height="100" alt=""></td>
    <td width="149" valign="bottom"></td>
  </tr>
  <tr>
    <td rowspan="2" valign="top"><img src="design/images/inter_princ1_07.jpg" alt="" width="450" height="121" border="0" usemap="#Map"><br>
      <map name="Map">
        <area shape="rect" coords="19,51,68,71" href="?p=accueil">
        <area shape="rect" coords="72,52,153,70" href="?p=top&a=last">
        <area shape="rect" coords="155,53,190,69" href="?p=top&a=top10">
        <area shape="rect" coords="194,53,252,69" href="?p=top&a=topH">
        <area shape="rect" coords="259,54,316,69" href="?p=top&a=topF">
        <area shape="rect" coords="322,54,400,69" href="?p=top&a=enLigne">
      </map>
	  
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td style="background-image:url(design/images/inter_princ1_12b.jpg); background-repeat:no-repeat;background-position:top" valign="top">';
}

function foot() {
	echo '</td>
			</tr>
			</table>
			
		</td>
		  <td colspan="2" valign="top">
			
			<form id="form1" name="form1" method="post" action="?p=search&first=0&last=10">
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="20%"><img src="design/images/inter_princ1_08.jpg" width="88" height="156" alt=""></td>
				<td width="15%" background="design/images/inter_princ1_09.jpg"><table width="100%" height="20%" border="0" cellpadding="1" cellspacing="0">
		
					  <tr>
						<td height="58">&nbsp;</td>
					  </tr>
					  <tr>
						<td><select name="gender" id="select2">
							<option value="">Peu Importe</option>
							<option value="h" >Homme</option>
							<option value="f" >Femme</option>
							</select>
						</td>
					  </tr>
					  <tr>
						<td><input name="city" type="text" id="city" size="13" /></td>
					  </tr>
					  <tr>
						<td height="26" style="color:#4D928F"><b>de</b> <input type="text" name="age1" id="age1" value="" size="2" maxlength="2" />
										<b>à</b> 
										<input type="text" name="age2"  id="age2"  value="" size="2" maxlength="2"/>
						</td>
					  </tr>
					  <tr>
						<td height="20">
							<select name="country" id="select3">
								<option value="">Tous</option>
								<option value="canada" >Canada</option>
								<option value="france" >France</option>
								<option value="belgique" >Belgique</option>
								<option value=".s.a" >U.S.A</option>
								<option value="autre" >Autres</option>		
							</select>
						</td>
					  </tr>
				</table>
			
			
				</td>
				<td width="8%"><img src="design/images/inter_princ1_10.jpg" width="39" height="156" alt=""></td>
		
			  </tr>
			  <tr>
				<td><img src="design/images/inter_princ1_13.jpg" width="88" height="24" alt=""></td>
				<td><img src="design/images/inter_princ1_14.jpg" width="67" height="24" alt=""><input name="" type="image" src="design/images/inter_princ1_15.jpg" onClick="document.form1.submit();" class="no"></td>
				<td><img src="design/images/inter_princ1_16.jpg" width="39" height="24" alt=""></td>
			  </tr>
			  <tr>
				<td><img src="design/images/inter_princ1_17.jpg" width="88" height="20" alt=""></td>
				<td><img src="design/images/inter_princ1_18.jpg" width="67" height="20" alt=""><img src="design/images/inter_princ1_19.jpg" width="38" height="20" alt=""></td>
				<td><img src="design/images/inter_princ1_20.jpg" width="39" height="20" alt=""></td>
			  </tr>  
		  </table>
		  
		  </form>
		  
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td background="design/images/inter_princ1_21.jpg" style="vertical-align:top">
				'.bloc_stats().' <br>
				 > <a href="?p=contact"><b>Contactez nous</b></a> <br><br><br>
				'.bloc_profil().' <br>
				 ';
				if (is_log()==0) echo bloc_login();
				else echo bloc_membre();
				echo '<br><br><a href="http://action.metaffiliation.com/suivi.php?mclic=S341B443B91112" target="_blank" class="opacity"><img src="images/pub/netaffil1.gif" border="0" style="margin-left:20px"></a>
			<br>
				<img src="px.gif" width="0px" height="190px">
			</td>
			</tr>
		  </table><br>
	
	   </td>
	  </tr>
	</table>
	
	
	<div align="center">
		<a href="http://action.metaffiliation.com/suivi.php?mclic=S3663443B9114" target="_blank"><img src="images/pub/netaffil2.gif" border="0" id="img3"></a>   
		<p style="font-variant:italic; color:#333333; font-size:10px">Copyright Mon-Look 2005-2006 Tous droits réservés. Coding by <b style="color:#3399FF">YoTsumi</b></p>
	</div>
	
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
		_uacct = "UA-316708-1";
		urchinTracker();
		</script>
	</body>
	</html>';
}
	
?>