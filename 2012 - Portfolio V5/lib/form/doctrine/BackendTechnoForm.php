<?php

/**
 * Techno form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BackendTechnoForm extends BaseTechnoForm
{
  public function configure()
  {
    
    // Upload du logo
    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Logo',
      'file_src'  => $this->getObject()->getLogo(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%Supprimer? %delete% </div>',
    ));
    
    $this->setValidator('logo', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/techno',
      'required' => false
    )));
  
    $this->validatorSchema['logo_delete'] = new sfValidatorPass();
    
    // Créations liées
    $this->widgetSchema['creations_list'] = new sfWidgetFormDoctrineChoice(array( 'model' => 'Creation' ));
    $this->widgetSchema['creations_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['creations_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));
    
  }
}
