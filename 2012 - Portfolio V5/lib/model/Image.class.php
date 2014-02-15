<?php 

class Image {
  
  protected $path;
  protected $filename;
  protected $object;
  
  public function __construct($path, $filename, $object)
  {
    $this->filename = $filename;
    $this->path = $path;
    $this->object = $object;
  }
  
  public function getPath() {
    return $this->path;
  }
  
  public function getFilename()
  {
    return $this->filename;
  }
  
  public function getObject()
  {
    return $this->object;
  }
  
  
  public function getMiniature()
  {
    
    $chemin = sfConfig::get('sf_upload_dir').'/folio/_'.$this->getObject()->getCode().'/gen/';
    $final = $chemin.'_min_'.$this->getFilename();

    if (!is_file($final))
    {
      if (!is_dir($chemin)) mkdir($chemin, true); // Cré le chemin si il n'existe pas
      
      $img = new sfImage(sfConfig::get('sf_web_dir').$this->getPath().$this->getFilename());
      $img->thumbnail(205, 190, 'scale');
      $img->setQuality(100);
      $img->saveAs($final);
    }
    
    return '/uploads/folio/_'.$this->getObject()->getCode().'/gen/_min_'.$this->getFilename();
  }
  
  public function getTailleReelle()
  {
    $chemin = sfConfig::get('sf_upload_dir').'/folio/_'.$this->getObject()->getCode().'/gen/';
    $final = $chemin.'_big_'.$this->getFilename();

    if (true || !is_file($final))
    {
      if (!is_dir($chemin)) mkdir($chemin, true); // Cré le chemin si il n'existe pas
      
      $img = new sfImage(sfConfig::get('sf_web_dir').$this->getPath().$this->getFilename());
      $img->thumbnail(1080, 800, 'scale');
      $img->setQuality(90);
      $img->saveAs($final);
    }
    
    return '/uploads/folio/_'.$this->getObject()->getCode().'/gen/_big_'.$this->getFilename();
  }
  
}