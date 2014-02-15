<div>
  <img src="/images/moi.png" class="portrait" />
  <h2>Contact</h2>
  
  <p>N'hésitez pas à me contacter pour toutes vos demandes ou questions.</p>
  <p>Je suis ouvert à toute proposition de <strong>mission</strong>, de <strong>poste</strong>, de <strong>collaboration</strong> ou d'<strong>entre-aide</strong>, et je vous répondrais dans les plus brefs délais.</p>
</div><br class="clear" />

<div class="col60">
  <form action="<?php echo url_for('contact')?>" method="post" accept-charset="utf-8" id="form_commentaire" style="padding: 20px 0 20px 20px;">
  
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
        <label for="name">Votre nom ou pseudonyme</label><br />
        <input type="text" name="<?php echo $form['pseudo']->renderName()?>" value="<?php echo $form['pseudo']->getValue()?>" id="name" class="pseudo <?php if ($form['pseudo']->hasError()) echo 'erreur'; ?>">
      </p>
      
      <p>
        <label for="email">Votre adresse email</label><br />
        <input type="text" name="<?php echo $form['email']->renderName()?>" value="<?php echo $form['email']->getValue()?>" id="email" class="email <?php if ($form['email']->hasError()) echo 'erreur'; ?>">
      </p>
      
      <p>
        <label for="website">Le sujet de votre message</label><br />
        <input type="text" name="<?php echo $form['sujet']->renderName()?>" value="<?php echo $form['sujet']->getValue()?>" id="website" class="site <?php if ($form['sujet']->hasError()) echo 'erreur'; ?>">
      </p>
     
      <p class="nomargin">
        <label for="comment">Rédigez votre couriel</label><br />
        <textarea style="width:320px" cols="30" rows="10" name="<?php echo $form['message']->renderName()?>" id="comment" class="<?php echo $form['message']->renderName()?>  <?php if ($form['message']->hasError()) echo 'erreur'; ?>"><?php echo $form['message']->getValue()?></textarea>
      </p>
      
      <?php echo $form['name']->render()?>
      
      <p><a href="#" class="button submit float_left" ><span>Envoyer le couriel</span></a></p>
     
    </fieldset>
    
  </form>
</div>

<div class="col40" style="padding-top:100px; " >
  
  <h4 class="right">Contact direct</h4>
  
  <div class="medias tip" title="Adresse [strong]email[/strong]">
    <img src="/images/social/mail-clair.png"/>
	<p class="long">&#102;&#114;&#101;&#101;&#108;&#097;&#110;&#099;&#101;&#064;&#115;&#116;&#117;&#100;&#105;&#111;&#045;&#100;&#101;&#118;&#046;&#102;&#114;</p>
  </div>
  
  <div class="medias tip" title="Contact [strong]téléphonique[/strong]">
    <img src="/images/social/mobile.png"/>
	<p>&#048;&#054;&#032;&#055;&#054;&#032;&#048;&#049;&#032;&#053;&#056;&#032;&#049;&#050;</p>
  </div>
  
  <div class="medias tip" title="Compte [strong]Skype[/strong]">
    <img src="/images/social/skype.png"/>
	<p>studio-dev</p>
  </div>
  
  <!--<div class="medias tip" title="Adresse [strong]MSN[/strong]">
    <img src="/images/social/msn.png"/>
	<p>&#121;&#111;&#116;&#115;&#117;&#109;&#105;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;</p>
  </div>-->
  
  <div class="medias tip" title="Adresse [strong]Google Talk[/strong]">
    <img src="/images/social/gtalk.png"/>
	<p>&#121;&#111;&#116;&#115;&#117;&#109;&#105;&#046;&#102;&#120;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;</p>
    
  </div>

</div>
<?php slot('menu_gauche')?>

  <?php include_partial('design/blocQuisuisje')?>
  <?php include_partial('contact/reseauxSociaux')?>
  <?php include_partial('contact/mesAmis')?>
  
<?php end_slot() ?>