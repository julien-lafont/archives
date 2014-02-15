<?php /* Smarty version 2.6.18, created on 2008-08-13 17:30:09
         compiled from fr/_quisuisje/accueil.tpl */ ?>
<br /><br />

<div class="slide_menu">
	<ul>
		<li class="titre">Accés rapide</li>
		<li class="selected"><a href="#1" class="cross-link" title="Qui suis-je : petit résumé de ma vie">Qui suis-je ?</a></li>	
		<!--<li><a href="#2" class="cross-link" title="Petite présentation de moi, de mes perspectives en vidéo">Présentation vidéo</a></li>-->
		<li><a href="#2" class="cross-link" title="Quelques une de mes passions">Mes passions</a></li>
		<li><a href="#3" class="cross-link" title="Mon projet pour l'avenir ?">Mon projet</a></li>
		<li><a href="#4" class="cross-link" title="Les mots clés qui définissent mon petit monde">Nuage de tag</a></li>
		<!--<li><a href="#6" class="cross-link" title="Que m'a apporté la réalisation de ce portfolio">Retour d'expérience</a></li>-->
	</ul>
</div>

<div class="slider-wrap">
	<div id="slider1" class="csw codaslide">
		<div class="panelContainer big">
		
			<div class="panel">
				<div class="wrapper">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_quisuisje/quisuisje.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
			<div class="panel" >
				<div class="wrapper">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_quisuisje/passions.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
				</div>
			</div>		
			<div class="panel">
				<div class="wrapper">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_quisuisje/ppp.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
			<div class="panel">
				<div class="wrapper">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_quisuisje/nuagetag.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
		</div>
	</div>
</div>



