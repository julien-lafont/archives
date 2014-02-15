<?php

class folioComponents extends sfComponents
{
  
  public function executeBlocMesCreations()
  {
    $crea = $this->getVar('crea');
    $liste=array();
    
    $liste[2] = $crea;
    if ($liste[2]->hasCreaSuivante()) 
      $liste[1] = $liste[2]->getCreaSuivante();
    if ($liste[2]->hasCreaSuivante() && $liste[1]->hasCreaSuivante()) 
      $liste[0] = $liste[1]->getCreaSuivante();
    if ($liste[2]->hasCreaPrecedente())
      $liste[3] = $liste[2]->getCreaPrecedente();
    if ($liste[2]->hasCreaPrecedente() && $liste[3]->hasCreaPrecedente())
      $liste[4] = $liste[3]->getCreaPrecedente();
    
    $this->liste = $liste;
  }
  
  public function executeBlocDerniersAjouts()
  {
    $nb = ($this->getVar('nb')>0) ? $this->getVar('nb') : 5;
	
	$message = $this->getVar('message');
	if (empty($message)) $message = 'Dernier ajouts';

    $this->liste = CreationTable::getInstance()->getDerniersAjouts($nb );
	$this->message = $message;
  }
  
  public function executeDernieresMiniatures()
  {
    $nb = ($this->getVar('nb')>0) ? $this->getVar('nb') : 4;

    $this->liste = CreationTable::getInstance()->getDerniersAjouts($nb);
  }
}