<?php

/**
 * Article form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BackendArticleForm extends BaseArticleForm
{
  public function configure()
  {
    
    unset($this['reverse_articles_lies_list'], $this['created_at'], $this['deleted_at'], $this['updated_at']);
    
    // Champs Wysiwyg
    //$this->widgetSchema['chapeau'] = new sfWidgetFormCKEditor();
    //$this->widgetSchema['contenu'] = new sfWidgetFormCKEditor();

    // Articles liés
    $this->widgetSchema['articles_lies_list'] = new sfWidgetFormDoctrineChoice(array( 'model' => 'Article' ));
    $this->widgetSchema['articles_lies_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['articles_lies_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));
    
    //$dateWidget = new sfWidgetFormI18nDate(array('format' => '%day%/%month%/%year%','month_format' => 'short_name','culture' => 'fr'));
    //$this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array('culture'=> 'fr',  'date_widget' => $dateWidget));


  }
}
