<?php /* Smarty version 2.6.18, created on 2008-04-20 01:06:52
         compiled from _questionnaires/diffuser_accueil.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>CHOIX DU QUESTIONNAIRE A DIFFUSER</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<h1 class="bug">Mes questionnaires prêts à l'envoie</h1>
	
	<p style="font-size:14px">Quel questionnaire désirez-vous diffuser à vos amis ?</p>
	
	<ul class="liste_quest">
	<?php $_from = $this->_tpl_vars['liste']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['quest']):
?>
		<li><h4><img src="images/puce1.gif" alt="." class="vmiddle"/>&nbsp; <?php echo $this->_tpl_vars['quest']['nom']; ?>
 <span>Soumissions : <strong><?php echo $this->_tpl_vars['quest']['nb_soumis']; ?>
</strong> - Avis : <strong><?php echo $this->_tpl_vars['quest']['nb_rep']; ?>
</strong></span></span> </h4>
			
			<div class="bouton remontee" ><a href="diffuser-choix-<?php echo $this->_tpl_vars['quest']['id_form_membre']; ?>
.htm" title="#">Diffuser ce questionnaire</a></div><br />
			<div><?php echo $this->_tpl_vars['quest']['description']; ?>
</div>
			
		</li>	
	<?php endforeach; endif; unset($_from); ?>
	<br />
</div>