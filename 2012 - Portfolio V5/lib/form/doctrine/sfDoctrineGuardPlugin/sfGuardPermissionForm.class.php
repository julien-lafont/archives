<?php

/**
 * sfGuardPermission form.
 *
 * @package    form
 * @subpackage sfGuardPermission
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class sfGuardPermissionForm extends PluginsfGuardPermissionForm
{
  public function configure()
  {
    $this->useFields(array(
      'name',
      'description',
      'groups_list',
      'users_list',

    ));
  
    //$this->widgetSchema['name'] = new sfWidgetFormReadOnly(array('type' => 'sfWidgetFormInputText'));

    $this->widgetSchema['users_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'     => 'sfGuardUser',
      'order_by'  => array('username', 'ASC'),
    ));

    $this->widgetSchema['users_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['users_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));

    $this->widgetSchema['groups_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'     => 'sfGuardGroup',
      'order_by'  => array('name', 'ASC'),
    ));

    $this->widgetSchema['groups_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['groups_list']->setOption('renderer_options', array(
      'label_unassociated'  => 'Non associé',
      'label_associated'    => 'Associé',
    ));
  }
}