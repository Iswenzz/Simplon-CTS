<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/PaysDAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Agent.php";

class AgentDAO implements DAO
{
	public PaysDAO $paysDAO;

    public const SELECT_QUERY = "SELECT codeAgent, nomAgent, prenomAgent, dateNaissanceAgent, codePays from Agent";
    public const SELECT_ONE_QUERY = "SELECT codeAgent, nomAgent, prenomAgent, dateNaissanceAgent, codePays from Agent WHERE codeAgent = :code";
    public const ADD_QUERY = "INSERT INTO Agent (nomAgent, prenomAgent, dateNaissanceAgent, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
    public const DELETE_QUERY = "DELETE FROM Agent WHERE codeAgent = :code";
    public const UPDATE_QUERY = "UPDATE Agent SET nomAgent = :nom, prenomAgent = :prenom, dateNaissanceAgent = :dateNaissance, codePays = :codePays WHERE codeAgent = :code";

	/**
	 * AgentDAO constructor.
	 */
	public function __construct()
	{
		DAOFactory::registerDAO(PaysDAO::class);
		/**
		 * @var PaysDAO $paysDAO
		 */
		$paysDAO = DAOFactory::getDAO(PaysDAO::class);
		$this->paysDAO = $paysDAO;
	}

    /**
     * Fetch all rows to get all Agent objects.
     * @return Agent[]
     */
    public function getAll(): array
    {
        $agents = [];
        $stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::SELECT_QUERY);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $agent = new Agent(
                (int)$row["codeAgent"],
                $row["nomAgent"],
                $row["prenomAgent"],
                DateTime::createFromFormat("Y-m-d", $row["dateNaissanceAgent"]),
                $this->paysDAO->get((int)$row["codePays"])
            );
            $agents[] = $agent;
        }
        return $agents;
    }

    /**
     * Get an Agent from its primary key.
     * @param int $code - The primary key code.
     * @return Agent|null
     */
    public function get($code): ?Agent
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::SELECT_ONE_QUERY);
        $stmt->execute([
            "code" => $code
        ]);

        if ($row = $stmt->fetch()) {
            return new Agent(
                (int)$row["codeAgent"],
                $row["nomAgent"],
                $row["prenomAgent"],
                DateTime::createFromFormat("Y-m-d", $row["dateNaissanceAgent"]),
				$this->paysDAO->get((int)$row["codePays"])
            );
        }
        return null;
    }

    /**
     * Update a agent row.
     * @param Agent $agent - The agent.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function update($agent): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::UPDATE_QUERY);
        return $stmt->execute([
            "code" => $agent->getCode(),
            "nom" => $agent->getNom(),
            "prenom" => $agent->getPrenom(),
            "dateNaissance" => $agent->getDateNaissance()->format("Y-m-d"),
            "codePays" => $agent->getPays()->getCode()
        ]);
    }

    /**
     * Delete a agent row.
     * @param Agent $agent - The agent.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function delete($agent): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::DELETE_QUERY);
        return $stmt->execute([
            "code" => $agent->getCode()
        ]);
    }

    /**
     * Add a new agent row.
     * @param Agent $agent - The agent.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function add($agent): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::ADD_QUERY);
        $res = $stmt->execute([
            "nom" => $agent->getNom(),
            "prenom" => $agent->getPrenom(),
            "dateNaissance" => $agent->getDateNaissance()->format("Y-m-d"),
            "codePays" => $agent->getPays()->getCode()
        ]);
        if ($agent->getCode() == null) {
            $agent->setCode(DatabaseFactory::getConnection()->lastInsertId());
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