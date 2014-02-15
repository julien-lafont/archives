<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 	

$design['contenu']='<h2>Envoyer des SMS gratuitement</h2> <br /><br />
 

	 Ce site vous permet d\'envoyer gratuitement des SMS vers tous les mobiles francais <br />
  et &eacute;trangers, le tout sans dépenser un seul centime   <br />
  <br />
  L\'acc&eacute;s &agrave; ce service n\'est disponible à tous, je suis obligé de faire un choix <br />parmis les nouveaux inscrits, mais demandez moi toujours ! <br />
 <div id="etat" class="round2"></div>
 
  <div id="log_global">
	  <div class="log1">
	  	 <div id="wait"></div>
		 <h4>J\'ai déjà un accés au site</h4> 
		  <form id="form1" method="post" action="?connexion">
			  
			<div style="text-align:left">
				<h5 style="margin-left:80px">Login</h5>
				<h5 style="margin-left:45px">Pass</h5>
			</div>
			  
			  <fieldset>	
			  	<input type="text" id="pseudo" style="width:80px; margin-bottom:6px " />&nbsp;
				<input type="password" id="pass" style="width:50px; margin-bottom:6px" />
			  </fieldset>
			  <div class="envoyer"><a href="#" onclick="login(); return false" class="envoyer">Connexion</a></div>
		</form>

    </div>
	  
	  <div class="log2">
		 <h4>Je n\'ai pas d\'accés au site</h4> 
		 <p>Pour obtenir un accés, contactez moi sur msn :</p>
		 <h6>yotsumi@gmail.com</h6>
		 
	  </div>
  </div>
  <br /><br />';
  
$design['onload']='
	<script type="text/javascript">
		window.onload=function(){
			Nifty("div.log1","smooth fixed-height");
			Nifty("div.log2","smooth fixed-height");
		}	
	</script>';

// Page appellé lors de la deconnexion
if ($_GET['ajax']==1) echo 'OK|:|Nifty("div.log1","smooth fixed-height");Nifty("div.log2","smooth fixed-height");|:|'.$design['contenu'];

?>