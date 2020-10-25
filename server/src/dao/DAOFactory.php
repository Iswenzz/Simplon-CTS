<?php
require_once __DIR__ . "/DAO.php";

class DAOFactory
{
	private static array $daoMap = [];

	/**
	 * Get a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to get.
	 * @return DAO
	 */
	public static function getDAO(string $class): DAO
	{
		if (!array_key_exists($class, DAOFactory::$daoMap))
			throw new RuntimeException("DAO for class " . $class . " is not implemented.");
		return DAOFactory::$daoMap[$class];
	}

	/**
	 * Register a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to register.
	 * @return bool
	 */
	public static function registerDAO(string $class): bool
	{
		if (array_key_exists($class, DAOFactory::$daoMap))
			return false;
		DAOFactory::$daoMap[$class] = new $class;
		return true;
	}

	/**
	 * Unregister a DAO object instance from the specified class name.
	 * @param string $class - The DAO class name to unregister.
	 * @return bool
	 */
	public static function unregisterDAO(string $class): bool
	{
		if (array_key_exists($class, DAOFactory::$daoMap))
			unset(DAOFactory::$daoMap[$class]);
		else
			return false;
		return true;
	}
}
