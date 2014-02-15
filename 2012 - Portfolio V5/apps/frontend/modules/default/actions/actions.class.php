<?php

/**
 * default actions.
 *
 * @package    SDRH
 * @subpackage default
 * @author     Vivian Pennel <vpennel@iocean.fr>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Error page for page not found
  *
  * @param sfRequest $request A request object
  */
  public function executeError404(sfWebRequest $request)
  {
    $this->getResponse()->setFullwidth(true);
  }

  public function executeLogin(sfWebRequest $request) {}

  public function executeSecure(sfWebRequest $request) {}

  public function executeDisabled(sfWebRequest $request) {}

}

?>