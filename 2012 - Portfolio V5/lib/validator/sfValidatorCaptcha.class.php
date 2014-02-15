<?php


class sfValidatorCaptcha extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {
    $this->setOption('empty_value', '');
    $this->setOption('required', false);
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $clean = (string) $value;

    $length = function_exists('mb_strlen') ? mb_strlen($clean, $this->getCharset()) : strlen($clean);

    if ($length > 0)
    {
      throw new sfValidatorError($this, "Les robots ne sont pas les bienvenus !");
    }

    return $clean;
  }
}
