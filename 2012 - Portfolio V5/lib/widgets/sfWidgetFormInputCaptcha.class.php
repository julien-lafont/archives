<?php 
class sfWidgetFormInputCaptcha extends sfWidgetFormInput
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    
    $this->setAttribute('class', 'sfValidatorAntiSp_a_m');
  }
}