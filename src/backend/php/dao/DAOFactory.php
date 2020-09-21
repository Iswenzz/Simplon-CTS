<?php
require_once __DIR__ . "/DAO.php";

class DAOFactory
{
	private static array $daoMap = [];

	/**
	 * Get a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to get.
	 */
	public static function getDAO(string $class): DAO
	{
		$result = DAOFactory::$daoMap[$class];
		if (!$result)
			throw new RuntimeException("DAO for class " . $class . " is not implemented.");
		return $result;
	}

	/**
	 * Register a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to register.
	 */
	public static function registerDAO(string $class): void
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

	/**
	 * Unregister a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to unregister.
	 */
	public static function unregisterDAO(string $class): void
	{
		if (array_key_exists($class, DAOFactory::$daoMap))
			unset(DAOFactory::$daoMap[$class]);
		else
			throw new RuntimeException("DAO for class " . $class . " not found.");
	}
}