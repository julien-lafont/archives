<?php

class dbClearTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'doctrine';
    $this->name             = 'clear';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [dbClear|INFO] task does things.
Call it with:

  [php symfony dbClear|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

	$tables = array(
		'commentaire',
		'articles_lies',
		'article_index',
		'article',
		'categorie',
		'rel_techno_creation',
		'techno',
		'creation',
		'categorie_folio',
		'tagging',
		'tag',
		'sf_guard_group_permission',
		'sf_guard_user_group',
		'sf_guard_user_permission',
		'sf_guard_user',
		'sf_guard_group',
		'sf_guard_permission'
	);
	
	foreach ($tables as $table) {
	  $this->log("Suppression en cours : ".$table);
		$connection->query("DELETE FROM ".$table);
	}
    // add your code here
    
	$this->log("Vidange des tables terminée !");
  }
}
