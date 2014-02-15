<?php

class IxDebug {

    private $request;
    private $response;
    private $channel;
    public $logger;

    public static $instance=null;
    private static $correspondance = array (Zend_Log::INFO  => "info",
					    Zend_Log::DEBUG => "debug",
					    Zend_Log::WARN  => "alerte",
					    Zend_Log::ERR   => "erreur",
					    Zend_Log::CRIT  => "securite"
					  );


    public function __construct() {

      $c = IxCoreConfig::getInstance();
      $config = $c->getConfigEnvironnement();

      if ($config->Debug->Actif!=0)
      {
	switch($config->Debug->Type) 
	{
	  case "firebug":
	  case "firephp":

	    // Altération des requêtes
	    $this->request = new Zend_Controller_Request_Http();
	    $this->response = new Zend_Controller_Response_Http();
	    $this->channel = Zend_Wildfire_Channel_HttpHeaders::getInstance();
	    $this->channel->setRequest($this->request);
	    $this->channel->setResponse($this->response);

	    $writer = new Zend_Log_Writer_Firebug();
	    $this->logger = new Zend_Log($writer);

	  break;

	  // -----------------------------------------------------------------------------

	  case "fichier":

	      if (isset($config->Debug->Fichier) && !empty($config->Debug->Fichier)) {
		$url = IXBASE .DIRECTORY_SEPARATOR. "logs". DIRECTORY_SEPARATOR. $config->Debug->Fichier;
		$writer = new Zend_Log_Writer_Stream($url);
		$this->logger = new Zend_Log($writer);
	      }
	      else 
	      {
		throw new IxCoreException("IxDebug.php > Impossible d'initialiser le logger fichier sur ".$config->Debug->Fichier);
	      }

	  break;
	  
	  // -----------------------------------------------------------------------------

	  case "mail":
	  case "email":
	    
	    $c= IxCoreConfig::getConfig();

	    $mail = new Zend_Mail();
	    $mail->setFrom($c->Emails->Destinataire->Logs);
  
	    $writer = new Zend_Log_Writer_Mail($mail);
	    $writer->setSubjectPrependText('Logs du site '.$c->Site->General->Nom);

	    $this->logger = new Zend_Log($writer);

	  break;

	  // -----------------------------------------------------------------------------

	  case "direct":
	  default:

	    $writer = new Zend_Log_Writer_Stream('php://output');
	    $formatter = new Zend_Log_Formatter_Simple('<div class="debug">%priorityName% - %timestamp% >>>> <strong>%message%</strong></div>' . PHP_EOL);
	    $writer->setFormatter($formatter);

	    $this->logger = new Zend_Log($writer);

	  break;
	  
	}
      }
    }

    private static function getInstance() 
    {
        if (!isset(self::$instance)) 
	{
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

  
    public static function info($m) {
      self::getInstance()->logger($m, Zend_Log::INFO);
    }

    public static function debug($m) {
      self::getInstance()->logger($m, Zend_Log::DEBUG);
    }

    public static function alerte($m) {
      self::getInstance()->logger($m, Zend_Log::WARN);
    }

    public static function erreur($m) {
      self::getInstance()->logger($m, Zend_Log::ERR);
    }

    public static function secu($m) {
      self::getInstance()->logger($m, Zend_Log::CRIT);
    }

    public static function direct($m) {
      
      $writer = new Zend_Log_Writer_Stream('php://output');
      $formatter = new Zend_Log_Formatter_Simple('<div class="debug">%priorityName% - %timestamp% >>>> <strong>%message%</strong></div>' . PHP_EOL);
      $writer->setFormatter($formatter);

      $logger = new Zend_Log($writer);
      $logger->log($m, Zend_Log::DEBUG);
    }

    private function logger($m, $level) {
      
      $c = IxCoreConfig::getConfigEnvironnement();
      
      if (in_array(self::$correspondance[$level], (array)$c->Debug->Niveau)) {
	if ($this->logger!==null) 
	  $this->logger->log($m, $level);
	else
	  throw new IxCoreException("IxDebug.php > Logger non initialisé");
      }
    }

    function __destruct() {
      
      $c = IxCoreConfig::getInstance();
      $config = $c->getConfigEnvironnement();

      // Envoie des headers pour le mode firebug
      if ($config->Debug->Actif!=0 && ($config->Debug->Type=="firebug" || $config->Debug->Type=="firephp") )
      {
	$this->channel->flush();
	$this->response->sendHeaders();
      }
    }



  }

?> 
