<?php
securite_admin();

	$design->zone('titrePage', 'Administration Membres');
	$design->zone('titre', 'Gérer les membres');
	
	$champs=array('Pseudo'=>'pseudo','Email'=>'email','Groupe'=>'groupe','Pass'=>'mdp','Nom'=>'gen_nom','Prenom'=>'gen_prenom','Pays'=>'gen_pays','Date Naissance'=>'gen_date_naiss','Sexe'=>'gen_sexe','Ville'=>'gen_ville','Msn'=>'c_msn','Blog'=>'c_blog','Site'=>'c_site','Irc'=>'c_irc','Cpu'=>'h_cpu','Ram'=>'h_ram','Stockage'=>'h_stockage','Carte graph'=>'h_carte_graph','Carte son'=>'h_carte_son','Clavier'=>'h_clavier','Souris'=>'h_souris','Moniteur'=>'h_moniteur','Ecouteur'=>'h_ecouteur','Connexion'=>'s_connexion','Résolution'=>'s_resolution','OS'=>'s_os','FAI'=>'s_fai','Pref arme'=>'g_arme','Pref map'=>'g_map','Sensibility'=>'g_sens','Clan'=>'g_clan','Avatar'=>'avatar','Amis'=>'amis','Visiteurs'=>'visiteurs', 'Config'=>'url_config', 'Date upload Config'=>'date_config');

switch(@$_GET['action'])
{
default:

	$c='<div id="retour"><a href="?admin"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		
		<br /><br /><div class="titreMessagerie">Rechercher un membre par :</div><br />
		
		<form id="form" action="?admin-membres&action=search" method="post" onsubmit="return verifSearch()">
			<table style="border:0; width:100%; margin-left:30px">
				<tr>
					<td width="100"><b>Son Pseudo</b></td>
					<td width="220"><input type="text" name="pseudo" id="pseudo" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
				<tr>				
					<td><b>Son Email</b></td>
					<td><input type="text" name="email" id="email" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
				<tr>				
					<td><b>Son IP</b></td>
					<td><input type="text" name="ip" id="ip" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
			</table>
		</form>';

break;

case "search":

	if (!empty($_POST['email'])) 		$search="email='".strtolower($_POST['email'])."'";
	elseif (!empty($_POST['pseudo'])) 	$search="pseudo='".strtolower($_POST['pseudo'])."'";
	elseif (!empty($_POST['ip'])) 		$search="last_ip='".strtolower($_POST['ip'])."'";
	else 								$search="id='".$_GET['id']."'";
	
	$sql=mysql_query("	SELECT * 
						FROM ".PREFIX."membres m
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						WHERE $search");
		$d=mysql_fetch_object($sql);
			$id=$d->id;
		$nb=mysql_affected_rows();
		
	$c='<div id="retour"><a href="?admin-membres"><img src="images/retour.png" onmouseover="this.src=\'images/retour_hover.png\';" onmouseout="this.src=\'images/retour.png\';" alt="retour" /></a></div>
		<br><center><span style="color:#FF6600; font-weight:bold">Rechercher un membre par :</span></center><br>
		
		<form id="form" action="?admin-membres&action=search" method="post" onsubmit="return verifSearch()">
			<table style="border:0; width:100%; margin-left:30px">
				<tr>
					<td width="100"><b>Son Pseudo</b></td>
					<td width="220"><input type="text" name="pseudo" id="pseudo" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
				<tr>				
					<td><b>Son Email</b></td>
					<td><input type="text" name="email" id="email" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
				<tr>				
					<td><b>Son IP</b></td>
					<td><input type="text" name="ip" id="ip" /></td>
					<td><input type="submit" class="submit" value="ok" style="width:25px" /></td>
				</tr>
			</table>
		</form>		
		
		<span style="color:#00A8FF">
			<center>___________________________________________________________________</center>
		</span>
		<br><br>';
		
		if ($nb==0) 
		{
			$c.='<center><b>Membre introuvable !</b></center>';
		} 
		else 
		{
		
			$c.='<center><b>Membre : <u>'.ucfirst($d->pseudo).'</u></b></center><br>
				 <center><a href="?admin-membres&action=suppr&id='.$d->id.'" onclick="return confirm(\'Etes vous sur de vouloir supprimer le membre '.$d->membre.' ?\');" style="color:#FF0000">Supprimer le membre</a></center><br>
			
			<form method="post" action="?admin-membres&action=modifier&id='.$id.'">
			<table id="table_ad_membre" style="width:450px; border:1px solid #ccc; margin:0 auto" align="center">
				<tr>
					<td width="100" class="center"><b>Champs</b></td>
					<td>&nbsp;&nbsp;&nbsp;<b>Valeur</b></td>
				</tr>';
			
			$i=0;	
			foreach($champs as $champ=>$valeur) 
			{
				if ($i%2==0) $class="tr1"; else $class="tr2";
				
				// Infos en plus
				switch($valeur) {
					default:
					 $enPlus='';
					break;
					case "mdp":
					  $plus='<span id="lienPass"><a href="#" onclick="$(\'#coderPass\').css(\'display\',\'inline\'); $(\'#lienPass\').hide(); return false;">Crypter un mdp</a></span>
							<div id="coderPass" style="display:none">
								Nouveau mdp : <input type="text" id="newPass" style="width:50px" /> <input type="button" class="submit" value="crypter" style="width:50px" onclick="crypterPass();" />
							</div>';
					break;
					case "groupe":
					  $plus='<b>0</b>:inactif - <b>1</b>:membre - <b>3</b>:Mbre de la Team <br />&nbsp;&nbsp;> <b>4</b>:Modérateur - <b>5</b>:admin - <b>9</b>:BANNI';
					break;
				}
				if (!empty($plus)) { $enPlus='<br>&nbsp;&nbsp;> '.$plus; $plus=''; }
				
				$c.='<tr class="'.$class.'">
						<td class="center">'.$champ.'</td>
						<td><input type="text" name="'.$valeur.'" id="'.$valeur.'" value="'.stripslashes($d->$valeur).'" />'.$enPlus.'</td>
					</tr>';
					
				
				$i++;
			}
			
			
			$c.='
			<tr>
				<td></td>
				<td><input type="submit" class="submit" value="Modifier" style="width:100px; font-weight:bold" /></td>
			</tr>
		</table>
		</form>';
		}
		
break;

case "modifier":

	$id=$_GET['id'];
	$post=$_POST;
	
	$noslashes=array('pseudo', 'email', 'mdp', 'amis', 'visiteurs');
	
	$set='';
	foreach($post as $champ=>$valeur)
	{
		if (!in_array($champ, $noslashes)) $valeur=addslashes($valeur);
		$set.="`$champ`='$valeur', ";
	}
	$set=substr($set, 0, -2);
	
	$sql=mysql_query("UPDATE ".PREFIX."membres m 
						LEFT JOIN ".PREFIX."membres_detail md
						ON md.id_membre=m.id
						SET $set
						WHERE m.id=$id") or die(mysql_error());
	
	header('location: ?admin-membres&action=search&id='.$id);
	
break;

case "suppr":

	$id=$_GET['id'];
	$sql1=mysql_query("DELETE FROM ".PREFIX."membres WHERE id=$id");
	$sql2=mysql_query("DELETE FROM ".PREFIX."membres_detail WHERE id_membre=$id");
	$sql3=mysql_query("DELETE FROM ".PREFIX."guestbook WHERE id_membre=$id");
	$sql4=mysql_query("DELETE FROM ".PREFIX."messagerie WHERE id_dest=$id");
	$sql5=mysql_query("DELETE FROM ".PREFIX."galerie_verif_vote WHERE id_membre=$id");
	$sql6=mysql_query("SELECT img FROM ".PREFIX."galerie WHERE id_membre=$id");
		while ($d=mysql_fetch_object($sql6))
		{
			echo $d->img.'<br>';
			@unlink('images/upload/galerie/'.$id.'/'.$d->img);
			@unlink('images/upload/galerie/'.$id.'/min_'.$d->img);
			
		}
		@rmdir('images/upload/galerie/'.$id.'/');
	$sql7=mysql_query("DELETE FROM ".PREFIX."galerie WHERE id_membre=$id");
	
	$c='<div id="retour"><a href="?admin-membres">&lsaquo; Retour &lsaquo;</a></div>'
		.miseEnForme('message', 'Membre supprimé avec succés !');

break;
}

$design->zone('contenu', $c);

?>