<?php


class CategorieFolioTable extends Doctrine_Table
{
    
  /**
   * Retourne l'instance
   * @return CategorieFolioTable
   */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CategorieFolio');
    }
    
    public function getAllCache()
    {
      //$apc = new Doctrine_Cache_Apc();
      
      return $this->createQuery("c")
            //->useQueryCache(Apc::getInstance(), sfConfig::get('app_cachelistecategories'))
            //->useResultCache(Apc::getInstance(), sfConfig::get('app_cachelistecategories'))
            ->execute();
    }
}