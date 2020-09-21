<?php
require_once __DIR__ . "/config/config.php";

/**
 * Database PDO factory.
 */
class DatabaseFactory
{
	private static ?PDO $DB = null;

	/**
	 * Singleton database instance.
	 * @param string $user - The database username.
	 * @param string $password - The database password.
	 * @param string $db - The default db to acess.
	 * @param bool $debug - Print debug informations.
	 */
	private function __construct(string $user, string $password, string $db, bool $debug = false)
	{
		try 
		{
			DatabaseFactory::$DB = new PDO("mysql:host=localhost;dbname=$db;port=3306;charset=utf8mb4", $user, $password);
			if ($debug)
				print_r("Connected to $db! <br/>");
		} 
		catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage());
		}
	}

	/**
	 * Get the database singleton instance.
	 */
	public static function getConnection(): ?PDO
	{
		if (!DatabaseFactory::$DB)
			new DatabaseFactory($_ENV["user"], $_ENV["password"], 
			$_ENV["db"], false);
		return DatabaseFactory::$DB;
	}

	/**
	 * Fetch the SQLSTATE associated with the last operation on the database handle.
	 */
	public static function getLastError(): string
	{
		return DatabaseFactory::$DB->errorCode();
	}

	/**
	 * Shutdown the PDO connection.
	 */
	public static function shutdown(): void
	{
		DatabaseFactory::$DB = null;
	}

	/**
	 * Execute a SELECT query to the chosen $table, for the chosen $columns (optional), 
	 * with the chosen $conditions (optional).
	 * @param string $table The name of the table.
	 * @param array $columns The list of columns to be fetched : ["id", "type", etc.]
	 * @param array $conditions The list of conditions to check :
	 * [
	 * [opBool=>"", col=>"id", opMath=>">", val=>"5"],
	 * [opBool=>"AND", col=>"type", opMath=>"<>", val=>"stable"]
	 * ]
	 * @return array Array of resulting rows, with each row being an array with the columns names as indexes.
	 */
	public static function fetch(string $table, array $columns = ["*"], array $conditions = []): array
	{
		// prepare query string for the columns (select ...)
		$columnsString = count($columns) == 1 ? $columns[0] : implode(", ", $columns);

		// prepare query string for the conditions (where ...)
		if (count($conditions) == 0) {
			$conditionsString = "";
		} else {
			$conditionsString = "WHERE ";
			
			// get all components of each condition
			foreach ($conditions as list($opBool, $col, $opMath, $val)) {
				$conditionsString .= " $opBool $col $opMath $val";
			}
		}

		// prepare the query
		$req = DatabaseFactory::$DB->prepare("SELECT :cols FROM :tab :conds");
		// execution
		$req->execute([
			"cols" => $columnsString,
			"tab" => $table,
			"conds" => $conditionsString
		]);

		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Execute a SELECT query to the chosen $table, in order to get ALL data.
	 *
	 * @param string $table The name of the table.
	 * @return array Array of resulting rows, with each row being an array with the columns names as indexes.
	 */
	public static function fetchAll(string $table): array
	{
		// prepare the query
		$req = DatabaseFactory::$DB->prepare("SELECT * FROM $table");
		// $req->debugDumpParams(); // debug
		// execution
		$req->execute();

		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
}
