<div class="comments_post" id="com_<?php echo $commentaire->getId()?>">
  
  <div class="user_post">
    <span class="user_name"><?php echo ucfirst($commentaire->getPseudo()); ?></span> <span class="date_right"><a href="#com_<?php echo $commentaire->getId()?>"># <?php echo format_date($commentaire->getCreatedAt(), 'U');?></a></span>
    <p><?php echo $commentaire->getMessage(); ?></p>
  </div>
  <br class="clear" />
  
</div>
<div class="user_post_end"></div>