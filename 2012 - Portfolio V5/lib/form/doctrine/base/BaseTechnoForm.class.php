<?php

/**
 * Techno form base class.
 *
 * @method Techno getObject() Returns the current form's model object
 *
 * @package    foliov4
 * @subpackage form
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTechnoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nom'            => new sfWidgetFormInputText(),
      'logo'           => new sfWidgetFormInputText(),
      'url'            => new sfWidgetFormInputText(),
      'creations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Creation')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom'            => new sfValidatorPass(),
      'logo'           => new sfValidatorPass(array('required' => false)),
      'url'            => new sfValidatorPass(array('required' => false)),
      'creations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Creation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('techno[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Techno';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['creations_list']))
    {
      $this->setDefault('creations_list', $this->object->Creations->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCreationsList($con);

    parent::doSave($con);
  }

  public function saveCreationsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['creations_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Creations->getPrimaryKeys();
    $values = $this->getValue('creations_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Creations', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Creations', array_values($link));
    }
  }

}
