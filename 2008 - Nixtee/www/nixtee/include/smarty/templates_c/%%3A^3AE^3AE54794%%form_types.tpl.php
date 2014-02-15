<?php /* Smarty version 2.6.18, created on 2008-04-18 19:00:29
         compiled from _questionnaires/form_types.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>LES QUESTIONNAIRES TYPES A PERSONNALISER</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Etape 1/3 : Choix du questionnaire type</h1>
	
	<p>Choisissez dans la liste ci-dessous le questionnaires que vous trouvez le plus proche de vos envies.<br />
	Vous pourrez dans l'étape suivante le personnaliser si vous le désirer.</p>
	
	<div class="info">
		<div class="img"></div>
		<p>Dans quelques jours, vous aurez la possibilité de créer vos questionnaires de A à Z !</p>
		<!--TODO:Bulle sous IE6/EI7 ? -->
	</div>
	
	
	<ul class="liste_form">
	<?php $_from = $this->_tpl_vars['apercus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['form']):
?>
		<li><h2><?php echo $this->_tpl_vars['form']['nom']; ?>
</h2>
		    <p><?php echo $this->_tpl_vars['form']['description']; ?>
</p>

			<div class="apercu" id="apercu_<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
" style="display:none">
				<?php echo $this->_tpl_vars['form']['html']; ?>

			</div>
			
		    <div class="bouton" style="margin-left:400px"><a href="#" title="Apercu du questionnaire" class="ouvrir_apercu" rel="<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
">Aperçu des questions</a></div>
		    <div class="bouton"><a href="questionnaires-infos-<?php echo $this->_tpl_vars['form']['id_form_type']; ?>
.htm" title="">Choisir ce questionnaire</a></div>
		    <br class="clear" />
		    
		</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
	<br /><br />
</div>