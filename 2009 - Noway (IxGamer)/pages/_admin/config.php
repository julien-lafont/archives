<?php

// Protège la page : accessible seulement aux Admins
securite_admin();

switch (@$_GET['act']) 
{
default:

	$sql=mysql_query("SELECT * FROM ".PREFIX."config");
	
	$c='<div class="titreMessagerie">Configuration des variables du site</div>
	
		<div style="text-align:center">Par sécurité, vous ne pouvez pas modifier les informations de connexion MYSQL.</div>
		
		<form name="config" action="?admin-config&act=edit" method="post">
			<fieldset id="form" style="margin-left:25px">
			
				<table style="width:90%; border:0; border:1px solid #ccc; background-color:#FAFAFA; margin:15px 0 0 15px; padding:5px">';
					
			while ($d=mysql_fetch_object($sql)) {
				
				if ($d->cle!="SPONSOR") {
				
					if ($d->type=="textarea")
						$c.='<tr>
								<td>'.recupBdd($d->description).'<br />
									<textarea type="text" name="'.recupBdd($d->cle).'" style="width:440px; margin:5px 0 15px 20px"/>'.recupBdd($d->valeur).'</textarea></td>
							</tr>';
					elseif ($d->type=="petit") {
						$c.='<tr>
								<td>'.recupBdd($d->description).'<br />
									<input type="text" name="'.recupBdd($d->cle).'" value="'.recupBdd($d->valeur).'" style="width:100px; margin:5px 0 15px 20px" /></td>
							</tr>';
					}
					else {
						$c.='<tr>
								<td>'.recupBdd($d->description).'<br />
									<input type="text" name="'.recupBdd($d->cle).'" value="'.recupBdd($d->valeur).'" style="width:300px; margin:5px 0 15px 20px" /></td>
							</tr>';
					}	
				}
						
			}
		
		
	$c.='			<tr>
						<td colspan="2"><br /><input type="submit" class="submit" value="Modifier" /></td>
					</tr>
				</table>
			
			</fieldset>
		</form><br /><br />';
		
break;

case "edit":
	
	foreach($_POST as $cle=>$val) {
		
		$val=mysql_real_escape_string($val);
		
		// Modification dans la bdd 
		$sql=mysql_query("UPDATE ".PREFIX."config SET `valeur`='$val' WHERE `cle`='$cle'");
	}

	header('location: ?admin-config');
	
break;
}

$design->zone('contenu', $c);
$design->zone('titre', 'Configuration du site');
$design->zone('titrePage', 'Configuration du site');


?>