<?php

$texte="<br><center>Bienvenue sur <span class='txt2'>IX-TEAM</span>, le nouveau portail pour les <span class='txt2'>Gamer'z</span>.<br><br>
A partir de ce site, vous pouvez suivre l'actu du développement de notre portail, et tester les modules que nous codons au fur et à mesure moi (<a href='mailto:yotsumi@gmail.com'>YoTsumi</a>) et <a href='mailto:phoenix48200@hotmail.com'>Phoenix</a>.<br>
<br>Si vous avez des talents en Codage, Design, Traduction, n'hésitez pas à nous contacter.</center><br>

<div class='barremenu' style='width:90%; margin-left:20px' ></div>
<p align=\"center\"><span class=\"txt2\">Etat d'avancement :</span><span style=\"font-family: Geneva, Arial, Helvetica, sans-serif;font-weight: bold;font-size: 14px;\"><font color=\"#00FF00\">IIII</font><font color=\"#FF0000\">IIIIIIIIIIIIIIIII</font></span></p>
<p><u><span class=\"txt2\">D&eacute;j&agrave; programm&eacute; :</span></u><br>
 &nbsp;&nbsp;- [14.05.05] Nouvelle Shoutbox, Stats Serveur <br>
&nbsp;&nbsp;- [01.05.05] Syst&egrave;me de News avec Commentaires, Messagerie Priv&eacute; <br />
&nbsp;&nbsp;- [08.04.05] Mon Compte, Profil, mes Options<br />
&nbsp;&nbsp;- [08.04.05] Administration des membres<br />
&nbsp;&nbsp;- [29.03.05] Module Match utilisateur et admin<br />
&nbsp;&nbsp;- [29.03.05] Inscription, Login & Espace admin<br />
&nbsp;&nbsp;- [28.03.05] Syst&egrave;me de gestion des th&egrave;mes<br />
&nbsp;&nbsp;- [25.03.05] Architecture du site</p>
<p><u><span class=\"txt2\">En cours de codage :</span></u><br />
&nbsp;&nbsp;- Téléchargements<br>
&nbsp;&nbsp;- Calendrier </p>
                <p><u><span class=\"txt2\">Pr&eacute;vu &agrave; coder :</span></u><br />
&nbsp;&nbsp;- Modules sp&eacute;cials teams : d&eacute;fier, membres ...<br />
&nbsp;&nbsp;- Module Article, T&eacute;l&eacute;chargement, Gallerie, Annuaire<br />
&nbsp;&nbsp;- Et pleins d'autres choses ! <br />
<p><u><span class=\"txt2\">Design en cours :</span></u><br /> 
&nbsp;&nbsp;- Revelation <br />
&nbsp;&nbsp;- Suspiction Game <br />
&nbsp;&nbsp;- Reality Dream <br />";		

$afficher->AddSession($handle,"contenu");
$afficher->setVar($handle,"contenu.module_titre","Info sur le codage");
$afficher->setVar($handle,"contenu.module_texte",$texte);
$afficher->CloseSession($handle,"contenu");

?>