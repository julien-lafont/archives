<?php

/**
 * sfWidgetFormReadOnly display value without HTML tag.
 *
 * @package    symfony
 * @subpackage widget
 */
class sfWidgetFormNoRender extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidget
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->setOption('is_hidden', true);    
    parent::configure($options, $attributes);
  }

  /**
   * Returns the label for the widget.
   *
   * @return string The label
   */
  public function getLabel()
  {
    return '&nbsp;';
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return '&nbsp;';
  }

}
