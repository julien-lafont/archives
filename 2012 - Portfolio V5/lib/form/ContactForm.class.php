<?php


class ContactForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'message'    => new sfWidgetFormTextarea(),
      'pseudo'     => new sfWidgetFormInputText(),
      'email'      => new sfWidgetFormInputText(),
      'sujet'      => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormInputCaptcha()
    ));

    $this->setValidators(array(
      'message'    => new sfValidatorString(array('required' => true)),
      'pseudo'     => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'email'      => new sfValidatorEmail(array('max_length' => 255, 'required' => true)),
      'sujet'      => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'name'       => new sfValidatorCaptcha(),
    ));

    $this->widgetSchema->setNameFormat('contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);


    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact';
  }

}
