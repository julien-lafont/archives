<?php


class ArticlesLiesTable extends Doctrine_Table
{

	/**
	 * Retourne l'instance du mod�le
	 * @return ArticleLiesTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('ArticlesLies');
	}
}