<HTML>
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
A.liens {color: #FFCC00; text-decoration:none}
A:hover.liens {color:#FFE784; text-decoration:underline;font-weight:Bolder} 
A { font-family:Verdana;font-size:11px;color:#FFCC00;text-decoration:none } 
A:hover { font-family:Verdana;font-size:11px;color:#CC0000 } 
BODY {SCROLLBAR-FACE-COLOR: #ffa534; SCROLLBAR-HIGHLIGHT-COLOR: #ffd756; SCROLLBAR-SHADOW-COLOR: #ff8312; SCROLLBAR-3DLIGHT-COLOR: #000000; SCROLLBAR-ARROW-COLOR: #000000; SCROLLBAR-TRACK-COLOR: #8E908D; SCROLLBAR-DARKSHADOW-COLOR: #000000}</STYLE>

<SCRIPT LANGUAGE="JavaScript">
function PopupImage(img,nb1,nb2) {
	titre="Image du Quizzzzz";
	w=open("",'image','width='+nb1+',height='+nb2+',toolbar=no,scrollbars=no,resizable=no,left=100,top=0');	
	w.document.write("<HTML><HEAD><TITLE>"+titre+"</TITLE></HEAD>");
	w.document.write("<BODY BGCOLOR=black>")
	w.document.write("<center> <b> <font color=#00FF00> .. Veuillez patienter pendant le chargement de l'image .. </b> </center> </font>");
	w.document.write(" <br> ");
	w.document.write("<center><IMG src='"+img+"' border=0,  leftMargin=0 topMargin=0 marginwidth=0 marginheight=0></center>");
	w.document.write("<br>");
	w.document.write("<center> <b> <font color=#00FF00> .: Vous avez trouvé ? Alors retournez vite répondre !! :. </b> </center> </font>");
	w.document.write("</BODY></HTML>");
	w.document.close();
}
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">
function load() {
	if (document.images) {
		this.length=preload.arguments.length;
		for (var i=0;i<this.length;i++) {
			this[i+1]=new Image();
			this[i+1].src=preload.arguments[i];
		}
	}
}
function preload() {
	var temp=new load("images/quiz/mix2.png","images/quiz/Son grenade.wav","images/quiz/arme2.jpg","images/quiz/ct.jpg")
}
//-->
</SCRIPT>

<script language="JavaScript">
function PlayMusique() {
	eval("document.musique.play();");
}
</script>

<SCRIPT LANGUAGE="JavaScript">
function VerifForm()
	{
	var cbon=0;
	mail = document.form1.mail.value;
	pseudo = document.form1.pseudo.value;
			
	
		
	if (mail=='Votre adresse e-mail - VALIDE -')
		{
		alert('Le champ destinataire est Inchangé !');
		}
	else
		{
		var place2 = mail.indexOf("@",1);
	var point2 = mail.indexOf(".",place2+1);
	if ((place2 > -1)&&(mail.length >5)&&(point2 > 1))
		{
		cbon++;
		}
	else
		{
		alert('Le champ destinataire est invalide !');
		}
		cbon++;
		}
		
	if ((pseudo=='') || (pseudo=='Votre Pseudo'))
		{	
		alert('le champ Pseudo est Invalide');
		}
	else
		{
		cbon++;
		}
		
	if (cbon==3)
		{
		alert ('Merci d avoir participé à ce quizz  \n              .: Kirikiri :.');
		document.form1.submit();
		}
	
}	
</SCRIPT>

</HEAD>
<BODY BGCOLOR=#000000 TEXT=#FFFFFF LINK=#0000FF VLINK=#800080 ALINK=#FF0000>
<!-- <BODY BGCOLOR=#000000 TEXT=#FFFFFF LINK=#0000FF VLINK=#800080 ALINK=#FF0000 onUnload="Affiche()">
-->
<EMBED NAME='musique' SRC='images/quiz/Son grenade.wav' LOOP="0" MASTERSOUND AUTOSTART="0" WIDTH=10 HEIGHT=10 hidden="true">
<CENTER>

<TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=774>
  <TR>
    <TD WIDTH=175><IMG SRC="images/haut3a.jpg" BORDER=0 WIDTH=175 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
      <TD WIDTH=579 BACKGROUND=images/top_cs.gif CLASS=titre> Dossier QUIZZzzzz
        : WEB<BR>
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
    		<TD WIDTH=26><IMG SRC="images/cad_bleu_hg.gif" BORDER=0 WIDTH=25 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
    		<TD BACKGROUND=images/cad_bleue_h.gif WIDTH=523 CLASS=menu><B>Voici 
              mon Quizz Counter Strike : </B></TD>
    		<TD WIDTH=27><IMG SRC="images/cad_bleu_hd.gif" BORDER=0 WIDTH=27 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD WIDTH=26 BACKGROUND=images/cad_g.gif><IMG SRC="images/cad_g.gif" BORDER=0 WIDTH=25 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
    		<TD BGCOLOR=#4D574A WIDTH=523> <p>Voici le nouveau quizz traitant du sujet
    		    : <strong>Sites CS et Jeu Online.</strong></p>
    		  <p align="left">Ces questions sont assez faciles ! Alors bonne chances
    		    :-)</p>
              <form name="form1" method="post" action="http://kidlogis.com/kirikiri/cs/QwebConf.php">
                <p><strong><font color="#9BDEFF">1&deg;)
                      De combien de personne est constitu&eacute; la Team CS
                      ( les cr&eacute;ateurs
                      ) ?</font></strong></p>
                <p>
                  <select name="a" id="a">
                    <option value="1">- de 5
                    <option value="2">de 5 &agrave; 10
                    <option value="3">de 10 &agrave; 20
                    <option value="4">+ de 20                    
                  </select>                  
                </p>
                <p><strong><font color="#9BDEFF">                  2&deg;)
                      Quelle est la meilleur Team FR ? <br>
                      </font></strong><font color="#9BDEFF"><font color="#CCFFCC">( Au 12 Novembre 03 : World Cyber Games 2003 )
                      </font></font>                       </p>
                <p>
                  <select name="b" id="b">
                    <option value="1">GG
                    <option value="2">aAa
                    <option value="3">Dimension 4
                    <option value="4">A.I.B
                    <option value="5">Tr1b4L
                    <option value="6">Hostile
                    <option value="7">FairGame
                  </select>
                </p>
                <p><font color="#9BDEFF"><strong>3&deg;) Comment s'appelle le
                syst&egrave;me de protection dans cs 1.6 qui remplace WON ?</strong></font>                </p>
                <p>    
                  <label>
                  <input type="radio" name="c" value="1">
Won 1.6</label>
                  <br>
                  <label>
                  <input type="radio" name="c" value="2">
Stream</label>
                  <br>
                  <label>
                  <input type="radio" name="c" value="3">
Won II</label>
                  <br>
                  <label>
                  <input type="radio" name="c" value="4">
Steam</label>
                  <br>
                  <label>
                  <input type="radio" name="c" value="5">
SK ( Securiser Key )</label>
                  <br>
                </p>
                <p><strong><font color="#9BDEFF">4&deg;) Quel est le nom du Webmaster
                      principal du site tr&egrave;s connu : Vossey ?</font></strong></p>
                <p>                  
                  <select name="d" id="d">
                    <option value="1">BigBoss
                    <option value="2">Fragman
                    <option value="3">RazorBill
                    <option value="4">BenHur
                    <option value="5">Sn00py                    
                  </select>
                </p>
                <p> <br>
                  <font color="#9BDEFF"><strong>5&deg;) Laquelle de ces connexion
                  aura un ping le plus bas ?</strong></font></p>
                <p>
                  <label>
                  <input type="radio" name="e" value="1">
Modem RTC ( 56kb/s )</label>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#99FF99">Attention
                   : </font></strong><font color="#99FF99">Pi&egrave;ge ! </font><br>
                  <label>
                  <input type="radio" name="e" value="2">
Modem Numéris ( 64kbs/s )</label>
                  <br>
                  <label>
                  <input type="radio" name="e" value="3">
Cable 128 </label>
                  <br>
                  <label>
                  <input type="radio" name="e" value="4">
Adsl 512 FREE</label>
                  <br>
                  <label>
                  <input type="radio" name="e" value="5">
Morse . . - - - . - . . . - - -</label>
                </p>
                <p> <font color="#9BDEFF"><strong>6&deg;) Quel jour est sorti
                      Counter Strike 1.6 ?</strong></font></p>
                <p>                  
                  <label>                  </label>
                  <input name="textfield" type="text" value="12 Ao&ucirc;t 2003" disabled>
                  <input type="radio" name="f" value="1">
                  <br>
                  <input name="textfield2" type="text" value="12 Septembre 2003" disabled>
                  <input type="radio" name="f" value="2">
                  <br>
                  <input name="textfield3" type="text" value="12 octobre 2003" disabled>
                  <input type="radio" name="f" value="3">
                  <br>
                  <input name="textfield4" type="text" value="12 Novembre 2003" disabled>
                  <input type="radio" name="f" value="4">
                  <br>
                  <br>
                  <font color="#9BDEFF"><strong>7&deg;) Quels site se consacre
                  aux AMX M0d, Clan M0D, Meta M0d, Chiken M0d ...?</strong></font></p>
                <label>                
                <select name="g" id="g">
                  <option value="1">Vossey</option>
                  <option value="2">CscomFr</option>
                  <option value="3">Djeyl.net</option>
                  <option value="4">Counter Snip</option>
                  <option value="5">Cs France</option>
                  <option value="6">markilly's</option>
                  <option value="7">ZeroPing.com</option>
                </select>
                </label>
                <p> <font color="#9BDEFF"><strong>8&deg;) Quel constructeur sera
                      priviligi&eacute; dans HL 2 ?</strong></font></p>
                <p>
                  <label>
                  <input type="radio" name="h" value="1">
ATI</label>
                  <br>
                  <label>
                  <input type="radio" name="h" value="2">
Nvidia</label>
                  <br>
                  <label>
                  <input type="radio" name="h" value="3">
TNT</label>
                  <br>
                  <label>
                  <input type="radio" name="h" value="4">
IBM</label>
                  <br>
                </p>
                <p><font color="#9BDEFF"><strong>9&deg;) Que signifie &quot; CS-x
                      &quot; ?</strong></font></p>
                <p>
                  <select name="i" id="i">
                  <option value="1">Counter Strike Project X</option>
                  <option value="2">Counter Strike XXL</option>
                  <option value="3">Counter Strike x</option>
                  <option value="4">Counter Strike X-Box</option>
                  </select>
</p>
                <p><strong><font color="#9BDEFF">10&deg;) Quel nouveau super
                      site propose pleins de Supers QuiZz Cs ????</font></strong></p>
                <p><strong> 
                </strong>
                  <label>                  </label>
                  <label>
                  <input type="radio" name="j" value="1">
Cs france</label>
                  <br>
                  <label>
                  <input type="radio" name="j" value="2">
Counter Snip</label>
                  <br>
                  <label>
                  <input type="radio" name="j" value="3">
^Zone HL II^</label>
                  <br>
                  <label>
                  <input type="radio" name="j" value="4">
CsComFr</label>
                  <br>
                  <label>
                  <input type="radio" name="j" value="5">
???</label>
                  <br>
                  <br>
                  <br>
                  <strong><font color="#00FF00"><img src="images/Puces/puceverte.gif" width="10" height="10"> Qui &ecirc;tes-vous
                  ? <font color="#FF0000">/!\ 
                  A REMPLIR ABSOLUMENT ! /!\
                  <input name="temps" type="hidden" id="temps" value="temps">
                  </font></font></strong></p>
                <table width="98%" border="0">
                  <tr>
                    <td><p>
                      <input name="mail" type="text" id="mail" value="Votre adresse e-mail -{ VALIDE&nbsp;}-" size="50" onFocus="this.value=''">
                        &nbsp;&nbsp;&nbsp;&nbsp; 
                        <input name="pseudo" type="text" id="002_Speudo" value="Votre Pseudo" onFocus="this.value=''">
                        <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        </p>
                    </td>
                  </tr>
                </table>
                <p align="center">
                <input name="bout" type="button" id="bout"  onClick="VerifForm(),this.value='En cours d&#8217;envoie ...'" value="Envoyer">                                
              </form>
              <p align="center"><font color="#CCCCCC">Copyright 2003-2004<br>
              Cr&eacute;ateur des Quizz : <a href="mailto:sniperman.cs@laposte.net">kirikiri</a></font></p>
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
