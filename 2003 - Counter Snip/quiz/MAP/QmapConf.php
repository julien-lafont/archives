<html>
<head>
<title>Confirmation : Quiz MAP</title>
<body bgcolor="#000000" text="#66FF00" link="#C0FF97" vlink="#FFFFFF" alink="#FFFF00">
<?php

// On verifie que la personne n'a pas déja joué grace aux cookies
if($_COOKIE['csnipMAP']=="oui")
{
print "<script language=javascript>window.alert ('Vous avez déja joué à ce quizz dans la semaine !')</script>";
print "<script language=javascript>window.alert ('Mais vous pouvez quand même le Refaire!')</script>";
}

// On definit les variables :
$points=0;
$demipoints=0;

$adresseip="$REMOTE_ADDR";
$date = date("d-m-Y");
$date2 = date("d-m");
$heure = date("H:i");

// On note les bonnes reponses

#   -- Question 1 --
if ($a=="prodigy")
{
$points++;
$Q1=1;
}

#   -- Question 2 --
if ($b==2)
{
$points++;
$Q2=1;
}

#   -- Question 3 --

if ($c=='assault')
{
$points++;
$Q3=1;
}

#   - Question 4 --
if ($d=='chateau')
{
$points++;
$Q4=1;
}

#   - Question 5 --
if ($e=="militia")
{
$points++;
$Q5=1;
}

#   - Question 6 --
if ($f=='piranesi')
{
$points++;
$Q6=1;
}

#   - Question 7 --
if ($g=='militia')
{
$points++;
$Q7=1;
}

#   - Question 8 --
if ($h=='aztec')
{
$points++;
$Q8=1;
}
if ($h=='dust')
{
$points++;
$Q8=1;
}
if ($h=='dust2')
{
$points++;
$Q8=1;
}

#   - Question 9 --
if ($i=='siege')
{
$points++;
$Q9=1;
}

#   - Question 10 --
if ($j=='survivor')
{
$points++; 
$Q10=1;
}

// On calcule le score

if (($points==0)||($points==0.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 0/10  .: Nul Nul et Nul ! :. ')</script>"; }
if (($points==1)||($points==1.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 1/10  .: Nul :. ')</script>"; }
if (($points==2)||($points==2.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 2/10  .: Médiocre :. ')</script>"; }
if (($points==3)||($points==3.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 3/10  .: Peut mieux faire :. ')</script>"; }
if (($points==4)||($points==4.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 4/10  .: Passable :. ')</script>"; }
if (($points==5)||($points==5.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 5/10  .: Vous avez la moyenne :. ')</script>"; }
if (($points==6)||($points==6.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 6/10  .: Assez Bien :. ')</script>"; }
if (($points==7)||($points==7.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 7/10  .: Bien : Good Job :. ')</script>"; }
if (($points==8)||($points==8.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 8/10  .: Très Bien :. ')</script>"; }
if (($points==9)||($points==9.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 9/10  .: Méga Supra Extra Bien :. ')</script>"; }
if ($points==10) { print "<script language=javascript>window.alert ('Votre score est d environ : 10/10  .: Parfait ! Voici enfin un vrai CSeur ! :. ')</script>"; }

// Preparation de lemail pour moi :
$message .= "Pseudo : $pseudo\n";
$message .= "Email  : $mail\n";
$message .= "Quizz   : Arme\n\n";
$message .= "IP     : $adresseip\n";
$message .= "Date   : $date\n";
$message .= "Heure  : $heure\n";
$message .= "\n\nNote   : $points\n\n";
$message .= "\n\n-------------------- Réponses -----------------\n\n\n";
$message .= "01 : $Q1 \n";
$message .= "02 : $Q2 \n";
$message .= "03 : $Q3 \n";
$message .= "04 : $Q4 \n";
$message .= "05 : $Q5 \n";
$message .= "06 : $Q6 \n";
$message .= "07 : $Q7 \n";
$message .= "08 : $Q8 \n";
$message .= "09 : $Q9 \n";
$message .= "10 : $Q10 \n";
$head .= "From:$mail\n";
$head .= "X-Priority:1\n";


// Envoie email pour moi
mail("sniperman.cs@laposte.net","-- Nouveau Quizz MAP --","$message","$head"); 


// Preparation email pour lui
$message1 = "<body bgcolor=#4D574A text=#FFFFFF link=#66CCFF vlink=#003366 alink=#66FFFF><p><font color=#FFFF00 size=+1><B>Salutations,</B></font></p><p>Voici le mail de confirmation &agrave  votre participation au Grand QuiZZzzz Counter Snip.<br> J ai l honneur de vous annoncer votre résultat du quizz Counter Snip <b> MAP </b>:<br> <br> <B>Votre Pseudo &nbsp &nbsp :</B> <font color=#00FF00>$pseudo</font><br> <B>Votre Score &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$points /10 </font><br> <B>Classement &nbsp &nbsp &nbsp :</B> <font color=#00FF00><a href=http://sniperman.free.fr/cs_quiz.php>Page de Résultat</a></font><br> <B>Date-Heure &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$date - $heure</font></p></font><br>Je tiens à préciser que ce module de quizz n aura plus aucun retard gràce à un gros travail qui abouti à la creation de plusieurs scripts PHP qui font tout pour moi :-)<br><br> Merci encore d avoir participé à ce quiZzzz.</p><p align=center><font color=#FFFF00><B> Kirikiri-kiriiiii<br>http://www.countersnip.fr.st</B></font></p>";
$head1 .= "From:Quiz@CounterSnip.fr\n";
$head1 .= "Reply-To:sniperman.cs@laposte.net\n";
$head1 .= "X-Priority:1\n";
$head1 .= "X-Mailer: CounterSnip-Mailer par Kirikiri\n";
$head1 .= "Content-Type: text/html; charset=iso-8859-1\r\n";

// Envoie email pour lui
mail("$mail","-- Résultat du Quizz CounterSnip : MAP --","$message1","$head1"); 

// Enregistrement dans fichier txt
$ouvrir=fopen("map.txt","a+"); 
fputs($ouvrir," ||$adresseip - $date - $heure - $pseudo - $points /10                  ||\n" );
fclose($ouvrir);



echo ("<iframe src='http://sniperman.free.fr/mapMysql.php?pseudo=$pseudo&points=$points?' width='0' height='0'>pbm</iframe>");
?>
<strong><u>Etapes : </u></strong>
<p> <font size="2">&nbsp;-&nbsp;R&eacute;ception des donn&eacute;es : <font color="#66FFFF"><code>OK</code></font><br>
  &nbsp;-&nbsp;Correction du Quizz : <font color="#66FFFF"><code>OK</code></font><br>
  &nbsp;- Affichage du r&eacute;sultat : <font color="#66FFFF"><code>OK</code></font><br>
  &nbsp;- Envoie de mail au joueur : <font color="#66FFFF"><code>OK<br>
  </code></font></font>Toutes
les &eacute;tapes sont r&eacute;ussis !</p>
<p align="left"><font color="#00FF00" size="4">Vous allez recevoir un mail
    de confirmation</font></p>
<p align="center"><strong><font color="#FFFF00" size="+1">Voici les r&eacute;ponces
      du Quizz MAP<br>
 </font></strong><font color="#FFFF00" size="+1"><font color="#FFFFFF">[ Pour
 des r&eacute;sultats plus d&eacute;taill&eacute;s
: <a href="http://sniperman.free.fr/cs_Qmaps_Corr.php">ici</a> ]</font></font></p>
<p align="left"><strong><font color="#9BDEFF">  1</font><font color="#9BDEFF">&deg;)
Quel est cette map ? ( Ecrans d'ordinateurs derri&egrave;re une vitre )</font></strong></p>
<p align="left">  
  <select name="a" id="a">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" selected STYLE="background-color:#00FF00;color=blue">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select> 
  <strong><font color="#9BDEFF">
  <? if ($Q1==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
</font></strong></p>
<p align="left"><strong><font color="#9BDEFF"><strong>2&deg;) Cette map est elle
CS, DE ou AS ?</strong></font></strong></p>
<p align="left">
  <select name="select9" id="select9">
  <option value="CS"style="background-color:#FF0000;color=#FFFFFF">CS
  <option value="DE" selected STYLE="background-color:#00FF00;color=blue">DE
  <option value="AS" style="background-color:#FF0000;color=#FFFFFF">AS  
  </select>
  <strong><font color="#9BDEFF">
  <? if ($Q2==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  </font></strong></p>
<p align="left"><font color="#9BDEFF"><strong>3&deg;) Sur quel map trouvons nous
      cet entr&eacute;e de b&acirc;timent ?<font color="#9BDEFF">
      </font></strong></font></p>
<p align="left">  <font color="#9BDEFF"><strong><font color="#9BDEFF">
  <select name="select" id="select">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" selected STYLE="background-color:#00FF00;color=blue">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q3==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
</font></strong></font></p>
<p align="left"><strong><font color="#9BDEFF">4</font><font color="#9BDEFF">&deg;)
Quel est cette map ? ( Tonneau de Vin ) </font></strong></p>
<p align="left">  <strong><font color="#9BDEFF">
  <select name="select2" id="select10">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" selected STYLE="background-color:#00FF00;color=blue">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q4==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
</font></strong></p>
<p align="left"> <br>
    <font color="#9BDEFF"><strong>5&deg;) Sur quel map pouvons nous trouver un
    mini stand de tir ? <font color="#CC6600"></font></strong></font></p>
<p align="left">  <strong><font color="#9BDEFF">
  <select name="select3" id="select3">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" selected STYLE="background-color:#00FF00;color=blue">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q5==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  </font></strong></p>
<p align="left"> <font color="#9BDEFF"><strong><font color="#9BDEFF">6</font><font color="#9BDEFF">&deg;)
Sur quelle map les terroristes commencent sur un b&acirc;teau ? <font color="#CC6600"></font></font></strong></font></p>
<p align="left">
  <label>  </label>
  <label></label>
  <strong><font color="#9BDEFF">
  <select name="select4" id="select4">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" selected STYLE="background-color:#00FF00;color=blue">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q6==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  </font></strong><br>
</p>
<p><font color="#9BDEFF"><strong>7&deg;) Dans quel map trouvons nous une crotte
explosive ? lol !</strong></font></p>
<label></label>
<strong>
<font color="#9BDEFF">
<select name="select5" id="select2">
  <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
  <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
  <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
  <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
  <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
  <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
  <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
  <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
  <option value="militia" selected STYLE="background-color:#00FF00;color=blue">cs_militia</option>
  <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
  <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
  <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
  <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
  <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
  <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
  <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
  <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
  <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
  <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
  <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
  <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
  <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
  <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
  <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
  <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
  <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
</select>
</font>
<? if ($Q7==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
</strong><br>
<label></label>
<p><font color="#9BDEFF"><strong>8&deg;) Quel est la map la plus jou&eacute; (
source : Clubic ) ?</strong></font></p>
<p><strong><font color="#9BDEFF">
  <font color="#00FF00">ou 
  </font>
  <select name="select6" id="select6">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" selected STYLE="background-color:#00FF00;color=blue">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q8==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  <br>
  <font color="#00FF00">ou</font>  </font><font color="#00FF00" size="1"><strong>
  <select name="select10" id="select13">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" selected STYLE="background-color:#00FF00;color=blue">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  </strong></font><font color="#9BDEFF"><br>
  <font color="#00FF00">ou</font>  </font><font color="#00FF00" size="1"><strong>
  <select name="select11" id="select12">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" selected STYLE="background-color:#00FF00;color=blue">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  </strong></font></strong><br>
  <font color="#99FF66">&nbsp;&nbsp;</font></p>
<p><font color="#9BDEFF"><strong><font color="#9BDEFF">9</font><font color="#9BDEFF">&deg;)
Dans dans map ya t-il un semblant de mine de charbon ? <font color="#CC6600"></font></font></strong></font></p>
<p> <font color="#99FF66">  <strong><font color="#9BDEFF">
  <select name="select7" id="select7">
    <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
    <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
    <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
    <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
    <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
    <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
    <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
    <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
    <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
    <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
    <option value="siege" selected STYLE="background-color:#00FF00;color=blue">cs_siege</option>
    <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
    <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
    <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
    <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
    <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
    <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
    <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
    <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
    <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
    <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
    <option value="survivor" style="background-color:#FF0000;color=#FFFFFF">de_survivor</option>
    <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
    <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
    <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
    <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
  </select>
  <? if ($Q9==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
</font></strong></font></p>
<p><strong><font color="#9BDEFF"><strong>10&deg;) Sur quel map entend-on ces
son ? <font color="#CC6600"></font></strong></font></strong></p>
<p><strong> </strong>
    <label><font color="#FFFFFF">
  </font></label><label></label>
    <strong><font color="#9BDEFF">
    <select name="select8" id="select8">
      <option value="oilrig" style="background-color:#FF0000;color=#FFFFFF">as_oilrig</option>
      <option value="tundra" style="background-color:#FF0000;color=#FFFFFF">as_tundra</option>
      <option value="747" style="background-color:#FF0000;color=#FFFFFF">cs_747</option>
      <option value="assault" style="background-color:#FF0000;color=#FFFFFF">cs_assault</option>
      <option value="backalley" style="background-color:#FF0000;color=#FFFFFF">cs_backalley</option>
      <option value="estate" style="background-color:#FF0000;color=#FFFFFF">cs_estate</option>
      <option value="havana" style="background-color:#FF0000;color=#FFFFFF">cs_havana</option>
      <option value="italy" style="background-color:#FF0000;color=#FFFFFF">cs_italy</option>
      <option value="militia" style="background-color:#FF0000;color=#FFFFFF">cs_militia</option>
      <option value="office" style="background-color:#FF0000;color=#FFFFFF">cs_office</option>
      <option value="siege" style="background-color:#FF0000;color=#FFFFFF">cs_siege</option>
      <option value="aztec" style="background-color:#FF0000;color=#FFFFFF">de_aztec</option>
      <option value="cbble" style="background-color:#FF0000;color=#FFFFFF">de_cbble</option>
      <option value="chateau" style="background-color:#FF0000;color=#FFFFFF">de_chateau</option>
      <option value="dust" style="background-color:#FF0000;color=#FFFFFF">de_dust</option>
      <option value="dust2" style="background-color:#FF0000;color=#FFFFFF">de_dust2</option>
      <option value="inferno" style="background-color:#FF0000;color=#FFFFFF">de_inferno</option>
      <option value="nuke" style="background-color:#FF0000;color=#FFFFFF">de_nuke</option>
      <option value="piranesi" style="background-color:#FF0000;color=#FFFFFF">de_piranesi</option>
      <option value="prodigy" style="background-color:#FF0000;color=#FFFFFF">de_prodigy</option>
      <option value="storm" style="background-color:#FF0000;color=#FFFFFF">de_storm</option>
      <option value="survivor" selected STYLE="background-color:#00FF00;color=blue">de_survivor</option>
      <option value="torn" style="background-color:#FF0000;color=#FFFFFF">de_torn</option>
      <option value="train" style="background-color:#FF0000;color=#FFFFFF">de_train</option>
      <option value="vegas" style="background-color:#FF0000;color=#FFFFFF">de_vegas</option>
      <option value="vertigo" style="background-color:#FF0000;color=#FFFFFF">de_vertigo</option>
    </select>
    <? if ($Q10==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
    </font></strong><br>
</p>
<p>&nbsp; </p>
<p align="center"><strong>Voil&agrave; ! Je pense que ce quizz est dans l'ensemble
    assez facile. Sachez que si vous &ecirc;tes un pro, d'autres quizz plus compliqu&eacute;s
    sont disponibles en il en faut pour tous le monde !</strong></p>
<p align="center"><strong>Si vous avez aim&eacute; ce quizz, n'oubliez pas de
    laisser un petit mot sur mon <a href="http://www.maxiservices.net/livre/livre.php3?id=2810%20">livre
    d'or</a> </strong></p>
<hr>
<ul>
  <li> <a href="http://sniperman.free.fr/cs_Qmaps.php" class="liens">Refaire
          le Quizz </a></li>
</ul>
<ul>
  <li> <a href="http://sniperman.free.fr/cs_Qmaps_Class.php" class="liens">Voir
        les Statistiques / Classement :</a></li>
</ul>
<ul>
  <li><a href="http://sniperman.free.fr/cs_Qmaps_Corr.php">Voir Correction d&eacute;taill&eacute;e :</a></li>
</ul>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;
      
</p>
</html>
