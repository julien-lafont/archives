
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="#" onsubmit="this.action='<?php echo url_for('article', $article)?>#poster'" method="post" accept-charset="utf-8" id="form_commentaire" style="padding: 0 20px 20px 20px;">

  <input type="hidden" name="sf_method" value="put" />
  <?php echo $form->renderHiddenFields(false) ?>

  <?php if ($form->hasErrors()):?>
  <div class="bloc_erreur ">
    <strong>Erreur</strong>
    <span>Merci de remplir les champs obligatoires</span>
  </div>
  <?php endif; ?>
  
  <fieldset>
    <p>
      <label for="name">Votre pseudo</label><br />
      <input type="text" name="<?php echo $form['pseudo']->renderName()?>" value="<?php echo $form['pseudo']->getValue()?>" id="name" class="pseudo <?php if ($form['pseudo']->hasError()) echo 'erreur'; ?>">
    </p>
    <p>
      <label for="email">Votre adresse email</label><br />
      <input type="text" name="<?php echo $form['email']->renderName()?>" value="<?php echo $form['email']->getValue()?>" id="email" class="email <?php if ($form['email']->hasError()) echo 'erreur'; ?>">
    </p>
    <p>
      <label for="website">Un site internet ? <i>(facultatif)</i></label><br />
      <input type="text" name="<?php echo $form['site']->renderName()?>" value="<?php echo $form['site']->getValue()?>" id="website" class="site <?php if ($form['site']->hasError()) echo 'erreur'; ?>">
    </p>
	<p class="formPiege">
		<label for="name">Nom ?</label><br />
		<input type="text" name="commentaire[name]" value="" id="name" class="site">

	</p>
   
    
    <div class="col70">
    <p class="nomargin">
      <label for="comment">Rédigez votre commentaire</label><br />
      <textarea cols="30" rows="10" name="<?php echo $form['message']->renderName()?>" id="comment" class="<?php echo $form['message']->renderName()?>  <?php if ($form['message']->hasError()) echo 'erreur'; ?>"><?php echo $form['message']->getValue()?></textarea>
    </p>
    </div>
    
    <div class="col30 vbottom" >
      <a href="#" class="button submit" ><span>Poster le commentaire</span></a>
    </div>
    
  </fieldset>
  
</form>
