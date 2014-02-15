<? ob_start("ob_gzhandler"); ?> 
<html>
<head>
<title>Confirmation :</title>
<body bgcolor="#000000" text="#66FF00" link="#C0FF97" vlink="#003300" alink="#FFFF00">
<?php
// On verifie que la personne n'a pas déja joué grace aux cookies
if($_COOKIE['csnip123456']=="oui")
{
print "<script language=javascript>window.alert ('Vous avez déja joué à ce quizz dans la semaine !')</script>";
print "<script language=javascript>window.alert ('Vous n'avez pas le droit !')</script>";
print "<script language=javascript>window.alert ('A bientôt !!!!!!')</script>";
print "<script language=javascript>window.location=\"http://sniperman.free.fr\"</script>";
break;
}

// On definit les variables :
$points=0;
$demipoints=0;

$adresseip="$REMOTE_ADDR";
$date = date("d-m-Y");
$date2 = date("d-m");
$heure = date("H:i");

if ($mail=="")
{
print "<script language=javascript>window.alert ('Vous n\'avez pas mis votre email !!')</script>";
print "<script language=javascript>window.alert ('Faites précédents dans votre navigateur ...')</script>";
break;
}

if ($pseudo=="")
{
print "<script language=javascript>window.alert ('Vous n\'avez pas mis votre Pseudo !!')</script>";
print "<script language=javascript>window.alert ('Faites précédents dans votre navigateur ...')</script>";
break;
}

// On note les bonnes reponses

#   -- Question 1 --
if (($a>=4650)&&($a<=4850))
{
$points++;
}
if (($a>=4600)&&($a<4650))
{
$demipoints++;
}
if (($a>4850)&&($a<=4900))
{
$demipoints++;
}

#   -- Question 2 --
if (($b>=3000)&&($b<=3200))
{
$points++;
}
if (($b>=2900)&&($b<3000))
{
$demipoints++;
}
if (($b>3200)&&($b<=3300))
{
$demipoints++;
}

#   -- Question 3 --
if ($c=="sensitivity")
{
$points++;
}
if ($c=="sensibility")
{
$demipoints++;
}

#   - Question 4 --
if ($d=="net_graphpos")
{
$points++;
}
if ($d=="net_graphpos 3")
{
$points++;
}
if ($d=="netgraph_pos")
{
$demipoints++;
}
if ($d=="netgraph_pos 3")
{
$demipoints++;
}

#   - Question 5 --
if ($e=="changelevel")
{
$points++;
}
if ($e=="rcon_changelevel")
{
$demipoints++;
}

#   - Question 6 --
if ($f==120)
{
$points++;
}


#   - Question 7 --
if ($g==4)
{
$points++;
}
if ($g==3)
{
$demipoints++;
}

#   - Question 8 --
if (($h==2)||($h==3))
{
$points++;
}

#   - Question 9 --
if ($i==5)
{
$points++;
}

#   - Question 10 --
if (($j>=2550)&&($j<=2950))
{
$points++;
}
if ($j==3000)
{
$demipoints++;
}

#   - Question 11 --
if (($k>=800)&&($k<=1200))
{
$points++;
}

#   - Question 12 --
if (($l>=3100)&&($l<=3500))
{
$points++;
}
if (($l==3000)||($l==3050))
{
$demipoints++;
}

#   - Question 13 --
if (($m=="B")||($m=="b"))
{
$points++;
}

#   - Question 14 --
if ($n==3)
{
$points++;
}

#   - Question 15 --
if ($o==51)
{
$points++;
}

#   - Question 16 --
if ($p==99)
{
$points++;
}
if (($p==98)||($p==2000))
{
$demipoints++;
}

#   - Question 17 --
if ($q=="takescreen")
{
$points++;
}
if ($q=="screenshot")
{
$demipoints++;
}

#   - Question 18 --
if ($r==27015)
{
$points++;
}

#   - Question 19 --
if ($s==1)
{
$points++;
}

#   - Question 20 --
if ($t==4)
{
$points++;
}

// On calcule le score
$demipoints=$demipoints/2;
$points=$points+$demipoints;

if (($points==0)||($points==0.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 0/20 .: Nul Nul et Nul ! :.')</script>"; }
if (($points==1)||($points==1.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 1/20 .: Nul :.')</script>"; }
if (($points==2)||($points==2.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 2/20 .: Nul :.')</script>"; }
if (($points==3)||($points==3.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 3/20 .: Nul :.')</script>"; }
if (($points==4)||($points==4.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 4/20 .: Médiocre :.')</script>"; }
if (($points==5)||($points==5.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 5/20 .: Médiocre :.')</script>"; }
if (($points==6)||($points==6.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 6/20 .: Peut mieux faire :.')</script>"; }
if (($points==7)||($points==7.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 7/20 .: Peut mieux faire :.')</script>"; }
if (($points==8)||($points==8.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 8/20 .: Peut mieux faire :.')</script>"; }
if (($points==9)||($points==9.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 9/20 .: Passable :.')</script>"; }
if (($points==10)||($points==10.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 10/20 .: Passablr :.')</script>"; }
if (($points==11)||($points==11.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 11/20 .: Vous êtes dans la moyenne :.')</script>"; }
if (($points==12)||($points==12.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 12/20 .: Assez Bien :.)</script>"; }
if (($points==13)||($points==13.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 13/20 .: Bien Good Job:.')</script>"; }
if (($points==14)||($points==14.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 14/20 .: Bien Verry Good Job :.')</script>"; }
if (($points==15)||($points==15.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 15/20 .: Très Bien :.')</script>"; }
if (($points==16)||($points==16.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 16/20 .: Super Bien .:. Extremly very Good Job :.')</script>"; }
if (($points==17)||($points==17.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 17/20 .: Méga Supra Extra Bien .:. Bravo :.')</script>"; }
if (($points==18)||($points==18.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 18/20 .: Excellent .:. Presque parfait :.')</script>"; }
if (($points==19)||($points==19.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 19/20 .: Excellent .:. Encore un petit effort :.!')</script>"; }
if ($points==20) { print "<script language=javascript>window.alert ('Votre score est d environ : 20/20 .: Parfait .:. Mais je pense que vous avez triché :...')</script>"; }

// Preparation de lemail pour moi :
$message .= "Pseudo : $pseudo\n";
$message .= "Email  : $mail\n";
$message .= "type   : $koi\n\n";
$message .= "IP     : $adresseip\n";
$message .= "Date   : $date\n";
$message .= "Heure  : $heure\n";
$message .= "\n\nNote   : $points\n\n";
$message .= "\n\n-------------------- Réponses -----------------\n";
$message .= "Pseudo : $pseudo\n";
$message .= "Email  : $mail\n";
$message .= "type   : $koi\n\n";
$message .= "IP     : $adresseip\n";
$message .= "Date   : $date\n";
$message .= "Heure  : $heure\n";
$message .= "\n\nNote   : $points\n\n";
$message .= "\n\n-------------------- Réponses -----------------\n";
$message .= "01 : $a -> 4750\n";
$message .= "02 : $b -> 3100\n";
$message .= "03 : $c -> sensitivity\n";
$message .= "04 : $d -> net_graphpos\n";
$message .= "05 : $e -> changelevel\n";
$message .= "06 : $f -> 120\n";
$message .= "07 : $g -> 4\n";
$message .= "08 : $h -> 2 ou 3\n";
$message .= "09 : $i -> 5\n";
$message .= "10 : $j -> 2750\n";
$message .= "11 : $k -> 1000\n";
$message .= "12 : $l -> 3300\n";
$message .= "13 : $m -> B\n";
$message .= "14 : $n -> 3\n";
$message .= "15 : $o -> 51\n";
$message .= "16 : $p -> 99\n";
$message .= "17 : $q -> takescreen\n";
$message .= "18 : $r -> 27015\n";
$message .= "19 : $s -> 1\n";
$message .= "20 : $t -> 4\n";
$head .= "From:$mail\n";
$head .= "X-Priority:1\n";


// Envoie email pour moi
@mail("snake.spm@laposte.net","-- Nouveau Quizz --","$message","$head"); 


// Preparation email pour lui
$message1 = "<body bgcolor=#4D574A text=#FFFFFF link=#66CCFF vlink=#003366 alink=#66FFFF><p><font color=#FFFF00 size=+1><B>Salutations,</B></font></p><p>Voici le mail de confirmation &agrave  votre participation au Grand QuiZZzzz Counter Snip.<br> J ai l honneur de vous annoncer votre résultat du quizz Counter Snip :<br> <br> <B>Votre Pseudo &nbsp &nbsp :</B> <font color=#00FF00>$pseudo</font><br> <B>Votre Score &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$points /20 </font><br> <B>Classement &nbsp &nbsp &nbsp :</B> <font color=#00FF00><a href=sniperman.free.fr/cs_quizResultat.html>Page de Résultat</a></font><br> <B>Date-Heure &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$date - $heure</font></p><p><br> Pour info, à la date du $date2,<I> <font color=#FFCC33>Araminet</font></I> est 1er avec <font color=#FFCC33>19/20</font><br> La moyenne des scores est de : <B><font color=#00CCFF>11.56</font></B><font color=#00CCFF>/ 20.</font><br> <br> Les résultas TEMPORAIRE et NON - CLOTURE du quizz sont dispo <a href=http://sniperman.free.fr><B>---ici---</B></a> dans les news.<br> <br> je tiens à préciser que ce module de quizz n aura plus aucun retard gràce à un gros travail qui abouti à la creation d un script PHP qui fait tout pour moi !<br><br> Merci encore d avoir participé à ce quizz</p><font size=2>Attention : Ne tenez pas compte de votre score qui ne doit sûrement pas être élevé. Le quizz est très difficile mais tout les participants partent du même point.<p align=center></font><br> <font color=#FFFF00><B><br> Kirikiri-kiriiiii<br> <font color=#00FF00>http://www.countersnip.fr.st</font></B></font></p><p align=center>&nbsp </p><p align=center>&nbsp </p><p align=center><font color=#999999 size=+2><br> <font size=-2>ps : si vous êtes class&eacute  parmi les 5 premiers au classement d&eacute finitif, veuillez m avertir pas mail pour récupérer ce qui vous revient.</font></font><br></p>";
$head1 .= "From:Webmaster CounterSnip\n";
$head1 .= "X-Priority:1\n";
$head1 .= "X-Mailer: CounterSnip-Mailer par Kirikiri\n";
$head1 .= "Content-Type: text/html; charset=iso-8859-1\r\n";

// Envoie email pour lui
@mail("$mail","-- Résultat du Quizz CounterSnip --","$message1","$head1"); 

// Enregistrement dans fichier txt
$ouvrir=fopen("copie.txt","a+"); 
fputs($ouvrir," ||$adresseip - $date - $heure - $pseudo - $points /20                  ||" );
fclose($ouvrir);

// Cookies pour ne pas jouer deux fois en une semaine
setcookie("csnip123456","oui", mktime()+604800);
?>
<div align="left">
  <p align="right"><strong><a href="http://sniperman.free.fr/cs_quizResultat.html">&lt;= 
    Retour au site</a></strong></p>
  <p><strong><u>Etapes : </u></strong></p>
  <p> <font size="2">&nbsp;-&nbsp;R&eacute;ception des donn&eacute;es : <font color="#66FFFF"><code>OK</code></font><br>
    &nbsp;- Cr&eacute;ation des variables : <font color="#66FFFF"><code>OK</code></font><br>
    &nbsp;-&nbsp;Correction du Quizz : <font color="#66FFFF"><code>OK</code></font><br>
    &nbsp;- Affichage du r&eacute;sultat : <font color="#66FFFF"><code>OK</code></font><br>
    &nbsp;- Envoie du mail au Webmaster : <font color="#66FFFF"><code>OK</code></font><br>
    &nbsp;- Envoie de mail au joueur : <font color="#66FFFF"><code>OK</code></font></font></p>
  <p>Toutes les &eacute;tapes sont r&eacute;ussis !</p>
  <p>&nbsp;</p>
  <p align="center"><font color="#FFFF00" size="4">Vous allez recevoir un mail
       de confirmation</font></p>
  <p align="center"><font color="#66CCFF" size="4">Si vous pensez que votre note
       a &eacute;t&eacute; mal &eacute;valu&eacute;e, contactez moi <a href="http://sniperman.free.fr/site_contact.html">ici</a></font></p>
  <p align="center"><strong><font color="#999999">@ Bient&ocirc;t sur Counter-Snip 
    !</font></strong></p>
  <p align="center"><strong>--&gt;--&gt;--&gt;<a href="http://www.maxiservices.net/livre/livre.php3?id=2810%20" target="_blank"><img src="http://sniperman.free.fr/images/Autres/vivredor.jpg" width="120" height="60" border="0" align="absmiddle" lowsrc="Livre%20d%27or%20!"></a> 
    &lt;--&lt;--&lt;--<br>
    Aller poster ici pour dire<br>
    ce que vous en pensez !</strong></p>
  <p align="center">&nbsp;
    <script src="http://www.ovnet.net/compteur.php?13289"></script>
  </p>
</div>
</html>
<? ob_end_flush(); ?> 