<?php

/**
 * contact actions.
 *
 * @package    foliov4
 * @subpackage contact
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new ContactForm();
    
    // Envoyer un message
    if ($request->isMethod('PUT'))
    {
      $this->processContactForm($request, $this->form);
    }
    
    // SEO
    $this->getResponse()->addMeta('description', 'N\'hésitez pas à rentrer en contact avec moi si vous avez une proposition de projet, une offre d\'emploi ou pour toute autre demande');
    $this->getResponse()->setTitle('Studio-Dev.fr - Contacter Julien Lafont, Ingénieur étude et développement indépendant sur Montpellier');
    
    
  }
  
  protected function processContactForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->envoyerEmail($form->getValues());
      
      $this->getUser()->setFlash('succes', 'Votre couriel a été transmis avec succès.');
      $this->redirect('contact');
    }
  }
  
  private function envoyerEMail($values)
  {
    
    $message = '';
    $message .= '<h1>Mise en contact de '.$values['pseudo'].'</h1>';
    $message .= '<h3>Informations personnelles </h3>';
    $message .= '<ul>';
    $message .= '<li><strong>Nom : </strong> '.$values['pseudo'].'</li>';
    $message .= '<li><strong>Email : </strong> '.$values['email'].'</li>';
    $message .= '<li><strong>Ip : </strong> '.$_SERVER['REMOTE_ADDR'].'</li>';
    $message .= '<li><strong>Referer : </strong> '.$_SERVER['HTTP_REFERER'].'</li>';
    $message .= '<li><strong>UserAgent : </strong> '.$_SERVER['HTTP_USER_AGENT'].'</li>';
    $message .= '</ul>';
    $message .= '<h3>Message : </h3>';
    $message .= '<pre>';
    $message .= $values['message'];
    
    $mail = Swift_Message::newInstance()
      ->setFrom('contact@studio-dev.fr')
      ->setTo( sfConfig::get('app_email_contact'))
      ->setSubject("[Contact] ".$values['sujet'])
      ->setBody($message, 'text/html');
	  
	  
     
    $this->getMailer()->send($mail);

  }
  
}
