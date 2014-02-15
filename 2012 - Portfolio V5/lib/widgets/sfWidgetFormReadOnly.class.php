<?php

/**
 * sfWidgetFormReadOnly display value without HTML tag.
 *
 * @package    symfony
 * @subpackage widget
 */
class sfWidgetFormReadOnly extends sfWidgetForm
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
    $this->addOption('type', null);
    $this->addOption('model', null);
    $this->addOption('query', null);

    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML span tag
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  { 
    switch ($this->getOption('type'))
    {
      case 'sfWidgetFormInputCheckbox':
        if ($value)
        {
          $value = image_tag('/images/doctrine/tick.png', array('alt' => 'Oui', 'title' => 'Oui'));
        }
        else
        {
          $value = image_tag('/images/doctrine/delete.png', array('alt' => 'Non', 'title' => 'Non'));
        }
        break;

      case 'sfWidgetFormDoctrineChoice':
        if (!empty($value))
        {
          $table = Doctrine::getTable($this->getOption('model'));
          $primaryKey = $table->getIdentifier();
          $collection = $table->createQuery('o')
                              ->whereIn('o.' . $primaryKey, $value)
                              ->execute();

          $value = '';
          foreach ($collection as $item)
          {
            $value .= $item . '<br />';
          }
        }
        else
        {
          $value = '';
        }
        break;
      case 'sfWidgetFormIoDate' :
        $value = Utility::getDateFormate($value);
        break;
      case 'sfWidgetFormJQueryAutocompleter' : // @TODO: rendre spécifique a adresse
        if(!empty($value)) {
          $ville = Doctrine_Query::create()->from('Commune')->where('id_commune = ?', $value)->fetchOne();
        }
        $value = '<span>'. $ville .'</span>';
        break;
    }

    // generate id field
    $attributes = $this->fixFormId(array_merge(array('name' => $name), $attributes));
    unset($attributes['name']);

    return $this->renderContentTag('span', $value, $attributes);
  }
}
