<?php

/**
 * IxConfig : Chargement des paramètres de configuration du site
 *
 * Cette classe permet de transformer les différents fichiers de configuration au format Yaml en objets php facilement accessibles.
 * Un cache est utilisé pour ne pas avoir à parser à chaque appel les différents fichiers.
 *
 * Utilisation :
 *
 * > Récupérer la config :
 *    $config = IxCoreConfig::getConfig();  
 * > Récupérer l'instance
 *    @config = IxCoreConfig::getInstance(); 
 *
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GPL
 * @version    0.0.1
 * @since      File available since Release 0.0.1
 * @author     Julien LAFONT (www.Studio-Dev.fr)
 * @todo       - Virer la fonction array2object de là
 * @link
*/

class IxCoreConfig {
    
    // Instance de l'outil de configuration
    private static $instance=null;
    
    // Tableau contenants les différents éléments de la config du site 
    public $config;

    // Cache des fichiers de config
    private $cache;
    
    // Parseur de fichiers Yaml
    private static $yaml;




    public function __construct() 
    {
	echo "Constructeur";
        // Chargement du loader de Yaml
        require_once(IXBASE  . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'IxYaml.php'); 
        self::$yaml = new IxYaml();
        
	// Initialisation du cache
	$this->cache = Zend_Cache::factory('Core', 
					    'File', 
					    array('lifetime'=>3600*24, 'automatic_serialization'=> true),
					    array('cache_dir' => IXBASE . DIRECTORY_SEPARATOR .'cache'. DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR, 
						  'file_name_prefix' => 'ix_cache')
					   );

        // On charge la config
        $this->charger_configuration();
    }
    


    /*
     * Retourne une instance unique de la classe de Configurations
     */
    public static function getInstance() 
    {
        if (!isset(self::$instance)) 
	{
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    public static function getConfig() 
    {
        return self::getInstance()->config;
    }

    /*
     * Retourne une instance unique de la classe de Configurations
     */
    public function config() 
    {
        return $this->config;
    }

    /*
     * Retourne la configuration de l'environnement sélectionné
    */
     public function getConfigEnvironnement() {
	$config=self::getConfig(); 
	$env = $config->Environnements->Actif;
	return $config->Environnements->{$env};
    }


    /*
     * Charger la configuration du site
     * Depuis le cache ou depuis les fichiers d'origine
    */
    private function charger_configuration($forcerNoCache=false) 
    {

      // Récupère la configuration depuis les fichiers
      if (!$this->cache->test('config_globale') || $forcerNoCache) 
      {
	$this->config = self::$yaml->load(IXBASE . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config-globale.yml");

	foreach ($this->config['FichiersConfigurations'] as $fichier) 
	{
	  $config_annexe = self::$yaml->load(IXBASE . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . $fichier);
	  if ($config_annexe==false) {
	    
	  }
	  else
	  {
	    $this->config = array_merge($this->config, $config_annexe);
	  }
	}
      
	$this->config = $this->array2object($this->config);
	$this->cache->save($this->config, 'config_globale', array('config'));

      } 

      // Configuration depuis le cache
      else 
      {
	$this->config = $this->cache->load('config_globale');
	
	// On force le chargement des fichiers si le cache est désactivé
	$env = $this->config->Environnements->Actif;
	$envLive= $this->config->Environnements->{$env};
	if ($envLive->Cache==0) $this->charger_configuration(true);
      }
    }


    public function ajouter($v1, $v2) {
      if (!isset($this->config->Live)) 
      {
	$this->Config->Live=null;
      }

      if (is_array($v2))
      {
	$this->config->Live->{$v1}=$this->array2object($v2);
      }
      else
      {
	$this->config->Live->{$v1}=$v2;
      }
    }

    public function dump() {
      return self::$yaml->dumpObjet($this->config);
    }

    /*
     * Fonction permettant de transformer un tableau multidimentionnel en objet
     */
    private function array2object(array $array) 
    {
      $object = new stdClass();
      foreach($array as $key => $value) 
      {
	if(is_array($value)) 
	{
		$object->$key = $this->array2object($value);
	} 
	else 
	{
		$object->$key = $value;
	}
      }
      return $object;

    }


    
}

?>