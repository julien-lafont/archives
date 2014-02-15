<?php /* Smarty version 2.6.18, created on 2008-04-15 15:41:24
         compiled from form_infos.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>QUESTIONNAIRE : <?php echo $this->_tpl_vars['form']['nom']; ?>
</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Etape 2/3 : Mon questionnaire</h1>
	
	<p>Renseignez sur cettes pages les quelques informations qui permettront à vos amis de ne pas être totalement désorientés en arrivant sur votre questionnaire, et sur comment vous voulez qu'il soit géré.</p>
	<!--TODO:Phrase à refaire-->
	
	<form class="style" action="#" method="post" id="form_info">
		<fieldset>
		
			<label for="nom" class="long"><strong>>></strong> Nom de mon questionnaire</label><br />
			<input type="text" id="nom" name="nom" style="margin:5px 0 0 20px"/><br /><br />
	
			<label for="message" class="long"><strong>>></strong> Si vous désirez laisser un message aux utilisateurs qui s'apprètent à remplis votre questionnaire, c'est ici : </label>
			<textarea name="message" id="message" style="margin:5px 0 0 20px" cols="75" rows="5"></textarea><br /><br />
			
			<label for="prive" class="long"><strong>>></strong> Formulaire privé ? ( seuls les personnes invités pourront y répondre ) </label><br />
			<input type="radio" name="prive" id="prive" value="non" class="radio" checked=""  /> <strong>NON</strong><br /> 
			<input type="radio" name="prive" id="prive" value="oui" class="radio" /> <strong>OUI</strong><br /><br />
			
			
			<p style="margin-top:20px; border-top:1px dashed #ccc; padding-top:15px">Vous êtes maintenant prêt à diffuser ce questionnaire. Vous pouvez aussi personaliser ce questionnaire afin de modifier/supprimer certaines questions.</p>
			
			<table style="width:85%;">
				<tr>
					<td style="width:10%"></td>
					<td style="width:45%"><h3 style="width:85%"><a href="#" title="Etape 3/3 : Personnaliser mon questionnaire" onclick="$('#form_info').attr('action', 'questionnaires-personnaliser-<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
.htm').submit(); return false">Personnaliser le questionnaire</a></h3></td>
					<td>				  <h3 style="width:85%"><a href="#" title="Enregistrer le questionnaire" onclick="$('#form_info').attr('action', 'questionnaires-enregistrer-<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
.htm').submit(); return false">Questionnaire terminé</a></h3></td>
				</tr>
				<tr>
					<td></td>
					<td><p style="padding:0 35px 10px 5px" class="centre">Si vous souhaitez modifier le formulaire type que nous vous avons proposé, passez par cette dernière étape.</p></td>
					<td><p style="padding:0 35px 10px 5px" class="centre">Notre questionnaire répond parfaitement à vos attente, alors n'hésitez plus et partager ce questionnaire à vos amis !</p></td>
				</tr>
				<tr>
					<td></td>
					<td><div class="bouton" style="margin-left:25px"><a href="#" title="Etape 3/3 : Personnaliser mon questionnaire" onclick="$('#form_info').attr('action', 'questionnaires-personnaliser-<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
.htm').submit(); return false">Etape 3/3 : Personnalisation</a></div></td>
					<td><div class="bouton" style="margin-left:15px"><a href="#" title="Enregistrer le questionnaire" onclick="$('#form_info').attr('action', 'questionnaires-enregistrer-<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
.htm').submit(); return false">Enregistrer le questionnaire</a></div></td>		
				</tr>
			</table>
			<br class="clear" />
		    	    			
		</fieldset>
	</form>
	
</div>