<?php /* Smarty version 2.6.18, created on 2008-07-02 22:04:34
         compiled from _questionnaires/diffuser_choix.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', '_questionnaires/diffuser_choix.tpl', 12, false),)), $this); ?>
<div class="titre">
	<div class="g"></div>
	<h2>Diffuser mon questionnaire</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Lien direct à partager</h1>
	
		<p>Voici tout d'abord un lien que vous pouvez tout simplement envoyer à vos contacts, ils auront un accés direct à votre questionnaire :<br /><br />
			<strong class="lien">
			http://www.nixtee.com/repondre-au-questionnaire-de-<?php echo ((is_array($_tmp=$this->_tpl_vars['infos_mbre']['pseudo'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
-<?php echo $this->_tpl_vars['quest']['id_form_membre']; ?>
.htm
			</strong>
		</p><br />
	
	<form action="diffuser-validation.htm" method="post">
	
	<input type="hidden" name="id_quest" value="<?php echo $this->_tpl_vars['quest']['id_form_membre']; ?>
" />
	
	
	<br /><h1>Envoie à mes buddylist</h1>
	
		<p>Si vous avez configuré vos <a href="#" title="#">buddylist</a>, vous pouvez sélectionner quels groupes recevront ce questionnaire.</p>
		
		<fieldset class="diff_checkbox">
			<input type="checkbox" name="buddy_h" value="1" /> <label>Groupe '<strong>Mecs</strong>'</label><br />
			<input type="checkbox" name="buddy_f" value="1" /> <label>Groupe '<strong>Femmes</strong>'</label><br />
			<input type="checkbox" name="buddy_p1" value="1" /> <label>Groupe '<strong>Perso 1</strong>'</label><br />
			<input type="checkbox" name="buddy_p2" value="1" /> <label>Groupe '<strong>Perso 2</strong>'</label>
		</fieldset>
			
	<br /><h1>Ajouter des contacts par leur email</h1>
	
		<p>Saisissez les adresses emails  ( 1 email / ligne ).</p>
		
		<fieldset class="diff_textarea">
			<textarea name="autre_emails"></textarea>
		</fieldset>
	<br />

	<br /><h1>Un petit mot en plus ?</h1>
	
		<p>Si vous souhaitez rajouter quelques mots sur le mail que nous allons adresser à vos amis, c'est ici que ça se passe.</p>
		
		<fieldset class="diff_textarea">
			<textarea name="mots"></textarea>
		</fieldset>
	<br />
	
		
	<input type="submit" class="submit" value="Commencer la diffusion !" /><br />
	<br /><br />
	
</div>
<div class="b"></div>