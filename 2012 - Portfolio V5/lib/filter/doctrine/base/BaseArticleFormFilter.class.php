<?php

/**
 * Article filter form base class.
 *
 * @package    foliov4
 * @subpackage filter
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseArticleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'chapeau'                    => new sfWidgetFormFilterInput(),
      'contenu'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duree_redaction'            => new sfWidgetFormFilterInput(),
      'copyright'                  => new sfWidgetFormFilterInput(),
      'nb_lu'                      => new sfWidgetFormFilterInput(),
      'categorie_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'), 'add_empty' => true)),
      'publie'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'afficher_chapeau'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'                       => new sfWidgetFormFilterInput(),
      'articles_lies_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
      'reverse_articles_lies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
    ));

    $this->setValidators(array(
      'titre'                      => new sfValidatorPass(array('required' => false)),
      'date'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'chapeau'                    => new sfValidatorPass(array('required' => false)),
      'contenu'                    => new sfValidatorPass(array('required' => false)),
      'duree_redaction'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'copyright'                  => new sfValidatorPass(array('required' => false)),
      'nb_lu'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'categorie_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Categorie'), 'column' => 'id')),
      'publie'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'afficher_chapeau'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                       => new sfValidatorPass(array('required' => false)),
      'articles_lies_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
      'reverse_articles_lies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticlesLiesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ArticlesLies ArticlesLies')
      ->andWhereIn('ArticlesLies.article_liee_id', $values)
    ;
  }

  public function addReverseArticlesLiesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ArticlesLies ArticlesLies')
      ->andWhereIn('ArticlesLies.article_src_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Article';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'titre'                      => 'Text',
      'date'                       => 'Date',
      'chapeau'                    => 'Text',
      'contenu'                    => 'Text',
      'duree_redaction'            => 'Number',
      'copyright'                  => 'Text',
      'nb_lu'                      => 'Number',
      'categorie_id'               => 'ForeignKey',
      'publie'                     => 'Boolean',
      'afficher_chapeau'           => 'Boolean',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'slug'                       => 'Text',
      'articles_lies_list'         => 'ManyKey',
      'reverse_articles_lies_list' => 'ManyKey',
    );
  }
}
