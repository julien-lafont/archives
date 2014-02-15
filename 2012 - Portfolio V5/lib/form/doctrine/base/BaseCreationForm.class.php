<?php

/**
 * Creation form base class.
 *
 * @method Creation getObject() Returns the current form's model object
 *
 * @package    foliov4
 * @subpackage form
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCreationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'titre'          => new sfWidgetFormInputText(),
      'sstitre'        => new sfWidgetFormInputText(),
      'code'           => new sfWidgetFormInputText(),
      'description1'   => new sfWidgetFormTextarea(),
      'description2'   => new sfWidgetFormTextarea(),
      'mini_desc1'     => new sfWidgetFormTextarea(),
      'mini_desc2'     => new sfWidgetFormTextarea(),
      'url'            => new sfWidgetFormInputText(),
      'miniature'      => new sfWidgetFormInputText(),
      'bandeau'        => new sfWidgetFormInputText(),
      'annee'          => new sfWidgetFormInputText(),
      'date'           => new sfWidgetFormDateTime(),
      'client'         => new sfWidgetFormInputText(),
      'techno'         => new sfWidgetFormInputText(),
      'duree'          => new sfWidgetFormInputText(),
      'categorie_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'), 'add_empty' => false)),
      'use_alternatif' => new sfWidgetFormInputCheckbox(),
      'slug'           => new sfWidgetFormInputText(),
      'technos_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Techno')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'titre'          => new sfValidatorPass(),
      'sstitre'        => new sfValidatorPass(array('required' => false)),
      'code'           => new sfValidatorPass(),
      'description1'   => new sfValidatorString(array('required' => false)),
      'description2'   => new sfValidatorString(array('required' => false)),
      'mini_desc1'     => new sfValidatorString(array('required' => false)),
      'mini_desc2'     => new sfValidatorString(array('required' => false)),
      'url'            => new sfValidatorPass(array('required' => false)),
      'miniature'      => new sfValidatorPass(array('required' => false)),
      'bandeau'        => new sfValidatorPass(array('required' => false)),
      'annee'          => new sfValidatorPass(array('required' => false)),
      'date'           => new sfValidatorDateTime(array('required' => false)),
      'client'         => new sfValidatorPass(array('required' => false)),
      'techno'         => new sfValidatorPass(array('required' => false)),
      'duree'          => new sfValidatorPass(array('required' => false)),
      'categorie_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'))),
      'use_alternatif' => new sfValidatorBoolean(array('required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'technos_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Techno', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Creation', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('creation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Creation';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['technos_list']))
    {
      $this->setDefault('technos_list', $this->object->Technos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTechnosList($con);

    parent::doSave($con);
  }

  public function saveTechnosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['technos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Technos->getPrimaryKeys();
    $values = $this->getValue('technos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Technos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Technos', array_values($link));
    }
  }

}
