<?php
/**
 * sfWidgetFormIoDate display an sfWidgetFormJQueryDate with default options
 *
 * @package    symfony
 * @subpackage widget
 */
class sfWidgetFormIoDate extends sfWidgetFormJQueryDate
{
  protected
    $range    = array(),
    $minRange = 80,
    $maxRange = 10;

  public function __construct($range = null, $options = array(), $attributes = array())
  {
    if ($range === null)
    {
      $range = array('min' => $this->minRange, 'max' => $this->maxRange);
    }
    else
    {
      if (!array_key_exists('min', $range)) $range['min'] = $this->minRange;
      if (!array_key_exists('max', $range)) $range['max'] = $this->maxRange;
    }

    $this->range = $range;

    parent::__construct($options, $attributes);
  }

  /**
   * (non-PHPdoc)
   * @see sfFormExtraPlugin/lib/widget/sfWidgetFormJQueryDate#configure($options, $attributes)
   */
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $dateMax = (date('Y') + $this->range['max']);
    $dateMin = (date('Y') - $this->range['min']);
    $years = range($dateMax, $dateMin);
    $years = array_combine($years, $years);
    $dateWidget = new sfWidgetFormDate();

    $this->setOption('culture','fr_FR');
    $this->setOption('config','{ changeMonth: true, changeYear: true, yearRange: \''.$dateMin.':'.$dateMax.'\' }');
    $this->setOption('image','/images/calendar.png');
   

    $dateWidget->setOption('format','%day%/%month%/%year%');
    $dateWidget->setOption('years',$years);
    $this->setOption('date_widget',$dateWidget);
  }
}
