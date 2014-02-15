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
function simplePreload('images/quiz/mix2.png','images/quiz/arme2.jpg','images/quiz/ct.jpg')
{ 
  var args = simplePreload.arguments;
  document.imageArray = new Array(args.length);
  for(var i=0; i<args.length; i++)
  {
    document.imageArray[i] = new Image;
    document.imageArray[i].src = args[i];
  }
}
</SCRIPT>

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
<CENTER>

<TABLE CELLPADDING=0 CELLSPACING=0 WIDTH=774>
  <TR>
    <TD WIDTH=175><IMG SRC="images/haut3a.jpg" BORDER=0 WIDTH=175 HEIGHT=61 HSPACE=0 VSPACE=0></TD>
      <TD WIDTH=579 BACKGROUND=images/top_cs.gif CLASS=titre> Dossier QUIZZzzzz :
        Armes<BR>
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
    		<TD BACKGROUND=images/cad_bleue_h.gif WIDTH=523 CLASS=menu><B>Voici 
              mon Quizz Counter Strike : </B></TD>
    		<TD WIDTH=27><IMG SRC="images/cad_bleu_hd.gif" BORDER=0 WIDTH=27 HEIGHT=37 HSPACE=0 VSPACE=0></TD>
  		</TR>
  		<TR>
    		<TD WIDTH=25 BACKGROUND=images/cad_g.gif><IMG SRC="images/cad_g.gif" BORDER=0 WIDTH=25 HEIGHT=20 HSPACE=0 VSPACE=0></TD>
    		<TD BGCOLOR=#4D574A WIDTH=523> <p>Voici le nouveau quizz traitant du sujet
    		    : <strong>Les Armes de Counter Strike 1.5</strong></p>
    		  <p align="left">Escusez-moi si je ne parle pas encore du Famas,
                Galil ou autre nouvelle arme de cs 1.6, cela car je viens juste
                d'avoir cette version que je ne connais pas encore bien !</p>
              <p align="left">Les questions sont dans l'ensemble assez de niveau
                MOYEN sauf quelques-unes :-)</p>
              <form name="form1" method="post" action="http://kidlogis.com/kirikiri/cs/QarmeConf.php">
                <p><strong><font color="#9BDEFF">1&deg;)
                      Quel est ce bruit ? </font><font color="#99FF66"><font color="#9BDEFF"><strong><font color="#CC6600">
                      <embed src='../../images/quiz/Son%20grenade.wav' width=50 height=25 autostart="0" align="absmiddle" name='musique'></embed>
                      </font></strong></font></font></strong></p>
                <p>                  
                  <select name="Q1" id="Q1">
                    <option value="nul">                    
                    <option value="flash">Une Flashbang qui p&egrave;te
                    <option value="terro">Un terro qui se soulage
                    <option value="fumi">un fumig&egrave;ne en action
                    <option value="coca">un urban buvant du coca
                  </select>
                </p>
                <p><strong><font color="#9BDEFF">2&deg;)
                      Combien co&ucirc;te un Pistolet
                      Desert Eagle ?</font></strong></p>
                <p> 
                  <input name="Q2" type="text" id="Q2" size="10" maxlength="10">
                  <font color="#99FF66">$ - ( 200$ pr&egrave;s )</font></p>
                <p><font color="#9BDEFF"><strong>3&deg;) Combien de balles rentre
                      dans une UMP [ 3-5 ] ?</strong></font></p>
                <p> 
                  <input name="Q3b" type="text" id="Q3b" value="chargeur" size="15" maxlength="15" onfocus="this.value=''">
- 
<input name="Q3" type="text" id="Q3" value="r&eacute;serve" size="15" maxlength="15" onfocus="this.value=''">
 <font color="#99FF66">(  <strong>Chargeur</strong> | <strong>R&eacute;serve</strong>  : Environ &agrave; 15 pr&eacute;s
 )</font></p>
                <p><strong><font color="#9BDEFF">4&deg;) Quel est la position
                      dans le menu d'achat du Ingram Mac 10</font></strong></p>
                <p> 
                  <input name="Q4" type="text" id="Q4" value="x-x" size="15" maxlength="15" onfocus="this.value=''">
                  <font color="#99FF66">- (exemple : <strong>1-3 </strong> =
                  Desert Eagle)</font></p>
                <p> <br>
                  <font color="#9BDEFF"><strong>5&deg;) Quel est le nom de l'arme
                  de cette photo : <a href="javascript:PopupImage('images/quiz/arme2.jpg',400,250)" class="liens">[ Voir ]</a></strong></font></p>
                <p>
                  <select name="Q5" id="select">
                    <option value="0"></option>
                    <option value="cout">Couteau</option>
                    <option value="1-2">Pistolet : GLOCK</option>
                    <option value="1-1">Pistolet : USP</option>
                    <option value="1-4">Pistolet : Sig P228</option>
                    <option value="1-3">Pistolet : Desert Eagle</option>
                    <option value="1-6">Pistolet : Fiveseven</option>
                    <option value="1-5">Pistolet : Dual Beretta</option>
                    <option value="2-2">Pompe : Automatique</option>
                    <option value="2-1">Pompe : Manuel</option>
                    <option value="3-3">Mitraillette : FN P90</option>
                    <option value="mp5">Mitraillette : MP5</option>
                    <option value="3-4">Mitraillette : MAC 10</option>
                    <option value="3-5">Mitraillette : UMP</option>
                    <option value="3-2">Mitraillette : Steyr TMP </option>
                    <option value="4-2">Fusil : Sig Commandos</option>
                    <option value="4-4">Fusil : Streyr aug</option>
                    <option value="4-1">Fusil : Ak 47</option>
                    <option value="4-3">Fusil : Colt M4A1</option>
                    <option value="4-6">Sniper : AWP</option>
                    <option value="4-7/8">Sniper : G3/SG1 &amp; Sig 550 </option>
                    <option value="4-5">Sniper : Streyr Scout </option>
                    <option value="51">Machin Gun</option>
                  </select>
                </p>
                <p> <font color="#9BDEFF"><strong>6&deg;) Est-ce que les balles
                      du MP5 passe &agrave; travers les portes ou les murs ?</strong></font></p>
                <p>                  
                  <label>
                  <input type="radio" name="Q6" value="oui">
oui</label>
                  <br>
                  <label>
                  <input type="radio" name="Q6" value="non">
non</label>
                  <br>
                  <br>
                  <br>
                  <font color="#9BDEFF"><strong>7&deg;) Que change le silencieux
                  au Colt M4A1 [ 4-3 ]</strong></font></p>
                <label> 
                  <input type="radio" name="Q7" value="r1">
</label>
                + Pr&eacute;cis, + Puissant<br>
                  <label> 
                  <input type="radio" name="Q7" value="r2">
                  - Pr&eacute;cis,</label>
                   - Puissant&nbsp; <br>
                  <label> 
                  <input name="Q7" type="radio" value="r3">
                  + Pr&eacute;cis, - Puissant</label>
                  <br>
                  <label> 
                  <input name="Q7" type="radio" value="r4">
                - Pr&eacute;cis, + Puissant</label>
                <p> <font color="#9BDEFF"><strong>8&deg;) Lequel des 2 fusils
                      &agrave; Pompes contient le plus de balles dans un chargeur
                      ?</strong></font></p>
                <p> 
                  <input name="Q8" type="radio" id="08" value="r1">
                   M3 [ 2-1 ] &nbsp;&nbsp;&nbsp;&nbsp;<font color="#99FF66"><strong>Aide
                   :</strong> Fusil Manuel</font><br>
                  <input name="Q8" type="radio" id="08" value="r2">
                  XM [ 2-2 ] &nbsp;&nbsp;&nbsp;&nbsp;<font color="#99FF66"><strong>Aide
                  :</strong> Fusil Auto</font><br>
                </p>
                <p><font color="#9BDEFF"><strong>9&deg;) Quel arme ce &quot;personnage&quot;
                      a-t-il dans les mains ? <a href="javascript:PopupImage('images/quiz/ct.jpg',400,400)" class="liens">[
                      Voir Image ]</a></strong></font></p>
                <p>
                  <select name="Q9" id="select2">
                    <option value="0"></option>
                    <option value="cout">Couteau</option>
                    <option value="1-2">Pistolet : GLOCK</option>
                    <option value="1-1">Pistolet : USP</option>
                    <option value="1-4">Pistolet : Sig P228</option>
                    <option value="1-3">Pistolet : Desert Eagle</option>
                    <option value="1-6">Pistolet : Fiveseven</option>
                    <option value="1-5">Pistolet : Dual Beretta</option>
                    <option value="2-2">Pompe : Automatique</option>
                    <option value="2-1">Pompe : Manuel</option>
                    <option value="fn">Mitraillette : FN P90</option>
                    <option value="mp5">Mitraillette : MP5</option>
                    <option value="3-4">Mitraillette : MAC 10</option>
                    <option value="3-5">Mitraillette : UMP</option>
                    <option value="3-2">Mitraillette : Steyr TMP </option>
                    <option value="4-2">Fusil : Sig Commandos</option>
                    <option value="4-4">Fusil : Streyr aug</option>
                    <option value="4-1">Fusil : Ak 47</option>
                    <option value="4-3">Fusil : Colt M4A1</option>
                    <option value="4-6">Sniper : AWP</option>
                    <option value="4-7/8">Sniper : G3/SG1 &amp; Sig 550 </option>
                    <option value="4-5">Sniper : Streyr Scout </option>
                    <option value="51">Machin Gun</option>
                  </select>
                </p>
                <p><strong><font color="#9BDEFF">10&deg;) Laquelle de ces armes
                      est un SG-552 [ 4-2 ] ? <strong><a href="javascript:PopupImage('images/quiz/mix2.png',550,530)" class="liens">[
                      Voir Image ]</a></strong></font></strong></p>
                <p><strong> 
                </strong>
                  <label>
                  <input type="radio" name="Q10" value="a">
A</label>
                  <br>
                  <label>
                  <input type="radio" name="Q10" value="b">
B</label>
                  <br>
                  <label>
                  <input type="radio" name="Q10" value="c">
C</label>
                  <br>
                  <label>
                  <input type="radio" name="Q10" value="d">
D</label>
                  <br>
                  <br>
                  <font color="#99FF66"><strong>Aide :</strong> Regardez bien le n&deg; de l'arme</font></p>
                <p><br>
                  <br>
                  <strong><font color="#00FF00"><img src="images/Puces/puceverte.gif" width="10" height="10"> Qui &ecirc;tes-vous
                  ? <font color="#FF0000">/!\ 
                  A REMPLIR ABSOLUMENT ! /!\
                  <input name="temps" type="hidden" id="temps" value="temps">
                  </font></font></strong></p>
                <table width="98%" border="0">
                  <tr>
                    <td><p>
                      <input name="mail" type="text" id="mail" value="Votre adresse e-mail - VALIDE&nbsp;-" size="50" onFocus="this.value=''">
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
  	</TABLE><a href="http://www.xiti.com/xiti.asp?s=98910" TARGET="_top">
<br>
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
</noscript><!--//--></a><BR>
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
