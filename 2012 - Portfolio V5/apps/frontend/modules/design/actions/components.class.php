<?php

class designComponents extends sfComponents
{
	public function executeMenuPrincipal()
	{
		$this->categories = CategorieTable::getInstance()->findAllCache();
	}
	
	public function executeMenuFooter()
	{
		
	}
}