<?php

/**
 * blog actions.
 *
 * @package    foliov4
 * @subpackage blog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class blogActions extends sfActions
{

  
  
  public function executeIndex(sfWebRequest $request)
  {
	
    $this->pager = new sfDoctrinePager(
		    'Article',
    sfConfig::get('app_blog_pagination')
    );
  
    $this->pager->setQuery(ArticleTable::getInstance()->getQueryDernierArticles());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    
    // SEO
    $this->getResponse()->addMeta('description', 'Découvrez mes expérimentations, retours d\'expériences, veille technologique et tutoriaux sur le développement, le web ou encore Symfony. Blog maintenu par Julien Lafont, développeur indépendant.');
    $this->getResponse()->setTitle('Blog Studio-dev : Expérimentations et retours d\'expériences - Julien Lafont');

  }

  public function executeCategorie(sfWebRequest $request)
  {
    $categorie = $this->getRoute()->getObject();
    
    $this->pager = new sfDoctrinePager('Article', sfConfig::get('app_blog_pagination'));

    $this->pager->setQuery(ArticleTable::getInstance()->getQueryDernierArticlesCategorie($categorie));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->setTemplate('index');
    
    // SEO
    $this->getResponse()->addMeta('description', 'Découvrez mes expérimentations, retours d\'expériences, veille technologique et tutoriaux sur le développement, le web ou encore Symfony. Blog maintenu par Julien Lafont, développeur indépendant.');
    $this->getResponse()->setTitle('Blog Studio-dev : '.$categorie->getTitre().' - Expérimentations et retours d\'expériences');
    
  }
  
  public function executeTag(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('Article', sfConfig::get('app_blog_pagination'));
    
    $this->pager->setQuery(ArticleTable::getInstance()->getQueryDernierArticlesTag($request->getParameter('tag')));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->setTemplate('index');
    
     // SEO
    $this->getResponse()->addMeta('description', 'Découvrez mes expérimentations, retours d\'expériences, veille technologique et tutoriaux sur le développement, le web ou encore Symfony. Blog maintenu par Julien Lafont, développeur indépendant.');
    $this->getResponse()->setTitle('Blog Studio-dev : '.$request->getParameter('tag').' - Expérimentations et retours d\'expériences');
    
    
  }

  public function executeShow(sfWebRequest $request)
  {
  	
	$this->getResponse()->setFullwidth(true);

    // Récupère l'article
    $this->forward404Unless($this->getRoute()->getObject(), "Article introuvable");
    $this->article = $this->getRoute()->getObject();
    
    /* // Ajout d'un commentaire
    if ($request->isMethod('PUT'))
    {
      $this->form = new CommentaireForm();
      $this->processCommentForm($request, $this->form);
    }
    
    // Nouveau commentaire
    else
    {
      $commentaire = new Commentaire();
      $commentaire->setArticle($this->article);
      
      $this->form = new CommentaireForm($commentaire);
    }*/
    
    $this->_marquerCommeLu($this->article);
    
    $this->getResponse()->addMeta('description', Toolbox::format_meta_desc($this->article->getChapeau()));
    $this->getResponse()->setTitle('Blog Studio-dev > '.$this->article->getTitre().' - Expérimentations et retours d\'expérience');
     
  }


  protected function processCommentForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
	  // ANTISPAM
	  $tab = $request->getParameter("commentaire");
	  $nameAntiSpam = $tab["name"];
	  if ($nameAntiSpam!=null && !empty($nameAntiSpam))
	  {
	    $message = "IP : ".$_SERVER["REMOTE_ADDR"]."<br />
					USERAGENT : ".$_SERVER["HTTP_USER_AGENT"]."<br />
					REFERER : ".$_SERVER["HTTP_REFERER"]."<br />
					COOKIE : ".$_SERVER["HTTP_COOKIE"];
					
		@mail("yotsumi.fx@gmail.com", "[Studio-dev] Spam intercepté via [name]", $message);
	  }
	  else if (stripos($tab["message"], "[url")!==false) {
		$message = "IP : ".$_SERVER["REMOTE_ADDR"]."<br />
					USERAGENT : ".$_SERVER["HTTP_USER_AGENT"]."<br />
					REFERER : ".$_SERVER["HTTP_REFERER"]."<br />
					COOKIE : ".$_SERVER["HTTP_COOKIE"];
					
		@mail("yotsumi.fx@gmail.com", "[Studio-dev] Spam intercepté via [url]", $message);
	  }
	  else 
	  {
		$commentaire = $form->save();
		$this->getUser()->setFlash('succes', 'Votre commentaire a été ajouté avec succès.');
	  }
      $this->redirect('article', $this->getRoute()->getObject());
    }
  }
  

  private function _marquerCommeLu(Article $article)
  {
    if (!$this->getUser()->hasAttribute('lu', 'blog'))
    {
      $this->getUser()->setAttribute('lu', array(), 'blog');
    }

    if (!in_array($article->getId(), $this->getUser()->getAttribute('lu', array(), 'blog')))
    {
      $lus = $this->getUser()->getAttribute('lu', array(), 'blog');
      $lus[] = $article->getId();
      $this->getUser()->setAttribute('lu', $lus, 'blog');

      $article->incrementerLus();
      $article->save();

    }

  }



}
