<?php

/**
 * BackendCreation form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BackendCreationForm extends BaseCreationForm
{

  
  public function configure()
  {
    
    
    
    $mini = array(
      'jsoptions'=> array(  
        'height' => '100px'
      )
    );
    

   
    // Champs Wysiwyg
    //$this->widgetSchema['description1'] = new sfWidgetFormCKEditor();
    //$this->widgetSchema['description2'] = new sfWidgetFormCKEditor();
    //$this->widgetSchema['mini_desc1'] = new sfWidgetFormCKEditor($mini);
    //$this->widgetSchema['mini_desc2'] = new sfWidgetFormCKEditor($mini);
    
    $dateWidget = new sfWidgetFormI18nDate(array('format' => '%day%/%month%/%year%','month_format' => 'short_name','culture' => 'fr'));
    $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array('culture'=> 'fr',  'date_widget' => $dateWidget));
    
    // Labels
    $this->widgetSchema['description1']->setLabel("Dev'note");
    $this->widgetSchema['description2']->setLabel("Description alternative");
    $this->widgetSchema['mini_desc1']->setLabel("Mini description");
    $this->widgetSchema['mini_desc2']->setLabel("Technologies");
    $this->widgetSchema['use_alternatif']->setLabel("Utiliser description alternative ?");
    
    // Upload de la miniature
    $this->widgetSchema['miniature'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Miniature',
      'file_src'  => $this->getObject()->getMiniature(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%Supprimer? %delete% </div>',
    ));
    
    $this->setValidator('miniature', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/folio/min',
      'required' => false
    )));
  
    $this->validatorSchema['miniature_delete'] = new sfValidatorPass();

    // Upload du bandeau
    $this->widgetSchema['bandeau'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Bandeau',
      'file_src'  => $this->getObject()->getBandeau(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%Supprimer? %delete% </div>',
    ));
    
    $this->setValidator('bandeau', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/folio/bandeau/',
      'required' => false
    )));
  
    $this->validatorSchema['bandeau_delete'] = new sfValidatorPass();
    
    // Technos liées
    $this->widgetSchema['technos_list'] = new sfWidgetFormDoctrineChoice(array( 'model' => 'Techno' ));
    $this->widgetSchema['technos_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['technos_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));
    
    
    
    // Ordre
    $this->getWidgetSchema()->setPositions(array(
      'id', 'titre', 'sstitre', 'categorie_id', 'slug', 'bandeau', 'description2', 'use_alternatif', 'mini_desc1', 'mini_desc2',  
      'miniature', 'code', 'annee', 'date', 'client', 'techno', 'duree', 'url', 'description1', 'technos_list'
    ));
    
  }

}
