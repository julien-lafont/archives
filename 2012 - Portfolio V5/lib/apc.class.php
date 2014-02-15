<?php

class Apc
{
	
	private static $instance = null;
	
	/**
	 * Retourne une instance vers le gestionnaire de cache APC
	 * @return Doctrine_Cache_Apc
	 */
	public static function getInstance()
	{
		if (!self::$instance) self::$instance = new Doctrine_Cache_Apc();
		return self::$instance;	
	}
}