<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/TypeMission.php";

class TypeMissionDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeTypeMission, libelleTypeMission, descTypeMission FROM TypeMission";
	public const SELECT_ONE_QUERY = "SELECT codeTypeMission, libelleTypeMission, descTypeMission FROM TypeMission WHERE codeTypeMission = :code";
	public const ADD_QUERY = "INSERT INTO TypeMission (libelleTypeMission, descTypeMission) VALUES (:libelle, :desc)";
	public const DELETE_QUERY = "DELETE FROM TypeMission WHERE codeTypeMission = :code";
	public const UPDATE_QUERY = "UPDATE TypeMission SET libelleTypeMission = :libelle, descTypeMission = :desc WHERE codeTypeMission = :code";

	/**
	 * Fetch all rows to get all TypeMission objects.
	 * @return TypeMission[]
	 */
	public function getAll(): array
	{
		$typePlanques = [];
		$stmt = DatabaseFactory::getConnection()->prepare(TypeMissionDAO::SELECT_QUERY);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			$typePlanque = new TypeMission(
				(int)$row["codeTypeMission"],
				$row["libelleTypeMission"],
				$row["descTypeMission"]
			);
			$typePlanques[] = $typePlanque;
		}
		return $typePlanques;
	}

	/**
	 * Get a typePlanque from its primary key.
	 * @param int $code - The primary key code.
	 * @return TypeMission|null
	 */
	public function get($code): ?TypeMission
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypeMissionDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch()) {
			return new TypeMission(
				(int)$row["codeTypeMission"],
				$row["libelleTypeMission"],
				$row["descTypeMission"],
			);
		}
		return null;
	}

	/**
	 * Update a typePlanque row.
	 * @param TypeMission $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function update($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypeMissionDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $typePlanque->getCode(),
			":libelle" => $typePlanque->getLibelle(),
			":desc" => $typePlanque->getDescription(),
		]);
	}

	/**
	 * Delete a typePlanque row.
	 * @param TypeMission $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function delete($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypeMissionDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $typePlanque->getCode()
		]);
	}

	/**
	 * Add a new typePlanque row.
	 * @param TypeMission $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function add($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypeMissionDAO::ADD_QUERY);
		$res = $stmt->execute([
			":code" => $typePlanque->getCode(),
			":libelle" => $typePlanque->getLibelle(),
			":desc" => $typePlanque->getDescription(),
		]);
		if ($typePlanque->getCode() == null) {
			$typePlanque->setCode(DatabaseFactory::getConnection()->lastInsertId());
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