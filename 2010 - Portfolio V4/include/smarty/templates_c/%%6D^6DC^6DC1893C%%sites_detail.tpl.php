<?php /* Smarty version 2.6.18, created on 2010-08-08 17:15:18
         compiled from fr/_rea/sites_detail.tpl */ ?>
<div class="infos">

	<h3><?php echo $this->_tpl_vars['site']['titre']; ?>
 <i>(<?php echo $this->_tpl_vars['site']['annee']; ?>
)</i></h3>
	
	
	<p><span>&ldquo;</span>   
	    <?php echo $this->_tpl_vars['site']['desc']; ?>

		<span>&rdquo;</span>
	</p>

	<ul>
		<li><strong>Technologies</strong> : <?php echo $this->_tpl_vars['site']['techno']; ?>
</li>
		<li><strong>Durée de réalisation</strong> : <?php echo $this->_tpl_vars['site']['duree']; ?>
</li>
		<li><strong>Client</strong> : <?php echo $this->_tpl_vars['site']['client']; ?>
</li>
		<li class="lien"><strong>Lien</strong> : <a href="<?php echo $this->_tpl_vars['site']['href']; ?>
" title="Ouvrir '<?php echo $this->_tpl_vars['site']['titre']; ?>
'|<?php echo $this->_tpl_vars['site']['title']; ?>
"><?php echo $this->_tpl_vars['site']['lien']; ?>
</a></li>
	</ul>
</div>

<div class="min">
	<?php if ($this->_tpl_vars['site']['prefix'] == 'na'): ?> 
		<?php $this->assign('ext', 'jpg'); ?>
	<?php else: ?>
		<?php $this->assign('ext', 'png'); ?>
	<?php endif; ?>
	
	<ul>
		<li><a href="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/1.<?php echo $this->_tpl_vars['ext']; ?>
" title="Voir une capture du site" rel="prettyOverlay[<?php echo $this->_tpl_vars['site']['prefix']; ?>
]"><img src="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/_1.<?php echo $this->_tpl_vars['ext']; ?>
" /></a></li>
		<li><a href="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/2.<?php echo $this->_tpl_vars['ext']; ?>
" title="Voir une capture du site" rel="prettyOverlay[<?php echo $this->_tpl_vars['site']['prefix']; ?>
]"><img src="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/_2.<?php echo $this->_tpl_vars['ext']; ?>
" /></a></li>
		<li><a href="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/3.<?php echo $this->_tpl_vars['ext']; ?>
" title="Voir une capture du site" rel="prettyOverlay[<?php echo $this->_tpl_vars['site']['prefix']; ?>
]"><img src="images/realisations/_<?php echo $this->_tpl_vars['site']['prefix']; ?>
/_3.<?php echo $this->_tpl_vars['ext']; ?>
" /></a></li>			
	</ul>
</div>