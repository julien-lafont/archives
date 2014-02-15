<?php /* Smarty version 2.6.18, created on 2008-01-20 22:49:21
         compiled from commentaires.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="commentaires">
    <div class="haut"></div>
    <div class="in">
    
    	<?php $_from = $this->_tpl_vars['commentaires']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['com']):
?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "commentaires_inside.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>                            
                            
     	<?php endforeach; else: ?>
            <div class="aucun_element">
                Cet article ne contient aucun commentaire ! <br /><br />
                N'h&eacute;sitez pas &agrave; &ecirc;tre le premier &agrave; donner votre avis.
            </div>
        <?php endif; unset($_from); ?>

    </div>
    <div class="bas"></div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>