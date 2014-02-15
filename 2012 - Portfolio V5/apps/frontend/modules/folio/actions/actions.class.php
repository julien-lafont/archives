<?php

/**
 * folio actions.
 *
 * @package    foliov4
 * @subpackage folio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class folioActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
	   $this->creations = CreationTable::getInstance()->getAll();
	   $this->categories = CategorieFolioTable::getInstance()->getAllCache();
	   
	  // SEO
    $this->getResponse()->addMeta('description', 'Ingénieur étude et développement à Montpellier, découvrez mes réalisations web et logiciel');
    $this->getResponse()->setTitle('Portfolio Studio-dev.fr - Développement web et logiciels - Julien Lafont');
    
	}
	
	
	public function executeShow(sfWebRequest $request)
	{
	  $this->crea = $this->getRoute()->getObject();
	  $this->forward404Unless($this->crea, "Création introuvable");
	  
	  // SEO
    $this->getResponse()->addMeta('description', 'Ingénieur étude et développement à Montpellier, découvrez mes réalisations web et logiciel');
    $this->getResponse()->setTitle('Studio-dev, Présentation de mes travaux : '.ucfirst($this->crea->getTitre()));
    
	}
}
