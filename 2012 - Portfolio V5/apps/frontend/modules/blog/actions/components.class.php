<?php

class blogComponents extends sfComponents
{
  /**
   * Affiche le bloc : Liste des catégories
   * @return unknown_type
   */
  public function executeBlocListeCategories()
  {
    $this->categories = CategorieTable::getInstance()->findAllCache();
  }
  
   /**
   * Affiche le bloc : Articles les plus lus
   * @return unknown_type
   */
  public function executeBlocTopArticles()
  {
    $this->tops = ArticleTable::getInstance()->getTopArticles(5);
  }
  
   /**
   * Affiche le bloc : Nuage de tag
   * @return unknown_type
   */
  
  public function executeBlocTagCloud()
  {
    $liste_tags = ArticleTable::getInstance()->getTags();
   
    $this->tags = $liste_tags;
    
  }
  
   /**
   * Affiche en résumé les derniers articles
   * @return unknown_type
   */
  public function executeResumeTopArticles()
  {
   
    $nb = $this->getVar('nb') ? $this->getVar('nb') : 5;
    
    $this->tops = ArticleTable::getInstance()->getTopArticles($nb);
  }
  
  public function executeListeDerniersArticles()
  {
    $nb = $this->getVar('nb') ? $this->getVar('nb') : 5;
    $this->articles = ArticleTable::getInstance()->getDerniersArticles($nb);
  }
  

}