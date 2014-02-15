<?php foreach($liste as $creation): ?>
    <li><a href="<?php echo url_for('creation', $creation)?>" class="tip" title="Consulter les informations concernant le projet [strong]<?php echo $creation->getTitre()?>[/strong]"><img src="<?php echo $creation->getMiniature()?>" alt="" /></a></li>
<?php endforeach;?>