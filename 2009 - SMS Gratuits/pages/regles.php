<?php

if ($_GET['new']==1) $design['contenu']=" <br><br>http://sms.yotsumi.info?regles&user=".urlencode(base64_encode(time()))."<br><br> <br>";

else if((urldecode(base64_decode($_GET['user']))<=time()-120) OR (urldecode(base64_decode($_GET['user']))>=time()+120)) {
	$design['contenu']='<br>Impossible d\'afficher la page <u>'.$page.'</u>.<br><br><br><a href="index.php">Retourner à l\'accueil</a><br><br><br>';
	
} else {

$design['contenu']='<h2>Règles du service \'Sms par YoTsumi\'</h2>
<p class="normal"><br/>
La première chose à savoir c\'est que les SMS je ne les aient pas gratos, je dois <br />
préalablement les acheter ( à un prix réduit certe ).<br \>
<strong>Le service auquel vous postuler est donc un privilège que je vous accorde, pas un droit</strong><br /><br />

Pour que le service puisse fonctionne à long terme, j\'ai mis en place un système utilisant la <span style="border-bottom:1px solid #09F">publicité</span><br />
pour essayer de rentabiliser l\'achat des SMS. <br /><br />
<strong style="color:#FF9900">Il n\'y a qu\'une seule règle à respecter :</strong><br />

<div style="border:1px solid #FFF; width:70%; margin-left:auto; margin-right:auto; padding:4px">
- Lorsque vous serez entrain d\'écrire votre SMS, il y aura un lien \'» <strong>Ouvrir la page</strong> «\' 
qui ouvrira dans une nouvelle fenêtre une page web sur laquelle se trouve 2 ou 3 bannières publicitaires.<br />
- Vous devez absolument cliquer sur une de ses pubs ( en variant de préférence ), c\'est le 
seul moyen mis en place pour rentabiliser un peu se service.</div> <br /><br />

Si certains d\'entre vous abuse de ce service et ne cliquent pas sur les pubs, mon compte passera <br />
dans le rouge et alors je déciderais tout simplement de <strong>fermer le site</strong>.<br />
C\'est vous qui ne pourrez plus profiter de ce service, moi perso je m\'en fout !<br /><br /><br />

<div id="popup" style="display:none; color:#F33; font-size:11px">Un antiPopup a été détecté, ce message est donc particulièrement pour vous.</div>
<strong>PS1</strong> : Si lorsque vous cliquerez sur le lien "Ouvrir la Page" rien ne s\'ouvre, pensez à désactiver votre AntiPopup<br/>
<strong>Ps2</strong> : Evitez de vous envoyer des SMS du type : "test trop cool ce service". Je vous assure que sa fonctionne !<br /><br />

Maintenant si vous êtes d\'accord avec ça, donnez moi sur MSN un <span style="border-bottom:1px solid #09F">login</span> ( identifiant de connexion au site )<br \>
 et un <span style="border-bottom:1px solid #09F">mot de passe</span> pour que je cré votre accés au site.<br /><br /><br />
</p> ';

$design['onload']='
	<script type="text/javascript">
		window.onload=function(){
		function detectPopupBlocker() {
		  var myTest = window.open("about:blank","","directories=no,height=100,width=100, menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
		  if (!myTest) $(\'popup\').style.display="block";
		  else myTest.close();
		}

			detectPopupBlocker();
		}	
	</script>';
	
	
}
?>