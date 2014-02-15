<?php 

class myWebResponse extends sfWebResponse {
  
  protected $fullwidth   = false;
  
  
  public function addJavascript($file, $position = '', $options = array())
  {
    if (isset($file) && !empty($file))
    {
      parent::addJavascript($file, $position, $options);
    }
  }
  
  
  public function setFullwidth($etat=true)
  {
    $this->fullwidth = $etat;
  }
  
  
  public function getFullwidth()
  {
    return $this->fullwidth;
  }
  
}
?>