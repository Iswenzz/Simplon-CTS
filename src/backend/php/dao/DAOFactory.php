<?php
require "./DAO.php";

class DAOFactory
{
	private static array $daoMap = [];

	public static function getDAO(string $class)
	{
		$result = DAOFactory::$daoMap[$class];
		if (!$result)
			throw new RuntimeException("DAO for class " . $class . " is not implemented.");
		return $result;
	}

	public static function registerDAO(string $class)
	{
		/**
		 * @var DAO $dao
		 */
		$dao = new $class;
		if (array_key_exists($dao->getClassName(), DAOFactory::$daoMap))
			throw new RuntimeException("DAO for class " . $class . " already exists.");
		else
			DAOFactory::$daoMap[$class] = $dao;
	}

	public static function unregisterDAO(string $class)
	{
		/**
		 * @var DAO $dao
		 */
		$dao = new $class;
		if (array_key_exists($dao->getClassName(), DAOFactory::$daoMap))
			unset(DAOFactory::$daoMap[$class]);
		else
			throw new RuntimeException("DAO for class " . $class . " not found.");
	}
}
