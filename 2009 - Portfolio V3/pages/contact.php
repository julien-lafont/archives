<?php

$design->template('simple');
$design->zone('titrePage', "Demande d'informations");

$design->zone('titre', '<a href="contact.htm" title="Contactez Julien LAFONT alias YoTsumi, Studio-dev.fr">Formulaire de contact</a>');

$c='
<div style="font-size:13px"><br />Si vous souhaitez me contacter, utilisez ce formulaire ou écrivez moi directement à l\'adresse : <img src="images/email_white.png" class="noborder" style="vertical-align:middle"/> <br /></div>
<form name="contact" id="form_contact" action="#" method="post" onsubmit="contact_verif(); return false">
<fieldset id="form">

	<table>
		<tr>
			<td style="width:150px"><label for="form_nom">Votre nom <span>*</span></label></td>
			<td><input type="text" name="nom" id="form_nom" maxlength="75" class="textinput" /></td>
		</tr>
		<tr>
			<td><label for="form_email">Votre email <span>*</span></label></td>
			<td><input type="text" name="email" id="form_email" maxlength="150" /></td>
		</tr>
		<tr>
			<td ><label for="form_type">Type de demande</label></td>
			<td><select name="type" id="form_type" onchange="contact_cacher(); contact_afficher(this.options[selectedIndex].value);" style="width:150px">
					<option selected="selected" style="color:#777" value=" ">Choisir ...</option>
					<option value="infos">Informations</option>
					<option value="devis">Devis</option>
					<option value="partenariat" >Partenariat</option>
				</select></td>
		</tr>
	</table>
	
	<table id="infos" style="display:none">
		<tr>
			<td style="width:150px"><label for="form_com">Commentaire *</label></td>
			<td><textarea name="com" id="form_com"></textarea>
			<a id="fleche1a" href="#" onclick="plus_largeur(\'form_com\', \'fleche1b\'); return false"><img src="images/fleche_droite.gif" style="margin-bottom:5px; margin-left:-2px"/></a><br />
			<a id="fleche1b" href="#" onclick="plus_hauteur(\'form_com\'); return false"><img src="images/fleche_bas.gif" style="margin-left:386px; "/></a>
		</tr>
		<tr>
			<td><div class="traitement" id="statut1"></div></td>
			<td style="vertical-align:top"><input type="submit" name="Sub" value="Envoyer" class="submit" /></td>
		</tr>
	</table>
	
	<table id="devis" style="display:none;">
		<tr>
			<td colspan="2" class="tdTitre">Interlocuteur</td>
		</tr>
		<tr>
			<td width="150px"><label for="form_civilite">Civilité</label></td>
			<td><select name="civilite" id="form_civilite" style="width:150px">
					<option value=""></option>
					<option value="Mr">Monsieur</option>
					<option value="Mme">Madame</option>
					<option value="Melle" >Mademoiselle</option>
				</select></td>
		</tr>
		<tr>
			<td><label for="form_nom">Nom</label></td>
			<td><input type="text" name="nom" id="form_nom" maxlength="150" /></td>
		</tr>
		<tr>
			<td><label for="form_prenom">Prénom</label></td>
			<td><input type="text" name="prenom" id="form_prenom" maxlength="150" /></td>
		</tr>
		<tr>
			<td><label for="form_tel">Téléphone</label</td>
			<td><input type="text" name="tel" id="form_tel" maxlength="20" /></td>
		</tr>
		<tr>
			<td><label for="form_adresse">Adresse complète</label></td>
			<td><input type="text" name="adresse" id="form_adresse" /></td>
		</tr>
		<tr>
			<td colspan="2" class="tdTitre">Eléments apportés</td>
		</tr>
		<tr>
			<td><label for="form_heb">Hébergement</label></td>
			<td><input name="heb" id="form_heb" type="checkbox" value="0" style="width:15px" onchange="if (this.value==0) this.value=1; else this.value=0;"  /></td>
		</tr>
		<tr>
			<td><label for="form_ndd">Nom de domaine</label></td>
			<td><input name="ndd" id="form_ndd" type="checkbox" value="0" style="width:15px" onchange="if (this.value==0) this.value=1; else this.value=0;" /></td>
		</tr>
		<tr>
			<td><label for="form_oldver">Ancienne version</label></td>
			<td><input name="oldver" id="form_oldver" type="checkbox" value="0" style="width:15px"  onchange="if (this.value==0) this.value=1; else this.value=0;" /></td>
		</tr>
		<tr>
			<td><label for="form_org">Statut</label></td>
			<td><select name="civilite" id="form_civilite" style="width:150px">
					<option value=""></option>
					<option value="Particulier">Particulier</option>
					<option value="Association">Association</option>
					<option value="Entreprise">Entreprise</option>
					<option value="Autre">Autre</option>
				</select></td>
		</tr>
		<tr>
			<td colspan="2" class="tdTitre">Spécifications techniques</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:15px">Si vous n\'êtes pas sûr des informations, contentez vous de me décrire <br />votre projet dans le champs description.<br /><br /></td>
		</tr>
		<tr>
			<td><label for="form_typeSite">Type</label></td>
			<td><select name="typeSite" id="form_typeSite" style="width:150px">
					<option value=""></option>
					<option value="Particulier">Statique</option>
					<option value="Association">Dynamique</option>
				</select></td>
		</tr>
		<tr>
			<td><label for="form_budget">Budget</label></td>
			<td>Entre <input type="text" name="budgetMin" id="form_budget" style="width:35px" />€ et <input type="text" name="budgetMax" style="width:35px" />€</td>
		</tr>
		<tr>
			<td><label for="form_delai">Délai</label></td>
			<td><select name="delai" id="form_delai" style="width:150px">
					<option value=""></option>
					<option value="Moins 1 mois">Moins d\'1 mois</option>
					<option value="1 mois">1 mois</option>
					<option value="2 mois">2 mois</option>
					<option value="3 mois">3 mois</option>
				</select></td>
		</tr>
		<tr>
			<td><label for="form_design">Charte graphique</label></td>
			<td><select name="design" id="form_design" style="width:150px">
					<option value=""></option>
					<option value="Fournis">Modèle fournis</option>
					<option value="Libre">Choix libre</option>
					<option value="Libre et Unique">Choix libre + modèle unique</option>
				</select></td>
		</tr>
		<tr>
			<td><label for="form_desc">Description *</label></td>
			<td><textarea name="desc" id="form_desc"></textarea>
			<a id="fleche2a" href="#" onclick="plus_largeur(\'form_desc\', \'fleche2b\'); return false"><img src="images/fleche_droite.gif" style="margin-bottom:5px; margin-left:-2px"/></a><br />
			<a id="fleche2b" href="#" onclick="plus_hauteur(\'form_desc\'); return false"><img src="images/fleche_bas.gif" style="margin-left:386px; "/></a>
		</tr>
		<tr>
			<td><div class="traitement" id="statut2"></div></td>
			<td><input type="submit"  name="Sub" value="Envoyer" class="submit" /></td>
		</tr>
	</table>
	
	<table id="partenariat" style="display:none">
		<tr>
			<td style="width:150px"><label for="form_mess">Message *</label></td>
			<td><textarea name="mess" id="form_mess"></textarea>
			<a id="fleche3a" href="#" onclick="plus_largeur(\'form_mess\', \'fleche3b\'); return false"><img src="images/fleche_droite.gif" style="margin-bottom:5px; margin-left:-2px"/></a><br />
			<a id="fleche3b" href="#" onclick="plus_hauteur(\'form_mess\'); return false"><img src="images/fleche_bas.gif" style="margin-left:386px; "/></a>
		</tr>
		<tr>
			<td><div class="traitement" id="statut3"></div></td>
			<td><input type="submit"  name="Sub" value="Envoyer" class="submit" /></td>
		</tr>
	</table>



</fieldset>
</form>
';

$design->zone('contenu', $c);

?>