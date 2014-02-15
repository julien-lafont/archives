<?php

/**
 * Commentaire form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentaireForm extends BaseCommentaireForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
    
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required'=>true));
    
    $this->widgetSchema['article_id'] = new sfWidgetFormInputHidden();
    
    // Antispam
    $this->widgetSchema['name'] = new sfWidgetFormInputCaptcha();
    $this->validatorSchema['name'] = new sfValidatorCaptcha();
    
    
  }
}
