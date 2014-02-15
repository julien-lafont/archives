<?php
securite('4+');


switch(@$_GET['act']) {

default:

	if (!$_GET['openAjouter']==1) $styleAj='style="display:none"';
	if (!$_GET['openGerer']==1)   $styleG='style="display:none"';
	
		$c='<h2>Gestion des duels :</h2>
			
			<table id="cat" align="center" cellspacing="5">
				<tr>
					<td ><a href="#" onclick="Element.show(\'ajouter_duel\'); Element.hide(\'gerer_duel\'); return false">Ajouter un duel</a></td>
					<td ><a href="#" onclick="Element.show(\'gerer_duel\'); Element.hide(\'ajouter_duel\'); return false">Gérer les duels</a></td>
				</tr>
			</table>
			
			<div id="ajouter_duel" '.@$styleAj.'>';
			
				if (@$_GET['errorA']==1) $c.='<br /><br /><center><span style="color:red; font-size:11px">Merci de remplir tous les champs !</span></center>';
				if (@$_GET['okA']==1) $c.='<br /><br /><center><span style="color:#0066FF; font-size:11px">Duel ajouté avec succés !</span></center>';

			$c.='<form id="form" method="post" action="?admin-duels&act=ajouter">
			<table id="table_aj_duel" align="center">
				<tr>
					<td style="border-right:2px solid #ccc">
						<b>Nom du premier concurrent</b><br /><br />
						<input type="text" name="nom1" />
					</td>
					<td>
						<b>Nom du second concurrent</b><br /><br />
						<input type="text" name="nom2" />
					</td>
				</tr>
				
				<tr>
					<td style="border-right:2px solid #ccc; padding-top:40px">
						<b>Image one</b><br /><br />
						<input type="text" name="url1" style="width:250px" />
					</td>
					<td style=" padding-top:40px"> 
						<b>Image two</b><br /><br />
						<input type="text" name="url2" style="width:250px" />
					</td>
				</tr>
				<tr>
					<td colspan="2" style="font-size:11px">Nom du fichier sans le chemin<br /><br /></td>
				</tr>
				<!--<tr>
					<td  style="border-right:2px solid #ccc; ><span style="font-size:15px; color:#06F">OU</span><br /><br /></td>
					<td><span style="font-size:15px; color:#06F">OU</span><br /><br /></td>
				</tr>
				
				<tr>
					<td style="border-right:2px solid #ccc;">
						<input type="file" name="img1" style="width:250px" disabled="disabled"/>
					</td>
					<td> 
						<input type="file" name="img2" style="width:250px" disabled="disabled"/>
					</td>
				</tr>-->
				<tr>
					<td colspan="2"><br /><input type="submit" value="&nbsp;&nbsp;&nbsp; Ajouter &nbsp;&nbsp;&nbsp;" class="submit"/></td>
				</tr>
	
			</table>
			</form>
					
			
			</div>
			
			<div id="gerer_duel" '.@$styleG.'><br /><br />';
			
			if (@$_GET['okG']==1) $c.='<center><span style="color:#0066FF; font-size:11px">Duel édité avec succés !</span></center><br /><br />';
			if (@$_GET['okV']==1) $c.='<center><span style="color:#0066FF; font-size:11px">Votes réinitialisés avec succés !</span></center><br /><br />';

			$c.='<table id="liste" align="center" style="width:600px">
					<tr>
						<td class="titre" width="20">ID</td>
						<td class="titre" width="314">Nom 1</td>	
						<td class="titre" width="314">Nom 2</td>	
						<td class="titre" width="75">Votes</td>';
						if ($_SESSION['sess_level']>=5) $c.='<td class="titre" width="75">Animateur</td>';
						$c.='<td class="titre" width="52">Actions</td>	
					</tr>';
					
	$sqlL=mysql_query("SELECT * FROM ".PREFIX."duels ORDER BY id DESC");
	while ($d=mysql_fetch_object($sqlL)) {
		$c.='<tr><td>'.$d->id.'</td>
			 <td>'.recupBdd($d->nom1).'</td>
			 <td>'.recupBdd($d->nom2).'</td>
			 <td>'.$d->note1.' - '.$d->note2.'</td>';
			 if ($_SESSION['sess_level']>=5) $c.='<td>'.$d->admin.'</td>';
			 $c.='<td><a href="?admin-duels&act=edit&id='.$d->id.'"><img src="images/boutons/edit.png" /></a> &nbsp; <a href="?admin-duels&act=suppr&id='.$d->id.'"><img src="images/boutons/del.png" /></a></td></tr>';
		}
		
		$c.='</table>
				
			</div>';
break;

case "ajouter":

	$nom1=addslashes($_POST['nom1']);
	$nom2=addslashes($_POST['nom2']);
	
	$url1=addslashes($_POST['url1']);
	$url2=addslashes($_POST['url2']);
	
	if (empty($nom1) || empty($nom2) || empty($url1) || empty($url2)) {
		header('location: ?admin-duels&openAjouter=1&errorA=1');
		exit();
	}
	
	$date=date("d.m");
	$sql=mysql_query("INSERT INTO ".PREFIX."duels (`nom1` , `nom2` , `img1` , `img2` , `date` , `timestamp`, `admin`) VALUES ('$nom1', '$nom2', '$url1', '$url2', '$date', '".time()."', '".$_SESSION['sess_pseudo']."' )") or die(mysql_error());
	
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_duels=nb_duels+1 WHERE id=".$_SESSION['sess_id']);
	
	@maj_rss();
	include ('pages/admin/make_module_js.php');
	
	header('location: ?admin-duels&openAjouter=1&okA=1');
	
break;

case "suppr":

	$sql=mysql_query("DELETE FROM ".PREFIX."duels WHERE ID=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);

	@maj_rss();
	include ('pages/admin/make_module_js.php');
	
	header('location: ?admin-duels&openGerer=1');
	
break;

case "edit":

	$id=$_GET['id'];
	$sql=mysql_query("SELECT * FROM ".PREFIX."duels WHERE id=$id");
	$d=mysql_fetch_object($sql);

	if (@$_GET['error']==1) $c='<center><span style="color:red; font-size:11px">Merci de remplir tous les champs !</span></center>';
	
	@$c.='<form id="form" method="post" action="?admin-duels&act=edit2&id='.$id.'">
			<table id="table_aj_duel" align="center">
				<tr>
					<td style="border-right:2px solid #ccc">
						<b>Nom du premier concurrent</b><br /><br />
						<input type="text" name="nom1" value="'.$d->nom1.'" />
					</td>
					<td>
						<b>Nom du second concurrent</b><br /><br />
						<input type="text" name="nom2" value="'.$d->nom2.'" />
					</td>
				</tr>
				
				<tr>
					<td style="border-right:2px solid #ccc;"><br /><br /><b>Image one</b><br /><br /><img src="'.DUEL.$d->img1.'" style="border:1px solid #ccc" /></td>
					<td><br /><br /><b>Image two</b><br /><br /><img src="'.DUEL.$d->img2.'" style="border:1px solid #ccc" /></td>
				</tr>
				<tr>
					<td style="border-right:2px solid #ccc;">
						<br /><input type="text" name="url1" style="width:250px" value="'.$d->img1.'" />
					</td>
					<td> 
						<br /><input type="text" name="url2" style="width:250px" value="'.$d->img2.'" />
					</td>
				</tr>
				<tr>
					<td colspan="2" style="font-size:11px">Nom du fichier sans le chemin<br /><br /></td>
				</tr>
				<!--<tr>
					<td  style="border-right:2px solid #ccc; ><span style="font-size:15px; color:#06F">OU</span><br /><br /></td>
					<td><span style="font-size:15px; color:#06F">OU</span><br /><br /></td>
				</tr>
				
				<tr>
					<td style="border-right:2px solid #ccc;">
						<input type="file" name="img1" style="width:250px" disabled="disabled"/>
					</td>
					<td> 
						<input type="file" name="img2" style="width:250px" disabled="disabled"/>
					</td>
				</tr>-->
				<tr>
					<td colspan="2"><br /><input type="submit" value="&nbsp;&nbsp;&nbsp; éditer &nbsp;&nbsp;&nbsp;" class="submit"/></td>
				</tr>
				<tr>
					<td colspan="2"><br /><br />/!\ <a href="?admin-duels&act=vote&id='.$id.'">Remettre les votes à 0</a> /!\ </td>
				</tr>
	
			</table>
			</form>';

break;

case "edit2":

	$id=$_GET['id'];
	
	$nom1=addslashes($_POST['nom1']);
	$nom2=addslashes($_POST['nom2']);
	
	$url1=addslashes($_POST['url1']);
	$url2=addslashes($_POST['url2']);
	
	if (empty($nom1) || empty($nom2) || empty($url1) || empty($url2)) {
		header('location: ?admin-duels&act=edit&id='.$id.'&error=1');
		exit();
	}
	
	$sql=mysql_query("UPDATE ".PREFIX."duels SET `nom1`='$nom1', `nom2`='$nom2', `img1`='$url1', `img2`='$url2' WHERE id=$id");
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	
	@maj_rss();
	include ('pages/admin/make_module_js.php');

	header('location: ?admin-duels&openGerer=1&okG=1');

break;

case "vote" :

	$id=$_GET['id'];
	$sql=mysql_query("SELECT nom1, nom2 FROM ".PREFIX."duels WHERE id=$id");
	$d=mysql_fetch_object($sql);
	
	$c='<h2>Réinitialiser les votes d\'un duel</h2><br /><br />
	
		<p>Etes vous sûr de vouloir réinitialiser les votes pour le duel <b>'.recupBdd($d->nom1).'</b> <span>vs</span> <b>'.recupBdd($d->nom2).'</b> : <br /><br />
		<a href="?admin-duels&act=vote2&id='.$id.'">OUI</a> ou <a href="?admin-duels&openGerer=1">NON</a></p>';

break;

case "vote2":

	$sql=mysql_query("UPDATE ".PREFIX."duels SET note1=1, note2=1, votestotal=2 WHERE id=".$_GET['id']);
	$sql2=mysql_query("UPDATE ".PREFIX."admin SET nb_actions=nb_actions+1 WHERE id=".$_SESSION['sess_id']);
	
	header('location: ?admin-duels&openGerer=1&okV=1');

}	

$design->template('admin');
$design->zone('contenu', $c);
$design->zone('categorie', 'GESTION DES DUELS');

?>