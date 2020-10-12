<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Cible.php";

class CibleDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeCible, nomCible, prenomCible, dateNaissanceCible, codePays from Cible";
	public const SELECT_ONE_QUERY = "SELECT codeCible, nomCible, prenomCible, dateNaissanceCible, codePays from Cible WHERE codeCible = :code";
	public const ADD_QUERY = "INSERT INTO Cible (nomCible, prenomCible, dateNaissanceCible, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
	public const DELETE_QUERY = "DELETE FROM Cible WHERE codeCible = :code";
	public const UPDATE_QUERY = "UPDATE Cible SET nomCible = :nom, prenomCible = :prenom, dateNaissanceCible = :dateNaissance, codePays = :codePays WHERE codeCible = :code";

	/**
	 * Fetch all rows to get all Cible objects.
	 * @return Cible[]
	 */
	public function getAll(): array
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
	 * Get a Cible from its primary key.
	 * @param int $code - The primary key code.
	 * @return Cible|null
	 */
	public function get($code): ?Cible
	{
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch())
		{
			return new Cible($row["codeCible"], $row["nomCible"], $row["prenomCible"],
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceCible"]),
				(int)$row["codePays"]);
		}
		return null;
	}

	/**
	 * Update a cible row.
	 * @param Cible $cible - The cible.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function update($cible): bool
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
	 * @param Cible $cible - The cible.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function delete($cible): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(CibleDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $cible->getCode()
		]);
	}

	/**
	 * Add a new cible row.
	 * @param Cible $cible - The cible.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function add($cible): bool
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
