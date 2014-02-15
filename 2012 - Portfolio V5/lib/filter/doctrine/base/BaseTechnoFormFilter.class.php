<?php

/**
 * Techno filter form base class.
 *
 * @package    foliov4
 * @subpackage filter
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTechnoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'logo'           => new sfWidgetFormFilterInput(),
      'url'            => new sfWidgetFormFilterInput(),
      'creations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Creation')),
    ));

    $this->setValidators(array(
      'nom'            => new sfValidatorPass(array('required' => false)),
      'logo'           => new sfValidatorPass(array('required' => false)),
      'url'            => new sfValidatorPass(array('required' => false)),
      'creations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Creation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('techno_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCreationsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.RelTechnoCreation RelTechnoCreation')
      ->andWhereIn('RelTechnoCreation.creation_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Techno';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'nom'            => 'Text',
      'logo'           => 'Text',
      'url'            => 'Text',
      'creations_list' => 'ManyKey',
    );
  }
}
