<?php

/**
 * Fichier chargé de définir les règles d'autochargement des classes
 *
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GPL
 * @version     0.01
 * @since      File available since Release 1.5.0
 * @author     Julien LAFONT (www.Studio-Dev.fr)
 * @todo
 * @link
*/

class IxCoreAutoloader {
    
    public function __construct() 
    {

        // Chargement du Zend Frameworks grace à l'autoloader intégré
        require_once( IXBASE .DIRECTORY_SEPARATOR. "librairies" .DIRECTORY_SEPARATOR. "Zend" .DIRECTORY_SEPARATOR. "Loader" .DIRECTORY_SEPARATOR. "Autoloader.php");
        spl_autoload_register(array('Zend_Loader_Autoloader',  'autoload'));
        
        // Chargement des configurations
        require_once (  IXBASE .DIRECTORY_SEPARATOR. "classes" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "IxCoreConfig.php");
	$this->determinerApplication();

	  /*
	    $c=Ix_Core_Configuration::getInstance();
	    print_r($c->config);
	    print_r($c->getConfig());
	    print_r($c->getConfigEnvironnement());
	  */


        // Chargement de Doctrine
        
        // Autoload des classes Ix
        spl_autoload_register(array('IxCoreAutoloader', 'autoload'));
        
    }
    
    /*
     * Auto-chargement des classes Ix, déterminé à partir du nom des classes
     * @param $class : Nom de la classe à charger
    */
    public static function autoload($class)
    {
        /*
         * Classes internes à Ix
         * Nom de la classe: Ix[Dossiers]*Nom
         *   ex> (IxCoreAutoloader.php)
         * Dossir de la classe: classes/[Dossiers]* /Nom_Complet.php
         *   ex> (classes/core/IxCoreAutoloader.php)
        */
        if (preg_match('#^ix#i', $class) ) 
	{
            $url = IXBASE . DIRECTORY_SEPARATOR . "classes";
            $composants = preg_split("#,#", preg_replace("#([A-Z])#", ",$1", $class), -1, PREG_SPLIT_NO_EMPTY);
            
            for($i=1; $i<count($composants)-1; $i++)  $url.= DIRECTORY_SEPARATOR . strtolower($composants[$i]);
            $url.= DIRECTORY_SEPARATOR . $class .".php";
           
            if (file_exists($url)) require_once ($url);
            else   throw new IxCoreException("Impossible de charger la classe ".$class);
        }
        
        /*
         * Classes des différents modules
         * Nom de la classe: Module[Module]Nom
         *   ex> ModuleMembresInscription.php
         * Chemin de la classe applications/[Application]/[Module]/lib/Nom_Complet.php
         *   ex> applications/frontend/membres/lib/ModuleMembresInscription.php
         */
        else if (preg_match('#^module#i', $class)) 
	{
	    
	    $appli = $c = IxCoreConfig::GetConfig()->Live->Application;
            $url = IXBASE . DIRECTORY_SEPARATOR . "applications" . DIRECTORY_SEPARATOR . $appli; // Application
            
	    $composants = preg_split("#,#", preg_replace("#([A-Z])#", ",$1", $class), -1, PREG_SPLIT_NO_EMPTY);

	    $url .= DIRECTORY_SEPARATOR . strtolower($composants[1]) . DIRECTORY_SEPARATOR ."lib"; // Module

	    for($i=2; $i<count($composants)-1; $i++)  $url.= DIRECTORY_SEPARATOR . strtolower($composants[$i]);
	    $url.=  DIRECTORY_SEPARATOR  . $class . ".php";

            if (file_exists($url)) require_once ($url);
            else   throw new IxCoreException("Impossible de charger la classe ".$class);

	}
        
    }

    /*
     * Récupère l'application à chargée à partir de l'url et de la configuration du site
     * On cherche les concordances entre le sous-domaine et la configuration Site->Applications
     * Le signe '*' dans les url des appli signifient : Toutes les autres
     * @return L'application à charger
    */
    private function determinerApplication() {
      $liste_applis = IxCoreConfig::getConfig()->Site->Applications;
      $sous_domaine = $this->recupNomDeDomaine();
      
      $appli_defaut=null;
      $appli_detectee=null;
      foreach ($liste_applis as $appli=>$urls) {
	foreach ($urls as $url) {
	  if ($url=="*") $appli_defaut=$appli;
	  if ($url==$sous_domaine) $appli_detectee=$appli;
	}
      }

      if ($appli_detectee==null) $appli_detectee = ($appli_defaut!=null) ? $appli_defaut : $liste_applis[0];
      
      $c = IxCoreConfig::GetInstance();
      $c->ajouter('Application', $appli_detectee);

    }


    private function recupNomDeDomaine($host = '') {
      return substr_count($_SERVER['HTTP_HOST'], '.') > 1 ? substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.')) : ''; 
    }

    
    
}

?>
