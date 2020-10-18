<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/StatutDAO.php";
require_once __DIR__ . "/TypeMissionDAO.php";
require_once __DIR__ . "/TypeMissionDAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Mission.php";
require_once __DIR__ . "/../model/Specialite.php";
require_once __DIR__ . "/../model/Statut.php";

class MissionDAO implements DAO
{
	public StatutDAO $statutDAO;
	public TypeMissionDAO $typeMissionDAO;
	public SpecialiteDAO $specialiteDAO;

    public const SELECT_QUERY = "SELECT codeMission, titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite from Mission";
    public const SELECT_ONE_QUERY = "SELECT codeMission, titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite from Mission WHERE codeMission = :code";
    public const ADD_QUERY = "INSERT INTO Mission (titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite) VALUES (:titre, :description, :dateDebut, :dateFin, :codeStatut, :codeType, :codeSpecialite)";
    public const DELETE_QUERY = "DELETE FROM Mission WHERE codeMission = :code";
    public const UPDATE_QUERY = "UPDATE Mission SET titreMission = :titre, descriptionMission = :description, dateDebut = :dateDebut, dateFin = :dateFin, codeStatutMission = :codeStatut, codeTypeMission = :codeType, codeSpecialite: codeSpecialite WHERE codeMission = :code";

	/**
	 * ContactDAO constructor.
	 */
	public function __construct()
	{
		DAOFactory::registerDAO(StatutDAO::class);
		DAOFactory::registerDAO(TypeMissionDAO::class);
		DAOFactory::registerDAO(SpecialiteDAO::class);
		/**
		 * @var StatutDAO $statutDAO
		 * @var TypeMissionDAO $typeMissionDAO
		 * @var SpecialiteDAO $specialiteDAO
		 */
		$statutDAO = DAOFactory::getDAO(StatutDAO::class);
		$typeMissionDAO = DAOFactory::getDAO(TypeMissionDAO::class);
		$specialiteDAO = DAOFactory::getDAO(SpecialiteDAO::class);
		$this->statutDAO = $statutDAO;
		$this->typeMissionDAO = $typeMissionDAO;
		$this->specialiteDAO = $specialiteDAO;
	}

    /**
     * Fetch all rows to get all Mission objects.
     * @return Mission[]
     */
    public function getAll(): array
    {
        $missions = [];
        $stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::SELECT_QUERY);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $mission = new Mission(
                (int)$row["codeMission"],
                $row["titreMission"],
                $row["descriptionMission"],
                DateTime::createFromFormat("Y-m-d", $row["dateDebut"]),
                DateTime::createFromFormat("Y-m-d", $row["dateFin"]),
                $this->statutDAO->get((int)$row["codeStatutMission"]),
				$this->typeMissionDAO->get((int)$row["codeTypeMission"]),
				$this->specialiteDAO->get((int)$row["codeSpecialite"])
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
    public function get($code): ?Mission
    {
        $stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::SELECT_ONE_QUERY);
        $stmt->execute([
            "code" => $code
        ]);

        if ($row = $stmt->fetch()) {
            return new Mission(
                (int)$row["codeMission"],
                $row["titreMission"],
                $row["descriptionMission"],
                DateTime::createFromFormat("Y-m-d", $row["dateDebut"]),
                DateTime::createFromFormat("Y-m-d", $row["dateFin"]),
				$this->statutDAO->get((int)$row["codeStatutMission"]),
				$this->typeMissionDAO->get((int)$row["codeTypeMission"]),
				$this->specialiteDAO->get((int)$row["codeSpecialite"])
            );
        }
        return null;
    }

    /**
     * Update a mission row.
     * @param Mission $mission - The mission.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function update($mission): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::UPDATE_QUERY);
        return $stmt->execute([
            ":code" => $mission->getCode(),
            ":titre" => $mission->getTitre(),
            ":description" => $mission->getDescription(),
            ":dateDebut" => $mission->getDateDebut()->format("Y-m-d"),
            ":dateFin" => $mission->getDateFin()->format("Y-m-d"),
            ":codeStatut" => $mission->getStatut()->getCode(),
            ":codeType" => $mission->getTypeMission()->getCode(),
            ":codeSpecialite" => $mission->getSpecialite()->getCode()
        ]);
    }

    /**
     * Delete a mission row.
     * @param Mission $mission - The mission.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function delete($mission): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::DELETE_QUERY);
        return $stmt->execute([
            ":code" => $mission->getCode()
        ]);
    }

    /**
     * Add a new mission row.
     * @param Mission $mission - The mission.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function add($mission): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(MissionDAO::ADD_QUERY);
        $res = $stmt->execute([
            ":titre" => $mission->getTitre(),
            ":description" => $mission->getDescription(),
            ":dateDebut" => $mission->getDateDebut()->format("Y-m-d"),
            ":dateFin" => $mission->getDateFin()->format("Y-m-d"),
			":codeStatut" => $mission->getStatut()->getCode(),
			":codeType" => $mission->getTypeMission()->getCode(),
			":codeSpecialite" => $mission->getSpecialite()->getCode()
        ]);
        if ($mission->getCode() == null) {
            $mission->setCode(DatabaseFactory::getConnection()->lastInsertId());
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