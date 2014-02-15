<HTML>

<?php
$sql_serveur="localhost";
$sql_user="sniperman";
$sql_passwd="";
$sql_bdd="sniperman";
$i=0;

$db_link = @mysql_connect($sql_serveur,$sql_user,$sql_passwd);
$select_db=@mysql_select_db($sql_bdd) or die(mysql_error());

# Meilleur ARME :
$req="SELECT * FROM quiz2 WHERE quiz='arme' ORDER BY note DESC LIMIT 1";
$result=mysql_query($req); 
$meilleur=mysql_fetch_array($result); 

# Meilleur MAP :
$req="SELECT * FROM quiz2 WHERE quiz='map' ORDER BY note DESC LIMIT 1";
$result=mysql_query($req); 
$meilleur2=mysql_fetch_array($result); 

# Meilleur MAP :
$req="SELECT * FROM quiz2 WHERE quiz='web' ORDER BY note DESC LIMIT 1";
$result=mysql_query($req); 
$meilleur3=mysql_fetch_array($result); 


# Nombres faits de celui la :
$sql = mysql_query("SELECT * FROM quiz2 WHERE quiz='arme'"); 
$Nbarme = mysql_numrows($sql); 

# Nombres faits de celui la :
$sql = mysql_query("SELECT * FROM quiz2 WHERE quiz='map'"); 
$Nbmap = mysql_numrows($sql); 

# Nombres faits de celui la :
$sql = mysql_query("SELECT * FROM quiz2 WHERE quiz='web'"); 
$Nbweb = mysql_numrows($sql); 


mysql_close();
?>

<HEAD>
<TITLE>Counter Snip</TITLE>
<META NAME="TITLE" CONTENT="Counter-Snip">
<META NAME="identifer-URL" CONTENT="http://sniperman.free.fr">
<META NAME="AUTHOR" lang="fr" CONTENT="Sniperman">
<META NAME="OWNER" CONTENT="snake.spm@laposte.net">
<META NAME="SUBJECT" CONTENT="Counter Strike">
<META NAME="Category" CONTENT="Internet - Jeux - Cs">
<META NAME="DESRIPTION" CONTENT="Tout sur Counter Strike et plus">
<META NAME="KEYWORDS" CONTENT="sniperman,kirikiri,countersnip,counter-snip,cs,counter strike,counterstrike,wallpapers,fond d'écran,sms,loto,prizee,astuces,armes,skins,binds,alias,half life,maps,download,téléchargement,patchs,guide,dossier,aide,ping,fps,optimisation,mms,loteries,Orange,LAN,réseau,France,fr,hl key fr,1.5,1.3,1.4,Forum,Astuces,Console,commandes,Cheat,Hack,OGL,wallhack,liens,GBA,rom,Annuaire,">
<META NAME="LANGUAGE" CONTENT="FR">
<META NAME="robots" CONTENT="All">

<STYLE TYPE=text/css>
TD { font-family:Verdana;font-size:11px;color:white } 
.menu { font-family:Verdana;font-size:12px;color:white } 
.titre { font-family:Verdana;font-size:20px;color:white } 
A.menu { font-family:Verdana;font-size:12px;color:white;text-decoration:none } 
A:hover.menu { font-family:Verdana;font-size:12px;color:#FFCC00;font-weight:normal;text-decoration:none } 
A { font-family:Verdana;font-size:11px;color:#FFCC00;text-decoration:none } 
A.liens {color: #0000FF;decoration:none }
A:hover.liens {color:#FF0000;text-decoration:underline;font-weight:Bolder } 
A:hover { font-family:Verdana;font-size:11px;color:#CC0000 } 
BODY {SCROLLBAR-FACE-COLOR: #ffa534; SCROLLBAR-HIGHLIGHT-COLOR: #ffd756; SCROLLBAR-SHADOW-COLOR: #ff8312; SCROLLBAR-3DLIGHT-COLOR: #000000; SCROLLBAR-ARROW-COLOR: #000000; SCROLLBAR-TRACK-COLOR: #8E908D; SCROLLBAR-DARKSHADOW-COLOR: #000000}</STYLE>

</HEAD>
<BODY BGCOLOR=#000000 TEXT=#FFFFFF LINK=#0000FF VLINK=#800080 ALINK=#FF0000>

<CENTER>

<TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=774>
  <TR>
    <TD WIDTH=175><IMG SRC="images/haut3a.jpg" BORDER=0 WIDTH=175 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
      <TD WIDTH=579 BACKGROUND=images/top_cs.gif CLASS=titre> Dossier QUIZZzzzz<BR>
        <IMG SRC="images/pixel.gif" BORDER=0 WIDTH=1 HEIGHT=13 HSPACE=0 VSPACE=0></TD>
    <TD WIDTH=20><IMG SRC="images/top_d.gif" BORDER=0 WIDTH=20 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
  </TR>
  <TR> 
      <TD WIDTH=175 BACKGROUND=images/fond_menu.gif VALIGN=top CLASS=menu> <IMG SRC="images/haut3b.jpg" BORDER=0 WIDTH=175 HEIGHT=115 HSPACE=0 VSPACE=0><BR> 
        <TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=175 HEIGHT=26 BACKGROUND=images/menu_bleu.gif><TR>
            <TD WIDTH=175 CLASS=menu><B>&nbsp;&nbsp;&gt; Site</B></TD>
          </TR></TABLE>
        		&nbsp;&nbsp;- <A HREF="index.htm" CLASS=menu>Accueil</A><br>
		&nbsp;&nbsp;- <A HREF="/phpBB2" target="_blank" CLASS=menu>Forum</A> /&nbsp;<A HREF="site_chat.htm" CLASS=menu>Chat</A><BR>&nbsp;&nbsp;- <A HREF="http://www.maxiservices.net/livre/livre.php3?id=2810%20" target="_blank" CLASS=menu>Livre d'or</A><BR>
        &nbsp;&nbsp;- <A HREF="site_quisuisje.html" CLASS=menu>Qui suis-je</A><BR>
                &nbsp;&nbsp;- <A HREF="site_contact.html" CLASS=menu>Me contacter</A><br>
            &nbsp;&nbsp;- <A HREF="site_pub.html" CLASS=menu>Pubs</A><BR><BR>
        <TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=175 HEIGHT=26 BACKGROUND=images/menu_bleu.gif><TR>
            <TD WIDTH=175 CLASS=menu><B>&nbsp;&nbsp;&gt; Counter strike</B></TD>
          </TR></TABLE>
	&nbsp;&nbsp;- <A HREF="cs_Downloads.html" CLASS=menu>Downloads</A><BR>
	&nbsp;&nbsp;- <A HREF="cs_Astuces.html" CLASS=menu>Astuces</A><BR>
   			&nbsp;&nbsp;- <A HREF="cs_Binds_&_Alias.html" CLASS=menu>Binds & Alias</A><br> 		&nbsp;&nbsp;- <A HREF="cs_Podbot.html" CLASS=menu>PodBots</A><br> 
    	&nbsp;&nbsp;- <A HREF="cs_counterMania.html" CLASS=menu>Counter Mania</A><BR> 
	&nbsp;&nbsp;- <A HREF="cs_console.html" CLASS=menu>Console</A><BR>
	&nbsp;&nbsp;- <A HREF="cs_armes.html" CLASS=menu>Armes</A><BR>
		&nbsp;&nbsp;- <A HREF="cs_Ping.html" CLASS=menu>Ping</A><BR>
     
    	&nbsp;&nbsp;- <A HREF="cs_wallpapers.html" CLASS=menu>Wallpapers</A><br>
    	&nbsp;&nbsp;- <A HREF="cs_cheats.html" CLASS=menu>Cheats</A><BR>&nbsp;&nbsp;- <A HREF="cs_liens.html" CLASS=menu>Liens</A><BR>
		<A HREF="cs_quiz.php" CLASS=menu><SCRIPT language=JavaScript1.2>

function initArray() {
this.length = initArray.arguments.length;
for (var i = 0; i < this.length; i++) {
this[i] = initArray.arguments[i];
   }
}

var ctext = "&nbsp;&nbsp;- QuiZZzzz";
var x = 0;
var color=new Array()
 color[0] = "#ECF400"; 
 color[1] = "#F4EB00"; 
 color[2] = "#F4CF00"; 
 color[3] = "#F4BD00"; 
 color[4] = "#F4B200"; 
 color[5] = "#F4AC00"; 
 color[6] = "#F49B00"; 
 color[7] = "#F48A00"; 
 color[8] = "#F48400"; 
 color[9] = "#F46D00"; 
 color[10] = "#F46200"; 
 color[11] = "#F45000"; 
 color[12] = "#F43F00"; 
 color[13] = "#F42800"; 
 color[14] = "#FF0000"; 
 color[15] = "#F42800"; 
 color[16] = "#F43F00"; 
 color[17] = "#F45000"; 
 color[18] = "#F46200"; 
 color[19] = "#F46D00"; 
 color[20] = "#F46D00"; 
 color[21] = "#F48A00"; 
 color[22] = "#F49B00"; 
 color[23] = "#F4AC00"; 
 color[24] = "#F4B200"; 
 color[25] = "#F4BD00"; 
 color[26] = "#F4CF00"; 
 color[27] = "#F4EB00"; 
 color[28] = "#ECF400"; 
  
var modif = '<font face="verdana">'+ctext+'</font>';
if(navigator.appName == "Netscape") {
document.write('<layer id="ct">'+modif +'</layer>');
}
if (navigator.appVersion.indexOf("MSIE") != -1){
document.write('<b><div id="ct">'+modif +'</div></b>');
}
function chcolor(){ 
if(navigator.appName == "Netscape") {
document.ct.document.write('<font color="'+color[x]); 
document.ct.document.write('">'+modif +'</font>');
document.ct.document.close();
}
else if (navigator.appVersion.indexOf("MSIE") != -1){
document.all.ct.style.color = color[x];
}
(x <color.length-1) ? x++ : x=0; 
} 
setInterval("chcolor()", 100 );
</SCRIPT></A><BR>
        <TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=175 HEIGHT=26 BACKGROUND=images/menu_bleu.gif>
          <TR>
            <TD WIDTH=175 CLASS=menu><B>&nbsp;&nbsp;&gt; Petits +</B></TD>
          </TR></TABLE>		  
        &nbsp;&nbsp;- <A HREF="plus_sms.html" CLASS=menu>SMS & MMS gratuits</A><BR>
          
          
          &nbsp;&nbsp;- <A HREF="plus_cine.html" CLASS=menu>Programme Ciné & TV</A><br>
          &nbsp;&nbsp;- <A HREF="" CLASS=menu>Mail Anonyme</A><br>
          
          &nbsp;&nbsp;- <A HREF="plus_annuaire.html" CLASS=menu>Annuaire Inversé</A><BR>
&nbsp;&nbsp;- <A HREF="plus_virus.html" CLASS=menu>Dossier Virus</A><BR>
&nbsp;&nbsp;- <A HREF="plus_autres.html" CLASS=menu><font color="#CCFF99">Tous les Services</font></A><BR>
<br>
          &nbsp;&nbsp;- <A HREF="plus_espaceprive.html" CLASS=menu>Espace Privé</A></p>
        <p align="center">&nbsp;</p>
        <p align="center"><br>
          <BR>
          <BR>
        </p></TD>
    <TD WIDTH=579 BGCOLOR=#364132 VALIGN=top ALIGN=center> 
        <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=575>
  		<TR>
    		<TD WIDTH=25><IMG SRC="images/cad_bleu_hg.gif" BORDER=0 WIDTH=25 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
    		<TD BACKGROUND=images/cad_bleue_h.gif WIDTH=523 CLASS=menu><B>Index : Quizz
    		    Counter Strike</B></TD>
    		<TD WIDTH=27><IMG SRC="images/cad_bleu_hd.gif" BORDER=0 WIDTH=27 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD WIDTH=25 BACKGROUND=images/cad_g.gif><IMG SRC="images/cad_g.gif" BORDER=0 WIDTH=25 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
    		<TD BGCOLOR=#4D574A WIDTH=523> <p align="center"><font color="#FFFFFF"><strong>Vous
    		      avez envie de tester vos connaissances sur Counter Strike ??
    		        <br>
   		        Alors n'h&eacute;sitez plus et faites ces quizz.<br>
   		        <br>
   		        Au nombre de 4 dont 3 in&eacute;dits, ils explorent
    		3 nouveaux domaines : <br>
    		<font color="#FFFFCC">Les Armes, Les Maps et Le Jeu
    		Online.</font></strong></font></p>
    		  <p align="center"><strong><font color="#FFFFFF">A vos clavier et bonne chance !</font></strong></p>
    		  <table width="45%" border="0" align="center" cellspacing="2">
                <tr>
                  <td bgcolor="#FF0000"><div align="center"><strong></strong> </div>
                      <div align="center"><strong><font color="#FFFF00">QuiZz
                            Web :</font></strong></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00"><p><font color="#000000"><strong>Niveau
                          :</strong> 1<br>
                                  <strong>Description :</strong> Ce quiz est
                                  destin&eacute; &agrave; vous qui passez votre
                                  journ&eacute;e sur des sites de CS ainsi qu'&agrave; jouer
                                  Online.<br>
                                          <strong>Clicks : </strong><? print "$Nbweb"; ?><br>
                                          <strong>Suxxer :</strong> </font><font color="#000000"><? print "$meilleur3[pseudo] avec $meilleur3[note]/10"; ?><br>
                                        </font></p>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#00FF00"><ul>
                      <li><font color="#000000"><a href="cs_Qweb.php" class="liens">Faire
                            le Quizz</a></font></li>
                      <li><font color="#000000"><a href="cs_Qweb_Corr.php" class="liens">Voir
                            les Corrections</a></font></li>
                      <li><font color="#000000"><a href="cs_Qweb_Class.php" class="liens">Voir
                            le Classement</a></font></li>
                    </ul>
                  </td>
                </tr>
              </table>    		  
    		  <br>
    		  <table width="45%" border="0" align="center" cellspacing="2">
                <tr>
                  <td bgcolor="#FF0000"><div align="center"><strong></strong> </div>
                      <div align="center"><strong><font color="#FFFF00">QuiZz
                            Armes : </font></strong></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00"><p><font color="#000000"><strong>Niveau
                          :</strong> 2<br>
                                  <strong>Description :</strong> Vous savez vous
                                  servir de l'usp dans CS ? Mais que savez vous
                                  d'autres sur ce gun ? Et sur les Autres ?<br>
                                          <strong>Clicks : </strong><? print "$Nbarme"; ?><br>
                                          <strong>Suxxer :</strong> </font><font color="#000000"><? print "$meilleur[pseudo] avec $meilleur[note]/10"; ?><br>
                                        </font></p>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#00FF00"><ul>
                      <li><font color="#000000"><a href="cs_Qarmes.php" class="liens">Faire
                            le Quizz</a></font></li>
                      <li><font color="#000000"><a href="cs_Qarmes_Corr.php" class="liens">Voir
                            les Corrections</a></font></li>
                      <li><font color="#000000"><a href="cs_Qarmes_Class.php" class="liens">Voir
                            le Classement</a></font></li>
                    </ul>
                  </td>
                </tr>
              </table>
    		  <br>
    		  <table width="45%" border="0" align="center" cellspacing="2">
                <tr>
                  <td bgcolor="#FF0000"><div align="center"><strong></strong> </div>
                      <div align="center"><strong><font color="#FFFF00">QuiZz
                            Maps : </font></strong></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00"><p><font color="#000000"><strong>Niveau
                          :</strong> 3<br>
                                      <strong>Description :</strong> Des questions
                                      sur les Maps Officiels de cs 1.5. Bien
                                      pour les d&eacute;butants !<br>
                                          <strong>Clicks : </strong><? print "$Nbmap"; ?><br>
                                          <strong>Suxxer :</strong> </font><font color="#000000"><? print "$meilleur2[pseudo] avec $meilleur2[note]/10"; ?><br>
                                        </font></p>
                  </td>
                </tr>
                <tr>
                  <td height="60" bgcolor="#00FF00"><ul>
                      <li><font color="#000000"><a href="cs_Qmaps.php" class="liens">Faire
                            le Quizz</a></font></li>
                      <li><font color="#000000"><a href="cs_Qmaps_Corr.php" class="liens">Voir
                            les Corrections</a></font></li>
                      <li><font color="#000000"><a href="cs_Qmaps_Class.php" class="liens">Voir
                            le Classement</a></font></li>
                    </ul>
                  </td>
                </tr>
              </table>    		   
    		  <br>
    		  <table width="45%" border="0" align="center" cellspacing="2">
                <tr>
                  <td bgcolor="#FF0000"><div align="center"><strong></strong> </div>
                      <div align="center"><strong><font color="#FFFF00">QuiZz
                            Divers :</font></strong></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFF00"><p><font color="#000000"><strong>Niveau
                          :</strong> 4<br>
                                  <strong>Description :</strong> Ancien Quiz
                                  assez difficile mais qui porte sur tout les
                                  sujets !<br>
                                              <strong>Clicks : </strong>+ de
                                              300</font><font color="#000000"><br>
                                            </font></p>
                  </td>
                </tr>
                <tr>
                  <td height="60" bgcolor="#00FF00"><ul>
                      <li><font color="#000000"><a href="cs_quiz1.html" class="liens">Faire
                            le Quizz</a></font></li>
                      <li><font color="#000000"><a href="cs_quizReponces.html" class="liens">Voir
                            les Corrections</a></font></li>
                      <li><font color="#000000"><a href="cs_quizResultat.html" class="liens">Voir
                            le Classement</a></font></li>
                    </ul>
                  </td>
                </tr>
              </table>    		  <p>&nbsp;
    		    </p>
    		  <p align="center"><img src="images/Autres/ligne%20sang.gif" width="493" height="24" align="baseline"></p>
    		  <p align="center"><strong><font color="#CCFFCC">Et n'oubliez pas : Il n'y a rien a gagn&eacute; ! C'est juste
    		    pour le Fun.<br>
    		    Alors pas la peine de tricher ;-)</font></strong></p>
   		    </TD>
    		<TD WIDTH=27 BACKGROUND=images/cad_d.gif><IMG SRC="images/cad_d.gif" BORDER=0 WIDTH=27 HEIGHT=12 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD COLSPAN=3><IMG SRC="images/cad_b.gif" BORDER=0 WIDTH=575 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
  		</TR>
  	</TABLE><BR>
        <a href="http://www.xiti.com/xiti.asp?s=98910" TARGET="_top">
<script language="JavaScript1.1">
<!--
hsh = new Date();
hsd = document;
hsr = hsd.referrer.replace(/[<>]/g, '');
hsi = '<img width="39" height="25" border=0 ';
hsi += 'src="http://logv20.xiti.com/hit.xiti?s=98910';
hsi += '&p=';
hsi += '&hl=' + hsh.getHours() + 'x' + hsh.getMinutes() + 'x' + hsh.getSeconds();
if(parseFloat(navigator.appVersion)>=4)
{Xiti_s=screen;hsi += '&r=' + Xiti_s.width + 'x' + Xiti_s.height + 'x' + Xiti_s.pixelDepth + 'x' + Xiti_s.colorDepth;}
hsd.writeln(hsi + '&ref=' + hsr.replace(/&/g, '$') + '" title="Mesurez votre audience"><\!--');
//-->
</script>
<noscript>
<img width="39" height="25" border=0 src="http://logv20.xiti.com/hit.xiti?s=98910&p=&" title="Mesurez votre audience">
</noscript><!--//--></a><br> </TD>
    <TD WIDTH=20 BACKGROUND=images/d.gif><IMG SRC="images/d.gif" BORDER=0 WIDTH=20 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
  </TR>
  <TR>
  	<TD COLSPAN=3><IMG SRC="images/bas.jpg" BORDER=0 WIDTH=774 HEIGHT=32 USEMAP="#bas"></TD>
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
