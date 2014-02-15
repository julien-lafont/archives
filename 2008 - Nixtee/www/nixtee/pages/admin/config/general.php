<?php
$m->mbre->securite_admin("configuration");

	$page="admin.php?config-general";
	$table=PREFIX."config";
	
	$fil_ariane="<strong>Configuration</strong> / ";
	
	// Gestion des retours
	if (!empty($_GET['mess'])) {
		$mess=$_GET['mess'];
		if ($mess=="modif_ok") $retour=miseEnForme_admin('ok', "Mise à jour effectuée avec succés !");
		$m->design->assign('retour', $retour);
	}
	
switch(@$_GET['action']) {

default:
	
	// Sélection de toutes les données
	$sql=mysql_query("SELECT * FROM ".$table);

	while($conf=mysql_fetch_array($sql, MYSQL_ASSOC))
	{
		$config[$conf['cle']]=$conf['valeur'];
	}
		
	$fil_ariane.='<strong>Configuration du site</strong>';
	
	// Gestion des checkbox //
	if ($config['MODERER_COM']==1) $c1="checked";
	else						   $c2="checked";
	
	$c= '<form action="'.$page.'&action=modifier" method="post" class="f-wrap-1" onsubmit="$(\'#FOOTER\').val(oEdit1.getHTMLBody());">
			
			<div class="req"><b>*</b> Champs requis</div>
			
			<fieldset>
			
			<h3>Optimisation r&eacute;f&eacute;rencement :</h3>
			
			<label for="NOM"><b><span class="req">*</span> Nom site site internet</b>
				<input id="NOM" name="NOM" type="text" class="f-name" maxlength="255" style="width:150px" value="'.$config['NOM'].'"/> <br />
			</label>
			
			<label for="DESCRIPTION"><b>Metatag Description du site</b>
				<input id="DESCRIPTION" name="DESCRIPTION" type="text" class="f-name" maxlength="255" style="width:450px" value="'.$config['DESCRIPTION'].'"/> <br />
			</label>
			
			<label for="KEYWORDS"><b>Metatag Keywords : mots clés</b>
				<input id="KEYWORDS" name="KEYWORDS" type="text" class="f-name" maxlength="255" style="width:450px" value="'.$config['KEYWORDS'].'"/> <br />
			</label>
			
			<label for="TITRE_PAGE"><b><span class="req">*</span> Titre de la page affich&eacute; par d&eacute;faut</b>
				<input id="TITRE_PAGE" name="TITRE_PAGE" type="text" class="f-name" maxlength="255"  value="'.$config['TITRE_PAGE'].'"/> <br />
			</label>
			
			<br /><br /><h3>Configuration de la gestion du blog :</h3>
			
			<label><b><span class="req">*</span> Pr&eacute;-mod&eacute;ration des coms</b>
			</label>
				<input name="MODERER_COM" type="radio" value="1" style="width:20px;" '.@$c1.'/> Activer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="MODERER_COM" type="radio" value="0" style="width:20px;" '.@$c2.'/> D&eacute;sactiver<br />
					<i>En cas d\'activation, les commentaires ne seront visibles qu\'apr&egrave;s mod&eacute;ration.</i><br /><br />
					
			<label for="PAGE_DEFAUT"><b><span class="req">*</span> Page par d&eacute;faut affich&eacute;e sur l\'accueil du site</b>
				<input id="PAGE_DEFAUT" name="PAGE_DEFAUT" type="text" class="f-name" maxlength="255" style="width:100px" value="'.$config['PAGE_DEFAUT'].'"/> &nbsp;&nbsp;&nbsp;<span class="txt11">Ex : billets_generaux</span><br />
			</label>

			<label for="EMAIL"><b><span class="req">*</span> Email sur laquelle envoyer les messages de la page contact</b>
				<input id="EMAIL" name="EMAIL" type="text" class="f-name" maxlength="255" value="'.$config['EMAIL'].'"/> <br />
			</label>			
			

			<label for="NB_BILLETS"><b><span class="req">*</span> Nombres de billets affichés par page</b>
				<input id="NB_BILLETS" name="NB_BILLETS" type="text" class="f-name" maxlength="5" value="'.$config['NB_BILLETS'].'" style="width:30px" /><br />
			</label>
			
			<label for="NB_COM"><b><span class="req">*</span> Nombres de commentaires affichés par page</b>
				<input id="NB_COM" name="NB_COM" type="text" class="f-name" maxlength="5" value="'.$config['NB_COM'].'" style="width:30px" /><br />
			</label>
						
			<br /><br /><h3>Configuration du coeur du blog</h3>
			
			<!--<label for="NOM_FEED"><b><span class="req">*</span> Login feedburner du flux RSS</b>
				<input id="NOM_FEED" name="NOM_FEED" type="text" class="f-name" maxlength="255"  value="'.$config['NOM_FEED'].'"/> <br />
			</label>-->
			
			<label for="GROUPE_ADMIN"><b><span class="req">*</span> Groupe minimum des modos/admin</b>
				<input id="GROUPE_ADMIN" name="GROUPE_ADMIN" type="text" class="f-name" maxlength="255" style="width:20px"  value="'.$config['GROUPE_ADMIN'].'"/> <br />
			</label>
			
			<label for="GROUPE_BAN"><b><span class="req">*</span> Groupe des membres bannis</b>
				<input id="GROUPE_BAN" name="GROUPE_BAN" type="text" class="f-name" maxlength="255" style="width:20px" value="'.$config['GROUPE_BAN'].'"/> <br />
			</label>
			
			<br /><br /><h3>Zones personnalisées</h3>
			
			<label><b>Footer</b>
				'.afficher_htmlarea("FOOTER", 450, 300, 1, $config['FOOTER'], "footer.css").'
			</label>
			
			
			
			<input type="submit" value="Modifier" class="f-submit" /><br />

		</fieldset>
		</form>';
			
break;

case "modifier":

	foreach($_POST as $cle=>$val) {
		
		$val=mysql_real_escape_string($val);
		
		// modification dans la bdd 
		$sql=mysql_query("UPDATE $table SET `valeur`='$val' WHERE `cle`='$cle'");
	}

	header('location: '.$page.'&mess=modif_ok');
	
break;

}	
	
	$m->design->assign('titre', 'Configuration du site');
	$m->design->assign('fil_ariane', $fil_ariane);
	$m->design->assign('contenu', $c);

?>