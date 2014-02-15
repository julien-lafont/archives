<?php

/**
 * ArticlesLies form base class.
 *
 * @method ArticlesLies getObject() Returns the current form's model object
 *
 * @package    foliov4
 * @subpackage form
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticlesLiesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_src_id'  => new sfWidgetFormInputHidden(),
      'article_liee_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'article_src_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('article_src_id')), 'empty_value' => $this->getObject()->get('article_src_id'), 'required' => false)),
      'article_liee_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('article_liee_id')), 'empty_value' => $this->getObject()->get('article_liee_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('articles_lies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticlesLies';
  }

}
