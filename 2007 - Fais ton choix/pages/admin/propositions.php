<?php
securite('4+');


switch(@$_GET['act']) {

default:

	$sql=mysql_query("SELECT * FROM ".PREFIX."propositions WHERE etat<5 ORDER BY id DESC");
	$nb=mysql_num_rows($sql);
	
	$c='<h2>Listes des propositions non classées</h2>
	
		Cette page sert à faire un premier tri dans propositions des membres : celles qui seraient potentiellement utilisables et les autres farfelues.<br /><br />
		
		<center><a href="?admin-propositions&act=good">&raquo; <b>Liste des propositions intéressantes</b> &laquo;</a> </center><br />
		<table id="liste" align="center" style="width:600px">
			<tr>
				<td class="titre" width="50">New ?</td>	
				<td class="titre" width="300">Proposition</td>	
				<td class="titre" width="200">Classement</td>	
			</tr>';
	if ($nb==0) $c.='<tr><td colspan="3"><br />Pas de nouvelles propositions<br /><br /></td></tr>';		
	while ($d=mysql_fetch_object($sql)) {
		if ($d->etat==0) { $new='&bull;'; /*$sql2=mysql_query("UPDATE ".PREFIX."propositions SET etat=1 WHERE id=".$d->id);*/ }
		else $new="";
		
			$c.='<tr id="tr'.$d->id.'"><td style="color:#00A8FF">'.$new.'</td>
			 <td>'.recupBdd($d->nom1).' VS '.recupBdd($d->nom2).'</td>
			 <td style="font-size:11px"><a href="#" onclick="proposition(\'garder\', '.$d->id.'); return false">A garder</a> - <a href="#" onclick="proposition(\'jet\', '.$d->id.'); return false">A jeter</a></td></tr>';
	}
		
			$c.='</table>';


break;

case "good":

	$sql=mysql_query("SELECT * FROM ".PREFIX."propositions WHERE etat>=5 ORDER BY id DESC LIMIT 0,50");
	
	$c='<h2>Les propositions intéressantes :</h2><br /><br />
	
	Liste des 50 dernières propositions jugées intéressantes : 
	
	<ul>';
	
	while ($d=mysql_fetch_object($sql)) {
		$c.='<li><b>'.recupBdd($d->nom1).'</b> vs <b>'.recupBdd($d->nom2).'</b></li>';
	}
	
	$c.='</ul>';


break;
}	

$design->template('admin');
$design->zone('contenu', $c);
$design->zone('categorie', 'GESTION DES PROPOSITIONS');
?>