<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package form
 * @package sf_guard_user
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $this->useFields(array(
      'username',
      'password',
      'password_again',
      'is_active',
      'is_super_admin',
      'groups_list',
      'permissions_list',
    ));

    $this->widgetSchema['groups_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'    => 'sfGuardGroup',
      'order_by' => array('name', 'ASC'),
    ));

    $this->widgetSchema['groups_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['groups_list']->setOption('renderer_options', array(
      'label_unassociated' => 'Non associé',
      'label_associated'   => 'Associé',
    ));
    $this->widgetSchema['groups_list']->setAttribute('size', 15);

    $this->widgetSchema['permissions_list'] = new sfWidgetFormDoctrineChoice(array(
      'model'    => 'sfGuardPermission',
      'order_by' => array('name', 'ASC'),
    ));

    $this->widgetSchema['permissions_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    $this->widgetSchema['permissions_list']->setOption('renderer_options', array(
      'label_unassociated' => 'Non associé',
      'label_associated'   => 'Associé',
    ));
    $this->widgetSchema['permissions_list']->setAttribute('size', 25);

    $this->widgetSchema->setDefaults(array(
      'is_active'      => true,
      'is_super_admin' => false
    ));

    $this->widgetSchema->setLabels(array(
      'password_again'   => 'Confirmation',
      'is_active'        => 'Actif ?',
      'is_super_admin'   => 'Super administrateur ?',
      'groups_list'      => 'Groupes',
      'permissions_list' => 'Permissions supplémentaires'
    ));
  }
}