<?php

/**
 * cv actions.
 *
 * @package    foliov4
 * @subpackage cv
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cvActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->getResponse()->setFullwidth(true);
		
		// SEO
		$this->getResponse()->addMeta('description', 'Curriculum Vitae de Julien Lafont : mes formations, mes expériences et mon projet professionnel');
		$this->getResponse()->setTitle('Studio-dev : CV de Julien LAFONT, Ingénieur Etude et Développement');
    
	}
	
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeReferences(sfWebRequest $request)
	{
		// SEO
		$this->getResponse()->addMeta('description', 'Consultez mes références professionnelles. Avis de mes chefs de projet IOcean et Kaliop. Références de clients Studio-Dev');
		$this->getResponse()->setTitle('Studio-dev : Références professionnelles de Julien Lafont, Ingénieur à Montpellier');
    
	}
}
