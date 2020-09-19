<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Agent.php";

class AgentDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeAgent, nomAgent, prenomAgent, dateNaissanceAgent, codePays from Agent";
	public const ADD_QUERY = "INSERT INTO Agent (nomAgent, prenomAgent, dateNaissanceAgent, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
	public const DELETE_QUERY = "DELETE FROM Agent WHERE codeAgent = :code";
	public const UPDATE_QUERY = "UPDATE Agent SET nomAgent = :nom, prenomAgent = :prenom, dateNaissanceAgent = :dateNaissance, codePays = :codePays WHERE codeAgent = :code";

	/**
	 * Fetch all rows to get all Agent objects.
	 */
	public function getAllAgents(): array
	{
		$agents = [];
		$stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::SELECT_QUERY);
		$stmt->execute();
        
		while ($row = $stmt->fetch())
		{
			$agent = new Agent((int)$row["codeAgent"], $row["nomAgent"], $row["prenomAgent"], 
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceAgent"]), 
				(int)$row["codePays"]);
            $agents[] = $agent;
        }
        return $agents;
	}

	/**
	 * Update a agent row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function updateAgent(Agent $agent): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $agent->getCode(),
			":nom" => $agent->getNom(),
			":prenom" => $agent->getPrenom(),
			":dateNaissance" => $agent->getDateNaissance()->format("Y-m-d"),
			":codePays" => $agent->getCodePays()
		]);
	}

	/**
	 * Delete a agent row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function deleteAgent(Agent $agent): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $agent->getCode()
		]);
	}

	/**
	 * Add a new agent row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function addAgent(Agent $agent): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(AgentDAO::ADD_QUERY);
		$res = $stmt->execute([
			":nom" => $agent->getNom(),
			":prenom" => $agent->getPrenom(),
			":dateNaissance" => $agent->getDateNaissance()->format("Y-m-d"),
			":codePays" => $agent->getCodePays()
		]);
		if ($agent->getCode() == null)
			$agent->setCode(DatabaseFactory::getConnection()->lastInsertId());
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
