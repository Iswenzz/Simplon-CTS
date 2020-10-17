<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/DAOFactory.php";
require_once __DIR__ . "/PaysDAO.php";
require_once __DIR__ . "/TypePlanqueDAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Planque.php";
require_once __DIR__ . "/../model/TypePlanque.php";

class PlanqueDAO implements DAO
{
	public PaysDAO $paysDAO;
	public TypePlanqueDAO $typePlanqueDAO;

    public const SELECT_QUERY = "SELECT codePlanque, adressePlanque, codePays, codeTypePlanque FROM Planque";
    public const SELECT_ONE_QUERY = "SELECT codePlanque, adressePlanque, codePays, codeTypePlanque from Planque WHERE codePlanque = :code";
    public const ADD_QUERY = "INSERT INTO Planque (adressePlanque, codePays, codeTypePlanque) VALUES (:adresse, :codePays, :typePlanque)";
    public const DELETE_QUERY = "DELETE FROM Planque WHERE codePlanque = :code";
    public const UPDATE_QUERY = "UPDATE Planque SET adressePlanque = :adresse, codePays = :codePays, codeTypePlanque = :typePlanque WHERE codePlanque = :code";

	/**
	 * PlanqueDAO constructor.
	 */
	public function __construct()
	{
		DAOFactory::registerDAO(TypePlanqueDAO::class);
		DAOFactory::registerDAO(PaysDAO::class);
		/**
		 * @var PaysDAO $paysDAO
		 * @var TypePlanqueDAO $typePlanqueDAO
		 */
		$typePlanqueDAO = DAOFactory::getDAO(TypePlanqueDAO::class);
		$paysDAO = DAOFactory::getDAO(PaysDAO::class);
		$this->typePlanqueDAO = $typePlanqueDAO;
		$this->paysDAO = $paysDAO;
    }

    /**
     * Fetch all rows to get all Planque objects.
     * @return Planque[]
     */
    public function getAll(): array
    {
        $planques = [];
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::SELECT_QUERY);
        $stmt->execute();

        while ($row = $stmt->fetch())
		{
            $planque = new Planque(
            	(int)$row["codePlanque"],
				$row["adressePlanque"],
				$this->paysDAO->get((int)$row["codePays"]),
				$this->typePlanqueDAO->get((int)$row["codeTypePlanque"])
            );
            $planques[] = $planque;
        }
        return $planques;
    }

    /**
     * Fetch all rows to get all Planque objects.
     * @param int $code - The country's code (foreign key).
     * @return Planque[]
     */
    public function getAllInCountry($code): array
    {
        $planques = [];
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::SELECT_IN_COUNTRY_QUERY);
        $stmt->execute([
            "code" => $code
        ]);
        
        while ($row = $stmt->fetch()) {
            $planque = new Planque(
                (int)$row["codePlanque"],
				$row["adressePlanque"],
				$this->paysDAO->get((int)$row["codePays"]),
				$this->typePlanqueDAO->get((int)$row["codePlanque"])
            );
            $planques[] = $planque;
        }
        return $planques;
    }

    /**
     * Get a planque from its primary key.
     * @param int $code - The primary key code.
     * @return Planque|null
     */
    public function get($code): ?Planque
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::SELECT_ONE_QUERY);
        $stmt->execute([
            "code" => $code
        ]);

        if ($row = $stmt->fetch()) {
            return new Planque(
                (int)$row["codePlanque"],
				$row["adressePlanque"],
				$this->paysDAO->get((int)$row["codePays"]),
            );
        }
        return null;
    }

    /**
     * Update a planque row.
     * @param Planque $planque - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function update($planque): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::UPDATE_QUERY);
        var_dump($planque);
        return $stmt->execute([
            ":code" => $planque->getCode(),
            ":adresse" => $planque->getAdresse(),
            ":codePays" => $planque->getPays()->getCode(),
            ":typePlanque" => $planque->getTypePlanque()->getCode()
        ]);
    }

    /**
     * Delete a planque row.
     * @param Planque $planque - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function delete($planque): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::DELETE_QUERY);
        return $stmt->execute([
            ":code" => $planque->getCode()
        ]);
    }

    /**
     * Add a new planque row.
     * @param Planque $planque - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function add($planque): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PlanqueDAO::ADD_QUERY);
        $res = $stmt->execute([
            ":code" => $planque->getCode(),
            ":adresse" => $planque->getAdresse(),
            ":codePays" => $planque->getPays()->getCode(),
            ":typePlanque" => $planque->getTypePlanque()->getCode()
        ]);
        if ($planque->getCode() == null) {
            $planque->setCode(DatabaseFactory::getConnection()->lastInsertId());
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