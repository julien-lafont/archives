<?php

/**
 * sfGuardGroup form.
 *
 * @package    form
 * @subpackage sfGuardGroup
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class sfGuardGroupForm extends PluginsfGuardGroupForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );

    $this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'     => 'sfGuardUser',
      'order_by'  => array('username', 'ASC'),
    ));

    $this->widgetSchema['users_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['users_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));

    $this->widgetSchema['permissions_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'     => 'sfGuardPermission',
      'order_by'  => array('name', 'ASC'),
    ));

    $this->widgetSchema['permissions_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['permissions_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));
  }
}