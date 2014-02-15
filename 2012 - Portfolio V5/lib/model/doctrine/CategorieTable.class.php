<?php


class CategorieTable extends Doctrine_Table
{
    
	/**
	 * Retourne l'instance
	 * @return CategorieTable
	 */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Categorie');
    }
    
    public function findAllCache()
    {
    	//$apc = new Doctrine_Cache_Apc();
    	
    	return $this->createQuery("c")
    				  //->useQueryCache(Apc::getInstance(), sfConfig::get('app_cachelistecategories'))
					   //->useResultCache(Apc::getInstance(), sfConfig::get('app_cachelistecategories'))
					   ->execute();
    }
    
}