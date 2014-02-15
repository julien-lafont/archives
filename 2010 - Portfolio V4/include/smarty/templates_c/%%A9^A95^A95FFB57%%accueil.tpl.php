<?php /* Smarty version 2.6.18, created on 2010-08-06 20:47:45
         compiled from fr/_rea/accueil.tpl */ ?>
<br /><br />

<div class="center" id="top"><img src="images/T_MesRealisations.png" alt="" /></div>


<table class="rea">
	<tr>
		<td><a href="#Developpement_web" title="Mes sites webs" class="noborder" onclick="<?php echo '$.scrollTo(\'#web\', {speed:1000, axis:\'y\', easing:\'backout\', offset:-50}); return false'; ?>
"><img src="images/web.png" alt="Sites webs" /></a></td>
		<td><a href="#Mes_design" title="Mes designs" class="noborder" onclick="<?php echo '$.scrollTo(\'#design\', {speed:1000, axis:\'y\', easing:\'backout\', offset:-50}); return false'; ?>
"><img src="images/design.png" alt="Design" /></a></td>
		<td><a href="#Applications_et_publications" title="Applications et publications" class="noborder" onclick="<?php echo '$.scrollTo(\'#autres\', {speed:1000, axis:\'y\', easing:\'expoout\', offset:-50}); return false'; ?>
"><img src="images/autres4.png" alt="Logiciels" /></a></td>
	</tr>
	<tr>
		<td><div><a href="#Developpement_web" title="Mes sites webs" onclick="<?php echo '$.scrollTo(\'#web\', {speed:1000, axis:\'y\', easing:\'backout\', offset:-50}); return false'; ?>
" >Développement web</a></div></td>
		<td><div><a href="#Mes_design" title="Mes designs" onclick="<?php echo '$.scrollTo(\'#design\', {speed:1000, axis:\'y\', easing:\'backout\', offset:-50}); return false'; ?>
">Infographie</a></div></td>
		<td><div><a href="#Applications_et_publications" title="Applications et publications" onclick="<?php echo '$.scrollTo(\'#autres\', {speed:1000, axis:\'y\', easing:\'expoout\', offset:-50}); return false'; ?>
">Applications</a></div></td>
	</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_rea/sites.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br class="clear" /><br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_rea/design.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br class="clear" /><br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['lang'])."/_rea/autres.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br class="clear" /><br />