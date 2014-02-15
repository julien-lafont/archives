<?php /* Smarty version 2.6.18, created on 2008-02-07 10:16:02
         compiled from messagerie_ecrire.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messagerie_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="messagerie">

    <form action="#" method="post" class="style" style="margin-left:30px">
                
        <div class="titreMessagerie">R&eacute;diger un nouveau message</div>

        <label for="dest_id">Destinataire</label>
        <?php echo $this->_tpl_vars['destinataire']; ?>
<br /><br />
   
        <label for="sujet">Sujet</label>
        <input type="text" name="sujet" id="sujet" maxlength="255"  tabindex="2" value="<?php echo $this->_tpl_vars['sujet']; ?>
"><br /><br />
            
        <label for="mess">Message</label>
        <textarea id="mess" name="mess" tabindex="3" cols="20" rows="10"></textarea><br /><br />

		<label for="submit_com">&nbsp;</label> 
        <input type="image" src="templates/images/submit.png" class="image" id="submit_com" onclick="this.blur(); messagerie_envoyer(); return false"/>  <br /><br />

    </form>

</div>