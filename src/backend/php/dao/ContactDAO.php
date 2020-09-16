<?php
require "../DatabaseFactory.php";
require "../model/Contact.php";

class ContactDAO
{
	public const SELECT_QUERY = "SELECT * from Contact";

	public function getAllContacts(): array
	{
		$contacts = [];
		$stmt = DatabaseFactory::getConnection()->prepare($this->SELECT_QUERY);
        
		while ($row = $stmt->fetch())
		{
			$contact = new Contact($row["codeContact"], $row["nomContact"], 
				$row["prenomContact"], $row["dateNaissanceContact"], $row["codePays"]);
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
}
