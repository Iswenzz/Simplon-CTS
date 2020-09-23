<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Mission.php";

class MissionDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeMission, titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite from Mission";
	public const SELECT_ONE_QUERY = "SELECT codeMission, titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite from Mission WHERE codeMission: code";
	public const ADD_QUERY = "INSERT INTO Mission (titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite) VALUES (:titre, :description, :dateDebut, :dateFin, :codeStatut, :codeType, :codeSpecialite)";
	public const DELETE_QUERY = "DELETE FROM Mission WHERE codeMission = :code";
	public const UPDATE_QUERY = "UPDATE Mission SET titreMission = :titre, descriptionMission = :description, dateDebut = :dateDebut, dateFin = :dateFin, codeStatutMission = :codeStatut, codeTypeMission = :codeType, codeSpecialite: codeSpecialite WHERE codeMission = :code";

	/**
	 * Fetch all rows to get all Mission objects.
	 * @return Mission[]
	 */
	public function getAllMissions(): array
	{
		$missions = [];
		$stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::SELECT_QUERY);
		$stmt->execute();
        
		while ($row = $stmt->fetch())
		{
			$mission = new Mission((int)$row["codeMission"], $row["titreMission"], $row["descriptionMission"], 
				DateTime::createFromFormat("Y-m-d", $row["dateDebut"]), 
				DateTime::createFromFormat("Y-m-d", $row["dateFin"]), 
				(int)$row["codeStatutMission"], (int)$row["codeTypeMission"], (int)$row["codeSpecialite"]
			);
            $missions[] = $mission;
        }
        return $missions;
	}

	/**
	 * Get a mission from its primary key.
	 * @param int $code - The primary key code.
	 * @return Mission|null
	 */
	public function getMission(int $code): ?Mission
	{
		$stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch())
		{
			return new Mission((int)$row["codeMission"], $row["titreMission"], $row["descriptionMission"],
				DateTime::createFromFormat("Y-m-d", $row["dateDebut"]),
				DateTime::createFromFormat("Y-m-d", $row["dateFin"]),
				(int)$row["codeStatutMission"], (int)$row["codeTypeMission"], (int)$row["codeSpecialite"]
			);
		}
		return null;
	}

	/**
	 * Update a mission row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function updateMission(Mission $mission): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $mission->getCode(),
			":titre" => $mission->getTitre(),
			":description" => $mission->getDescription(),
			":dateDebut" => $mission->getDateDebut()->format("Y-m-d"),
			":dateFin" => $mission->getDateFin()->format("Y-m-d"),
			":codeStatut" => $mission->getCodeStatut(),
			":codeType" => $mission->getCodeType(),
			":codeSpecialite" => $mission->getCodeSpecialite()
		]);
	}

	/**
	 * Delete a mission row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function deleteMission(Mission $mission): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $mission->getCode()
		]);
	}

	/**
	 * Add a new mission row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function addMission(Mission $mission): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::ADD_QUERY);
		$res = $stmt->execute([
			":titre" => $mission->getTitre(),
			":description" => $mission->getDescription(),
			":dateDebut" => $mission->getDateDebut()->format("Y-m-d"),
			":dateFin" => $mission->getDateFin()->format("Y-m-d"),
			":codeStatut" => $mission->getCodeStatut(),
			":codeType" => $mission->getCodeType(),
			":codeSpecialite" => $mission->getCodeSpecialite()
		]);
		if ($mission->getCode() == null)
			$mission->setCode(DatabaseFactory::getConnection()->lastInsertId());
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
