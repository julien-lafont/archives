<?php use_helper('Date');?>

<?php  $crea->getImages(); ?>

<article class="folio">

  <hgroup>
    <h2 class="center"><?php echo $crea->getTitre();?></h2>
    <h3 class="center"><?php echo $crea->getSsTitre();?></h3>
  </hgroup>
  
  <?php if ($crea->getBandeau()):?>
    <div class="bandeau"><img src="<?php echo $crea->getBandeau();?>" alt="" /> </div>
    <div class="user_post_end"></div>
  <?php elseif ($crea->getDescription2()!='' && $crea->getUseAlternatif()==true):?>
    <blockquote><?php echo $crea->getDescription2(ESC_RAW)?></blockquote>
  <?php endif;?>
  
  <div class="body">
    
    <div class="infos">
      <div class="quote"><span>“</span> <?php echo $crea->getMiniDesc1(ESC_RAW)?> <span>”</span></div>
      <div class="hr"></div>
      
      <ul>
        <li><span>Date :</span><?php echo ucfirst(format_date($crea->getDate(), "MMMM yyyy")) ?></li>
        <li><span>Commanditaire :</span> <?php echo $crea->getClient()?></li>
        <li><span>Développement :</span> <?php echo $crea->getDuree()?></li>
        <?php if (strlen($crea->getUrl())>0):?><li><span>Lien :</span><a href="<?php echo $crea->getUrl()?>"><?php echo $crea->getTitre();?></a></li><?php endif; ?>
      </ul>
    </div>
    
    <?php $images = $crea->getImages(); ?>
    <?php if (count($images)>0):?>
    <div class="slide">
      <div id="slider">
        <?php foreach($images as $image): ?>
          <a href="<?php echo $image->getTailleReelle()?>" class="fancy" rel="gp"><img src="<?php echo $image->getMiniature()?>" alt="" /></a>
        <?php endforeach;?>
      </div>
    </div>
    <?php endif;?>
    
    <br class="clear" />
  </div>
  
  <?php if (count($crea->getTechnos())>0):?>
  <h4 style="padding-top:25px">Technologies</h4>
  
  <ul class="technos">
    <?php foreach ($crea->getTechnos() as $techno):?>
    <li>
      <div class="logo"><img src="<?php echo $techno->getLogo()?>" alt="<?php echo $techno->getNom()?>" /></div><br />
      <strong><?php echo $techno->getNom()?></strong>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif;?>
  
  <?php if (strlen($crea->getDescription1(ESC_RAW))>10):?>
  <h4>Dev'note</h4>
  
    <section class="devnote">
    <?php echo $crea->getDescription1(ESC_RAW)?>
    </section>
    
  <?php endif; ?>

</article>



<?php slot('menu_gauche')?>

  <?php include_partial('design/blocCv')?>
  <?php include_partial('contact/reseauxSociaux')?>
  <?php include_component('folio', 'blocMesCreations', array("crea"=>$crea))?>
  
<?php end_slot() ?>