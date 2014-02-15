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
		$this->sql=new Sql(LOGIN, PASS, HOTE, BASE);
		
		// Chargement des variables de configuration dynamique
		$sql_config=$this->sql->query("SELECT cle, valeur FROM ".PREFIX."config");
		while($conf=$this->sql->getRowAssoc($sql_config))
		{
			define($conf['cle'], $conf['valeur']);
		}

		
		// Initialisation du système de template
		define('TEMPLATE_DIR', BASE_TEMPLATE.'templates/');
		define('COMPILE_DIR', BASE_TEMPLATE.'include/smarty/templates_c/');
		define('CONFIG_DIR', BASE_TEMPLATE.'include/smarty/configs/');
		define('CACHE_DIR', BASE_TEMPLATE.'include/smarty/cache/');
		require_once $path_class.'include/smarty/Smarty.class.php';
		$this->design = new Smarty();
		
		// Initialisation de la classe Membres
		$this->mbre = new Membres($this);
		if (!$this->mbre->est_log())
			$this->mbre->connexion_cookies();

		// Initialisation de la classe fonctions
		$this->fct = new fonctions();
		
		
	}

	 
}

// Fonction de chargement automatique des classes à leur instanciation
function __autoload($classe)
{
	global $path_class;
	require_once $path_class.'classes/class_'.strtolower($classe).'.php';
}

?>