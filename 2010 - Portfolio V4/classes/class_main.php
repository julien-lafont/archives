<?php

/**
 * Classe principale du moteur : initialise le moteur de base de donnée et la gestion des membres
 *
 * PHP version 5
 *
 * @package    Ix'Class
 * @author     Julien LAFONT <freelance@studio-dev.fr>
 * @copyright  2007 Studio-dev.fr
 * @version    1.0
 * @modified   11/11/2007 
 */
 
 


			
// Début de la classe principale
class Main {

	private $debug = false;

	// Attributs partagés
	public $design;
	public $sql;
	public $mbre;
	public $fct;
	public $config=array();
	
	// Constructeur, démarrage du moteur
	public function __construct($path='./')
	{
		session_start();
		
		// Gestion du chemin relatif
		global $path_class;
		$path_class=$path;
		
		// Initialisation de la classe SQL
		require_once $path_class.'include/abstraction_sql.php';
		
		// Chargement des variables de configuration dynamique
		$sql_config=mysql_query("SELECT cle, valeur FROM ".PREFIX."config");
		while($conf=mysql_fetch_array($sql_config, MYSQL_ASSOC))
		{
			define($conf['cle'], $conf['valeur']);
		}

		
		// Initialisation du système de template
		//$base="/kunden/homepages/45/d215760031/htdocs/blog2_0/";
		//$base="C:/dev/wamp/www/folio_iut/";
		$base="/homez.368/studiode/multi/v3/";
		
		define('TEMPLATE_DIR', $base.'templates/');
		define('COMPILE_DIR', $base.'include/smarty/templates_c/');
		define('CONFIG_DIR', $base.'include/smarty/configs/');
		define('CACHE_DIR', $base.'include/smarty/cache/');
		require_once $path_class.'include/smarty/Smarty.class.php';
		$this->design = new Smarty();

		// Initialisation de la classe fonctions
		$this->fct = new fonctions();
		
		// Connexion automatique à Mysql
		
	}

	 
}

// Fonction de chargement automatique des classes à leur instanciation
function __autoload($classe)
{
	global $path_class;
	require_once $path_class.'classes/class_'.strtolower($classe).'.php';
}

?>
