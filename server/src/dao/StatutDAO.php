<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Statut.php";

class StatutDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeStatutMission, libelleStatutMission FROM Statut";
	public const SELECT_ONE_QUERY = "SELECT codeStatutMission, libelleStatutMission FROM Statut WHERE codeStatutMission = :code";
	public const ADD_QUERY = "INSERT INTO Statut (libelleStatutMission) VALUES (:libelle)";
	public const DELETE_QUERY = "DELETE FROM Statut WHERE codeStatutMission = :code";
	public const UPDATE_QUERY = "UPDATE Statut SET libelleStatutMission = :libelle WHERE codeStatutMission = :code";

	/**
	 * Fetch all rows to get all Statut objects.
	 * @return Statut[]
	 */
	public function getAll(): array
	{
		$statuts = [];
		$stmt = DatabaseFactory::getConnection()->prepare(StatutDAO::SELECT_QUERY);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			$statut = new Statut(
				(int)$row["codeStatutMission"],
				$row["libelleStatutMission"]
			);
			$statuts[] = $statut;
		}
		return $statuts;
	}

	/**
	 * Get a statut from its primary key.
	 * @param int $code - The primary key code.
	 * @return Statut|null
	 */
	public function get($code): ?Statut
	{
		$stmt = DatabaseFactory::getConnection()->prepare(StatutDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch()) {
			return new Statut(
				(int)$row["codeStatutMission"],
				$row["libelleStatutMission"]
			);
		}
		return null;
	}

	/**
	 * Update a statut row.
	 * @param Statut $statut - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function update($statut): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(StatutDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $statut->getCode(),
			":libelle" => $statut->getLibelle()
		]);
	}

	/**
	 * Delete a statut row.
	 * @param Statut $statut - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function delete($statut): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(StatutDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $statut->getCode()
		]);
	}

	/**
	 * Add a new statut row.
	 * @param Statut $statut - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function add($statut): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(StatutDAO::ADD_QUERY);
		$res = $stmt->execute([
			":code" => $statut->getCode(),
			":libelle" => $statut->getLibelle()
		]);
		if ($statut->getCode() == null) {
			$statut->setCode(DatabaseFactory::getConnection()->lastInsertId());
		}
		return $res;
	}

	/**
	 * Get the DAO class name.
	 */
	public function getClassName(): string
	{
		return get_class($this);
	}
}