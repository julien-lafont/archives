<?php

/**
 * RelTechnoCreation form base class.
 *
 * @method RelTechnoCreation getObject() Returns the current form's model object
 *
 * @package    foliov4
 * @subpackage form
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRelTechnoCreationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'techno_id'   => new sfWidgetFormInputHidden(),
      'creation_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'techno_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('techno_id')), 'empty_value' => $this->getObject()->get('techno_id'), 'required' => false)),
      'creation_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('creation_id')), 'empty_value' => $this->getObject()->get('creation_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rel_techno_creation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RelTechnoCreation';
  }

}
