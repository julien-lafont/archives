<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		$this->enablePlugins('sfDoctrinePlugin');
		$this->enablePlugins('sfFormExtraPlugin');
		$this->enablePlugins('sfDoctrineGuardPlugin');
		$this->enablePlugins('sfImageTransformPlugin');
		$this->enablePlugins('sfTaskExtraPlugin');
		//$this->enablePlugins('sfSyntaxHighlighterPlugin');
		$this->enablePlugins('sfDoctrineActAsTaggablePlugin');
		//$this->enablePlugins('sfCKEditorPlugin');
		$this->enablePlugins('sfFeed2Plugin');
		$this->enablePlugins('sfMinifyPlugin');
  }
}
