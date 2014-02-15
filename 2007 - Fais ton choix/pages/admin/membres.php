<?php
securite('5+');

switch(@$_GET['act']) {

default:

	if (!$_GET['openAjouter']==1) $styleAj='style="display:none"';
	if (!$_GET['openGerer']==1)   $styleG='style="display:none"';
	if (!$_GET['openRaz']==1)   $styleR='style="display:none"';
	
		$c='<h2>Gestions des animateurs/admin</h2>
			
			<table id="cat" align="center" cellspacing="5">
				<tr>
					<td ><a href="#" onclick="Element.show(\'ajouter_anim\'); Element.hide(\'gerer_anim\'); Element.hide(\'raz\'); return false">Ajouter au staff</a></td>
					<td ><a href="#" onclick="Element.show(\'gerer_anim\'); Element.hide(\'ajouter_anim\'); Element.hide(\'raz\'); return false">Gérer le staff</a></td>
					<td ><a href="#" onclick="Element.show(\'raz\'); Element.hide(\'gerer_anim\'); Element.hide(\'ajouter_anim\'); return false">RAZ points</a></td>				</tr>
			</table>
			
			<div id="ajouter_anim" '.@$styleAj.'>';
			
				if (@$_GET['errorA']==1) $c.='<br /><br /><center><span style="color:red; font-size:11px">Merci de remplir tous les champs !</span></center>';
				if (@$_GET['okA']==1) $c.='<br /><br /><center><span style="color:#0066FF; font-size:11px">Membre ajouté avec succés !</span></center>';

			$c.='<form id="form" method="post" action="?admin-membres&act=ajouter">
					<fieldset id="form" style="text-align:center; color:#666"><br /><br />
					
						<b style="color:#39F"><u>Ajouter un animateur/administrateur</u></b><br /><br /><br />
						Login<br />
						<input type="text" name="nom"  style="text-align:center"/><br /><br />
						Mot de passe<br />
						<input type="text" name="pass"  style="text-align:center"/><br /><br />
						Grade<br />
						<select name="niveau">
							<option value="4">Animateur</option>
							<option value="5">Administrateur</option>
						</select><br /><br />
						<input type="submit" value="ajouter" class="submit" />
					</fieldset>
			</form>
					
			
			</div>
			
			<div id="gerer_anim" '.@$styleG.'><br /><br />';
			
			if (@$_GET['okG']==1) $c.='<center><span style="color:#0066FF; font-size:11px">Duel édité avec succés !</span></center><br /><br />';
			if (@$_GET['okV']==1) $c.='<center><span style="color:#0066FF; font-size:11px">Votes réinitialisés avec succés !</span></center><br /><br />';

			$c.='<table id="liste" align="center" style="width:600px">
					<tr>
						<td class="titre" width="100">Groupe</td>
						<td class="titre" width="100%">Nom</td>	
						<td class="titre">Actions</td>
					</tr>';
					
	$sqlL=mysql_query("SELECT * FROM ".PREFIX."admin ORDER BY groupe DESC");
	while ($d=mysql_fetch_object($sqlL)) {
		
		if ($d->groupe==4) $groupe="Animateur";
		else if ($d->groupe==5) $groupe="Administrateur";
		else $groupe=$d->groupe;
		
		$c.='<tr><td>'.$groupe.'</td>
			 <td>'.recupBdd($d->pseudo).'</td>
			 <td><a href="?admin-membres&act=editer&id='.$d->id.'" /><img src="images/boutons/edit.png" /></a>&nbsp; <a href="?admin-membres&act=suppr&id='.$d->id.'"><img src="images/boutons/cancel.png" /></a>';
		}
		
		$c.='</table>
				
			</div>
			
		<div id="raz" '.@$styleR.'><br /><br />';
		
			if (isset($_GET['razOk'])) $c.='<center><span style="color:#FF6600; font-weight:bold">Remise à Zero effectuée avec succés ! </span></center>';
		
			$c.='<br /><br /><center>Cette action aura pour conséquence de remettre à zéro les points accumulés par les membres.<br /><br />
			<b>Confirmer cette action ?</b><br /><a href="?admin-membres&act=raz">OUI</a></center>
		</div>';
break;

case "ajouter":

	$nom=addslashes($_POST['nom']);
	$pass=addslashes($_POST['pass']);
		$passCrypt=crypt(md5($pass), CLE);	
	$niveau=addslashes($_POST['niveau']);
	
	if (empty($nom) || empty($pass) ) {
		header('location: ?admin-membres&openAjouter=1&errorA=1');
		exit();
	}
	
	$date=date("d.m");
	$sql=mysql_query("INSERT INTO ".PREFIX."admin (`pseudo` , `pass` , `groupe`) VALUES ('$nom', '$passCrypt', '$niveau')");
	
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	
	header('location: ?admin-membres&openAjouter=1&okA=1');
	
break;

case "suppr":
	
	$sql=mysql_query("DELETE FROM ".PREFIX."admin WHERE id=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	header('location: ?admin-membres&openGerer=1');

break;

case "editer":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."admin WHERE id=$id");
	$d=mysql_fetch_object($sql);

	if (@$_GET['error']==1) $c='<center><span style="color:red; font-size:11px">Merci de remplir tous les champs !</span></center>';
	
	if ($d->groupe==4)  $select4="selected";
	else 				$select5="selected";
	
	$c='<h2>Editer le profil d\'un admin : </h2>
			
			<form id="form" method="post" action="?admin-membres&act=editer2">
					<fieldset id="form" style="text-align:center; color:#666"><br /><br />
					
						<b style="color:#39F"><u>Ajouter un animateur/administrateur</u></b><br /><br /><br />
						Login<br />
						<input type="text" name="nom" value="'.recupBdd($d->pseudo).'" style="text-align:center" /><br /><br />
						Mot de passe<br />
						<span style="color:#FF6600; font-size:10px">Laissez vide pour ne pas changer le mdp</span><br />
						<input type="text" name="pass" style="text-align:center" /><br /><br />
						Grade<br />
						<select name="niveau">
							<option value="4" '.@$select4.'>Animateur</option>
							<option value="5" '.@$select5.'>Administrateur</option>
						</select><br /><br />
						<input type="hidden" name="id" value="'.$id.'" />
						<input type="submit" value="éditer" class="submit" />
					</fieldset>
			</form>';
	
break;

case "editer2":
	
	$nom=addslashes($_POST['nom']);
	$pass=addslashes($_POST['pass']);
		$passCrypt=crypt(md5($pass), CLE);	
	$niveau=addslashes($_POST['niveau']);
	$id=$_POST['id'];

	if (!empty($pass)) $passVerif=", `pass`='$passCrypt'";
	$sql=mysql_query("UPDATE ".PREFIX."admin SET `pseudo`='$nom', `groupe`='$niveau' $passVerif WHERE id=$id");
	
	header('location: ?admin-membres&openGerer=1');
	
break;

case "raz":

	$sql=mysql_query("UPDATE ".PREFIX."membres SET nb_votes=0, nb_soumissions=0, points=0");
	header('location: ?admin-membres&openRaz=1&razOk=1');
	

break;
}

$design->template('admin');
$design->zone('contenu', $c);
$design->zone('categorie', 'GESTION DES MEMBRES');

?>
