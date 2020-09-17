<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Contact.php";

class ContactDAO implements DAO
{
	public const SELECT_QUERY = "SELECT * from Contact";

	public function getAllContacts(): array
	{
		$contacts = [];
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::SELECT_QUERY);
		$stmt->execute();
        
		while ($row = $stmt->fetch())
		{
			$contact = new Contact(
				(int)$row["codeContact"], $row["nomContact"], $row["prenomContact"], 
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]), 
				(int)$row["codePays"]);
            $contacts[] = $contact;
        }
        return $contacts;
	}

	public function updateContact(Contact $contact): void
	{
		
	}

	public function deleteContact(Contact $contact): void
	{
		
	}

	public function addContact(Contact $contact): void
	{
		
	}

	public function getClassName(): string
	{
		return get_class($this);
	}
}
