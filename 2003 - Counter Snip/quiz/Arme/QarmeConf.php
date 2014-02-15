<html>
<head>
<title>Confirmation : Quiz Arme</title>
<body bgcolor="#000000" text="#66FF00" link="#C0FF97" vlink="#FFFFFF" alink="#FFFF00">
<?php

// On verifie que la personne n'a pas déja joué grace aux cookies
if($_COOKIE['csnipArme']=="oui")
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
if ($Q1=='fumi')
{
$points++;
$Q1=1;
}

#   -- Question 2 --
if (($Q2>=450)&&($Q2<=850))
{
$points++;
$Q2=1;
}

#   -- Question 3 --

if (($Q3>=70)&&($Q3<=100))
{
$demipoints++;
$Q3=1;
}

if (($Q3b>=15) && ($Q3b<=35))
{
$demipoints++;
$Q3b=1;
}

#   - Question 4 --
if ($Q4=="3-4")
{
$points++; 
$Q4=1;
}

#   - Question 5 --
if ($Q5=="mp5")
{
$points++;
$Q5=1;
}

#   - Question 6 --
if ($Q6=='non')
{
$points++;
$Q6=1;
}

#   - Question 7 --
if ($Q7=='r3')
{
$points++;
$Q7=1;
}

#   - Question 8 --
if ($Q8=='r1')
{
$points++;
$Q8=1;
}

#   - Question 9 --
if ($Q9=='fn')
{
$points++;
$Q9=1;
}

#   - Question 10 --
if ($Q10=='d')
{
$points++; 
$Q10=1;
}

// On calcule le score
$demipoints=$demipoints/2;
$points=$points+$demipoints;

if (($points==0)||($points==0.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 0/10 .: Nul Nul et Nul ! :.')</script>"; }
if (($points==1)||($points==1.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 1/10 .: Nul :.')</script>"; }
if (($points==2)||($points==2.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 2/10 .: Médiocre :.')</script>"; }
if (($points==3)||($points==3.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 3/10 .: Peut mieux faire :.')</script>"; }
if (($points==4)||($points==4.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 4/10 .: Passable :.')</script>"; }
if (($points==5)||($points==5.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 5/10 .: Vous avez la moyenne :.')</script>"; }
if (($points==6)||($points==6.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 6/10 .: Assez Bien :.')</script>"; }
if (($points==7)||($points==7.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 7/10 .: Bien : Good Job :.')</script>"; }
if (($points==8)||($points==8.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 8/10 .: Très Bien :.')</script>"; }
if (($points==9)||($points==9.5)) { print "<script language=javascript>window.alert ('Votre score est d environ : 9/10 .: Méga Supra Extra Bien :.')</script>"; }
if ($points==10) { print "<script language=javascript>window.alert ('Votre score est de : 10/10 .: Parfait ! Voici enfin un vrai CSeur ! :.')</script>"; }

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
mail("sniperman.cs@laposte.net","-- Nouveau Quizz ARME --","$message","$head"); 


// Preparation email pour lui
$message1 = "<body bgcolor=#4D574A text=#FFFFFF link=#66CCFF vlink=#003366 alink=#66FFFF><font face=arial><p><font color=#FFFF00 size=+1><B>Salutations,</B></font></p><p>Voici le mail de confirmation &agrave  votre participation au Grand QuiZZzzz Counter Snip.<br> J ai l honneur de vous annoncer votre résultat du quizz Counter Snip <b> ARME </b>:<br> <br> <B>Votre Pseudo &nbsp &nbsp :</B> <font color=#00FF00>$pseudo</font><br> <B>Votre Score &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$points /10 </font><br> <B>Classement &nbsp &nbsp &nbsp :</B> <font color=#00FF00><a href=http://sniperman.free.fr/cs_quiz.php>Page de Résultat</a></font><br> <B>Date-Heure &nbsp &nbsp &nbsp :</B> <font color=#00FF00>$date - $heure</font></p></font><br>Je tiens à préciser que ce module de quizz n aura plus aucun retard gràce à un gros travail qui abouti à la creation de plusieurs scripts PHP qui font tout pour moi :-)<br><br> Merci encore d avoir participé à ce quiZzzz.</p><p align=center><font color=#FFFF00><B> Kirikiri-kiriiiii<br> http://www.countersnip.fr.st</B></font></p></font>";
$head1 .= "From:Quiz@CounterSnip.fr\n";
$head1 .= "Reply-To:sniperman.cs@laposte.net\n";
$head1 .= "X-Priority:1\n";
$head1 .= "X-Mailer: CounterSnip-Mailer par Kirikiri\n";
$head1 .= "Content-Type: text/html; charset=iso-8859-1\r\n";

// Envoie email pour lui
mail("$mail","-- Résultat du Quizz CounterSnip : ARME --","$message1","$head1"); 

// Enregistrement dans fichier txt
$ouvrir=fopen("arme.txt","a+"); 
fputs($ouvrir," ||$adresseip - $date - $heure - $pseudo - $points /10                  ||\n" );
fclose($ouvrir);

echo ("<iframe src='http://sniperman.free.fr/armeMysql.php?pseudo=$pseudo&points=$points?' width='0' height='0'>pbm</iframe>");

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
<p align="center"><strong><font color="#FFFF00" size="+1">Voici les r&eacute;ponces du
 Quizz ARME<br>
 </font></strong><font color="#FFFF00" size="+1"><font color="#FFFFFF">[ Pour
 des r&eacute;sultats plus d&eacute;taill&eacute;s
 : <a href="http://sniperman.free.fr/cs_Qarmes_Corr.php">ici</a> ]</font></font></p>
<p align="left"><strong><font color="#9BDEFF">1&deg;)  Quel est ce bruit
      ? 
	  
	  </font></strong></p>
<p align="left">
  <select name="Q1" id="Q1">
    <option value="nul" STYLE="background-color:red">
    <option value="flash" STYLE="background-color:red">Une Flashbang qui p&egrave;te
    <option value="terro" STYLE="background-color:red">Un terro qui se soulage
    <option value="fumi" selected STYLE="background-color:#00FF00;color=blue">un
    fumig&egrave;ne en action
    <option value="coca" STYLE="background-color:red">un urban buvant du coca
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
<p align="left"><strong><font color="#9BDEFF">2&deg;) Combien co&ucirc;te un
      Pistolet Desert Eagle ? 
      
</font></strong></p>
<p align="left">
  <input name="b" type="text" id="b" value="650" size="10" maxlength="10" readonly="" STYLE="background-color:green;color:white">
  <font color="#FFFFFF">$</font> <strong><font color="#9BDEFF">
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
<p align="left"><font color="#9BDEFF"><strong>3&deg;) Combien de balles rentre
      dans une UMP [ 3-5 ] ? <font color="#9BDEFF">
      </font></strong></font></p>
<p align="left">
  <input name="b32" type="text" id="b32" value="25" size="10" maxlength="10" readonly="" STYLE="background-color:green;color:white">
  <font color="#FFFFFF">-</font>  <input name="b3" type="text" id="b3" value="84" size="10" maxlength="10" readonly="" STYLE="background-color:green;color:white">
  <font color="#9BDEFF"><strong><font color="#9BDEFF">
  &nbsp;
  <? if ($Q3==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  <font color="#FFFFFF">-</font></font><font color="#9BDEFF"><? if ($Q3b==1)
	  		{
				print "<font color=#00FF00>&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  </font></strong></font></p>
<p align="left"><strong><font color="#9BDEFF">4&deg;) Quel est la position dans
      le menu d'achat du Ingram Mac 10</font></strong></p>
<p align="left">
  <input name="b2" type="text" id="b22" value="3-4" size="10" maxlength="10" readonly="" STYLE="background-color:green;color:white">
  <strong><font color="#9BDEFF">
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
    <font color="#9BDEFF"><strong>5&deg;) Quel est le nom de l'arme de cette
    photo :</strong></font></p>
<p align="left">
  <select name="select" id="select2">
    <option value="0" STYLE="background-color:red"></option>
    <option value="cout" STYLE="background-color:red">Couteau</option>
    <option value="1-2" STYLE="background-color:red">Pistolet : GLOCK</option>
    <option value="1-1" STYLE="background-color:red">Pistolet : USP</option>
    <option value="1-4" STYLE="background-color:red">Pistolet : Sig P228</option>
    <option value="1-3" STYLE="background-color:red">Pistolet : Desert Eagle</option>
    <option value="1-6" STYLE="background-color:red">Pistolet : Fiveseven</option>
    <option value="1-5" STYLE="background-color:red">Pistolet : Dual Beretta</option>
    <option value="2-2" STYLE="background-color:red">Pompe : Automatique</option>
    <option value="2-1" STYLE="background-color:red">Pompe : Manuel</option>
    <option value="3-3" STYLE="background-color:red">Mitraillette : FN P90</option>
    <option value="mp5" STYLE="background-color:#00FF00;color=blue" selected>Mitraillette
    : MP5</option>
    <option value="3-4" STYLE="background-color:red">Mitraillette : MAC 10</option>
    <option value="3-5" STYLE="background-color:red">Mitraillette : UMP</option>
    <option value="3-2" STYLE="background-color:red">Mitraillette : Steyr TMP </option>
    <option value="4-2" STYLE="background-color:red">Fusil : Sig Commandos</option>
    <option value="4-4" STYLE="background-color:red">Fusil : Streyr aug</option>
    <option value="4-1" STYLE="background-color:red">Fusil : Ak 47</option>
    <option value="4-3" STYLE="background-color:red">Fusil : Colt M4A1</option>
    <option value="4-6" STYLE="background-color:red">Sniper : AWP</option>
    <option value="4-7/8" STYLE="background-color:red">Sniper : G3/SG1 &amp; Sig
    550 </option>
    <option value="4-5" STYLE="background-color:red">Sniper : Streyr Scout </option>
    <option value="51" STYLE="background-color:red">Machin Gun</option>
  </select>
  <strong><font color="#9BDEFF">
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
<p align="left"> <font color="#9BDEFF"><strong>6&deg;) Est-ce que les balles
      du MP5 passe &agrave; travers les portes ou les murs ?</strong></font></p>
<p align="left">
  <label>
  <font color="#FFFFFF">
  <input type="radio" name="Q6" value="oui" disabled >
  oui</font></label>
  <font color="#FFFFFF">  <br>
  <label>
  <input name="Q6" type="radio" value="non" checked >
  non</label>
  </font>
  <label></label>
  <strong><font color="#9BDEFF">
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
<p><font color="#9BDEFF"><strong>7&deg;) Que change le silencieux au Colt M4A1
      [ 4-3 ]</strong></font></p>
<label>
<input type="radio" name="Q7" value="r1" disabled>
</label>
<font color="#FFFFFF"> + Pr&eacute;cis, + Puissant<br>
<label>
<input type="radio" name="Q7" value="r2" disabled>
- Pr&eacute;cis,</label>
- Puissant&nbsp; </font><br>
<label>
<input name="Q7" type="radio" value="r3" checked>
<font color="#FFFFFF">+ Pr&eacute;cis, - Puissant</font></label>
 <strong>
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
<label>
<input name="Q7" type="radio" value="r4" disabled>
<font color="#FFFFFF"> - Pr&eacute;cis, + Puissant</font></label>
<font color="#FFFFFF">
</font>
<p align="left">&nbsp;</p>
<p><font color="#9BDEFF"><strong>8&deg;) Lequel des 2 fusils &agrave; Pompes
      contient le plus de balles dans un chargeur ?</strong></font></p>
<p>
  <input name="Q8" type="radio" id="radio" value="r1" checked>
  <font color="#FFFFFF">  M3 [ 2-1 ]</font><font color="#99FF66"> Fusil Manuel</font> <strong><font color="#9BDEFF">
  <? if ($Q8==1)
	  		{
				print "<font color=#00FF00>&nbsp;&nbsp;Juste</font>";
			}
		else
			{
				print "<font color=#FF0000>&nbsp;&nbsp;Faux</font>";
			}
		?>
  </font></strong><br>
    <input name="Q8" type="radio" id="radio" value="r2" disable>
  <font color="#FFFFFF">  XM [ 2-2 ] </font><font color="#99FF66">Fusil Auto &nbsp;&nbsp;&nbsp;</font></p>
<p><font color="#9BDEFF"><strong>9&deg;) Quel arme ce &quot;personnage&quot; a-t-il
      dans les mains ?</strong></font></p>
<p> <font color="#99FF66">
  <select name="select2" id="select3">
    <option value="0" STYLE="background-color:red"></option>
    <option value="cout" STYLE="background-color:red">Couteau</option>
    <option value="1-2" STYLE="background-color:red">Pistolet : GLOCK</option>
    <option value="1-1" STYLE="background-color:red">Pistolet : USP</option>
    <option value="1-4" STYLE="background-color:red">Pistolet : Sig P228</option>
    <option value="1-3" STYLE="background-color:red">Pistolet : Desert Eagle</option>
    <option value="1-6" STYLE="background-color:red">Pistolet : Fiveseven</option>
    <option value="1-5" STYLE="background-color:red">Pistolet : Dual Beretta</option>
    <option value="2-2" STYLE="background-color:red">Pompe : Automatique</option>
    <option value="2-1" STYLE="background-color:red">Pompe : Manuel</option>
    <option value="fn" STYLE="background-color:#00FF00;color=blue"  selected>Mitraillette
    : FN P90</option>
    <option value="mp5" STYLE="background-color:red">Mitraillette : MP5</option>
    <option value="3-4" STYLE="background-color:red">Mitraillette : MAC 10</option>
    <option value="3-5" STYLE="background-color:red">Mitraillette : UMP</option>
    <option value="3-2" STYLE="background-color:red">Mitraillette : Steyr TMP </option>
    <option value="4-2" STYLE="background-color:red">Fusil : Sig Commandos</option>
    <option value="4-4" STYLE="background-color:red">Fusil : Streyr aug</option>
    <option value="4-1" STYLE="background-color:red">Fusil : Ak 47</option>
    <option value="4-3" STYLE="background-color:red">Fusil : Colt M4A1</option>
    <option value="4-6" STYLE="background-color:red">Sniper : AWP</option>
    <option value="4-7/8" STYLE="background-color:red">Sniper : G3/SG1 &amp; Sig
    550 </option>
    <option value="4-5" STYLE="background-color:red">Sniper : Streyr Scout </option>
    <option value="51" STYLE="background-color:red">Machin Gun</option>
  </select>
  <strong><font color="#9BDEFF">
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
<p><strong><font color="#9BDEFF">10&deg;) Laquelle de ces armes est un SG-552
      [ 4-2 ] ?</font></strong></p>
<p><strong> </strong>
    <label><font color="#FFFFFF">
    <input type="radio" name="Q10" value="a" disabled>
  A</font></label>
    <font color="#FFFFFF">    <br>
    <label>
    <input type="radio" name="Q10" value="b" disabled>
  B</label>
    <br>
    <label>
    <input type="radio" name="Q10" value="c" disabled>
  C</label>
    </font><br>
    <label>
    <input name="Q10" type="radio" value="d" checked>
    <font color="#FFFFFF">D</font></label>
    <strong><font color="#9BDEFF">
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
  <li> <a href="http://sniperman.free.fr/cs_Qarmes.php" class="liens">Refaire
          le Quizz </a></li>
</ul>
<ul>
  <li> <a href="http://sniperman.free.fr/cs_Qarmes_Class.php" class="liens">Voir
        les Statistiques / Classement :</a></li>
</ul>
<ul>
  <li><a href="http://sniperman.free.fr/cs_Qarmes_Corr.php">Voir Correction d&eacute;taill&eacute;e :</a></li>
</ul>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;
      
</p>
</html>
