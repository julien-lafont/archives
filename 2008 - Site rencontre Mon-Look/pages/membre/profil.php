<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 


switch($_GET['action']) {
#########################################################################################################################
// Page Principale //
#########################################################################################################################
default:

	securite_membre();
	
	$sql=mysql_query("SELECT * FROM members WHERE username='".$_SESSION['sess_pseudo']."'");
	$d=mysql_fetch_object($sql);
	
		// Préparation pour les SELECT's
		if ($d->gender=="h") $h="selected";
		if ($d->gender=="f") $f="selected";
		  if ($d->cherche=="h") $c1="selected";
		  if ($d->cherche=="f") $c2="selected";
		  if ($d->cherche=="hf") $c3="selected";
		  if ($d->cherche=="p") $c4="selected";
		if ($d->country=="canada") $p1="selected";
		if ($d->country=="france") $p2="selected";
		if ($d->country=="belgique") $p3="selected";
		if ($d->country=="u.s.a") $p4="selected";
		if ($d->country=="autre") $p5="selected"; // !! sans 'S' :) //
		  if ($d->poid=="1") $z1="selected";
		  if ($d->poid=="2") $z2="selected";
		  if ($d->poid=="3") $z3="selected";
		  if ($d->poid=="4") $z4="selected";
		  if ($d->poid=="5") $z5="selected";
		  if ($d->poid=="6") $z6="selected";
		  if ($d->poid=="7") $z7="selected";
		if ($d->yeux=="1") $y1="selected";
		if ($d->yeux=="2") $y2="selected";
		if ($d->yeux=="3") $y3="selected";
		if ($d->yeux=="4") $y4="selected";
		if ($d->yeux=="5") $y5="selected";
		if ($d->yeux=="6") $y6="selected";
		  if ($d->chx=="1") $w1="selected";
		  if ($d->chx=="2") $w2="selected";
		  if ($d->chx=="3") $w3="selected";
		  if ($d->chx=="4") $w4="selected";
		  if ($d->chx=="5") $w5="selected";
		  if ($d->chx=="6") $w6="selected";
		if ($d->fume=="1") $f1="selected";
		if ($d->fume=="2") $f2="selected";
		if ($d->fume=="3") $f3="selected";
		if ($d->fume=="4") $f4="selected";
		  if ($d->bois=="1") $b1="selected";
		  if ($d->bois=="2") $b2="selected";
		  if ($d->bois=="3") $b3="selected";
		  if ($d->bois=="4") $b4="selected";
		  if ($d->bois=="5") $b5="selected";
		  if ($d->bois=="6") $b6="selected";
		if ($d->status=="1") $s1="selected";
		if ($d->status=="2") $s2="selected";
		if ($d->status=="3") $s3="selected";
		if ($d->status=="4") $s4="selected";
		if ($d->status=="5") $s5="selected";
		  if ($d->orientation=="1") $o1="selected";
		  if ($d->orientation=="2") $o2="selected";
		  if ($d->orientation=="3") $o3="selected";
		  if ($d->orientation=="4") $o4="selected";
		  if ($d->orientation=="5") $o5="selected";
		// Et pour les Cases à cocher
		if ($d->messageemail=="1") $mess="checked";
		  if ($d->amitie=="1") $r1="checked";
		  if ($d->activites=="1") $r2="checked";
		  if ($d->relationct=="1") $r3="checked";
		  if ($d->relationlt=="1") $r4="checked";
		  if ($d->amusement=="1") $r5="checked";
		  if ($d->sexe=="1") $r6="checked";
		  
	if (!empty($d->img_principale)) {
		if ($d->img_valid==1) $status="<span style='color:#0066FF; font-weight:bold'>Validé</span>";
		if ($d->img_valid==2) $status="<span style='color:#FF0000; font-weight:bold'>Refusé !</span>";
		if ($d->img_valid==0) $status="<span style='color:#555555'>En attente</span>";
		$photo="<img src='upload/principal/".$d->img_principale."' alt='Photo de ".$_SESSION['sess_pseudo']."' style='border:1px solid #000000'><br>$status";
		
	} else { $photo='<img src="images/portrait.png">'; }
	
		$add='<style type="text/css" media="all">
		@import "include/effet/global.css";
		</style>
		<script src="include/only_ajax.js" type="text/javascript"></script>
		<script src="include/effet/prototype.js" type="text/javascript" ></script>
		<script src="include/effet/jquery.js" type="text/javascript"></script>
		<script src="include/effet/thickbox.js" type="text/javascript"></script>
		
		<script language="javascript">
			function modifPass() {
				Element.hide("TB_window");
				Element.hide("TB_overlay");
				newpass=$("newpass").value;
				ajaxGetA("pages/membre/profil.php?action=modifPass2&newpass="+newpass,"modifPass2");
			}
			function modifPass2(result) {
				$("passs").innerHTML=unescape(result);
			}
		
		</script>';
		head($add);
		
	echo '<div style="text-align:center;font-size:13px; color:#0099FF; width:90%"><b><u style="color:#0066FF">Mon Profil</u><br>Utilisez cette page pour modifier vos informations personelles et publiques.</b></div><br>
	
	<form name="form1" action="?p=membre/profil&action=maj1" method="post" >
	<table id="profil" >
			<tr>
				<td colspan="3"><h3>Étape 1 : Informations Générales </h3></td>
			</tr>
			<tr>
				<td style="width:160px;"><img src="img/px.gif" height="0" width="35"> Prénom</td>
				<td style="width:300px"><input type="text" name="prenom" maxlength="50"  value="'.ucfirst($d->fname).'"></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Nom</td>
				<td><input type="text" name="nom" maxlength="50" value="'.strtoupper($d->lname).'"> ( privé )</td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Email</td>
				<td><input type="text" name="email" maxlength="200" value="'.$d->email.'"></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Pass</td>
				<td><a href="pages/membre/profil.php?action=modifPass&height=130&width=220" title="ajax" class="thickbox" style="padding:2px;background-color:#FFFFFF;border-style:solid;border-width:1px;border-color:#777 #DDD #EEE #777;" ><span id="passs">Modifier mon mot de passe</span></a></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Age</td>
				<td><input type="text" name="age" maxlength="2" style="width:30px" value="'.$d->age.'"> ans</td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Sexe</td>
				<td><select name="genderr">
					  <option value="h" '.@$h.'>Homme</option>
					  <option value="f" '.@$f.'>Femme</option>
					</select></td>
			</tr>
			<tr>
				<td colspan=2><input type="checkbox" name="sendmess" value="1" style="width:20px; margin-left:10px;"  '.@$mess.'/> Notification par email lorsque je reçois un message.</td>
			</tr>
			<tr>
				<td></td>
				<td><br><div class="envoyer" id="send" style="width:135px;" OnClick="document.forms[0].submit()">Mettre à jour</div></td>
			</tr>

			</table><br></form>
	
	<form name="form2"  action="?p=membre/profil&action=maj2" method="post" >
	<table id="profil" >
			<tr>
				<td colspan="3"><h3>Étape 2 : Mes motivations </h3></td>
			</tr>
		<tr>
			<td style="width:160px"><img src="img/px.gif" height="1" width="35"> Je recherche</td>
			<td style="width:300px"><select name="cherche">
				  <option value="h" '.@$c1.'>un homme</option>
				  <option value="f" '.@$c2.'>une femme</option>
				  <option value="hf" '.@$c3.'>un homme ou une femme</option>
				  <option value="p" '.@$c4.'>personne</option>
				</select></td>
		</tr>
		<tr>
			<td ><img src="img/px.gif" height="1" width="20"> Type de relation</td>
			<td ><br>
			 	<input name="amitie" type="checkbox" value="1" style="width:20px" '.@$r1.'> Développer une amitié<br>
				<input name="activites" type="checkbox" value="1" style="width:20px" '.@$r2.'> Partenaires d\'activités<br>
				<input name="court" type="checkbox" value="1" style="width:20px" '.@$r3.'> Une relation à court terme<br>
				<input name="long" type="checkbox" value="1" style="width:20px" '.@$r4.'> Une relation à long terme<br>
				<input name="amusement" type="checkbox" value="1" style="width:20px" '.@$r5.'> L\'amusement<br>
				<input name="sexe" type="checkbox" value="1" style="width:20px" '.@$r6.'> Relation sexuelle<br>
			</td>
		</tr>
			<tr>
				<td></td>
				<td><br><div class="envoyer" id="send" style="width:135px;" OnClick="document.forms[1].submit()">Mettre à jour </div></td>
			</tr>

			</table></form><br>
			
	<form name="form3"  action="?p=membre/profil&action=maj3" method="post" >
	<table id="profil" >
			<tr>
				<td colspan="3"><h3>Étape 3 : Informations Personnelles </h3></td>
			</tr>
			<tr>
				<td style="width:160px;"><img src="img/px.gif" height="0" width="35"> Ville</td>
				<td style="width:300px"><input type="text" name="city" maxlength="50"  value="'.ucfirst($d->city).'"></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Pays</td>
				<td><select name="country">
					  <option value="Canada" '.@$p1.'>Canada</option>
					  <option value="France" '.@$p2.'>France</option>
					  <option value="Belgique" '.@$p3.'>Belgique</option>
					  <option value="U.S.A" '.@$p4.'>U.S.A</option>
					  <option value="Autre" '.@$p5.'>Autre</option>
					</select></td>
			</tr>
			<tr>
				<td style="width:160px;"><img src="img/px.gif" height="0" width="35"> Taille</td>
				<td style="width:300px"><input type="text" name="taille_pi" maxlength="3"  style="width:25px" value="'.$d->taille.'" onKeyUp="this.form.taille_cm.value=this.value*30,48"> pi ou <input type="text" name="taille_cm" style="width:30px" maxlength="3"  value="'.$d->taille*30.48.'" onKeyUp="this.form.taille_pi.value=this.value/30,48"> cm</td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="20"> Poids/Corpulence</td>
				<td><select name="poids">
					  <option value="1" '.@$z1.'>Préfère ne pas répondre</option>
					  <option value="2" '.@$z2.'>Mince</option>
					  <option value="3" '.@$z3.'>En forme</option>
					  <option value="4" '.@$z4.'>Musclé(e)</option>
					  <option value="5" '.@$z5.'>Dans la moyenne</option>
					  <option value="6" '.@$z6.'>Quelques livres en trop</option>
					  <option value="7" '.@$z7.'>Corpulant(e)</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="20"> Couleur des yeux</td>
				<td><select name="yeux">
					  <option value="1" '.@$y1.'>Bleu</option>
					  <option value="2" '.@$y2.'>Vert</option>
					  <option value="3" '.@$y3.'>Pairs</option>
					  <option value="4" '.@$y4.'>Brun</option>
					  <option value="5" '.@$y5.'>Noisette</option>
					  <option value="6" '.@$y6.'>Je sais pas</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Cheveux</td>
				<td><select name="cheveux">
					  <option value="1" '.@$w1.'>Brun</option>
					  <option value="2" '.@$w2.'>Chatain</option>
					  <option value="3" '.@$w3.'>Noir</option>
					  <option value="4" '.@$w4.'>Brun</option>
					  <option value="5" '.@$w5.'>Blond</option>
					  <option value="6" '.@$w6.'>Autre</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Fumes-tu ?</td>
				<td><select name="fume">
					  <option value="1" '.@$f1.'>Oui</option>
					  <option value="2" '.@$f2.'>Non</option>
					  <option value="3" '.@$f3.'>De temps en temps</option>
					  <option value="4" '.@$f4.'>Préfère ne pas répondre</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Bois-tu ?</td>
				<td><select name="bois">
					  <option value="1" '.@$b1.'>Trés souvent</option>
					  <option value="2" '.@$b2.'>Régulièrement</option>
					  <option value="3" '.@$b3.'>Desfois</option>
					  <option value="4" '.@$b4.'>Jamais</option>
					  <option value="5" '.@$b5.'>Non mes parents ne veulent pas !</option>
					  <option value="6" '.@$b6.'>Préfère ne pas répondre</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Situation</td>
				<td><select name="status">
					  <option value="1" '.@$s1.'>Célibataire</option>
					  <option value="2" '.@$s2.'>En couple</option>
					  <option value="3" '.@$s3.'>Marié</option>
					  <option value="4" '.@$s4.'>Divorcé</option>
					  <option value="5" '.@$s5.'>Ouvert aux sugestions</option>
					</select></td>
			</tr>
			<tr>
				<td><img src="img/px.gif" height="1" width="35"> Orientation</td>
				<td><select name="orientation">
					  <option value="1" '.@$o1.'>Hétéro</option>
					  <option value="2" '.@$o2.'>Bi</option>
					  <option value="3" '.@$o3.'>Gay</option>
					  <option value="4" '.@$o4.'>Lesbienne</option>
					  <option value="5" '.@$o5.'>Je ne sais pas</option>
					</select></td>
			</tr>
			<tr>
				<td></td>
				<td><br><div class="envoyer" style="width:135px;" OnClick="document.forms[2].submit()">Mettre à jour </div></td>
			</tr>

			</table></form><br>
			
	<form name="form4" action="?p=membre/profil&action=maj4" method="post" >
	<table id="profil" >
			<tr>
				<td colspan="3"><h3>Étape 4 : Ma description </h3></td>
			</tr>
			<tr>
				<td colspan="2"><center>Décris toi en général<br>
				<textarea name="des" cols="40" rows="6">'.stripslashes($d->about).'</textarea></center></td>
			</tr>
			<tr>
				<td colspan="2"><center>Ce que tu recherche en général sur le site<br>
				<textarea name="rech" cols="40" rows="6">'.stripslashes($d->recherchetxt).'</textarea></center></td>
			</tr>
			<tr>
				<td colspan="2"><center>Tes occupations, ce que tu aime faire<br>
				<textarea name="occ" cols="40" rows="6">'.stripslashes($d->occupations).'</textarea></center></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br><div class="envoyer" id="send" style="width:135px;" OnClick="document.forms[3].submit()">Mettre à jour</div></td>
			</tr>

			</table><br></form>
			
	<form name="form5" action="?p=membre/profil&action=maj5" method="post" enctype="multipart/form-data" >
	<table id="profil" >
			<tr>
				<td colspan="3"><h3>Étape 5 : Ma photo Perso </h3></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:12px; text-align:center">Vous devez avant d\'ajouter des photos dans votre album personnel choisir une photo qui deviendra la <b>photo principale</b> de votre compte.</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				
				<table><tr>
				    <td width="70%">
					   <input type="file" name="img1"><br>
					   . Photo en <b>Partrait</b>, 1.5mo maxixum<br>
					   . Formats supportés : Jpg, Gif, Png<br>
					   . Redimensionnement automatique
					</td>
					<td align="center">
				       '.$photo.'
				     </td>
				  </tr></table>
				 
				 </td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br><div class="envoyer" id="send" style="width:135px;" OnClick="document.forms[4].submit()">Mettre à jour</div></td>
			</tr>

			</table></form>
			<a href="?p=membre/home"><img src="images/retour.png" style="float:left" alt="Retour"></a>

';

	foot();
break;
#########################################################################################################################
// MAJ des informations ETAPE 1 //
#########################################################################################################################
case "maj1":

	if (empty($_POST)) rediriger("?p=erreur&code=03"); 

	$email=strtolower(htmlspecialchars($_POST['email']));
	$prenom=strtolower(htmlspecialchars($_POST['prenom']));
	$nom=strtolower(htmlspecialchars($_POST['nom']));
	$age=strtolower(htmlspecialchars($_POST['age']));
	$gender=strtolower(htmlspecialchars($_POST['genderr']));
	$sendmess=strtolower(htmlspecialchars($_POST['sendmess']));
	
	$sql=mysql_query("UPDATE members SET `email`='$email', `age`='$age', `fname`='$prenom', `lname`='$nom', `gender`='$gender', `messageemail`='$sendmess' 
					  WHERE username='".$_SESSION['sess_pseudo']."'");
	message_redir('Mise à Jour de l\'étape 1 effectuée avec succés !','?p=membre/profil');

break;
#########################################################################################################################
// MAJ des informations ETAPE 2 //
#########################################################################################################################
case "maj2":

	if (empty($_POST)) rediriger("?p=erreur&code=03"); 

	$cherche=strtolower(htmlspecialchars($_POST['cherche']));
	$amitie=strtolower(htmlspecialchars($_POST['amitie']));
	$activites=strtolower(htmlspecialchars($_POST['activites']));
	$court=strtolower(htmlspecialchars($_POST['court']));
	$long=strtolower(htmlspecialchars($_POST['long']));
	$amusement=strtolower(htmlspecialchars($_POST['amusement']));
	$sexe=strtolower(htmlspecialchars($_POST['sexe']));
	
	$sql=mysql_query("UPDATE members SET `cherche`='$cherche', `amitie`='$amitie' , `activites`='$activites' , `relationct`='$court' , `relationlt`='$long' , `amusement`='$amusement' , `sexe`='$sexe'
					  WHERE username='".$_SESSION['sess_pseudo']."'");
	message_redir('Mise à Jour de l\'étape 2 effectuée avec succés !','?p=membre/profil');

break;
#########################################################################################################################
// MAJ des informations ETAPE 3 //
#########################################################################################################################
case "maj3":

	if (empty($_POST)) rediriger("?p=erreur&code=03"); 

	$city=strtolower(htmlspecialchars($_POST['city']));
	$country=strtolower(htmlspecialchars($_POST['country']));
	$taille=strtolower(htmlspecialchars($_POST['taille_pi']));
	$poids=strtolower(htmlspecialchars($_POST['poids']));
	$yeux=strtolower(htmlspecialchars($_POST['yeux']));
	$cheveux=strtolower(htmlspecialchars($_POST['cheveux']));
	$fume=strtolower(htmlspecialchars($_POST['fume']));
	$bois=strtolower(htmlspecialchars($_POST['bois']));
	$status=strtolower(htmlspecialchars($_POST['status']));
	$orientation=strtolower(htmlspecialchars($_POST['orientation']));
	
	$sql=mysql_query("UPDATE members SET `city`='$city', `country`='$country' , `taille`='$taille' , `poid`='$poids' , `yeux`='$yeux' , `chx`='$cheveux' , `fume`='$fume', `bois`='$bois', `orientation`='$orientation', `status`='$status'
					  WHERE username='".$_SESSION['sess_pseudo']."'")or die('Erreur de selection '.mysql_error());
	message_redir('Mise à Jour de l\'étape 3 effectuée avec succés !','?p=membre/profil');

break;
#########################################################################################################################
// MAJ des informations ETAPE 4 //
#########################################################################################################################
case "maj4":

	if (empty($_POST)) rediriger("?p=erreur&code=03"); 

	$des=strtolower(htmlspecialchars(addslashes($_POST['des'])));
	$rech=strtolower(htmlspecialchars(addslashes($_POST['rech'])));
	$occ=strtolower(htmlentities(addslashes($_POST['occ'])));
	
	$sql=mysql_query("UPDATE members SET `about`='$des', `recherchetxt`='$rech' , `occupations`='$occ' 
					  WHERE username='".$_SESSION['sess_pseudo']."'")or die('Erreur de selection '.mysql_error());
	message_redir('Mise à Jour de l\'étape 4 effectuée avec succés !','?p=membre/profil');

break;
#########################################################################################################################
// MAJ des informations ETAPE 5 //
#########################################################################################################################
case "maj5":

	//if (empty($_POST)) rediriger("?p=erreur&code=03"); 

			// Infos sur le fichier envoyé
			$nomFichier    = $_FILES["img1"]["name"] ;
			$nomTemporaire = $_FILES["img1"]["tmp_name"] ;
			$typeFichier   = $_FILES["img1"]["type"] ;
			$poidsFichier  = round($_FILES["img1"]["size"]/1024) ;
			$nom2 		   = explode(".", $nomFichier);
			$extension	   = strtolower(array_pop(explode(".", $nomFichier)));
								
			// Vérifications
				if ($extension!="jpg" && $extension!="png" && $extension!="gif") {
					message_redir("------------- ERREUR -------------\\nLe format du fichier n'est pas autorisé.\\nLes extensions valides sont JPG, PNG et GIF !","?p=membre/profil");
				}
				if ($poidsFichier>=1500) {
					message_redir("------------- ERREUR -------------\\nVotre image a une taille supérieure à 1.5mo \\nVeuillez réduire votre image avant de recommancer","?p=membre/profil");
				}

			// On copie la Photo en Grand Format 
				$chemin = ("upload/big/");
				copy($nomTemporaire, $chemin.$nomFichier);
				
			// On cré la miniature à partir de la photo grand format
			$urlimage = "upload/big/".$nomFichier;
			$imgmin = RatioResizeImg($urlimage,120,140,"upload/principal/");
			
			// On supprime la photo grand format
			@unlink($chemin.$nomFichier);
			
			$sql = mysql_query("UPDATE `members` SET `img_principale`='$imgmin', `img_valid`='0' WHERE username='".$_SESSION['sess_pseudo']."'");
			message_redir('Mise à Jour de l\'étape 5 effectué avec succés\\nUn administrateur doit validé cette photo avec qu\'elle soit diffusée sur le site.','?p=membre/profil');

break;
#########################################################################################################################
// Modifier son Pass //
#########################################################################################################################
case "modifPass":

	echo "<img src='images/title/confirm_pass.png'
		<div style='width:220px; height:129px; background-image:url(images/title/bgfond2.png);'>
			<div style='padding:2px; text-align:center'><br><center>Entrez votre nouveau mot de passe<br><br>
			<input type='text' name='newpass' id='newpass' style='text-align:center'><br><br>
			<div class='envoyer' id='send' style='width:70px;' OnClick='modifPass()'>&nbsp;Modifier&nbsp;</div></center>
			</div>
		</div>";
		
break;
case "modifPass2":

	session_start();
	include '../../include/config.inc.php';
	
	$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<center><b>Erreur de connexion à la base de donné. Mauvais login / mdp / Hote .</b></center>");
	mysql_select_db(BASE, $db) or die ("<center><b>Erreur de connexion base</b></center>");
		function ip() {
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
			elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
			else {$ip = $_SERVER['REMOTE_ADDR']; }
			return $ip; }
		function securite_membre() { // Vérifie de façon sécurisée que l'utilisateur est loggué en tant que membre
			if (!isset($_SESSION['sess_pseudo'])) { rediriger('?p=erreur&code=01'); } 
			$sql = mysql_query("SELECT ip FROM members WHERE username='" . $_SESSION['sess_pseudo'] . "'");
			$result = mysql_fetch_object($sql);
			if ($result->ip != ip()) { rediriger('?p=erreur&code=02'); } }
	securite_membre();
	
	$pass=$_GET['newpass'];
	$password = crypt( md5($pass) , CLE );
	$sql=mysql_query("UPDATE members SET `password`='$password' WHERE id_membre=".$_SESSION['sess_id']);
	
	echo "<b style=\'color:#FF6600\'>&nbsp;&nbsp;&nbsp; Modifié ! &nbsp;&nbsp;&nbsp;</b>";
	
break;
#########################################################################################################################
// Supprimer son compte //
#########################################################################################################################
case "supprCompte":

	head('<link rel="stylesheet" type="text/css" href="include/effet/niftyCorners.css">
		<link rel="stylesheet" type="text/css" href="include/effet/niftyPrint.css" media="print">
		<script type="text/javascript" src="include/effet/nifty.js"></script>
		<script type="text/javascript" src="include/only_ajax.js"></script>');

	echo '<script type="text/javascript">
	window.onload=function(){
	if(!NiftyCheck())return;
	Rounded("div.round","all","#B4E4E6","#FFFFFF","smooth");}
	</script>';

	echo "<br><br><br>
	<center><div style='width:400px; background-color:#FFFFFF; margin-left:auto; margin-right:auto; opacity:1' class='round'>
		<br><b style='color:#3399FF'>Etes vous sur de vouloir cloturer votre compte ?</b><br><br>
		Cette démarche n'est pas reversible, toutes vos données seront définitivement perdues !<br><br><br>
						<table width=100%>
					<tr>
						<td width=43% align='right'><div class='envoyer' id='send' style='width:50px; opacity:0.5; cursor:pointer' OnClick='window.location.replace(\"?p=membre/profil&action=supprCompte2\");'>OUI&nbsp;</div></td>
						<td width=14%>&nbsp;</td>
						<td width=43% align='left'><div class='envoyer' style='width:50px; cursor:pointer' onClick='alert(\"Vous avez pris la bonne décision ! \\nVous pouvez encore faire de bonnes rencontres sur Mon-Look !!\");window.location.replace(\"http://www.mon-look.com\");'>NON</div></td>
					</tr>
				</table><br><br>

	</div></center><br><br><br><br><br><br>";
	
	foot();
break;
case "supprCompte2":

	$sql=mysql_query("UPDATE members SET active=9 WHERE id_membre=".$_SESSION['sess_id']);
	deconnexion();
	
	head();
	echo "<br><br><br><center>Compte supprimé...</center>";
	foot();

break;

}
?>