<HTML>
<?php
$sql_serveur="localhost";
$sql_user="sniperman";
$sql_passwd="";
$sql_bdd="sniperman";
$i=0;

$db_link = @mysql_connect($sql_serveur,$sql_user,$sql_passwd);
$select_db=@mysql_select_db($sql_bdd) or die(mysql_error());

# Total
$sql = mysql_query("SELECT * FROM quiz2"); 
$total = mysql_numrows($sql); 

# Meilleur :
$req="SELECT * FROM quiz2 WHERE quiz='web' ORDER BY note DESC LIMIT 1 ";
$result=mysql_query($req); 
$meilleur=mysql_fetch_array($result); 

# Nombres faits de celui la :
$sql = mysql_query("SELECT * FROM quiz2 WHERE quiz='web'"); 
$Nbarme = mysql_numrows($sql); 

# Dernier ID
$req="SELECT * FROM quiz2 WHERE quiz='web' ORDER BY date DESC LIMIT 1"  or die ('erreur 111');
$result=mysql_query($req); 
$dernier=mysql_fetch_array($result); 

# Tous
$req = mysql_query("SELECT * FROM quiz2 WHERE quiz='web' order by note DESC");
$result = mysql_fetch_array($req);

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
A:hover { font-family:Verdana;font-size:11px;color:#CC0000 } 
BODY {SCROLLBAR-FACE-COLOR: #ffa534; SCROLLBAR-HIGHLIGHT-COLOR: #ffd756; SCROLLBAR-SHADOW-COLOR: #ff8312; SCROLLBAR-3DLIGHT-COLOR: #000000; SCROLLBAR-ARROW-COLOR: #000000; SCROLLBAR-TRACK-COLOR: #8E908D; SCROLLBAR-DARKSHADOW-COLOR: #000000}</STYLE>

</HEAD>
<BODY BGCOLOR=#000000 TEXT=#FFFFFF LINK=#0000FF VLINK=#800080 ALINK=#FF0000>

<CENTER>

<TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=774>
  <TR>
    <TD WIDTH=175><IMG SRC="images/haut3a.jpg" BORDER=0 WIDTH=175 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
      <TD WIDTH=579 BACKGROUND=images/top_cs.gif CLASS=titre> Dossier QUIZZzzzz .:.
        Classement<BR>
      <IMG SRC="images/pixel.gif" BORDER=0 WIDTH=1 HEIGHT=13 HSPACE=0 VSPACE=0></TD>
    <TD WIDTH=20><IMG SRC="images/top_d.gif" BORDER=0 WIDTH=20 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
  </TR>
  <TR> 
      <TD WIDTH=175 BACKGROUND=images/fond_menu.gif VALIGN=top CLASS=menu> <IMG SRC="images/haut3b.jpg" BORDER=0 WIDTH=175 HEIGHT=115 HSPACE=0 VSPACE=0><BR> 
        <TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=175 HEIGHT=26 BACKGROUND=images/menu_bleu.gif><TR>
            <TD WIDTH=175 CLASS=menu><B>&nbsp;&nbsp;&gt; Site</B></TD>
          </TR></TABLE>
        		&nbsp;&nbsp;- <A HREF="index.htm" CLASS=menu>Accueil</A><br>
		&nbsp;&nbsp;- <A HREF="/phpBB2" target="_blank" CLASS=menu>Forum</A> /&nbsp;<A HREF="site_chat.htm" CLASS=menu>Chat</A><BR>&nbsp;&nbsp;- <A HREF="http://www.maxiservices.net/livre/livre.php3?id=2810 " target="_blank" CLASS=menu>Livre d'or</A><BR>
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
&nbsp;&nbsp;- <A HREF="plus_autres.html" CLASS=menu>Tous les Services</A><BR>
<br>
          &nbsp;&nbsp;- <A HREF="plus_espaceprive.html" CLASS=menu>Espace Privé</A></p>
        <p align="center"><a href="http://www.prizee.com/index.htm3?refer=Spm"><img src="images/Loteries/prizee.gif" width="90" height="30" border="0"></a><br>
          <BR>
          <BR>
        </p></TD>
    <TD WIDTH=579 BGCOLOR=#364132 VALIGN=top ALIGN=center> 
        <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=575>
  		<TR>
    		<TD WIDTH=25><IMG SRC="images/cad_bleu_hg.gif" BORDER=0 WIDTH=25 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
    		<TD BACKGROUND=images/cad_bleue_h.gif WIDTH=523 CLASS=menu><b>Quizz / WEB
    		    / Classement :</b></TD>
    		<TD WIDTH=27><IMG SRC="images/cad_bleu_hd.gif" BORDER=0 WIDTH=27 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD WIDTH=25 BACKGROUND=images/cad_g.gif><IMG SRC="images/cad_g.gif" BORDER=0 WIDTH=25 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
    		<TD BGCOLOR=#4D574A WIDTH=523> <p>Voici la page de classement du Quizz
    		    : WEB :</p>
    		  <blockquote>
    		    <p> <img src="images/Puces/puce_flechejaune.gif" width="15" height="15" align="absmiddle"> Nb
   		      Total de Quiz  :                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <strong><? print "$total"; ?> </strong>   		      
    		    <p> <img src="images/Puces/puce_flechejaune.gif" width="15" height="15" align="absmiddle"> Nb
   		      Total de Quiz WEB : <strong><? print "$Nbarme"; ?>    		    </strong>
    		    <p> <img src="images/Puces/puce_flechejaune.gif" width="15" height="15" align="absmiddle"> Meilleur
   		      Quiz WEB : <strong><? print "$meilleur[pseudo] avec $meilleur[note]/10"; ?> </strong>   		      
    		    <p> <img src="images/Puces/puce_flechejaune.gif" width="15" height="15" align="absmiddle"> Dernier
                Quiz WEB : <strong><? print "$dernier[pseudo] avec $dernier[note]/10"; ?> </strong>                
    		    <p><img src="images/Puces/puce_flechejaune.gif" width="15" height="15" align="absmiddle"> Classement
              G&eacute;n&eacute;ral quiz WEB :                 
                <p><font color="#000000">
<?
echo '<table bgcolor="#FFFFFF" bordercolor="#000000" cellspacing="0">'."\n";
        echo '<tr>';
		echo '<td bgcolor="#00FF00" align="center"><b><font color="#000000">&nbsp;&nbsp;&nbsp;Numéro :&nbsp;&nbsp;&nbsp;</font></b></td>';
        echo '<td bgcolor="#FF0000" align="center"><b><font "#FFFFFF">&nbsp;&nbsp;&nbsp;Pseudo :&nbsp;&nbsp;&nbsp;</font></b></td>';
        echo '<td bgcolor="#FFFF00" align="center"><b><font color="#000000">&nbsp;&nbsp;&nbsp;Note   :&nbsp;&nbsp;&nbsp;</font></b></td>';
        echo '</tr>'."\n";

// affichage du resultat
while ( $result = mysql_fetch_array($req))
{
$i++;

echo '<tr>';
        echo '<td bgcolor="#00FF00" align="center"><font color="#000000">'.$i.'</font></td>';
        echo '<td bgcolor="#FF0000" align="center"><font color="#FFFFFF">'.$result['pseudo'].'</font></td>';
        echo '<td bgcolor="#FFFF00" align="center"><font color="#000000">'.$result['note'].'</font></td>';
        echo '</tr>'."\n";
} 
echo '</table>'."\n";
?>
&nbsp;</font>                 
                <p>&nbsp;  		      
    		  </blockquote>    		  
    		         
              <p>&nbsp;		    </p></TD>
    		<TD WIDTH=27 BACKGROUND=images/cad_d.gif><IMG SRC="images/cad_d.gif" BORDER=0 WIDTH=27 HEIGHT=12 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD COLSPAN=3><IMG SRC="images/cad_b.gif" BORDER=0 WIDTH=575 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
  		</TR>
  	</TABLE><BR>
        <br> </TD>
    <TD WIDTH=20 BACKGROUND=images/d.gif><IMG SRC="images/d.gif" BORDER=0 WIDTH=20 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
  </TR>
  <TR>
  	<TD COLSPAN=3><IMG SRC="images/bas.jpg" BORDER=0 WIDTH=774 HEIGHT=32 USEMAP="#bas"></TD>
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
