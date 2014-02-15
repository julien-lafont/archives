<?php

/**
 * accueil actions.
 *
 * @package    foliov4
 * @subpackage accueil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accueilActions extends sfActions
{

  
	/**
	 * Executes index action
	 * @param sfWebRequest $request
	 * @return unknown_type
	 */
	public function executeIndex(sfWebRequest $request)
	{
	  
    $this->getResponse()->setFullwidth(true);

    // SEO
    $this->getResponse()->addMeta('description', 'Découvrez mes dernières réalisations web et logiciels, parcourez mon blog technique, téléchargez mon CV et prenons contact sur Studio-dev.fr !');
    $this->getResponse()->setTitle('Portfolio de Julien Lafont, Ingénieur Étude et Développement à Montpellier');
    
  }
}
