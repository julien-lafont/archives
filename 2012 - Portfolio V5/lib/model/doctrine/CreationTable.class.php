<?php


class CreationTable extends Doctrine_Table
{
    /**
     * Get Instance
     * @return CreationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Creation');
    }
    
    /**
     * Retourne toutes les créas ordonnées par date
     * @return Doctrine_Collection
     */
    public function getAll()
    {
      return $this->createQuery('c')->orderBy('c.annee DESC, c.date DESC')->execute();
    }
    
    /**
     * Retourne la liste des $nb dernières créations
     * @param int $nb
     * @return Doctrine_Collection
     */
    public function getDerniersAjouts($nb = 5)
    {
      return $this->createQuery('c')->orderBy('c.date DESC')->limit($nb)->execute();
    }
}