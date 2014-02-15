<section>
  <header>
    <h5><?php echo $message ?></h5>
  </header>
  
  <ul>
  <?php foreach($liste as $creation): ?>
      <li><a href="<?php echo url_for('creation', $creation)?>" title=""><span><?php echo $creation->getTitre()?></span></a></li>
  <?php endforeach;?>
  </ul>

</section>