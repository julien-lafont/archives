<?php


class ArticleTable extends Doctrine_Table
{

	/**
	 * Retourne l'instance du modèle
	 * @return ArticleTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Article');
	}
	
	/**
	 * Retourne la requête permettant d'obtenir les derniers articles
	 * @return Doctrine_Query
	 */
	public function getQueryDernierArticles()
	{
	  return $this->createQuery('a')->where('a.publie = ?', true)->orderBy('date DESC');
	}

	/**
   * Retourne la requête permettant d'obtenir les derniers articles en fonction de leur catégorie
   * @return Doctrine_Query
   */
  public function getQueryDernierArticlesCategorie(Categorie $cat)
  {
    return $this->getQueryDernierArticles()->andwhere('a.categorie_id = ?', $cat->getId());
  }
  
  /**
   * Retourne la requête permettant d'obtenir les derniers articles en fonction de leur tag
   * @return Doctrine_Query
   */
  public function getQueryDernierArticlesTag($tag)
  {
    return PluginTagTable::getObjectTaggedWithQuery('Article', $tag)->orderBy('date DESC');
  }
	
  /**
   * Retourne les $nb articles les plus lus
   * @param int $nb
   * @return int
   */
	public function getTopArticles($nb=5)
	{
	  return $this->createQuery('a')->where('a.publie = ?', true)->orderBy('nb_lu DESC, date DESC')->limit($nb)->execute();
	}
	
  /**
   * Retourne les $nb derniers articles
   * @param int $nb
   * @return int
   */
  public function getDerniersArticles($nb=5)
  {
    return $this->getQueryDernierArticles()->limit($nb)->execute();
  }
  
	
	/**
	 * Retourne la liste des tags liés à cet article
	 * @return array
	 */
	public function getTags()
	{
	   return PluginTagTable::getPopulars();
	}
}