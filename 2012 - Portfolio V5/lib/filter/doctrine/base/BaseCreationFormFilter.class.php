<?php

/**
 * Creation filter form base class.
 *
 * @package    foliov4
 * @subpackage filter
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCreationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sstitre'        => new sfWidgetFormFilterInput(),
      'code'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description1'   => new sfWidgetFormFilterInput(),
      'description2'   => new sfWidgetFormFilterInput(),
      'mini_desc1'     => new sfWidgetFormFilterInput(),
      'mini_desc2'     => new sfWidgetFormFilterInput(),
      'url'            => new sfWidgetFormFilterInput(),
      'miniature'      => new sfWidgetFormFilterInput(),
      'bandeau'        => new sfWidgetFormFilterInput(),
      'annee'          => new sfWidgetFormFilterInput(),
      'date'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'client'         => new sfWidgetFormFilterInput(),
      'techno'         => new sfWidgetFormFilterInput(),
      'duree'          => new sfWidgetFormFilterInput(),
      'categorie_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'), 'add_empty' => true)),
      'use_alternatif' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'           => new sfWidgetFormFilterInput(),
      'technos_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Techno')),
    ));

    $this->setValidators(array(
      'titre'          => new sfValidatorPass(array('required' => false)),
      'sstitre'        => new sfValidatorPass(array('required' => false)),
      'code'           => new sfValidatorPass(array('required' => false)),
      'description1'   => new sfValidatorPass(array('required' => false)),
      'description2'   => new sfValidatorPass(array('required' => false)),
      'mini_desc1'     => new sfValidatorPass(array('required' => false)),
      'mini_desc2'     => new sfValidatorPass(array('required' => false)),
      'url'            => new sfValidatorPass(array('required' => false)),
      'miniature'      => new sfValidatorPass(array('required' => false)),
      'bandeau'        => new sfValidatorPass(array('required' => false)),
      'annee'          => new sfValidatorPass(array('required' => false)),
      'date'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'client'         => new sfValidatorPass(array('required' => false)),
      'techno'         => new sfValidatorPass(array('required' => false)),
      'duree'          => new sfValidatorPass(array('required' => false)),
      'categorie_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Categorie'), 'column' => 'id')),
      'use_alternatif' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'technos_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Techno', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('creation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addTechnosListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('RelTechnoCreation.techno_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Creation';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'titre'          => 'Text',
      'sstitre'        => 'Text',
      'code'           => 'Text',
      'description1'   => 'Text',
      'description2'   => 'Text',
      'mini_desc1'     => 'Text',
      'mini_desc2'     => 'Text',
      'url'            => 'Text',
      'miniature'      => 'Text',
      'bandeau'        => 'Text',
      'annee'          => 'Text',
      'date'           => 'Date',
      'client'         => 'Text',
      'techno'         => 'Text',
      'duree'          => 'Text',
      'categorie_id'   => 'ForeignKey',
      'use_alternatif' => 'Boolean',
      'slug'           => 'Text',
      'technos_list'   => 'ManyKey',
    );
  }
}
