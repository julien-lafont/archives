<?php


class CommentaireTable extends Doctrine_Table
{

	/**
	 * Retourne l'instance du mod�le
	 * @return CommentaireTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Commentaire');
	}
}