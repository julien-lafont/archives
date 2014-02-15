<?php /* Smarty version 2.6.18, created on 2008-06-14 10:42:22
         compiled from _general/inscription.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>CREER MON COMPTE NIXTEE</h2>
	<div class="d"></div>
</div>
<div class="bloc">

	<div class="erreur" style="display:<?php if (isset ( $this->_tpl_vars['erreur'] )): ?> block <?php else: ?> none <?php endif; ?>">
		<h5 style='font-size:14px'>Une erreur est survenue  durant la validation de votre inscription : </h5><br />
		<?php echo $this->_tpl_vars['erreur']; ?>

	</div>
	
	<p>Tu aimerais toi aussi profiter du site nixtee, alors n'hésite plus et inscrit toi.<br />
    C' est <strong>gratuite</strong>, <strong>simple</strong>, et <strong>rapide</strong>. Que demander de plus ?</p>
	
    <img src="images/inscription.png" alt="" style="float:right; margin-right:20px" />
	<form name="inscription" action="inscription-verif.htm" method="POST" class="style" style="margin:30px 0 20px 0">
    
    	<label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" /><br /><br />
    
    	<label for="email">Adresse e-mail</label>
        <input type="text" name="email" id="email" /><br /><br />

    	<label for="pass1">Mot de passe</label>
        <input type="password" name="pass1" id="pass1" /><br /><br />
        
    	<label for="pass2">Confirmez mdp</label>
        <input type="password" name="pass2" id="pass2" /><br /><br />            

    	<label></label>
        <input type="submit" name="submit" value="Valider" class="submit"/><br /><br />  
    </form>	
  
  	 <p class="petit">Merci de rentrer une adresse email valide, vous en aurez besoin pour activer votre compte.<br />
     				  Votre adresse email ne sera en ancun cas utilisé à des fin publicitaires.</p>
</div>
<div class="b"></div>