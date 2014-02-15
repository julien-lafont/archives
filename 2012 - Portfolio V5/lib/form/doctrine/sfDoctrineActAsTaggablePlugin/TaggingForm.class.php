<?php

/**
 * Tagging form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TaggingForm extends PluginTaggingForm
{
  public function configure()
  {
    $this->widgetSchema['taggable_id']    =  new sfWidgetFormDoctrineChoice(array('model' => 'Article', 'add_empty' => false));
    $this->validatorSchema['taggable_id'] =  new sfValidatorDoctrineChoice(array('model' => 'Article'));    
    
    $this->widgetSchema['taggable_model']->setOption('default', 'Article');
  }
}
