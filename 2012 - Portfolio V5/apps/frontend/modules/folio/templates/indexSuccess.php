<p class="biglines">
 Voici une présentation des différents projets sur lesquels j'ai eu l'occasion de travailler.
</p>

<?php $slug_0 = false;?>
<nav class="folio">
  <ul>
    <?php foreach ($categories as $categorie):?>
      <?php $slug_0 = $slug_0 ?: $categorie->getSlug(); ?>
      <li><a href="#" rel="<?php echo $categorie->getSlug()?>"  class="<?php echo ($categorie->getSlug() == $slug_0) ? 'active':''; ?>"><?php echo $categorie->getTitre()?></a></li>
    <?php endforeach; ?>
  </ul>
</nav>

<ul class="folio-list"> 
    <?php $i=0; foreach ($creations as $creation):?>
      <li class="<?php echo ($i%2==0) ? 'odd':'even'?> <?php echo $creation->getCategorie()->getSlug()?>" style="<?php echo ($creation->getCategorie()->getSlug() != $slug_0) ? 'height:0':''; ?>">
        <div class="miniature" style="background-image:url(<?php echo $creation->getMiniature()?>)">
         
          <div class="masque">
            <a href="<?php echo url_for('creation', $creation); ?>" title=""></a>
             <div class="glass"></div>
          </div>
        </div>
        <div class="detail">
          <h3><a href="<?php echo url_for('creation', $creation); ?>" title=""><?php echo $creation->getTitre()?></a></h3>
          <strong><?php echo $creation->getSsTitre()?></strong>
          <div class="client"><span class="label">Client : </span><span><?php echo $creation->getClient()?></span></div>
          <div class="techno"><span class="label">Technos : </span><span><?php echo $creation->getTechno()?></span></div>
        </div>
      </li>
    <?php if ($creation->getCategorie()->getSlug() == $slug_0) $i++; endforeach;?>
</ul> 


<?php slot('menu_gauche')?>

  <?php include_partial('design/blocCv')?>
  <?php include_partial('contact/reseauxSociaux')?>
  <?php include_component('folio', 'blocDerniersAjouts', array('nb'=>5))?>
  
<?php end_slot() ?>