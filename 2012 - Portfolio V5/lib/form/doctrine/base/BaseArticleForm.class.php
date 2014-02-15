<?php

/**
 * Article form base class.
 *
 * @method Article getObject() Returns the current form's model object
 *
 * @package    foliov4
 * @subpackage form
 * @author     Julien Lafont
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'titre'                      => new sfWidgetFormInputText(),
      'date'                       => new sfWidgetFormInputText(),
      'chapeau'                    => new sfWidgetFormTextarea(),
      'contenu'                    => new sfWidgetFormTextarea(),
      'duree_redaction'            => new sfWidgetFormInputText(),
      'copyright'                  => new sfWidgetFormInputText(),
      'nb_lu'                      => new sfWidgetFormInputText(),
      'categorie_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'), 'add_empty' => false)),
      'publie'                     => new sfWidgetFormInputCheckbox(),
      'afficher_chapeau'           => new sfWidgetFormInputCheckbox(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'slug'                       => new sfWidgetFormInputText(),
      'articles_lies_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
      'reverse_articles_lies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'titre'                      => new sfValidatorString(array('max_length' => 200)),
      'date'                       => new sfValidatorPass(array('required' => false)),
      'chapeau'                    => new sfValidatorString(array('required' => false)),
      'contenu'                    => new sfValidatorString(),
      'duree_redaction'            => new sfValidatorInteger(array('required' => false)),
      'copyright'                  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'nb_lu'                      => new sfValidatorInteger(array('required' => false)),
      'categorie_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Categorie'))),
      'publie'                     => new sfValidatorBoolean(array('required' => false)),
      'afficher_chapeau'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'slug'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'articles_lies_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
      'reverse_articles_lies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Article', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Article';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['articles_lies_list']))
    {
      $this->setDefault('articles_lies_list', $this->object->Articles_lies->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['reverse_articles_lies_list']))
    {
      $this->setDefault('reverse_articles_lies_list', $this->object->ReverseArticlesLies->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveArticles_liesList($con);
    $this->saveReverseArticlesLiesList($con);

    parent::doSave($con);
  }

  public function saveArticles_liesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['articles_lies_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Articles_lies->getPrimaryKeys();
    $values = $this->getValue('articles_lies_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Articles_lies', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Articles_lies', array_values($link));
    }
  }

  public function saveReverseArticlesLiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['reverse_articles_lies_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ReverseArticlesLies->getPrimaryKeys();
    $values = $this->getValue('reverse_articles_lies_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ReverseArticlesLies', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ReverseArticlesLies', array_values($link));
    }
  }

}
