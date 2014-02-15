<?php if ($sf_user->hasFlash('erreur')): ?>
  <?php include_partial('design/erreur', array('message'=> $sf_user->getFlash('erreur'))) ?>
<?php endif; ?>

<?php if ($sf_user->hasFlash('information')): ?>
  <?php include_partial('design/information', array('message'=> $sf_user->getFlash('information'))) ?>
<?php endif; ?>

<?php if ($sf_user->hasFlash('succes')): ?>
  <?php include_partial('design/succes', array('message'=> $sf_user->getFlash('succes'))) ?>
<?php endif; ?>

<?php if ($sf_user->hasFlash('alerte')): ?>
  <?php include_partial('design/alerte', array('message'=> $sf_user->getFlash('alerte'))) ?>
<?php endif; ?>