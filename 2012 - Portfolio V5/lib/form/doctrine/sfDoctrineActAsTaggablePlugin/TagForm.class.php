<?php

/**
 * Tag form.
 *
 * @package    foliov4
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TagForm extends PluginTagForm
{
  public function configure()
  {
    unset($this['is_triple'], $this['triple_namespace'], $this['triple_key'], $this['triple_value']);
  }
}
