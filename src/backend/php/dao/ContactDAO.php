<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Contact.php";

class ContactDAO implements DAO
{
	public const SELECT_QUERY = "SELECT codeContact, nomContact, prenomContact, dateNaissanceContact, codePays from Contact";
	public const SELECT_ONE_QUERY = "SELECT codeContact, nomContact, prenomContact, dateNaissanceContact, codePays from Contact WHERE codeContact = :code";
	public const ADD_QUERY = "INSERT INTO Contact (nomContact, prenomContact, dateNaissanceContact, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
	public const DELETE_QUERY = "DELETE FROM Contact WHERE codeContact = :code";
	public const UPDATE_QUERY = "UPDATE Contact SET nomContact = :nom, prenomContact = :prenom, dateNaissanceContact = :dateNaissance, codePays = :codePays WHERE codeContact = :code";

	/**
	 * Fetch all rows to get all Contact objects.
	 * @return Contact[]
	 */
	public function getAll(): array
	{
		$contacts = [];
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::SELECT_QUERY);
		$stmt->execute();
        
		while ($row = $stmt->fetch())
		{
			$contact = new Contact($row["codeContact"], $row["nomContact"], $row["prenomContact"], 
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]), 
				(int)$row["codePays"]);
            $contacts[] = $contact;
        }
        return $contacts;
	}

	/**
	 * Get a contact from its primary key.
	 * @param int $code - The primary key code.
	 * @return Contact|null
	 */
	public function get($code): ?Contact
	{
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::SELECT_ONE_QUERY);
		$stmt->execute([
			"code" => $code
		]);

		if ($row = $stmt->fetch())
		{
			return new Contact($row["codeContact"], $row["nomContact"], $row["prenomContact"],
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]),
				(int)$row["codePays"]);
		}
		return null;
	}

	/**
	 * Update a contact row.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function update($contact): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $contact->getCode(),
			":nom" => $contact->getNom(),
			":prenom" => $contact->getPrenom(),
			":dateNaissance" => $contact->getDateNaissance()->format("Y-m-d"),
			":codePays" => $contact->getCodePays()
		]);
	}

	/**
	 * Delete a contact row.
	 * @param Contact $contact - The contact.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function delete($contact): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::DELETE_QUERY);
		return $stmt->execute([
			":code" => $contact->getCode()
		]);
	}

	/**
	 * Add a new contact row.
	 * @param Contact $contact - The contact.
	 * @return bool - TRUE on success or FALSE on failure.
	 */
	public function add($contact): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::ADD_QUERY);
		$res = $stmt->execute([
			":nom" => $contact->getNom(),
			":prenom" => $contact->getPrenom(),
			":dateNaissance" => $contact->getDateNaissance()->format("Y-m-d"),
			":codePays" => $contact->getCodePays()
		]);
		if ($contact->getCode() == null)
			$contact->setCode(DatabaseFactory::getConnection()->lastInsertId());
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
