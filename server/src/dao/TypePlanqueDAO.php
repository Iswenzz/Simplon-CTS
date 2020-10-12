<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/TypePlanque.php";

class TypePlanqueDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeTypePlanque, libelleTypePlanque, descTypePlanque FROM TypePlanque";
	public const SELECT_ONE_QUERY = "SELECT codeTypePlanque, libelleTypePlanque, descTypePlanque FROM TypePlanque WHERE codeTypePlanque = :code";
	public const ADD_QUERY = "INSERT INTO TypePlanque (libelleTypePlanque, descTypePlanque) VALUES (:libelle, :desc)";
	public const DELETE_QUERY = "DELETE FROM TypePlanque WHERE codeTypePlanque = :code";
	public const UPDATE_QUERY = "UPDATE TypePlanque SET libelleTypePlanque = :libelle, descTypePlanque = :desc WHERE codeTypePlanque = :code";

	/**
	 * Fetch all rows to get all TypePlanque objects.
	 * @return TypePlanque[]
	 */
	public function getAll(): array
	{
		$typePlanques = [];
		$stmt = DatabaseFactory::getConnection()->prepare(TypePlanqueDAO::SELECT_QUERY);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			$typePlanque = new TypePlanque(
				(int)$row["codeTypePlanque"],
				$row["libelleTypePlanque"],
				$row["descTypePlanque"]
			);
			$typePlanques[] = $typePlanque;
		}
		return $typePlanques;
	}

	/**
	 * Get a typePlanque from its primary key.
	 * @param int $code - The primary key code.
	 * @return TypePlanque|null
	 */
	public function get($code): ?TypePlanque
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypePlanqueDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch()) {
			return new TypePlanque(
				(int)$row["codeTypePlanque"],
				$row["libelleTypePlanque"],
				$row["descTypePlanque"],
			);
		}
		return null;
	}

	/**
	 * Update a typePlanque row.
	 * @param TypePlanque $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function update($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypePlanqueDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $typePlanque->getCode(),
			":libelle" => $typePlanque->getLibelle(),
			":desc" => $typePlanque->getDescription(),
		]);
	}

	/**
	 * Delete a typePlanque row.
	 * @param TypePlanque $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function delete($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypePlanqueDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $typePlanque->getCode()
		]);
	}

	/**
	 * Add a new typePlanque row.
	 * @param TypePlanque $typePlanque - model
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function add($typePlanque): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(TypePlanqueDAO::ADD_QUERY);
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