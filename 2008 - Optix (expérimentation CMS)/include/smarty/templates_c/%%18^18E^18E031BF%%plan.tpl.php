<?php /* Smarty version 2.6.18, created on 2008-11-07 14:00:05
         compiled from plan.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'recode', 'plan.tpl', 31, false),)), $this); ?>
<h1>Plan du site Optix</h1>

<h2>Général</h2>
<ul class="plan">
	<li>
		&rsaquo; <a href="accueil.htm" title="Retour à la apge d'accueil">Page d'accueil</a>
	</li>
	<li>
		&rsaquo; <a href="contact.htm" title="Contacter l'entreprise">Contact</a>
	</li>
	<li>
		&rsaquo; <a href="#" title="Flux RSS d'actualité">Flux RSS</a>
	</li>
</ul>


<h2>Articles</h2>
<?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
	<h3 style="margin-bottom:7px"><?php echo $this->_tpl_vars['cat']['nom']; ?>
</h3>
	<ul class="plan" style="margin-left:70px">
		<?php $_from = $this->_tpl_vars['cat']['contenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
		<li>&rsaquo; <a href="article-<?php echo $this->_tpl_vars['cat']['url']; ?>
-<?php echo $this->_tpl_vars['page']['url']; ?>
.htm" title="Accéder à l'article <?php echo $this->_tpl_vars['page']['titre']; ?>
 de la catégorie <?php echo $this->_tpl_vars['cat']['nom']; ?>
"><?php echo $this->_tpl_vars['page']['titre']; ?>
</a></li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
<?php endforeach; endif; unset($_from); ?>


<h2>Actualités</h2>
<ul class="plan">
<?php $_from = $this->_tpl_vars['actus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['actu']):
?>
	<li>&rsaquo; <a href="actualite-<?php echo $this->_tpl_vars['actu']['id_news']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['actu']['titre'])) ? $this->_run_mod_handler('recode', true, $_tmp) : smarty_modifier_recode($_tmp)); ?>
.htm" title="Lire la news : <?php echo $this->_tpl_vars['actu']['titre']; ?>
"><?php echo $this->_tpl_vars['actu']['titre']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>