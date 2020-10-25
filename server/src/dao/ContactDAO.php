<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/PaysDAO.php";
require_once __DIR__ . "/MissionDAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Contact.php";
require_once __DIR__ . "/../model/Pays.php";

class ContactDAO implements DAO
{
	public PaysDAO $paysDAO;
	public MissionDAO $missionDAO;

	public const SELECT_QUERY = "SELECT codeContact, nomContact, prenomContact, dateNaissanceContact, codePays from Contact";
	public const SELECT_MISSION_QUERY = "SELECT a.codeContact, nomContact, prenomContact, dateNaissanceContact, codePays FROM Aide a JOIN Contact AS c ON a.codeContact = c.codeContact JOIN Mission AS m ON a.codeMission = m.codeMission WHERE a.codeMission = :codeMission";
	public const SELECT_ONE_QUERY = "SELECT codeContact, nomContact, prenomContact, dateNaissanceContact, codePays from Contact WHERE codeContact = :code";
	public const ADD_QUERY = "INSERT INTO Contact (nomContact, prenomContact, dateNaissanceContact, codePays) VALUES (:nom, :prenom, :dateNaissance, :codePays)";
	public const DELETE_QUERY = "DELETE FROM Contact WHERE codeContact = :code";
	public const UPDATE_QUERY = "UPDATE Contact SET nomContact = :nom, prenomContact = :prenom, dateNaissanceContact = :dateNaissance, codePays = :codePays WHERE codeContact = :code";

	/**
	 * ContactDAO constructor.
	 */
	public function __construct()
	{
		DAOFactory::registerDAO(PaysDAO::class);
		DAOFactory::registerDAO(MissionDAO::class);
		/**
		 * @var PaysDAO $paysDAO
		 * @var MissionDAO $missionDAO
		 */
		$paysDAO = DAOFactory::getDAO(PaysDAO::class);
		$missionDAO = DAOFactory::getDAO(MissionDAO::class);
		$this->paysDAO = $paysDAO;
		$this->missionDAO = $missionDAO;
	}

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
			$contact = new Contact(
				(int)$row["codeContact"],
				$row["nomContact"],
				$row["prenomContact"],
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]),
				$this->paysDAO->get((int)$row["codePays"]),
				$this->missionDAO->getAllByContact((int)$row["codeContact"])
			);
            $contacts[] = $contact;
        }
        return $contacts;
	}

	/**
	 * Fetch all contacts by mission.
	 * @param int $codeMission - The mission code.
	 * @return Contact[]
	 */
	public function getAllByMission(int $codeMission): array
	{
		$contacts = [];
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::SELECT_MISSION_QUERY);
		$stmt->execute([
			":codeMission" => $codeMission
		]);

		while ($row = $stmt->fetch())
		{
			$contact = new Contact(
				$row["codeContact"],
				$row["nomContact"],
				$row["prenomContact"],
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]),
				$this->paysDAO->get((int)$row["codePays"]),
//				$this->missionDAO->getAllByContact((int)$row["codeContact"])
			);
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
			return new Contact(
				$row["codeContact"],
				$row["nomContact"],
				$row["prenomContact"],
				DateTime::createFromFormat("Y-m-d", $row["dateNaissanceContact"]),
				$this->paysDAO->get((int)$row["codePays"])
			);
		}
		return null;
	}

	/**
	 * Update a contact row.
	 * @return bool - TRUE on success or FALSE on failure.
	 * @param Contact $contact - The contact.
	 */
	public function update($contact): bool
	{
		$stmt = DatabaseFactory::getConnection()->prepare(ContactDAO::UPDATE_QUERY);
		return $stmt->execute([
			":code" => $contact->getCode(),
			":nom" => $contact->getNom(),
			":prenom" => $contact->getPrenom(),
			":dateNaissance" => $contact->getDateNaissance()->format("Y-m-d"),
			":codePays" => $contact->getPays()->getCode()
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
			":codePays" => $contact->getPays()->getCode()
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
