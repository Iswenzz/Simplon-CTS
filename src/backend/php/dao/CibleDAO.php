<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Cible.php";

class CibleDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeCible, nomCible, prenomCible, dateNaissanceCible, codePays from Cible";
	public const ADD_QUERY = "INSERT INTO Cible (nomCible, prenomCible, dateNaissanceCible, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
	public const DELETE_QUERY = "DELETE FROM Cible WHERE codeCible = :code";
	public const UPDATE_QUERY = "UPDATE Cible SET nomCible = :nom, prenomCible = :prenom, dateNaissanceCible = :dateNaissance, codePays = :codePays WHERE codeCible = :code";

	/**
	 * Fetch all rows to get all Cible objects.
	 * @return Cible[]
	 */
	public function getAllCibles(): array
	{
		$cibles = [];
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::SELECT_QUERY);
		$stmt->execute();
        
		while ($row = $stmt->fetch())
		{
			$cible = new Cible((int)$row["codeCible"], $row["nomCible"], $row["prenomCible"], 
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceCible"]), 
				(int)$row["codePays"]);
            $cibles[] = $cible;
        }
        return $cibles;
	}

	/**
	 * Update a cible row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function updateCible(Cible $cible): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $cible->getCode(),
			":nom" => $cible->getNom(),
			":prenom" => $cible->getPrenom(),
			":dateNaissance" => $cible->getDateNaissance()->format("Y-m-d"),
			":codePays" => $cible->getCodePays()
		]);
	}

	/**
	 * Delete a cible row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function deleteCible(Cible $cible): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $cible->getCode()
		]);
	}

	/**
	 * Add a new cible row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function addCible(Cible $cible): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::ADD_QUERY);
		$res = $stmt->execute([
			":nom" => $cible->getNom(),
			":prenom" => $cible->getPrenom(),
			":dateNaissance" => $cible->getDateNaissance()->format("Y-m-d"),
			":codePays" => $cible->getCodePays()
		]);
		if ($cible->getCode() == null)
			$cible->setCode(DatabaseFactory::getConnection()->lastInsertId());
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
