<?php

// Protège la page : accessible seulement aux Admins
securite_admin();

$contenu='


		<table style="width:75%; margin:40px auto 40px auto">
			<tr>
				<td width="33%">
					<form action="?" method="get">
					<fieldset style="margin-left:15px">
						
						<h4>Accéder à une commande</h4>
						
						<input type="hidden" name="page" value="admin-commandes-infos" />
						<label><b>ID</b> &nbsp; 	
							<input id="idA" name="id" type="text" style="width:50px" /><br />					
						</label>
						<input type="submit" value="Rechercher" class="f-submit"/><br />
			
					</fieldset>
					</form>
				</td>
				
				<td width="33%">
					<form action="?" method="get">
					<fieldset>
						
						<h4>Accéder à une produit</h4>
						<input type="hidden" name="page" value="admin-produits-gerer" />
						<input type="hidden" name="action" value="editer" />
						<label><b>ID &nbsp;</b> 
							<input id="idB" name="id" type="text"  style="width:50px" /><br />
						</label>
						<input type="submit" value="Rechercher" class="f-submit" tabindex="4"/><br />
			
					</fieldset>
					</form>
				</td>				
				
				<td width="33%">
					<form action="?" method="get">
					<fieldset>
						
						<h4>Accéder à un client</h4>
						<input type="hidden" name="page" value="admin-membres-gerer" />
						<input type="hidden" name="action" value="editer" />						<label><b>ID</b> &nbsp; 
						<input id="idC" name="id" type="text" tabindex="5" style="width:50px" /><br />
						</label>
						<input type="submit" value="Rechercher" class="f-submit" tabindex="6" readonly/><br />
			
					</fieldset>
					</form>
				</td>
			</tr>
		</table>';

	$design->zone('contenu', $contenu);
	$design->zone('titre', 'Accueil de l\'administration');

?>