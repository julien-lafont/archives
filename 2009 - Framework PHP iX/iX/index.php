<?php

/**
 * iX : Fichier d'entré
 *
 * iX : CMF Open source
 *
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GPL
 * @version    0.0.1
 * @since      File available since Release 1.5.0
 * @author     Julien LAFONT (www.Studio-Dev.fr)
 * @todo       
 * @link
*/

ob_start();

echo "<pre>";
DEFINE('IXBASE', dirname(__FILE__));

// Inclure les autoloads
include 'classes/core/IxCoreAutoloader.php';
new IxCoreAutoloader();

IxDebug::direct("coucou");

echo IxCoreConfig::getInstance()->dump();

$z = new ModuleContactTest();

echo "</pre>";
?>
    

    
    
