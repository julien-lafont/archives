<?php

/**
 * Categorie form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategorieForm extends BaseCategorieForm
{
  public function configure()
  {
      $mini = array(
        'jsoptions'=> array(  
          'height' => '100px'
        )
      );
    
    // Champs Wysiwyg
    //$this->widgetSchema['description'] = new sfWidgetFormCKEditor($mini);
    
    // Upload de la miniature
    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Logo',
      'file_src'  => $this->getObject()->getLogo(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%Supprimer? %delete% </div>',
    ));
    
    $this->setValidator('logo', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/categories',
    )));
  
    $this->validatorSchema['logo_delete'] = new sfValidatorPass();
    
  }
}
