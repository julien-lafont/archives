<?php
	
	// Protection
	$m->mbre->securite_admin();
	
	$m->design->assign("fil_ariane","<a href='admin.php?accueil'>Accueil</a>");

	// Commentaires en attente de validation
	$nb_coms=mysql_nb("SELECT id_com FROM ".PREFIX."commentaires WHERE statut=0");
	
	$contenu='
		<table style="width:75%; margin:40px auto 40px auto">
			<tr>
				<td width="33%" style="vertical-align:top">
					<form action="?" method="get">
					<fieldset style="margin-left:15px">
						
						<h4>Infos sur un membre</h4>
						
						<input type="hidden" name="page" value="admin-commandes-infos" />
						<label><b>Pseudo</b> &nbsp; 	
							<input id="idA" name="id" type="text" style="width:50px" /><br />					
						</label>
						<input type="submit" value="Rechercher" class="f-submit"/><br />
			
					</fieldset>
					</form>
				</td>
				
				<td width="33%" style="vertical-align:top">
					<h4>En attente de validation : </h4>
						Commentaires : <a href="admin.php?commentaires-amoderer"><strong>'.$nb_coms.'</strong></a><br />
				</td>				
				
				<td width="33%" style="vertical-align:top">
					<h4>Gestionnaire de fichiers : </h4>
					<div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image\'); return false">Parcourir</a></div>
				</td>
			</tr>
		</table>';

	$m->design->assign('contenu', $contenu);
?>