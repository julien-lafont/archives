<section>
  <header>
    <h5>Autres réalisations</h5>
  </header>
  
  <ul>
  <?php for($i=0; $i<5; $i++):?>
    <?php if (isset($liste[$i])):?>
      <li><a href="<?php echo url_for('creation', $liste[$i])?>" title="" <?php if ($i==2) echo 'class="current"'?>><span><?php echo $liste[$i]->getTitre()?></span></a></li>
    <?php endif;?>
  <?php endfor;?>
  </ul>

</section>